<?php
/**
 * Theme Core
 * 
 * Initialise application logic
 *
 * @package Theme Core
 * @author Simon Holloway
 * @version 1.0.0
 */

// Define constants
define('L', PHP_EOL);
define('DS', DIRECTORY_SEPARATOR);
define('FUNCTIONS_DIR', dirname(__DIR__) . DS);
define('CORE_DIR', FUNCTIONS_DIR . 'core' . DS);
define('MODULES_DIR', FUNCTIONS_DIR . 'modules' . DS);
define('VENDOR_DIR', FUNCTIONS_DIR . 'vendor' . DS);
define('CLASS_DIR', FUNCTIONS_DIR . 'psr-0' . DS);
define('THEME_DIR', dirname(FUNCTIONS_DIR) . DS);
define('TEMPLATES_DIR', THEME_DIR . 'templates' . DS);

if (false === defined('ENV')) {
    define('ENV', 'live');
}

// Include composer autoloader
include(VENDOR_DIR . 'autoload.php');

// Include php helpers
include(CORE_DIR . 'php-helpers.php');

// Include wordpress helpers
include(CORE_DIR . 'wp-helpers.php');

// Include wordpress hooks
include(CORE_DIR . 'wp-hooks.php');

// Include modules
$dir = new DirectoryIterator(MODULES_DIR);
foreach ($dir as $module_dir) {
    if ( ! $module_dir->isDot() && $module_dir->isDir() ) {
        $module_init = $module_dir->getPathname() . DS . $module_dir->getFilename() . '.php';
    } elseif($module_dir->isFile()) {
        $module_init = $module_dir->getPathname();
    } else {
        continue;
    }
    if (is_readable($module_init)) {
        require($module_init);
    }
}

do_action('theme_modules_loaded');