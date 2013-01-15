<?php

require __DIR__ . '/classes/session/autoload.php';
require __DIR__ . '/classes/Session.php';
require __DIR__ . '/classes/User.php';

use spriebsch\session\PHPMysqlSessionBackend;

try {
$backend = new PHPMysqlSessionBackend(DB_USER, DB_PASSWORD, DB_NAME);

$session = new Session($backend);
$session->configure('session-awestats', '.'.$baseUrl);
$session->start();

if(!empty($_POST['email']) && !empty($_POST['password'])) {
    $email = (string)$_POST['email'];
    $password = (string)$_POST['password'];
    $user = new User($email, $password);
    if(empty($user)) {
        require 'renderLogin.php';
        exit(0);
    } else {
        $session->setUser($user);
    }
}

if ($session->hasUser()) {
    $user = $session->getUser();
} else {
    require 'renderLogin.php';
    exit(0);
}

var_dump($session->hasUser());
var_dump($session->getUser());

} catch (\Exception $e) {
    $error_message = $e->getMessage();
    require 'renderError.php';
    exit(0);
}