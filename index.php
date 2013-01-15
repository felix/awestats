<?php

require __DIR__ . '/config.php';
require __DIR__ . '/classes/session/autoload.php';
require __DIR__ . '/classes/Session.php';
require __DIR__ . '/classes/User.php';

use spriebsch\session\PHPMysqlSessionBackend;

try {
    
$backend = new PHPMysqlSessionBackend(DB_USER, DB_PASSWORD, DB_NAME);

$session = new Session($backend);
$session->configure('session-awestats', '.'.BASE_URL);
$session->start();

if(!empty($_POST['email']) && !empty($_POST['password'])) {
    $email = (string)$_POST['email'];
    $password = (string)$_POST['password'];
    $user = new User($email, $password);
    if(empty($user)) {
        require 'views/render_login.php';
        exit(0);
    } else {
        $session->setUser($user);
    }
}

if ($session->hasUser()) {
    $user = $session->getUser();
} else {
    require 'views/render_login.php';
    exit(0);
}

var_dump($session->hasUser());
var_dump($session->getUser());

} catch (\Exception $e) {
    $error_message = $e->getMessage();
    require 'views/render_error.php';
    exit(0);
}

// get ctr param
$action = '';
$action = (string)$_GET['action'];

require_once "clsAWStats.php";

switch ($action) {
    case 'history':
        require 'views/xml_history.php';
        break;
    case 'pages':
        require 'views/xml_pages.php';
        break;
    case 'stats':
        require 'views/xml_stats.php';
        break;
    case 'update':
        require 'views/xml_update.php';
        break;
    default:
        require_once "languages/translations.php";
        require 'views/render_index.php';
        break;
}



