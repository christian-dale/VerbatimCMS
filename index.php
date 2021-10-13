<?php

require_once("lib/class/Router.php");
require_once("lib/class/PageLoader.php");
require_once("lib/class/App.php");

$app = new App();
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
