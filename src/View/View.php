<?php

namespace App\View;

use App\Model\User\User;
use App\View\Model\AnnounceView;
use App\View\Model\CategoryView;
use App\View\Communication\NewsletterView;
use App\View\Page\SideBar;

/**
 * Classe View. Regroupe toutes les vues de l'application.
 */
class View
{
    /**
     * Vue de l'index de l'application.
     * 
     * @return string
     */
    public static function index()
    {
        $categoryView = new CategoryView();
        $annonceView = new AnnounceView();
        $newsletterView = new NewsletterView();
        $snippet = new Snippet();
        $advertising = new AdvertisingView();
        $searchBar = new SearchView;

        return <<<HTML
        {$snippet->slider()}
        <div class="container">
            {$searchBar->heroAreaSearchBar()}
            {$advertising->top()}
            <div class="row section-padding">
                <aside class="col-12 col-lg-10">
                    {$categoryView->trendingCategoriesSection()}
                    {$annonceView->latest()}
                    {$newsletterView->suscribeNewsletterSection()}
                </aside>
                <aside class="d-none d-lg-block col-lg-2">
                    {$advertising->right()}
                </aside>
            </div>
        </div>
HTML;
    }

    /**
     * La vue à afficher lorsqu'on ne trouve pas la ressource.
     * 
     * @return string
     */
    public static function pageNotFound(string $current)
    {
        $snippet = new Snippet();
        $home = APP_URL;
        $searchView = new SearchView();
    
        return <<<HTML
        {$snippet->pageHeader("Oup's ! Page non trouvée", $current)}
        <div class="error">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="error-content">
                            <div class="error-message">
                                <h2>404</h2>
                                <h3>Oup's ! Nous n'avons trouvé la page que vous recherchez...</h3>
                            </div>
                            {$searchView->notFoundSearch()}
                            <div class="description">
                                <span>Retour vers à l'<a href="$home">accueil</a></span>
                            </div>
                        </div>
                    </div>
                </div>      
            </div>
        </div>
HTML;
    }

    /**
     * La vue à afficher lorsqu'on rencontre une erreur de type exception.
     * 
     * @param \Error|\TypeError|\Exception|\PDOException $e
     */
    public static function exception($e)
    {
        return <<<HTML
        <div class="container">
            <div class="bg-white rounded my-3 p-3">
                <h1 class="text-primary">Exception capturée.</h1>
                <p class="h3 text-secondary">{$e->getMessage()}</p>
                <p>Excéption jetée dans {$e->getFile()} à la ligne {$e->getLine()}.</p>
            </div>
        </div>
HTML;
    }

    /**
     * Affiche la page de succès.
     * 
     * @return string
     */
    public static function success(string $title, string $content, string $linkCaption = null, string $href = null, string $current = null)
    {
        $snippet = new Snippet;

        return <<<HTML
        {$snippet->pageHeader("Félicitation !", $current)}
        {$snippet->success($title, $content, $linkCaption, $href, $current)}
HTML;
    }

    /**
     * Affiche la page de succès.
     * 
     * @return string
     */
    public static function failed(string $title, string $content, string $linkCaption = null, string $href = null, string $current = null)
    {
        $snippet = new Snippet;

        return <<<HTML
        {$snippet->pageHeader("Oup's !", $current)}
        {$snippet->failed($title, $content, $linkCaption, $href, $current)}
HTML;
    }

    /**
     * La vue qui affiche le about.
     * 
     * @return string
     */
    public static function aboutUs()
    {
        $content = <<<HTML
        <section id="about" class="section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-md-9 col-lg-9">
                        <div class="about-wrapper">
                            <h2 class="intro-title">Qui sommes-nous ?</h2>
                            <p><strong>L’INDICE</strong> est une grande plateforme qui permet d’<strong>acheter, vendre ou louer des biens et services</strong> pour particuliers et professionnels.</p>
                            <p>L’indice a été fondé en 2020 par un Ivoirien fou de nouvelles technologies, dont l'ambition était de concevoir un site pratique, utile, à la portée de tous.</p>
                            <p>L’objectif est donc de changer la manière d’offrir des services et surtout de facilité vos recherches. Tout en restant gratuit.</p>
                            <p>Chaque jour plusieurs annonces sont publiées sur le site, dans des catégories différentes et  sous catégories.</p>
                            <p>Celles-ci vont des objets plus courants véhicules, Maisons, Terrains, mobiliers, appareils électroniques aux objets de collection.</p>

                            <h4 class="intro-title">Attention à la fraude sur Internet</h4>
                            <p>L'immense majorité des annonces sont publiées par des personnes honnêtes et de confiance. Vous pouvez donc faire d'excellentes affaires. Malgré cela, il est important de suivre les quelques règles de bon sens suivantes pour éviter toute tentative d'arnaque.</p>
                            
                            <h4 class="intro-title">Nos conseils</h4>
                            <ul>
                                <li>1 - Faîtes des affaires avec des gens que vous pouvez rencontrer en personne.</li>
                                <li>2 - N'envoyez jamais d'argent par Western Union, MoneyGram ou des systèmes de paiement anonymes.</li>
                                <li>3 - N'envoyez jamais des marchandises ou de l'argent à l'étranger</li>
                                <li>4 - N'acceptez pas de chèques.</li>
                                <li>5 - Renseignez-vous sur la personne à laquelle vous avez affaire en confirmant par une autre source son nom, son adresse et son numéro de téléphone.</li>
                                <li>6 - Conservez une copie de toutes les correspondances (emails, annonces, lettres, etc.) et coordonnées de la personne</li>
                                <li>7 - Si une affaire semble trop belle pour être vraie, il y a toutes les chances que ce soit le cas. Abstenez-vous.</li>
                            </ul>
                            
                            <h4 class="intro-title">Reconnaitre une tentative d'arnaque</h4>
                            <p>La majorité des arnaques ont une ou plusieurs de ces caractéristiques :</p>
                            <ul>
                                <li>1 - La personne est à l'étranger ou en déplacement à l'étranger.</li>
                                <li>2 - La personne refuse de vous rencontrer en personne.</li>
                                <li>3 - Le paiement est fait par Western Union, Money Gram ou par chèque.</li>
                                <li>4 - Les notifications sont dans un langage approximatif (que ce soit en anglais ou en français).</li>
                                <li>5 - Les textes semblent être copiés-collés.</li>
                                <li>6 - L'affaire semble être trop belle pour être vraie.</li>
                            </ul>
                                                        
                            <h4 class="intro-title">Nos contacts</h2>
                            <p>Régie publicitaire : AVENT CONCEPT, Téléphone : (+225) 01 70 70 83 44, Email : annonces@aventconcept.com, Abatta Ancienne route de Bingerville.</p>
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
HTML;
        return self::sliderWithTopAdvertisingTemplate($content);
    }

