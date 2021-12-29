<?php

namespace App\Controller;

use App\View\AdvertisingView;
use App\View\Page\Page;
use App\View\View;

/***
 * Controller qui gère les publicités
 */

class AdvertisingController extends AppController
{
    public static function changeBookLink()
    {
        $page = new Page(
            "Modification du lien du livre",
            AdvertisingView::changeBookLink(),
            "Cette page permet de modifier le lien du livre."
            , true
            , true
        );

        $page->show();
    }
}