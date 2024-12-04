<?php

namespace App\Controller;

use App\Controller\UserController\RegisteredController;
use App\Controller\UserController\AdministratorController;
use App\Controller\UserController\UserController;
use App\Model\Post\Announce;
use App\Model\Category;
use App\Model\Model;
use App\Model\User\User;
use App\View\Page\Page;
use App\View\View;
use Exception;

abstract class AppController
{
    /** @var array Les actions possibles au sein de l'application. */
    protected static $actions = [
        "create"
        , "read"
        , "update"
        , "delete"
        , "show"
        , "view"
        , "validate"
        , "suspend"
        , "block"
        , "comment"
    ];

    /**
     * Index du site.
     */
    public static function index()
    {
        $page = new Page("Le leader des petites annonces de Côte d'Ivoire &#149; L'indice", View::index());
        $page->setDescription("Pour tous vos besoins, vos annonces, besoins vestimentaires, appareils electroménagers, ventes d'équipements, vous pouvez faire confiance au meilleur site d'annonce de Côte d'Ivoire, L'indice est la reponse à vos besoins.");
        $page->show();
    }

    /**
     * Une couche qui permet de gérer le routage vers le bon controller
     * lorsqu'il le faut.
     * 
     * @param array $params La liste des paramètres de la route.
     * @return void
     */
    public static function subRouter(array $params)
    {
        if (Category::isCategorySlug($params[1]) && Announce::valueIssetInDB("slug", $params[2], Announce::TABLE_NAME)) {

            if (isset($params[3]) && self::isAction($params[3])) {
                return RegisteredController::manageAnnounce($params);
            }

            return UserController::readAnnounce($params);
        }

        elseif ($params[1] === "users") {
 
            if (Model::valueIssetInDB("code", $params[2], User::TABLE_NAME)) {

                if (isset($params[3])) {

                    if ($params[3] === "posts") {
                        return UserController::readRegisteredAnnounces($params);
                    } elseif (self::isAction($params[3])) {
                        return RegisteredController::selfManage($params);
                    }
                }

                else {
                    return AdministratorController::readUser($params);
                }

                return UserController::readRegisteredAnnounces($params);

            } else {
                throw new Exception();
            }
        }
        
        elseif ($params[1] === "administration") {

            if (isset($params[2])) {

                if ($params[2] === "users") {

                    if (isset($params[3])) {

                        if (Model::valueIssetInDB("pseudo", $params[3], User::TABLE_NAME)) {

                            if (!empty($params[4])) {
                                return RegisteredController::myDashboard($params);
                            }
        
                            return RegisteredController::myProfile($params);
                        }

                    }

                    return AdministratorController::readUsers();

                } elseif ($params[2] === "annonces") {
                    return AdministratorController::administrateAnnounces($params);
                }
            }

            return RegisteredController::administrationIndex();
        }

        else {
            throw new Exception();
        }
    }

    /**
     * Gère les actions qu'on veut faire dans l'application.
     * @return bool
     */
    public static function isAction(string $action)
    {
        return in_array($action, self::$actions);
    }

    /**
     * Cette page s'affiche pour les ressources pas encore développées.
     */
    public static function pageNotFound()
    {
        $page = new Page("Le leader des petites annonces de Côte d'Ivoire &#149; L'indice", View::pageNotFound("Page en cours de développement", "En cours"));
        $page->show();
    }

}