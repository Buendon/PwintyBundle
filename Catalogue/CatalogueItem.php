<?php

namespace Buendon\PwintyBundle\Catalogue;


class CatalogueItem
{
    const FIELD_DESCRIPTION = "description";
    const FIELD_IMAGE_HORIZONTAL_SIZE = "imageHorizontalSize";
    const FIELD_IMAGE_VERTICAL_SIZE = "imageVerticalSize";
    const FIELD_FULL_PRODUCT_HORIZONTAL_SIZE = "fullProductHorizontalSize";
    const FIELD_FULL_PRODUCT_VERTICAL_SIZE = "fullProductVerticalSize";
    const FIELD_NAME = "name";
    const FIELD_PRICE_GBP = "priceGBP";
    const FIELD_PRICE_USD = "priceUSD";
    const FIELD_RECOMMENDED_HORIZONTAL_RESOLUTION = "recommendedHorizontalResolution";
    const FIELD_RECOMMENDED_VERTICAL_RESOLUTION = "recommendedVerticalResolution";
    const FIELD_SIZE_UNITS = "sizeUnits";
    const FIELD_SHIPPING_BAND = "shippingBand";
    const FIELD_ATTRIBUTES = "attributes";

    const SHIPPING_BAND_PRINT = "Prints";

    const SIZE_UNIT_CM = "cm";
    const SIZE_UNIT_INCHES = "inches";

    const FIELDS_ATTR_NAME = "name";
    const FIELDS_ATTR_VALUE = "validValues";

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $description;
    /**
     * @var int
     */
    private $imageHorizontalSize;
    /**
     * @var int
     */
    private $imageVerticalSize;
    /**
     * @var int
     */
    private $fullProductHorizontalSize;
    /**
     * @var int
     */
    private $fullProductVerticalSize;
    /**
     * @var string
     */
    private $sizeUnits;
    /**
     * @var double Price in pence
     */
    private $priceGBP;
    /**
     * @var double Price in cents
     */
    private $priceUSD;
    /**
     * @var int
     */
    private $recommendedHorizontalResolution;
    /**
     * @var int
     */
    private $recommendedVerticalResolution;
    /**
     * @var array
     */
    private $attributes;
    /**
     * @var string
     */
    private $shippingBand;

    /**
     * Build a catalogue item from the JSON array got from the API
     *
     * @param array $jsonItem
     */
    public function __construct($jsonItem)
    {
        $this->description = $jsonItem[CatalogueItem::FIELD_DESCRIPTION];
        $this->imageHorizontalSize = intval($jsonItem[CatalogueItem::FIELD_IMAGE_HORIZONTAL_SIZE]);
        $this->imageVerticalSize = intval($jsonItem[CatalogueItem::FIELD_IMAGE_VERTICAL_SIZE]);
        $this->fullProductHorizontalSize = intval($jsonItem[CatalogueItem::FIELD_FULL_PRODUCT_HORIZONTAL_SIZE]);
        $this->fullProductVerticalSize = intval($jsonItem[CatalogueItem::FIELD_FULL_PRODUCT_VERTICAL_SIZE]);
        $this->name = $jsonItem[CatalogueItem::FIELD_NAME];
        $this->priceGBP = doubleval($jsonItem[CatalogueItem::FIELD_PRICE_GBP]);
        $this->priceUSD = doubleval($jsonItem[CatalogueItem::FIELD_PRICE_USD]);
        $this->recommendedHorizontalResolution = intval($jsonItem[CatalogueItem::FIELD_RECOMMENDED_HORIZONTAL_RESOLUTION]);
        $this->recommendedVerticalResolution = intval($jsonItem[CatalogueItem::FIELD_RECOMMENDED_VERTICAL_RESOLUTION]);
        $this->sizeUnits = $jsonItem[CatalogueItem::FIELD_SIZE_UNITS];
        $this->shippingBand = $jsonItem[CatalogueItem::FIELD_SHIPPING_BAND];
        $this->attributes = $jsonItem[CatalogueItem::FIELD_ATTRIBUTES];
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getImageHorizontalSize(): int
    {
        return $this->imageHorizontalSize;
    }

    /**
     * @return int
     */
    public function getImageVerticalSize(): int
    {
        return $this->imageVerticalSize;
    }

    /**
     * @return int
     */
    public function getFullProductHorizontalSize(): int
    {
        return $this->fullProductHorizontalSize;
    }

    /**
     * @return int
     */
    public function getFullProductVerticalSize(): int
    {
        return $this->fullProductVerticalSize;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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

    /**
     * @return int
     */
    public function getRecommendedHorizontalResolution(): int
    {
        return $this->recommendedHorizontalResolution;
    }

    /**
     * @return int
     */
    public function getRecommendedVerticalResolution(): int
    {
        return $this->recommendedVerticalResolution;
    }

    /**
     * @return string
     */
    public function getSizeUnits(): string
    {
        return $this->sizeUnits;
    }

    /**
     * @return string
     */
    public function getShippingBand(): string
    {
        return $this->shippingBand;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}