<?php

namespace Buendon\PwintyBundle\Order;


use Buendon\PwintyBundle\Catalogue\Catalogue;

class Photo
{
    const FIELD_ID = "id";
    const FIELD_TYPE = "type";
    const FIELD_URL = "url";
    const FIELD_STATUS = "status";
    const FIELD_COPIES = "copies";
    const FIELD_SIZING = "sizing";
    const FIELD_PRICE = "price";
    const FIELD_PRICE_TO_USER = "priceToUser";
    const FIELD_MD5_HASH = "md5Hash";
    const FIELD_PREVIEW_URL = "previewUrl";
    const FIELD_THUMBNAIL_URL = "thumbnailUrl";
    const FIELD_ATTRIBUTES = "attributes";

    const SIZING_CROP = 'Crop';
    const SIZING_SHRINK_TO_FIT = 'ShrinkToFit';
    const SIZING_SHRINK_TO_EXACT_FIT = 'ShrinkToExactFit';

    const STATUS_AWAITING_URL_OR_DATA = 'AwaitingUrlOrData';
    const STATUS_NOT_YET_DOWNLOADED = 'NotYetDownloaded';
    const STATUS_OK = 'Ok';
    const STATUS_FILE_NOT_FOUND_AT_URL = 'FileNotFoundAtUrl';
    const STATUS_INVALID = 'Invalid';

    public static function buildFromJSON($jsonPhoto) {
        $photo = new Photo();
        $photo->setId($jsonPhoto[Photo::FIELD_ID]);
        $photo->setType($jsonPhoto[Photo::FIELD_TYPE]);
        $photo->setUrl($jsonPhoto[Photo::FIELD_URL]);
        $photo->setStatus($jsonPhoto[Photo::FIELD_STATUS]);
        $photo->setCopies(intval($jsonPhoto[Photo::FIELD_COPIES]));
        $photo->setSizing($jsonPhoto[Photo::FIELD_SIZING]);
        $photo->setPrice(doubleval($jsonPhoto[Photo::FIELD_PRICE]));
        $photo->setMd5Hash($jsonPhoto[Photo::FIELD_MD5_HASH]);
        $photo->setPreviewUrl($jsonPhoto[Photo::FIELD_PREVIEW_URL]);
        $photo->setThumbnailUrl($jsonPhoto[Photo::FIELD_THUMBNAIL_URL]);
        $photo->setAttributes($jsonPhoto[Photo::FIELD_ATTRIBUTES]);
        return $photo;
    }

    /**
     * The photo ID
     * @var string
     */
    private $id;
    /**
     * Available types can be get from the @see Catalogue#getName()
     *
     * @var string
     */
    private $type;
    /**
     * @var string
     */
    private $url = null;
    /**
     * @var string
     */
    private $status = null;
    /**
     * @var int
     */
    private $copies;
    /**
     * @var string
     */
    private $sizing;
    /**
     * @var double
     */
    private $price = 0;
    /**
     * @var double
     */
    private $priceToUser = 0;
    /**
     * @var string
     */
    private $md5Hash = null;
    /**
     * @var string
     */
    private $previewUrl = null;
    /**
     * @var string
     */
    private $thumbnailUrl = null;
    /**
     * @var array
     */
    private $attributes = array();
    /**
     * The picture file PATH
     * @var string
     */
    private $file = null;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id = null)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type = null)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url = null)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status = null)
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getCopies(): int
    {
        return $this->copies;
    }

    /**
     * @param int $copies
     */
    public function setCopies(int $copies)
    {
        $this->copies = $copies;
    }

    /**
     * @return string
     */
    public function getSizing(): string
    {
        return $this->sizing;
    }

    /**
     * @param string $sizing
     */
    public function setSizing(string $sizing = null)
    {
        $this->sizing = $sizing;
    }

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
     * @return float
     */
    public function getPriceToUser(): float
    {
        return $this->priceToUser;
    }

    /**
     * @param float $priceToUser
     */
    public function setPriceToUser(float $priceToUser = 0)
    {
        $this->priceToUser = $priceToUser;
    }

    /**
     * @return string
     */
    public function getMd5Hash()
    {
        return $this->md5Hash;
    }

    /**
     * @param string $md5Hash
     */
    public function setMd5Hash(string $md5Hash = null)
    {
        $this->md5Hash = $md5Hash;
    }

    /**
     * @return string
     */
    public function getPreviewUrl()
    {
        return $this->previewUrl;
    }

    /**
     * @param string $previewUrl
     */
    public function setPreviewUrl(string $previewUrl = null)
    {
        $this->previewUrl = $previewUrl;
    }

    /**
     * @return string
     */
    public function getThumbnailUrl(): string
    {
        return $this->thumbnailUrl;
    }

    /**
     * @param string $thumbnailUrl
     */
    public function setThumbnailUrl(string $thumbnailUrl = null)
    {
        $this->thumbnailUrl = $thumbnailUrl;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes = array())
    {
        $this->attributes = $attributes;
    }

    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param string $file
     */
    public function setFile(string $file = null)
    {
        $this->file = $file;
    }
}