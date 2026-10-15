/*
 * Front-end behaviour. Everything here is progressive enhancement: pages are
 * complete without JavaScript, and motion is skipped for visitors who prefer
 * reduced motion.
 */

import { initTheme } from './modules/theme.js';
import { initNavigation } from './modules/navigation.js';
import { initForms } from './modules/forms.js';
import { initMotion } from './modules/motion.js';
import { initStudio } from './modules/studio.js';

document.documentElement.classList.replace('no-js', 'js');

initTheme();
initNavigation();
initForms();
initMotion();
initStudio();