    /**
     * La vue qui affiche le FAQ.
     * 
     * @return string
     */
    public static function FAQ()
    {
        $faqs = null;
        $tag = 0;

        foreach(self::faqs() as $title => $value) {
            $tag = $tag + 1;
            $faqs .= (new Snippet)->accordeon(ucfirst($title), ucfirst($value), $tag);
        }

        $content = <<<HTML
        <div class="faq">
            <div class="container">        
                <div class="row">
                    <div class="col-md-12">
                        <div class="head-faq text-center">
                            <h2 class="section-title">QUESTIONS FREQUENTES</h2>
                        </div>
                        <p class="mb-3">Vous vous posez des questions, trouvez la reponse ici.</p>
                        <div class="panel-group" id="accordion">
                            {$faqs}
                        </div>  
                    </div>      
                </div>
            </div>      
        </div>
HTML;
        return self::sliderWithTopAdvertisingTemplate($content);
    }

    /**
     * Les questions de la Faqs.
     * @return array
     */
    private static function faqs()
    {
        return [
            "Title" => "value"
            , "Title_2" => "value"
        ];
    }

    /**
     * Affiche la vue pour l'administration avec une sidebar. Cette vue est disposée
     * de façon responsive avec les class bootstrap.
     * 
     * @param string $content Le contenu de la page d'administration. Le contenu doit 
     *                        contenir des class de disposition (col) afin d'être
     *                        bien disposée en fonction des écrans.
     * @param string $title   Le titre qui va s'afficher dans le bannière du haut.
     * @param string $current Le texte qui sera affiché dans le
     * @return string
     */
    public static function administrationTemplate(string $content, string $title, string $current, string $notification = null)
    {
        $snippet = new Snippet;
        $sidebar = new SideBar;

        return <<<HTML
        {$snippet->pageHeader($title, $current)}
        {$notification}
        <div id="content" class="section-padding">
            <div class="container-fluid">
                <div class="row">
                    {$sidebar->sidebarNav(User::authenticated())}
                    <div class="col-sm-12 col-md-9">
                        {$content}
                    </div>
                </div>
            </div>
        </div>
HTML;
    }

    /**
     * Template avec la barre heraoArea 2 seulement. Hero area est une bannière avec un formulaire
     * de recherche.
     * @param string $content Le contenu de la page.
     * @return string
     */
    public static function sliderOnly(string $content)
    {
        $snippet = new Snippet();

        return <<<HTML
        {$snippet->slider()}
        <div class="container">
            <aside class="section-padding">
                {$content}
            </aside>
        </div>
HTML;
    }

    /**
     * Template avec la barre heraoArea avec la barre de recherche et les publicités sur les cotés et haut.
     * Hero area est une bannière avec un formulaire de recherche.
     * 
     * @param string $content Le contenu de la page.
     * @return string
     */
    public static function sliderWithTopAdvertisingTemplate(string $content, string $notification = null)
    {
        $snippet = new Snippet();
        $advertising = new AdvertisingView();

        return <<<HTML
        {$snippet->slider()}
        <div class="container">
            {$advertising->top()}
            <aside class="section-padding">
                {$content}
            </aside>
        </div>
HTML;
    }

    /**
     * Template avec page header.
     * 
     * @param string $title   Le titre qui sera affiché dans le page header en tant qu'indicateur
     *                        pour situer le visiteur.
     * @param string $current Pour indiquer où on se trouve.
     * @param string $content Le contenu principal de la page.
     * @param string $notification Dans le cas où on veut afficher une notification à l'utilisateur.
     * 
     * @return string
     */
    public static function pageHeaderTemplate(string $title, string $current, string $content, string $notification = null)
    {
        $snippet = new Snippet;

        return <<<HTML
        {$snippet->pageHeader($title, $current)}
        <section class="section-padding">
            {$notification}
            {$content}
        </section>
HTML;
    }

}