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
 * @version  GIT: Joel_tanoh
 * @link     Link
 */

namespace App\View\Page;

use App\File\Image\Logo;
use App\View\View;
use App\View\Page\Template;

/**
 * Classe qui gère tout ce qui est en rapport à une page.
 *  
 * @category Category
 * @package  App
 * @author   Joel <joel.developpeur@gmail.com>
 * @license  url.com license_name
 * @version  Release: 1
 * @link     Link
 */
class Page extends View
{
    private $metaTitle;
    private $description;
    private $view;
    private $navbarState;
    private $footerState;
    private $cssFiles = [];
    private $jsFiles = [];

    /**
     * @param string   $metaTitle   Le titre qui sera affiché dans la page.
     * @param string   $view        Le contenu de la page qui sera affiché dans
     *                              la page.
     * @param string   $description La description de la page.
     * @param string[] $cssFiles    Un tableau contenant des urls de fichiers css.
     * @param string[] $jsFiles     Un tableau contenant des urls de fichiers js.
     */
    public function __construct(
        string $metaTitle = null, 
        string $view = null, 
        string $description = null, 
        bool $navbarState = true, 
        bool $footerState = true, 
        array $cssFiles = null, 
        array $jsFiles = null
    ) {
        $this->metaTitle = $metaTitle;
        $this->description = $description;
        $this->view = $view;
        $this->navbarState = $navbarState;
        $this->footerState = $footerState;
        $this->cssFiles = $cssFiles;
        $this->jsFiles = $jsFiles;
    }

    /**
     * Affiche la page.
     * 
     * @return string
     **/
    public function show()
    {
        echo <<<HTML
        {$this->debutDePage("fr")}
        <head>
            {$this->metaData()}
            {$this->returnCssTags()}
        </head>
        <body>
            {$this->template()}
            {$this->returnJsTags()}
        </body>
        </html>
HTML;
    }

    /**
     * Template
     * 
     * @return string
     */
    private function template()
    {
        $navbar = new Navbar();
        $footer = new Footer();
        $template = new Template();

        if ($this->navbarState && $this->footerState) {
            return $template->navbarAndContentAndFooter(
                $navbar->get(), $this->view, $footer->get()
            );
        } elseif ($this->navbarState && !$this->footerState) {
            return $template->navbarAndContent($navbar->get(), $this->view);
        } elseif (!$this->navbarState && $this->footerState) {
            return $template->contentAndFooter($this->view, $footer->get());
        } else {
            return $this->view;
        }
    }

    /**
     * Permet de modifier le metaTitle de la page.
     * 
     * @param string $metaTitle
     * 
     * @return void
     */
    public function setMetaTitle(string $metaTitle)
    {
        $this->metaTitle = $metaTitle;
    }

    /**
     * Permet de modifier la meta description de la page.
     * 
     * @param string $description
     * 
     * @return void
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * Permet de modifier le contenu de la page.
     * 
     * @param string $view
     * 
     * @return void
     */
    public function setView(string $view)
    {
        $this->view = $view;
    }

    /**
     * Permet de spécifier si l'on veut voir la navbar sur la page.
     * 
     * @param bool $navbarState True si on veut que la navbar apparaisse sur la page,
     *                          False sinon.
     */
    public function setNavbar(bool $navbarState)
    {
        $this->navbarState = $navbarState;
    }

    /**
     * Permet de spécifier si l'on veut voir le footer sur la page.
     * 
     * @param bool $navbarState true si on veut que le footer apparaisse sur la page,
     *                          false sinon.
     */
    public function setFooter(bool $footerState)
    {
        $this->footerState = $footerState;
    }

    /**
     * Code du début de la page.
     * 
     * @param string $htmlLanguage
     * 
     * @return string
     */
    private function debutDePage($htmlLanguage = "fr")
    {
        return <<<HTML
        <!DOCTYPE html>
        <html lang="{$htmlLanguage}">
HTML;
    }

    /**
     * Retourne les balises meta
     * 
     * @return string
     */
    private function metaData(string $base = APP_URL)
    {
        return <<<HTML
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="description" content="{$this->description}">
        <base href="{$base}">
        <title>{$this->metaTitle}</title>
        {$this->favicon()}
HTML;
    }
    
    /**
     * Retourne le code pour les icones.
     * 
     * @return string
     */
    private function favicon(string $logosDir = Logo::LOGOS_DIR_URL)
    {
        return <<<HTML
        <link rel="icon" href="{$logosDir}/faviconx2.png" type="image/png">
        <link rel="shortcut icon" href="{$logosDir}/faviconx2.png" type="image/png">
HTML;
    }

    /**
     * Retourne les fichiers css selon le thème passé en paramètre.
     *  
     * @return string
     */
    private function returnCssTags()
    {
        $cssTagsList = null;
        $this->cssFilesList();

        foreach($this->cssFiles as $cssFile) {
            $cssTagsList .= $this->cssTag($cssFile["href"]);
        }

        return $cssTagsList;
    }

