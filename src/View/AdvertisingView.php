<?php

namespace App\View;

use App\File\Image\Image;
use App\Utility\AdvertisingEngine;

class AdvertisingView extends View
{
    /** @var \App\Utility\AdvertisingEngine */
    private $advertisingEngine;

    public function __construct()
    {
        $this->advertisingEngine = new AdvertisingEngine();
    }

    /**
     * Bloc de code pour la publicité. Elle doit prendre en paramètre une
     * image de taille 300x400.
     * 
     * @return string
     */
    public function advertisementSection()
    {
        return <<<HTML
        <div class="widget">
            <h4 class="widget-title">Publicité</h4>
            <div class="add-box">
                <img class="img-fluid" src="assets/img/img1.jpg" alt="">
            </div>
        </div>
HTML;
    }

    /**
     * Pour cette application, cette méthode permet d'afficher une publicité
     * au dessus de la barre de navigation supérieure.
     * 
     * @return string
     */
    public function top()
    {
        return <<<HTML
        <div class="row d-flex justify-content-center align-items-center my-3">
            <div class="col-12 col-md-9">
                <div class="advertising top slide-container">
                    <span class="text-muted">Publicité</span>
                    {$this->showImages($this->advertisingEngine->getImages("top"))}
                </div>
            </div>
            <div class="col-12 col-md-3 py-3 py-md-0">{$this->newsGif()}</div>
        </div>
HTML;
    }
    
    /**
     * Permet d'afficher une publicité les cotés de l'application.
     * 
     * @return string
     */
    public function side()
    {
        return <<<HTML
        <div class="advertising side slide-container">
            {$this->showImages($this->advertisingEngine->getImages("side"))}
        </div>
HTML;
    }


    /**
     * Permet d'afficher une publicité le cotés gauche de l'application.
     * 
     * @return string
     */
    public function left()
    {
        return <<<HTML
        <div class="advertising left slide-container">
            {$this->showImages($this->advertisingEngine->getImages("left"))}
        </div>
HTML;
    }

    /**
     * Permet d'afficher une publicité le coté droit de l'application.
     * 
     * @return string
     */
    public function right()
    {
        return <<<HTML
        <aside>
            <span class="text-muted">Publicité</span>
            <div class="advertising right slide-container">
                {$this->showImages($this->advertisingEngine->getImages("right"))}
            </div>
        </aside>
HTML;
    }

    /**
     * Affiche les images.
     * 
     * @param array $imagesSrc Un tableau contenant les sources des images.
     */
    private function showImages(array $imagesSrc)
    {
        if (empty($imagesSrc)) {
            return "<span>ESPACE PUBLICITAIRE</span>";
        }
        
        $return = null;
        foreach($imagesSrc as $imgSrc) {
            $return .= <<<HTML
            <div class="effect slide">
                <img class="img-fluid" src="{$imgSrc}" alt="publicité annonces vente location de biens">
            </div>
HTML;
        }
        return $return;
    }

    /**
     * Permet d'afficher le gif "nouveauté"
     */
    private function newsGif()
    {
        $gifSrc = Image::IMG_DIR_URL. "/gifs/gif-nouveau-3.gif" ;
        return <<<HTML
        <a href="{$this->bookLink()}"><img class="img-fluid" src="{$gifSrc}"/></a>
HTML;
    }

    /**
     * Lien du livre
     */
    private function bookLink()
    {
        return "https://online.fliphtml5.com/hslef/ljnz/#p=1";
    }

}