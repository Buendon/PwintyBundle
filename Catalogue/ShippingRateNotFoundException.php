<?php

namespace Buendon\PwintyBundle\Catalogue;


class ShippingRateNotFoundException extends \Exception
{

    /**
     * @param string $errorMessage
     */
    public function __construct($errorMessage)
    {
        parent::__construct($errorMessage);
    }
}