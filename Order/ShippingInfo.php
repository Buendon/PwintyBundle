<?php

namespace Buendon\PwintyBundle\Order;


class ShippingInfo
{
    const FIELD_PRICE = "price";
    const FIELD_SHIMPEMNTS = "shipments";

    public static function buildFromJSON($jsonShippingInfo) {
        $info = new ShippingInfo();
        $info->setPrice(doubleval($jsonShippingInfo[ShippingInfo::FIELD_PRICE]));

        $shipments = array();
        if(array_key_exists(ShippingInfo::FIELD_SHIMPEMNTS, $jsonShippingInfo)) {
            $jsonShipments = $jsonShippingInfo[ShippingInfo::FIELD_SHIMPEMNTS];
            foreach ($jsonShipments as $jsonShipment) {
                array_push($shipments, Shipment::buildFromJSON($jsonShipment));
            }
        }
        $info->setShipments($shipments);

        return $info;
    }

    /**
     * @var double
     */
    private $price = 0;
    /**
     * @see Shipment
     * @var array
     */
    private $shipments = array();

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price = 0)
    {
        $this->price = $price;
    }

    /**
     * @return array
     */
    public function getShipments(): array
    {
        return $this->shipments;
    }

    /**
     * @param array $shipments
     */
    public function setShipments(array $shipments = array())
    {
        $this->shipments = $shipments;
    }
}