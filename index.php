<?php

require 'config.php';
require 'classes/session/autoload.php';
require 'classes/Session.php';
require 'classes/User.php';
require_once "languages/translations.php";

use spriebsch\session\PHPMysqlSessionBackend;

try {

    $backend = new PHPMysqlSessionBackend(DB_USER, DB_PASSWORD, DB_NAME);

    $session = new Session($backend);
    $session->configure('session-awestats', BASE_URL, '/', CONFIG_SESSION_LIFETIME);
    $session->start();

    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = (string) $_POST['email'];
        $password = (string) $_POST['password'];
        $user = new User($email, $password);

        if (!$user->isValid()) {
            require 'controllers/render_login.php';
            exit(0);
        } else {
            $session->setUser($user);
            $session->commit();
        }
    }

    if ($session->hasUser()) {
        $user = $session->getUser();
    } else {
        require 'controllers/render_login.php';
        exit(0);
    }

    $sites = $user->getSites();
    $aConfig = array();
    foreach ($sites as $site) {
        if (!empty($site)) {
            $aConfig[$site] = array(
                "statspath" => "/var/lib/awstats/",
                "statsname" => "awstats[MM][YYYY].{$site}.txt",
                "updatepath" => "/usr/lib/cgi-bin/",
                "siteurl" => "http://{$site}/",
                "sitename" => $site,
                "theme" => "default",
                "fadespeed" => 250,
                "password" => "",
                "includes" => "",
                "language" => CONFIG_DEFAULT_LANGUAGE
            );
        }
    }

    if (empty($aConfig)) {
        throw new Exception('Aucun sites associés à votre compte.');
    }
    
} catch (\Exception $e) {
    $error_message = $e->getMessage();
    require 'controllers/render_error.php';
    exit(0);
}

// get ctr param
$action = '';
if (isset($_GET['action'])) {
    $action = (string) $_GET['action'];
}
// get year
$now = new DateTime();
$year = $now->format("Y");
if (isset($_GET['year'])) {
    $year = (string) $_GET["year"];
}
// get month
$month = $now->format("m");
if (isset($_GET['month'])) {
    $month = (string) $_GET["month"];
}
// get view
$view = CONFIG_DEFAULT_VIEW;
if (isset($_GET['view'])) {
    $view = (string) $_GET["view"];
}

require_once "classes/clsAWStats.php";

switch ($action) {
    case 'logout':
        $session->destroy();
        require 'controllers/render_login.php';
        break;
    case 'history':
        require 'controllers/xml_history.php';
        break;
    case 'pages':
        require 'controllers/xml_pages.php';
        break;
    case 'stats':
        require 'controllers/xml_stats.php';
        break;
    case 'update':
        require 'controllers/xml_update.php';
        break;
    default:
        require 'controllers/render_index.php';
        break;
}



