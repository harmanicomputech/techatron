<?php

namespace App\Support;

use Illuminate\Support\HtmlString;

/**
 * Renders schema.org structured data as a JSON-LD script tag.
 *
 * Built here rather than in Blade because Blade treats "@context" in a
 * template as its own directive and corrupts the output.
 */
class Schema
{
    public static function script(array $data): HtmlString
    {
        $json = json_encode(
            ['@context' => 'https://schema.org'] + $data,
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_THROW_ON_ERROR,
        );

        return new HtmlString('<script type="application/ld+json">'.$json.'</script>');
    }
}
