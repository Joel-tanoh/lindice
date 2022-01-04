<?php

namespace App\View;

use App\View\Model\User\RegisteredView;
use PHP_CodeSniffer\Generators\HTML;

class BookLinkView extends View
{
    /**
     * Retourne le code HTML de la vue qui affiche le lien du livre.
     * 
     * @param string $bookLink  Le lien du livre à afficher.
     * @param string $notification   Un notification à afficher.
     * 
     * @return string
     */
    public static function showBookLink(string $bookLink, string $notification = null)
    {
        $form = new Form("/administration/book-link", null, "post");

        $content = <<<HTML
        <h4>Lien du livre</h4>
        {$form->open()}
        <div class="form-row my-3">
            <div class="col-md-6">
                {$form->text("book_link", null, $bookLink, null, "form-control")}
            </div>
        </div>
        {$form->button("submit", "update-book-link", "Modifier", "btn btn-success mt-1 mb-3", "update-book-link")}
        <!-- <a href="/administration/book-link/delete" class="btn btn-danger mt-1 mb-3">Supprimer</a> -->
        {$form->close()}
HTML;

        return RegisteredView::administrationTemplate($content, "Lien du livre", "Lien du livre", $notification);
    }
}