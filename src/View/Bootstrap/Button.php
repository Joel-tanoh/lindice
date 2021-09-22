<?php

namespace App\View\Bootstrap;

/** Classe de gestion de bouton */
class Button
{
    /** @var string Le lien vers lequel le bouton pointe */
    private $href;

    private $caption;

    private $id;

    private $class;

    private $title;

    /**
     * Constructeur d'un bouton.
     */
    public function __construct(string $caption, string $href, string $id = null, string $class = null)
    {
        $this->caption = $caption;
        $this->href = $href;
        $this->id = $id;
        $this->class = $class;
    }

    /**
     * Affiche le bouton.
     * 
     * @return string
     */
    public function view() : string
    {
        return <<<HTML
        <a href="{$this->href}" id="0" class="{$this->class}">{$this->caption}</a>
HTML;
    }

    /**
     * Affiche le bouton.
     * 
     * @return string
     */
    public function show() : string
    {
        return <<<HTML
        <a href="{$this->href}" id="0" class="{$this->class}">{$this->caption}</a>
HTML;
    }

}