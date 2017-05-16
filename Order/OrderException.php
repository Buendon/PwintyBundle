<?php

namespace Buendon\PwintyBundle\Order;


class OrderException extends \Exception
{
    public function __construct($message = "")
    {
        parent::__construct($message);
    }
}