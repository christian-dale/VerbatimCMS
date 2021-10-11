<?php

require_once("vendor/autoload.php");

require_once("class/Router.php");
require_once("class/Lang.php");
require_once("class/PageLoader.php");
require_once("class/App.php");

$app = new App();
$app->smarty = new Smarty();
$app->lang = new Lang($_SESSION["lang"]);
$app->loadConfig();

$router = new Router();
$page_loader = new PageLoader();
$page_loader->loadPages();
$page_loader->loadRoutes($app, $router);

$app->assign($page_loader);

if (!$router->begin()) {
    $app->show404();
}

echo $app->render($page_loader);
