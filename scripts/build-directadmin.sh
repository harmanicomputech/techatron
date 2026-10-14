#!/usr/bin/env bash
# Builds an upload-ready zip for DirectAdmin / shared hosting without SSH.
#   scripts/build-directadmin.sh [output.zip]
# Packages the committed HEAD (not uncommitted changes), with production
# Composer dependencies, built assets and a migrated SQLite database.
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
OUT="${1:-$ROOT/dist/techatron-directadmin.zip}"
WORK="$(mktemp -d)"
trap 'rm -rf "$WORK"' EXIT

APP="$WORK/techatron_app"
WEB="$WORK/public_html"
mkdir -p "$APP" "$WEB"

echo "→ Exporting committed source"
git -C "$ROOT" archive HEAD | tar -x -C "$APP"

echo "→ Installing production PHP dependencies"
composer install --working-dir="$APP" --no-dev --optimize-autoloader --no-interaction --no-progress --quiet

echo "→ Building front-end assets"
(cd "$APP" && npm ci --silent && npm run build --silent)

echo "→ Writing .env and database"
KEY="base64:$(php -r 'echo base64_encode(random_bytes(32));')"
sed "s|__APP_KEY__|$KEY|" "$APP/deploy/directadmin/env.template" > "$APP/.env"
touch "$APP/database/database.sqlite"
(cd "$APP" && php artisan migrate --force --no-interaction --quiet)

echo "→ Splitting public files"
cp -a "$APP/public/." "$WEB/"
cp "$APP/deploy/directadmin/index.php" "$WEB/index.php"
rm -rf "$APP/public"
cp "$APP/deploy/directadmin/INSTALL.txt" "$WORK/INSTALL.txt"

echo "→ Removing development files"
rm -rf "$APP/node_modules" "$APP/tests" "$APP/.github" "$APP/scripts" "$APP/deploy" \
       "$APP/phpunit.xml" "$APP/vite.config.js" "$APP/package.json" "$APP/package-lock.json" \
       "$APP/resources/css" "$APP/resources/js" "$APP/.editorconfig" "$APP/.npmrc"
rm -f "$WEB/hot"
find "$APP/storage" -type f \( -name '*.log' -o -path '*/framework/views/*.php' -o -path '*/framework/sessions/*' -o -path '*/framework/cache/data/*' \) ! -name '.gitignore' -delete
chmod -R u+rwX,go+rX "$WORK"

echo "→ Zipping"
mkdir -p "$(dirname "$OUT")"
rm -f "$OUT"
(cd "$WORK" && zip -qr -X "$OUT" techatron_app public_html INSTALL.txt)
echo "✓ $OUT ($(du -h "$OUT" | cut -f1))"
