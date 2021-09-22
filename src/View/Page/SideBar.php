<?php

/**
 * Description
 * 
 * PHP version 7.1.9
 * 
 * @category Category
 * @package  Package
 * @author   Joel <joel.developpeur@gmail.com>
 * @license  url.com license_name
 * @version  "CVS: cvs_id"
 * @link     Link
 */

namespace App\View\Page;

use App\Model\User\User;
use App\View\Model\User\AdministratorView;
use App\View\Snippet;

/**
 * Permet de gérer les barres de menu sur le coté.
 * 
 * @category Category
 * @package  Package
 * @author   Joel <joel.developpeur@gmail.com>
 * @license  url.com license_name
 * @version  "Release: package_version"
 * @link     Link
 */
class SideBar extends Snippet
{

    /**
     * Affiche la sidebar de l'utilisateur afin de lui permettre de naviguer dans 
     * sa session personnelle.
     * 
     * @return string
     */
    public function sidebarNav()
    {
        if (User::isAuthenticated()) {
            $registered = User::authenticated();
            return <<<HTML
            <aside class="col-sm-12 col-md-3 col-lg-3 page-sidebar">
                {$this->sidebarContent($registered)}
            </aside>
HTML;
        }
    }

    /**
     * Affiche l'avatar et les liens de la sidebar de l'utilisateur.
     * 
     * @return string
     */
    private function sidebarContent() : string
    {
        if (User::isAuthenticated()) {

            $registered = User::authenticated();

            if ($registered->isAdministrator()) {
                $sidebarLinks = $this->administratorSidebar();
            } else {
                $sidebarLinks = $this->registeredSidebar();
            }
            
            return <<<HTML
            <div class="sidebar-box">
                <div class="user">
                    <figure>
                        <a href="{$registered->getProfileLink()}"><img src="{$registered->getAvatarSrc()}" alt="Image de {$registered->getPseudo()}" title="Mon profil"></a>
                    </figure>
                    <div class="usercontent">
                        <h3><a href="{$registered->getProfileLink()}" class="text-white">{$registered->getFullName()}</a></h3>
                        <h4>{$registered->getType()}</h4>
                    </div>
                </div>
                {$sidebarLinks}
            </div>
HTML;
        } else {
            return <<<HTML
            <div class="sidebar-box">
                <nav class="navdashboard">
                    <p class="text-muted">Veuillez vous <a href="sign-in">connecter</a>, ou vous <a href="register">inscrire</a> si vous n'avez pas de compte</p>
                </nav>
            </div>
HTML;
        }
    }
    
    /**
     * Affiche le menu du dashboard de l'utilisateur.
     * @return string
     */
    private function registeredSidebar() : string
    {
        if (User::isAuthenticated()) {
            $registered = User::authenticated();
            return <<<HTML
            <nav class="navdashboard">
                <ul>
                    {$this->defineSidebarLink("Mes annonces", $registered->getProfileLink(). "/posts", "lni-dashboard")}
                    {$this->defineSidebarLink("Déconnexion", "sign-out", "lni-enter")}
                </ul>
            </nav>
HTML;
        } else {
            return <<<HTML
            <nav class="navdashboard">
                <p class="text-muted">Veuillez vous <a href="sign-in">connecter</a>, ou vous <a href="register">inscrire</a> si vous n'avez pas de compte</p>
            </nav>
HTML;
        }
    }

    /**
     * Affiche le menu du dashboard de l'utilisateur.
     * 
     * @return string
     */
    private function administratorSidebar() : string
    {
        if (User::isAuthenticated() && User::authenticated()->isAdministrator()) {

            $administrator = User::authenticated();
            $sidebar = new SideBar;

            return <<<HTML
            <nav class="navdashboard">
                <ul>
                    {$sidebar->defineSidebarLink("Voir toutes les annonces", "/administration/annonces", "lni-pencil-alt")}
                    {$sidebar->defineSidebarLink("Gérer les utilisateurs", "/administration/users", "lni-users")}
                    {$sidebar->defineSidebarLink("Ajouter un compte", "/register", "lni-user")}
                    {$sidebar->defineSidebarLink("Mes annonces", $administrator->getProfileLink(). "/posts", "lni-dashboard")}
                    {$sidebar->defineSidebarLink("Déconnexion", "sign-out", "lni-enter")}
                </ul>
            </nav>
HTML;
        } else {
            return <<<HTML
            <nav class="navdashboard">
                <p class="text-muted">Veuillez vous <a href="sign-in">connecter</a>, ou vous <a href="register">inscrire</a> si vous n'avez pas de compte</p>
            </nav>
HTML;
        }
    }

    /**
     * Permet de créer une ligne de lien dans la sidebar du user.
     * 
     * @param string $text
     * @param string $href
     * @param string $iconClass
     * 
     * @return string
     */
    private function defineSidebarLink(string $text, string $href, string $iconClass = null)
    {
        return <<<HTML
        <li>
            <a href="{$href}">
                <i class="{$iconClass}"></i><span>{$text}</span>
            </a>
        </li>
HTML;
    }

}