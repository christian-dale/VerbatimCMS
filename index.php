<?php

require_once("vendor/autoload.php");

require_once("class/Router.php");
require_once("class/Lang.php");
require_once("class/PageLoader.php");
require_once("class/Item.php");
require_once("class/App.php");

session_start();

$app = new App(new Smarty(), new Lang($_SESSION["lang"] ??= "en"));
$app->appname = "Portfolio";
$app->title = "Title";
$app->description = "Example";
$app->smarty->assign("lang", $app->lang);
$app->smarty->assign("app", $app);

$router = new Router();

$page_loader = new PageLoader();
$page_loader->loadPages();
$page_loader->loadRoutes($app, $router);
$app->smarty->assign("nav", $page_loader->getNav($app->smarty));

$router->add("/", "get", function() use(&$app) {
    $app->title = "Title";
    $app->content = $app->smarty->fetch("templates/pages/home.tpl", []);
});

/*
$router->add("/blog/{id}", "get", function($res) use(&$app, &$blog) {
    $post = $blog->posts[$res->attr["id"]];

    $app->title = $post->get("title");
    $description = substr(strip_tags($post->get("content")), 0, 150);
    $app->description = "${description} ...";

    $app->content = $app->smarty->fetch("templates/pages/post.tpl", ["post" => $post]);
});

$router->add("/blog", "get", function() use(&$app, &$blog) {
    $app->title = "Title - Blog";
    $app->content = $app->smarty->fetch("templates/pages/blog.tpl", ["posts" => $blog->posts]);
});

$router->add("/projects", "get", function() use(&$app) {
    $app->title = "Title - Projects";
    $app->content = $app->smarty->fetch("templates/pages/projects.tpl", []);
});*/

$router->add("/set-lang", "get", function() use(&$app) {
    $app->lang->setLang($_GET["lang"]);
    exit();
});

if (!$router->begin()) {
    $app->content = $app->smarty->fetch("templates/pages/404.tpl", []);
    http_response_code(404);
}

echo $app->render();
