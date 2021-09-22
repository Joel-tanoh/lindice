<?php

namespace App\View;

use App\View\Model\AnnounceView;
use App\View\Model\CategoryView;
use App\View\Model\User\UserView;

/** Vue gestionnaires des recherches */
class SearchView extends Snippet
{
    /**
     * Retourne la vue pour afficher les résultats des recherches d'annonces.
     * 
     * @param string $modelType Le type des données à afficher (announces, users, etc.)
     * @param array $data Le tableau des éléments à afficher.
     * 
     * @return string
     */
    public function result(string $modelType, array $data)
    {
        if (empty($data)) {
            return Snippet::noResult();
        } elseif ($modelType === "announces") {
            return $this->announcesResult($data);
        }
    }

    /**
     * Retourne la vue qui affiche les résultats de recherches d'annonces.
     */
    public function announcesResult(array $annouces)
    {
        return parent::sliderWithTopAdvertisingTemplate((new AnnounceView)->show($annouces, "Résultats de la récherche"));
    }

    /**
     * La barre de recherche qui s'affiche dans la grande bannière du site.
     * 
     * @return string
     */
    public function heroAreaSearchBar()
    {
        $form = new Form("/annonces/search", "search-form", "post", "heroSearchForm", "search");

        return <<<HTML
        <div class="search-bar">
            <div class="search-inner">
                {$form->open()}
                    {$this->enterQuery()}
                    {$this->selectCategories()}
                    {$this->selectLocation()}
                    <button class="btn btn-common" type="submit"><i class="lni-search"></i> Chercher</button>
                {$form->close()}
            </div>
        </div>
HTML;
    }

    /**
     * La barre de recherche dans la sidebar sur la vue qui affiche les announces
     * par catégories.
     * 
     * @return string
     */
    public function categorySearchWidget()
    {
        $form = new Form("annonces/search", null, "post", "search-form", "search");
        $searchQuery = !empty($_POST["query"]) ? $_POST["query"] : null;

        return <<<HTML
        <div class="widget_search">
            {$form->open()}
                <input type="search" class="form-control" autocomplete="off" name="query" placeholder="Recherche..." id="search-input" value="{$searchQuery}" required>
                <button type="submit" id="search-submit" class="search-btn"><i class="lni-search"></i></button>
            {$form->close()}
        </div>
HTML;
    }

    /**
     * Retourne le formulaire de recherche qui s'affiche sur la page 404
     * 
     * @return string
     */
    public function notFoundSearch()
    {
        $form = new Form("/annonces/search", "form-error-search");

        return <<<HTML
        {$form->open()}
            <input type="search" name="query" class="form-control" placeholder="Une recherche..." required>
            <button class="btn btn-common btn-search" type="submit">Chercher</button>
        {$form->close()}
HTML;
    }

    /**
     * Retourne un champ pour saisir la requête.
     * 
     * @return string
     */
    private function enterQuery()
    {
        return <<<HTML
        <div class="form-group inputwithicon">
            <i class="lni-tag"></i>
            <input type="text" name="query" class="form-control" placeholder="Saisissez quelque chose" required>
        </div>
HTML;
    }

    /**
     * Retourne la liste des catégories.
     * 
     * @return string
     */
    private function selectCategories()
    {
        $categoryView = new CategoryView();

        return <<<HTML
        <div class="form-group inputwithicon">
            <i class="lni-menu"></i>
            <div class="select">
                <select name="id_category">
                    <option value="0">Choisissez la catégories</option>
                    {$categoryView->selectOptions()}
                </select>
            </div>
        </div>
HTML;
    }

    /**
     * Affiche le champ pour sélectionner une ville pour la recherche.
     * 
     * @return string
     */
    private function selectLocation()
    {
        $userView = new UserView();

        return <<<HTML
        <div class="form-group inputwithicon">
            <i class="lni-map-marker"></i>
            <div class="select">
                {$userView->townsSelectList("location")}
            </div>
        </div>
HTML;
    }

    /**
     * Retourne la liste des Directions (offre ou demande)
     * 
     * @return string
     */
    private function selectDirection()
    {
        return <<<HTML
        <div class="form-group inputwithicon">
            <i class="lni-hand"></i>
            <div class="select">
                <select name="direction" id="direction">
                    <option value="both">Offre et Demande</option>
                    <option value="professionnel">Offre</option>
                    <option value="particulier">Demande</option>
                </select>
            </div>
        </div>
HTML;
    }

    /**
     * Retourne la liste des types (professionnel ou particulier).
     * 
     * @return string
     */
    private function selectType()
    {
        return <<<HTML
        <div class="form-group inputwithicon">
            <i class="lni-menu"></i>
            <div class="select">
                <select name="type" id="type">
                    <option value="both">Particulier et Professionnel</option>
                    <option value="professionnel">Professionnel</option>
                    <option value="particulier">Particulier</option>
                </select>
            </div>
        </div>
HTML;
    }

    /**
     * Retourne un champ pour saisir le prix.
     * 
     * @return string
     */
    private function enterPrice()
    {
        return <<<HTML
        <div class="form-group inputwithicon">
            <i class="lni-menu"></i>
            <input type="number" name="price" class="form-control" placeholder="Entrer un prix" scale="5">
        </div>
HTML;
    }

}