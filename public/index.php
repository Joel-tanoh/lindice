<?php

/**
 *  Fichier de routage de l'application.
 */

session_start();

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.php";

use App\Route\Router;
use App\Model\User\Visitor;
use App\View\Page\Page;
use App\View\View;

try {
    
    Visitor::manage();

    $router = new Router(trim($_SERVER["REQUEST_URI"], "/"));

    $router->get("/", "App\Controller\AppController@index");
    $router->get("/annonces", "App\Controller\UserController\UserController@readAnnounces");
    $router->get("/register", "App\Controller\UserController\UserController@register");
    $router->get("/sign-in", "App\Controller\UserController\RegisteredController@signIn");
    $router->get("/sign-out", "App\Controller\UserController\RegisteredController@signOut");
    $router->get("/post", "App\Controller\UserController\RegisteredController@post");
    $router->get("/about-us", "App\Controller\UserController\UserController@readAboutUs");
    $router->get("/faq", "App\Controller\UserController\UserController@readFAQ");
    $router->get("/in-progress", "App\Controller\AppController@pageNotFound");
    $router->get("/forgot-password", "App\Controller\UserController\RegisteredController@forgotPassword");
    $router->get("/administration", "App\Controller\UserController\AdministratorController@index");
    $router->get("/administration/users", "App\Controller\UserController\AdministratorController@readUsers");
    $router->get("/administration/annonces", "App\Controller\UserController\AdministratorController@administrateAnnounces");
    
    $router->get("/:category", "App\Controller\UserController\UserController@readCategory");
    $router->get("/:1/:2", "App\Controller\AppController@subRouter");
    $router->get("/:1/:2/:3", "App\Controller\AppController@subRouter");
    $router->get("/:1/:2/:3/:4", "App\Controller\AppController@subRouter");
    $router->get("/:1/:2/:3/:4/:5", "App\Controller\AppController@subRouter");

    $router->post("/register", "App\Controller\UserController\UserController@register");
    $router->post("/sign-in", "App\Controller\UserController\RegisteredController@signIn");
    $router->post("/post", "App\Controller\UserController\RegisteredController@post");
    $router->post("/forgot-password", "App\Controller\UserController\RegisteredController@forgotPassword");
    $router->post("/newsletters/register", "App\Controller\UserController\VisitorController@registerToNewsletter");
    $router->post("/annonces/search", "App\Controller\UserController\UserController@searchAnnounce");
    $router->post("/:1/:2", "App\Controller\SearchController@subRouter");
    $router->post("/:1/:2/:3", "App\Controller\AppController@subRouter");

    $router->run();

} catch(Exception $e) {
    $page = new Page("Le leader des petites annonces en Côte d'Ivoire &#149; L'indice", View::pageNotFound($e, "404"));
    $page->show();
}