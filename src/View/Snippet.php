<?php

/**
 * Fichier de classe.
 * 
 * @author Joel <Joel.developpeur@gmail.com>
 */

namespace App\View;

use App\File\Image\Image;
use App\Router\Router;
use App\Model\Entity;
use App\Model\User\Visitor;
use App\View\Effect\Animation\Slider\Slide;
use App\View\Effect\Animation\Slider\Slider;
use App\View\Model\CategoryView;
use App\View\Model\User\UserView;

/**
 * Gère les fragments de code.
 * 
 * @author Joel <Joel.developpeur@gmail.com>
 */
class Snippet extends View
{

    /**
     * Hero Area
     * 
     * @param bool $showWelcomeText
     * 
     * @return string
     */
    public function heroArea(bool $showWelcomeText = null)
    {
        $searchView = new SearchView();
        $welcomeText = null;

        if ($showWelcomeText) {
            $welcomeText = <<<HTML
            <h1 class="head-title">Bienvenue sur <span class="year">L'indice</span></h1>
            <p>Achetez et vendez de tout, des voitures d'occasion aux téléphones mobiles et aux ordinateurs, <br> ou recherchez une propriété, des emplois et plus encore</p>
HTML;
        }

        return <<<HTML
        <div id="hero-area">
            <div class="overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-xs-12 text-center">
                        <div class="contents">
                            {$welcomeText}
                            {$searchView->heroAreaSearchBar()}
                        </div>
                    </div>
                </div>
            </div>
        </div>
HTML;
    }

    /**
     * 2eme format de bannière avec un formulaire de recherche.
     * 
     * @return string
     */
    public function heroAreaWithSearchBar()
    {
        $searchView = new SearchView();

        return <<<HTML
        <div id="hero-area">
            <div class="overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-xs-12 text-center">
                        <div class="contents-ctg">
                            {$searchView->heroAreaSearchBar()}
                        </div>
                    </div>
                </div>
            </div>
        </div>
HTML;
    }

    /**
     * Le header qui permet d'afficher le nom de la page sur laquelle
     * on se trouve avec le breadcrumbs.
     * 
     * @param string $title
     * @param string $current
     * 
     * @return string
     */
    public function pageHeader(string $title, string $current) : string
    {
        $home = APP_URL;

        return <<<HTML
        <div class="page-header" style="background: url(assets/img/slides/hero-area-2.jpg);">
            <div class="container">
                <div class="row">         
                    <div class="col-md-12">
                        <div class="breadcrumb-wrapper">
                            <h2 class="product-title">{$title}</h2>
                            <ol class="breadcrumb">
                                <li><a href="$home">Accueil /</a></li>
                                <li class="current">{$current}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
HTML;
    }

    /**
     * Affiche un slider qui fait défiler des images.
     */
    public function slider()
    {
        return (new Slider)->show();
    }

    /**
     * Counter Area. C'est un bloc de code qui affiche les statistiques
     * avec un effet d'incrémentation très rapide.
     * 
     * @return string
     */
    public function counterArea()
    {
        return <<<HTML
        <section class="counter-section section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-6 work-counter-widget text-center">
                        <div class="counter">
                            <div class="icon"><i class="lni-layers"></i></div>
                            <h2 class="counterUp">12090</h2>
                            <p>Annonces</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 work-counter-widget text-center">
                        <div class="counter">
                            <div class="icon"><i class="lni-map"></i></div>
                            <h2 class="counterUp">350</h2>
                            <p>Catégories</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 work-counter-widget text-center">
                        <div class="counter">
                            <div class="icon"><i class="lni-user"></i></div>
                            <h2 class="counterUp">23453</h2>
                            <p>Membres actifs</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 work-counter-widget text-center">
                        <div class="counter">
                            <div class="icon"><i class="lni-briefcase"></i></div>
                            <h2 class="counterUp">250</h2>
                            <p>Annonces Prémiums</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
HTML;
    }

