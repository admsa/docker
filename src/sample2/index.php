<?php

# Start session
session_start();

/**
 * Autoload files
 *
 * @return void
 */
spl_autoload_register(function($class) {
  if ( !class_exists($class)) {
    $file = __DIR__ . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (file_exists($file)) include_once $file;
  }
});

# Register constants
__register_const();

# Starts here
__initialize();

/**
 * Register constants from file
 *
 * @return void
 */
function __register_const() {
  $const = include 'config.php';

  foreach ($const as $key => $val) {
    define($key, $val);
  }
}

/**
 * Initialize files
 *
 * @return void
 */
function __initialize() {

  $page   = ucfirst($_REQUEST['page'] ?? DEFAULT_HOME_CONTROLLER);
  $action = $_REQUEST['action'] ?? 'index';

  if (file_exists(__path($page))) {
    $reflection = new ReflectionClass(__path($page, true));
    if ($reflection->hasMethod($action)) {

      $deps = include 'dependency.php';
      $reflection->newInstanceArgs()->setDependencies($deps)->setInput($_REQUEST)->applyMiddleware($action);

    } else __404();

  } else __404();

}

/**
 * Displays 404 page
 *
 * @return void
 */
function __404() {
  (new Core\Layout)->view('404');
}

/**
 * Returns controller path
 *
 * @param $page string
 * @param $namespace bool
 * @return string
 */
function __path($page, $namespace = false) {
  return "Controller" . ($namespace ? "\\{$page}" : "/{$page}.php");
}
