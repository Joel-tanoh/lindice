<?php

namespace App\Admin\Dashboard;

/**
 * Classe de gestion des vues Dashboard.
 */
class DashboardView
{

    public static function showvisitorsOnline() : string
    {
        return self::KPIBox(Dashboard::visitorsOnline(), "Visiteur(s) en ligne", "fas fa-users fa-2x");
    }

    public static function showCurrentDayVisitorsNumber() : string
    {
        return self::KPIBox(Dashboard::getCurrentDayVisitorsNumber(), "Visite(s) aujourd'hui", "fas fa-users fa-2x");
    }

    public static function showAllVisitorsNumber() : string
    {
        return self::KPIBox(Dashboard::getAllVisitorsNumber(), "Visite(s) au total", "fas fa-users fa-2x");
    }

    public static function showAllPostsNumber() : string
    {
        return self::KPIBox(Dashboard::getAllPostsNumber(), "Announce(s) postée(s) au total", "fas fa-folder fa-2x");
    }

    public static function showCurrentDayPostsNumber() : string
    {
        return self::KPIBox(Dashboard::getCurrentDayPostsNumber(), "Annonce(s) postée(s) aujourd'hui", "fas fa-folder fa-2x");
    }

    public static function showPendingPostsNumber() : string
    {
        return self::KPIBox(Dashboard::getPendingPostsNumber(), "Annonce(s) en attente", "fas fa-folder fa-2x");
    }

    public static function showPublishedPostsNumber() : string
    {
        return self::KPIBox(Dashboard::getPublishedPostsNumber(), "Annonce(s) validée(s)", "fas fa-folder fa-2x");
    }

    public static function showSuspendedPostsNumber() : string
    {
        return self::KPIBox(Dashboard::getSuspendedPostsNumber(), "Annonce(s) suspendue(s)", "fas fa-folder fa-2x");
    }

    /**
     * Affiche une box avec un nombre, un petit texte et une icône.
     * 
     * @param int $number            Le nombre (KPI) à afficher
     * @param string $text           Le texte descriptif du KPI
     * @param string|null $iconClass A passer si on veut afficher une icône, cela
     *                               peut être une icône Bootstrap ou autres.
     * 
     * @return string
     */
    public static function KPIBox(int $number, string $text, string $iconClass = null) : string
    {
        $icon = null;
        if ($iconClass) {
            $icon = '<span class="mr-2"><i class="' . $iconClass . '"></i></span>';
        }

        return <<<HTML
        <div class="col-12 col-md-3">
            <div class="bg-light border p-3 mb-2 rounded">
                <div class="mb-2">
                    $icon<span class="h1">$number</span>
                </div>
                <div class="justify-content-end">$text</div>
            </div>
        </div>
HTML;
    }

}