    /**
     * Pricing Section. La section qui affiche le code pour les prémiums.
     * 
     * @return string
     */
    public function pricingSection()
    {
        return <<<HTML
        <section id="pricing-table" class="section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mainHeading">
                            <h2 class="section-title">Select A Package</h2>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-xs-12">
                        <div class="table">
                            <div class="icon">
                                <i class="lni-gift"></i>
                            </div>
                            <div class="title">
                                <h3>SILVER</h3>
                            </div>
                            <div class="pricing-header">
                                <p class="price-value"><sup>$</sup>29<span>/ Mo</span></p>
                            </div>
                            <ul class="description">
                                <li><strong>Free</strong> ad posting</li>
                                <li><strong>No</strong> Featured ads availability</li>
                                <li><strong>For 30</strong> days</li>
                                <li><strong>100%</strong> Secure!</li>
                            </ul>
                            <button class="btn btn-common">Buy Now</button>
                        </div> 
                    </div>
                    <div class="col-lg-4 col-md-6 col-xs-12">
                        <div class="table" id="active-tb">
                            <div class="icon">
                                <i class="lni-leaf"></i>
                            </div>
                            <div class="title">
                                <h3>STANDARD</h3>
                            </div>
                            <div class="pricing-header">
                                <p class="price-value"><sup>$</sup>89<span>/ Mo</span></p>
                            </div>
                            <ul class="description">
                                <li><strong>Free</strong> ad posting</li>
                                <li><strong>6</strong> Featured ads availability</li>
                                <li><strong>For 30</strong> days</li>
                                <li><strong>100%</strong> Secure!</li>
                            </ul>
                            <button class="btn btn-common">Buy Now</button>
                        </div> 
                    </div>
                    <div class="col-lg-4 col-md-6 col-xs-12">
                        <div class="table">
                            <div class="icon">
                                <i class="lni-layers"></i>
                            </div>
                            <div class="title">
                                <h3>PLATINIUM</h3>
                            </div>
                            <div class="pricing-header">
                                <p class="price-value"><sup>$</sup>99<span>/ Mo</span></p>
                            </div>
                            <ul class="description">
                                <li><strong>Free</strong> ad posting</li>
                                <li><strong>20</strong> Featured ads availability</li>
                                <li><strong>For 25</strong> days</li>
                                <li><strong>100%</strong> Secure!</li>
                            </ul>
                            <button class="btn btn-common">Buy Now</button>
                        </div> 
                    </div>
                </div>
            </div>
        </section>
HTML;
    }

    /**
     * Testimonail Section. Section des témoignages.
     * 
     * @return string
     */
    public function testimonialSection()
    {
        return <<<HTML
        <section class="testimonial section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div id="testimonials" class="owl-carousel">
                            <div class="item">
                                <div class="testimonial-item">
                                    <div class="img-thumb">
                                        <img src="assets/img/testimonial/img1.png" alt="">
                                    </div>
                                    <div class="content">
                                        <h2><a href="#">John Doe</a></h2>
                                        <p class="description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo quidem, excepturi facere magnam illum, at accusantium doloremque odio.</p>
                                        <h3>Developer at of <a href="#">xyz company</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="testimonial-item">
                                    <div class="img-thumb">
                                        <img src="assets/img/testimonial/img2.png" alt="">
                                    </div>
                                    <div class="content">
                                        <h2><a href="#">Jessica</a></h2>
                                        <p class="description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo quidem, excepturi facere magnam illum, at accusantium doloremque odio.</p>
                                        <h3>Developer at of <a href="#">xyz company</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="testimonial-item">
                                    <div class="img-thumb">
                                        <img src="assets/img/testimonial/img3.png" alt="">
                                    </div>
                                    <div class="content">
                                        <h2><a href="#">Johnny Zeigler</a></h2>
                                        <p class="description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo quidem, excepturi facere magnam illum, at accusantium doloremque odio.</p>
                                        <h3>Developer at of <a href="#">xyz company</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="testimonial-item">
                                    <div class="img-thumb">
                                        <img src="assets/img/testimonial/img1.png" alt="">
                                    </div>
                                    <div class="content">
                                        <h2><a href="#">John Doe</a></h2>
                                        <p class="description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo quidem, excepturi facere magnam illum, at accusantium doloremque odio.</p>
                                        <h3>Developer at of <a href="#">xyz company</a></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="testimonial-item">
                                    <div class="img-thumb">
                                        <img src="assets/img/testimonial/img2.png" alt="">
                                    </div>
                                    <div class="content">
                                        <h2><a href="#">Jessica</a></h2>
                                        <p class="description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo quidem, excepturi facere magnam illum, at accusantium doloremque odio.</p>
                                        <h3>Developer at of <a href="#">xyz company</a></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
HTML;
    }

    /**
     * Retourne le vue pour lire la vidéo issue de Youtube.
     * 
     * @param string $youtubeVideoLink
     * 
     * @return string
     */
    public function youtubeIframe(string $youtubeVideoLink)
    {
        return <<<HTML
        <iframe src="https://www.youtube.com/embed/{$youtubeVideoLink}" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen class="w-100 video" style="height:25rem"></iframe>
HTML;
    }

    /**
     * Retourne un code HTML pour dire que tout s'est bien passé.
     * 
     * @param string $title   Cette partie s'affichera en grand.
     * @param string $content Le texte à afficher.
     * 
     * @return string 
     */
    public static function success(string $title, string $content, string $linkCaption = null, string $href = null, string $current = null)
    {
        if (null !== $linkCaption && null !== $href) {
            $link = '<a class="btn btn-success" href="/'. trim($href, "/") . '">'. $linkCaption . '</a>';
        } else {
            $link = '<a class="btn btn-success" href="/'. trim($_SERVER["HTTP_REFERER"], "/") . '">Retour</a>';
        }

        return <<<HTML
        <section id="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="inner-box posting">
                            <div class="alert alert-success alert-lg" role="alert">
                                <h2 class="postin-title">✔ {$title}</h2>
                                <p>{$content}</p>
                                <p class="mt-3">{$link}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
HTML;
    }

