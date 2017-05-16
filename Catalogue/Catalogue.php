<?php

namespace Buendon\PwintyBundle\Catalogue;


use Buendon\PwintyBundle\Country\Country;

class Catalogue
{
    const FIELD_QUALITY_LEVEL = "qualityLevel";
    const FIELD_ITEMS = "items";
    const FIELD_SHIPPING_RATES = "shippingRates";
    const FIELD_ERROR_MESSAGE = "errorMessage";

    const QUALITY_PRO = "Pro";
    const QUALITY_STANDARD = "Standard";

    /**
     * @var string
     */
    private $countryCode;
    /**
     * @var string
     */
    private $countryName;
    /**
     * @var string
     */
    private $qualityLevel;
    /**
     * @see CatalogueItem
     * @var array
     */
    private $items;
    /**
     * @see ShippingRatesItem
     * @var array
     */
    private $shippingRates;

    /**
     * Build a catalogue instance from the JSON array returned by the API
     * @param array $catalogue
     */
    public function __construct($catalogue)
    {
        $this->countryName = $catalogue[Country::FIELD_COUNTRY];
        $this->countryCode = $catalogue[Country::FIELD_COUNTRY_CODE];
        $this->qualityLevel = $catalogue[Catalogue::FIELD_QUALITY_LEVEL];

        $jsonItems = $catalogue[Catalogue::FIELD_ITEMS];
        $this->items = array();
        foreach ($jsonItems as $jsonItem) {
            array_push($this->items, new CatalogueItem($jsonItem));
        }

        $jsonShippings = $catalogue[Catalogue::FIELD_SHIPPING_RATES];
        $this->shippingRates = array();
        foreach ($jsonShippings as $jsonShipping) {
            array_push($this->shippingRates, new ShippingRatesItem($jsonShipping));
        }
    }


    /**
     * @return string
     */
    public function getCountryName(): string
    {
        return $this->countryName;
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * @return string
     */
    public function getQualityLevel(): string
    {
        return $this->qualityLevel;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @see ShippingRatesItem
     * @return array
     */
    public function getShippingRates(): array
    {
        return $this->shippingRates;
    }

    /**
     * @param string $shippingBandType
     * @return array
     */
    public function getItemsForShippingBandType($shippingBandType): array
    {
        $result = array();
        foreach ($this->items as $item) {
            if($item->getShippingBand() == $shippingBandType) {
                array_push($result, $item);
            }
        }

        return $result;
    }

    /**
     * @param string $shippingBandType
     * @return ShippingRatesItem
     * @throws ShippingRateNotFoundException
     */
    public function getShippingRateForBandType($shippingBandType): ShippingRatesItem
    {
        foreach ($this->shippingRates as $rate) {
            if($rate->getBand() == $shippingBandType) {
               return $rate;
            }
        }

        throw new ShippingRateNotFoundException("Shipping rate not found for shipping band type ".$shippingBandType);
    }

    /**
     * @param string $itemName
     * @return CatalogueItem
     * @throws CatalogueItemNotFoundException
     */
    public function getItemByName(string $itemName): CatalogueItem {
        foreach ($this->items as $item) {
            if($item->getName() == $itemName) {
                return $item;
            }
        }

        throw new CatalogueItemNotFoundException("Item ".$itemName." not found");
    }
}