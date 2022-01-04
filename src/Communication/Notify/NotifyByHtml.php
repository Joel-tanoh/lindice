<?php

namespace App\Communication\Notify;

/** Permet de faire des notification par HTML */
class NotifyByHTML extends Notify
{
    /**
     * Permet d'afficher un notification d'exception.
     * 
     * @param string $notification Notification d'erreur à afficher pour les alert-danger
     * 
     * @return string
     */
    public static function exception(string $notification): string
    {
        return <<<HTML
        <div class="container">
            <div class="alert alert-danger">
                {$notification}
            </div>
        </div>
HTML;
    }

    /**
     * Affiche un notification d'erreur.
     * 
     * @return string
     */
    public static function error(string $notification)
    {
        return <<<HTML
        <div class="app-alert-danger d-flex align-items-center mb-3">
            <div class="text-danger mr-3">
                <i class="fas fa-exclamation-circle fa-2x"></i>
            </div>
            <div class="text-danger">{$notification}</div>
        </div>
HTML;
    }

    /**
     * Retourne la liste des erreurs lors de l'exécution de la validation des
     * données issues d'un formulaire.
     * 
     * @param array $errors Liste des erreurs, dans un tableau ou chaque erreur
     *                      est indexé par une chaîne de caractère.
     * 
     * @return string Liste des erreurs bien formatée en balise ul.
     */
    public function errors(array $errors)
    {
        $text = "<ul>";
        foreach ($errors as $error) {
            $text .= "<li>$error<li/>";
        }
        $text .= "</ul>";

        return $this->toast($text, "danger");
    }

    /**
     * Retourne la liste des erreurs lors de l'exécution de la validation des
     * données issues d'un formulaire.
     * 
     * @param array $errors Liste des erreurs, dans un tableau ou chaque erreur
     *                      est indexé par une chaîne de caractère.
     * 
     * @return string Liste des erreurs bien formatée en balise ul.
     */
    public function errorsByToast(array $errors)
    {
        $text = "<ul>";
        foreach ($errors as $error) {
            $text .= "<li>$error<li/>";
        }
        $text .= "</ul>";

        return $this->toast($text, "danger");
    }

    /**
     * Permet d'afficher un notification de type information en mode toast.
     * 
     * @param string $notification Information à afficher.
     * @param string $type    Type de classe bootstrap pour la notification.
     * 
     * @return string
     */
    public function toast(string $notification, string $type): string
    {
        if ($type === "success") {
            $icon = "check-circle";
        } elseif ($type === "warning") {
            $icon = "exclamation-triangle";
        } elseif ($type === "danger") {
            $icon = "exclamation-circle";
        }

        return <<<HTML
        <div id="toast" class="app-alert-{$type}" style="position: fixed; top: 5rem; right: 1rem; min-width:13rem; max-width:30rem; z-index:999999;">
            <div class="d-flex align-items-center">
                <div class="text-{$type} mr-3">
                    <i class="fas fa-{$icon} fa-2x"></i>
                </div>
                <div class="text-{$type}">{$notification}</div>
            </div>
        </div>
HTML;
    }

    
    /**
     * Permet d'afficher un notification de type information qu'on peut faire disparaitre.
     * 
     * @param string $notification Information à afficher.
     * @param string $type    Type de classe bootstrap pour la notification.
     * 
     * @return string
     */
    public function toastDimissable(string $notification, string $type): string
    {
        return <<<HTML
        <div id="toast" class="alert alert-{$type} alert-dismissible fade show" style="position: fixed; top: 1rem; right: 1rem; min-width:13rem; max-width:30rem; z-index:999999;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="text-{$type}">{$notification}</div>
        </div>
HTML;
    }

}