<?php

namespace Buendon\PwintyBundle\Catalogue;


class CatalogueNotFoundException extends \Exception
{

    /**
     * @param string $errorMessage
     */
    public function __construct($errorMessage)
    {
        parent::__construct($errorMessage);
    }
}