    /**
     * Retourne les fichiers JS appelés.
     * 
     * @return string
     */
    private function returnJsTags()
    {
        $jsTagsList = null;
        $this->jsFilesList();
        foreach($this->jsFiles as $jsFile) {
            $jsTagsList .= $this->jsTag($jsFile["src"], $jsFile["async"]);
        }
        return $jsTagsList;
    }

    /**
     * Retourne les fichiers CSS utilisés sur toutes les pages.
     * 
     * @return string
     */
    private function cssFilesList()
    {
        // Bootstrap CSS
        $this->addCss("https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css");
        // Fontawesome
        $this->addCss("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css");
        // Animate
        $this->addCss("https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css");
        // Slicknav
        $this->addCss("https://cdnjs.cloudflare.com/ajax/libs/SlickNav/1.0.10/slicknav.min.css");
        // Nivo Lightbox
        $this->addCss("https://cdnjs.cloudflare.com/ajax/libs/nivo-lightbox/1.3.1/nivo-lightbox.min.css");
        // Summernote
        $this->addCss("https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.css");
        // Owl Theme
        $this->addCss(ASSETS_DIR_URL."/css/owl.theme.css");
        // Owl carousel
        $this->addCss(ASSETS_DIR_URL."/css/owl.carousel.css");
        // Color Switcher
        $this->addCss(ASSETS_DIR_URL."/css/color-switcher.css");
        // Settings
        $this->addCss(ASSETS_DIR_URL."/css/settings.css");
        // Icon
        $this->addCss(ASSETS_DIR_URL."/fonts/line-icons.css");
        // Responsive Style
        $this->addCss(ASSETS_DIR_URL."/css/responsive.css");
        // Main Style
        $this->addCss(ASSETS_DIR_URL."/css/main.css");
    }

    /**
     * Retourne les fichiers JS appelés sur toutes les pages.
     * @return string
     */
    private function jsFilesList()
    {
        // Jquery
        $this->addJs(ASSETS_DIR_URL."/js/jquery-min.js");
        // Popper
        $this->addJs("https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.8.6/umd/popper.min.js");
        // Fontawesome
        $this->addJs("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/js/all.min.js");    
        // Bootstrap
        $this->addJs("https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js");       
        // WOW
        $this->addJs("https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js");      
        // Carousel
        $this->addJs("https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js");   
        // SlickNav
        $this->addJs("https://cdnjs.cloudflare.com/ajax/libs/SlickNav/1.0.10/jquery.slicknav.min.js");
        // Summernote
        $this->addJs("https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.js");
        $this->addJs("https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/lang/summernote-fr-FR.min.js");
        // CounterUp
        $this->addJs(ASSETS_DIR_URL."/js/jquery.counterup.min.js");
        // Waypoints
        $this->addJs(ASSETS_DIR_URL."/js/waypoints.min.js");        
        // Nivo Lightbox
        $this->addJs(ASSETS_DIR_URL."/js/nivo-lightbox.js");       
        // Form Validator
        $this->addJs(ASSETS_DIR_URL."/js/form-validator.min.js");      
        // Contact Form script
        $this->addJs(ASSETS_DIR_URL."/js/contact-form-script.min.js");      
        // Main Js
        $this->addJs(ASSETS_DIR_URL."/js/main.js");
    }

    /**
     * Permet d'ajouter un fichier css à cette page.
     * 
     * @param $cssFile L'url du fichier Css.
     */
    public function addCss(string $href)
    {
        $this->cssFiles[] = [
            "href" => $href
        ];
    }

    /**
     * Permet d'ajouter un fichier js à cette page.
     * 
     * @param string $jsFileUrl      L'url du fichier Js.
     * @param string $async          Pour dire si le fichier est uploadé de façon asynchrone ou pas.
     */
    public function addJs(string $src, string $async = null)
    {
        $this->jsFiles[] = [
            "src" => $src,
            "async" => $async,
        ];
    }

    /**
     * Retourne une balise link pour le fichiers css.
     * 
     * @param string $href Url du fichier css.
     * 
     * @return string
     */
    private function cssTag(string $href)
    {
        return <<<HTML
        <link rel="stylesheet" type="text/css" href="{$href}">
HTML;
    }

    /**
     * Retourne une balise script pour appeler le fichier javascript passé
     * en paramètre.
     * 
     * @param string $jsFileUrl Url du fichier javascript.
     * 
     * @return string
     */
    private function jsTag($jsFileUrl, string $async = null)
    {
        if (null !== $async) {
            $async = "async = " . $async;
        }

        return <<<HTML
        <script src="{$jsFileUrl}" {$async}></script>
HTML;
    }

}