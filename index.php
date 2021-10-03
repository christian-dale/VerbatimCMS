<?php

require_once("vendor/autoload.php");

require_once("class/Router.php");
require_once("class/Lang.php");
require_once("class/PageLoader.php");
require_once("class/App.php");

$app = new App(new Smarty(), new Lang($_SESSION["lang"]));
$app->loadConfig();

$router = new Router();
$page_loader = new PageLoader();
$page_loader->loadPages();
$page_loader->loadRoutes($app, $router);

$app->smarty->assign("app", $app);
$app->smarty->assign("nav", $page_loader->getNav($app->smarty));

if (!$router->begin()) {
    $app->content = $app->smarty->fetch("templates/pages/404.tpl");
    http_response_code(404);
}

echo $app->render();