    /**
     * Bloc de code qui s'affiche lorsque l'action menée a échoué.
     * 
     * @param string $title   Le titre pour indiquer en grand un notification.
     * @param string $content Le notification à afficher.
     * @param string $link    Peut être null.
     */
    public static function failed(string $title, string $content, string $linkCaption = null, string $href = null, string $current = null)
    {
        if (null !== $linkCaption && null !== $href) {
            $link = '<a class="btn btn-danger" href="'. $href . '">'. $linkCaption . '</a>';
        } else {
            $link = '<a class="btn btn-primary" href="'. $_SERVER["HTTP_REFERER"] . '">Retour</a>';
        }

        return <<<HTML
        <section id="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="inner-box posting">
                            <div class="alert alert-danger alert-lg" role="alert">
                                <h2 class="postin-title"> {$title}</h2>
                                <p>{$content}</p>
                                <p class="mt-3">{$link}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
HTML;
    }

    /**
     * Retourne les icônes des réseaux sociaux dans le pied de page.
     * 
     * @return string
     */
    public function socialNetworksInfooter()
    {
        return <<<HTML
        <h3 class="block-title">Réseaux sociaux</h3>
        <ul class="footer-social">
            <li><a class="facebook" href="https://www.facebook.com/Lindice-101740878555286/"><i class="lni-facebook-filled"></i></a></li>
            <!-- <li><a class="twitter" href="#"><i class="lni-twitter-filled"></i></a></li>
            <li><a class="linkedin" href="#"><i class="lni-linkedin-fill"></i></a></li>
            <li><a class="google-plus" href="#"><i class="lni-google-plus"></i></a></li> -->
        </ul>
HTML;
    }

    /**
     * Retourne une section qui permet d'afficher quelques annonces.
     * @return string
     */
    public static function listingAnnouncesSection(string $title, string $content)
    {
        return <<<HTML
        <section class="featured py-3">
            <div class="container">
                <h1 class="section-title">{$title}</h1>
                <div class="row">
                    {$content}
                </div>
            </div>
        </section>
HTML;
    }

    /**
     * Retourne une section avec un effet de scrolling horizontal avec 
     * des boutons pour faire défiler les éléments.
     * 
     * @param string $sectionTitle Le titre de la section.
     * @param string $items        La liste des items en format string à afficher.
     * 
     * @return string
     */
    public static function hScrolling(string $sectionTitle, string $items)
    {
        return <<<HTML
        <section class="featured-lis section-padding my-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 wow fadeIn" data-wow-delay="0.5s">
                        <h3 class="section-title">{$sectionTitle}</h3>
                        <div id="new-products" class="owl-carousel">
                            {$items}
                        </div>
                    </div> 
                </div>
            </div>
        </section>
HTML;
    }

    /**
     * Cta Section. Section qui présente un peu la pub du site.
     * @return string
     */
    public function ctaSection()
    {
        return <<<HTML
        <section class="cta section-padding">
            <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-md-6 col-lg-4">
                            <div class="single-cta">
                                <div class="cta-icon">
                                    <i class="lni-grid"></i>
                                </div>
                                <h4>Refreshing Design</h4>
                                <p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie</p>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-4">
                            <div class="single-cta">
                                <div class="cta-icon">
                                    <i class="lni-brush"></i>
                                </div>
                                <h4>Easy to Customize</h4>
                                <p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie</p>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-lg-4">
                            <div class="single-cta">
                                <div class="cta-icon">
                                    <i class="lni-headphone-alt"></i>
                                </div>
                                <h4>24/7 Support</h4>
                                <p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
HTML;
    }
        
    /**
     * Un bloc de code HTML qui affiche aucune annonce lorqu'il n'y a pas 
     * d'annonce à afficher dans une partie de la page.
     * 
     * @return string
     */
    public static function noResult()
    {
        return <<<HTML
        <div class="col-12 text-muted text-center">
            <h2>Oup's</h2>
            <p>Nous n'avons trouvé aucun résultat.</p>
        </div>
HTML;
    }
    
    /**
     * Bloc de code pour les effets accordéons.
     * 
     * @param string $title
     * @param string $content
     * @param string $tag
     * 
     * @return string
     */
    public function accordeon(string $title, string $content, $tag)
    {
        return <<<HTML
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#{$tag}">
                        {$title}
                    </a>
                </h4>
            </div>
            <div id="{$tag}" class="panel-collapse collapse">
                <div class="panel-body">
                    {$content}
                </div>
            </div>
        </div>
HTML;
    }

    /**
     * Permet de filtrer les announces.
     * 
     * @return string
     * 
     * @return string
     */
    public function viewChanger()
    {
        return <<<HTML
        <div class="product-filter">
            {$this->changeViewButton()}
        </div>
HTML;
    }

    /**
     * Bouton qui permet de changer l'affichage des annonces.
     * 
     * @return string
     */
    private function changeViewButton()
    {
        return <<<HTML
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#grid-view"><i class="lni-grid"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#list-view"><i class="lni-list"></i></a>
            </li>
        </ul>
HTML;
    }

    /**
     * Affiche un gif animé pour le téléchargement du j
     */

}