<?php

/**
 * Classe de gestion des menus top
 * 
 * PHP version 7.1.9
 * 
 * @category Category
 * @package  Package
 * @author   Joel <joel.developpeur@gmail.com>
 * @license  url.com License
 * @link     Link
 */

namespace App\View\Page;

use App\File\Image\Logo;
use App\Model\User\User;
use App\View\Model\CategoryView;
use App\View\Snippet;

/**
 * Perlet de gérer tout ce qui concerne la barre de navigation supérieure.
 * 
 * @category Category
 * @package  App\
 * @author   Joel <joel.developpeur@gmail.com>
 * @license  url.com License
 * @link     Link
 */
class Navbar extends Snippet
{
    private $brandImgSrc;
    private $userAvatarSrc;

    public function __construct(string $brandImgSrc = null, string $userAvatarSrc = null)
    {
        $this->brandImgSrc = Logo::LOGOS_DIR_URL ."/logo-colored.png";
        $this->userAvatarSrc = $userAvatarSrc;
    }

    /**
     * Barre de navigation supérieure de la partie publique.
     * 
     * @return string
     */
    public function get()
    {
        $appUrl = APP_URL;
        $logoAltText = Logo::ALT_TEXT;
        $categoryView = new CategoryView();

        return <<<HTML
        <header id="header-wrap">
            <nav class="navbar navbar-expand-lg fixed-top scrolling-navbar top-nav-collapse">
                <div class="container">
                    <div class="navbar-header">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-navbar" aria-controls="main-navbar" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                            <span class="lni-menu"></span>
                            <span class="lni-menu"></span>
                            <span class="lni-menu"></span>
                        </button>
                        <a href="{$appUrl}" class="navbar-brand"><img id="logo" src="{$this->brandImgSrc}" alt="{$logoAltText}"></a>
                    </div>
                    <div class="collapse navbar-collapse" id="main-navbar">
                        <ul class="navbar-nav mr-auto">
                            <li>
                                <a class="nav-link" href="/">Accueil</a>
                            </li>
                            {$categoryView->navbarList()}
                            <li>
                                <a class="nav-link" href="annonces">Nos Annonces</a>
                            </li>
                        </ul>
                        {$this->navbarMenu()}
                        <a class="tg-btn" href="post"><i class="lni-pencil-alt"></i> Poster une annonce</a>
                    </div>
                </div>
                {$this->mobileMenu()}
            </nav>
        </header>
HTML;
    }

    /**
     * Le menu affiché sur les écrans des mobiles.
     * 
     * @return string
     */
    private function mobileMenu()
    {
        return <<<HTML
        <ul class="mobile-menu">
            {$this->mobileNavbar()}
        </ul>
HTML;
    }

    /**
     * Permet d'afficher le logo dans la navbar.
     * 
     * @param string $brandSrc Le lien vers l'image.
     * @param string $href     L'url exécuté lors du click sur le logo.
     * @param string $caption  Le texte à afficher si l'image introuvable.
     * 
     * @return string
     */
    private function navbarBrand(string $brandSrc, string $href = null, string $caption = null)
    {
        return <<<HTML
        <a class="navbar-brand" href="{$href}">
            <img src="{$brandSrc}" alt="{$caption}" class="brand" style="width:15rem">
        </a>
HTML;
    }

    /**
     * Retourne l'image miniature de l'utilisateur connecté dans la navbar.
     * 
     * @param string $avatarSrc
     * @param string $caption
     * 
     * @return string
     */
    private function navbarUserAvatar(string $avatarSrc, string $caption = null)
    {
        return <<<HTML
        <div>
            <img src="{$avatarSrc}" alt="{$caption}" class="navbar-user-avatar img-circle shdw mr-2"/>
        </div>
HTML;
    }

    /**
     * Affiche le navbar des utilisateurs.
     * 
     * @return string
     */
    public function navbarMenu()
    {
        if (User::isAuthenticated()) {
            $content = $this->navbar(User::authenticated());
        } else {
            $content = $this->navbarForUnconnectedUser();
        }

        return <<<HTML
        <ul class="sign-in">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="lni-user"></i> Mon compte</a>
                <div class="dropdown-menu">
                    {$content}                    
                </div>
            </li>
        </ul>
HTML;
    }

    /**
     * Affiche la navbar dans le menu version mobile.
     * 
     * @return string
     */
    public function mobileNavbar()
    {
        if (User::isAuthenticated()) {
            return self::mobileNavbarForConnectedUser(User::authenticated());
        } else {
            return $this->mobileNavbarForUnconnectedUser();
        }
    }

    /**
     * Menu qui sera affiché si l'utilisateur n'est pas encore authentifé.
     * 
     * @return string
     */
    private function navbarForUnconnectedUser()
    {
        return <<<HTML
        <a class="dropdown-item" href="register"><i class="lni-user"></i> S'inscrire</a>
        <a class="dropdown-item" href="sign-in"><i class="lni-lock"></i> Connexion</a>
HTML;
    }

    /**
     * Affiche le menu dans la version mobile pour un visitor non connecté.
     * 
     * @return string
     */
    private function mobileNavbarForUnconnectedUser()
    {
        return <<<HTML
        <li><a href="register"><i class="lni-user"></i> S'inscrire</a></li>
        <li><a href="sign-in"><i class="lni-lock"></i> Connexion</a></li>
HTML;
    }

    /**
     * Menu qui sera affiché si l'utilisateur s'est authentifié.
     * 
     * @return string
     */
    public function navbar()
    {
        if (User::isAuthenticated()) {

            $registered = User::authenticated();

            $administrationLink = User::authenticated()->isAdministrator()
                ? '<a class="dropdown-item" href="administration"><i class="lni-dashboard"></i> Administration</a>'
                . '<a class="dropdown-item" href="administration/users"><i class="lni-users"></i> Gérer les utilisateurs</a>'
                . '<a class="dropdown-item" href="register"><i class="lni-user"></i> Ajouter un compte</a>'
                : null;

            return <<<HTML
            {$administrationLink}
            <a class="dropdown-item" href="{$registered->getProfileLink()}/posts"><i class="lni-dashboard"></i> Mes annonces</a>
            <a class="dropdown-item" href="sign-out"><i class="lni-close"></i> Déconnexion</a>
HTML;
        }
    }

    /**
     * Affiche le menu dans la version mobile pour un utilisateur connecté.
     * 
     * @return string
     */
    public static function mobileNavbarForConnectedUser()
    {
        if (User::authenticated()) {
            $registered = User::authenticated();

            $administrationLink = User::authenticated()->isAdministrator()
                ? '<a class="dropdown-item" href="administration"><i class="lni-dashboard"></i> Administration</a>'
                . '<a class="dropdown-item" href="administration/users"><i class="lni-users"></i> Gérer les utilisateurs</a>'
                . '<a class="dropdown-item" href="register"><i class="lni-user"></i> Ajouter un compte</a>'
                : null;

            return <<<HTML
            <li><a href="/">Accueil</a></li>
            {$administrationLink}
            <li>
                <a>Mon compte</a>
                <ul class="dropdown">
                    <!-- <li><a href="{$registered->getProfileLink()}"><i class="lni-user"></i> Mon profil</a></li> -->
                    <li><a href="{$registered->getProfileLink()}/posts"><i class="lni-wallet"></i> Mes annonces</a></li>
                    <li><a href="sign-out"><i class="lni-close"></i> Déconnexion</a></li>
                </ul>
            </li>
HTML;
        }
    }

}