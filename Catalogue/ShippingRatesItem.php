<?php

namespace Buendon\PwintyBundle\Catalogue;


class ShippingRatesItem
{
    const FIELD_BAND = "band";
    const FIELD_DESCRIPTION = "description";
    const FIELD_IS_TRACKED = "isTracked";
    const FIELD_PRICE_GBP = "priceGBP";
    const FIELD_PRICE_USD = "priceUSD";

    const BAND_PRINT = "Prints";

    /**
     * @see Catalogue BAND_* constants
     * @var string
     */
    private $band;
    /**
     * @var string
     */
    private $description;
    /**
     * @var bool
     */
    private $isTracked;
    /**
     * @var double
     */
    private $priceGBP;
    /**
     * @var double
     */
    private $priceUSD;

    /**
     * Build a catalogue shipping rate item item from the JSON array got from the API
     *
     * @param array $jsonItem
     */
    public function __construct($jsonItem)
    {
        $this->band = $jsonItem[ShippingRatesItem::FIELD_BAND];
        $this->description = $jsonItem[ShippingRatesItem::FIELD_DESCRIPTION];
        $this->isTracked = boolval($jsonItem[ShippingRatesItem::FIELD_IS_TRACKED]);
        $this->priceGBP = doubleval($jsonItem[ShippingRatesItem::FIELD_PRICE_GBP]);
        $this->priceUSD = doubleval($jsonItem[ShippingRatesItem::FIELD_PRICE_USD]);
    }

    /**
     * @return string
     */
    public function getBand(): string
    {
        return $this->band;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return bool
     */
    public function isTracked(): bool
    {
        return $this->isTracked;
    }

    /**
     * @return float
     */
    public function getPriceGBP(): float
    {
        return $this->priceGBP;
    }

    /**
     * @return float
     */
    public function getPriceUSD(): float
    {
        return $this->priceUSD;
    }
}