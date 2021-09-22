<?php

namespace App\Exception;

use Exception;

class PageNotFoundException extends Exception
{
    /**
     * @param string $messsage
     */
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}