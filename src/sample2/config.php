<?php

return [

  'BASE_URL' => 'http://sample2.local/',

  'DEFAULT_HOME_CONTROLLER' => 'Home',

  'BASE_PATH' => __DIR__,

  /**
   * MySQL config
   */
  'DATABASE' => [
    'mysql' => [
      'host' => 'mysql',
      'db'   => 'sample2',
      'user' => 'sample2',
      'pass' => 'sample2',
    ]
  ],


  /**
   * Layout configs
   */
  'HEADER' => 'views/header',
  'FOOTER' => 'views/footer',

];

