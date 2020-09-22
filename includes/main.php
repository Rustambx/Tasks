<?php
session_start();

require_once 'env.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

// init routes
\Task\Routes::init();