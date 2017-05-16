<?php

namespace Buendon\PwintyBundle\Order;


use Buendon\PwintyBundle\Catalogue\Catalogue;
use Buendon\PwintyBundle\Country\Country;

class Order
{
    const FIELD_ID = "id";
    const FIELD_RECIPIENT_NAME = "recipientName";
    const FIELD_ADDRESS1 = "address1";
    const FIELD_ADDRESS2 = "address2";
    const FIELD_ADDRESS_TOWN_OR_CITY = "addressTownOrCity";
    const FIELD_STATE_OR_COUNTY = "stateOrCounty";
    const FIELD_POSTAL_OR_ZIP_CODE = "postalOrZipCode";
    const FIELD_COUNTRY_CODE = "countryCode";
    const FIELD_DESTINATION_COUNTRY_CODE = "destinationCountryCode";
    const FIELD_PRICE = "price";
    const FIELD_SHIPPING_INFO = "shippingInfo";
    const FIELD_STATUS = "status";
    const FIELD_PAYMENT = "payment";
    const FIELD_PAYMENT_URL = "paymentUrl";
    const FIELD_QUALITY_LEVEL = "qualityLevel";
    const FIELD_PHOTOS = "photos";

    const PAYMENT_INVOICE_ME = "InvoiceMe";
    const PAYMENT_INVOICE_RECIPIENT = "InvoiceRecipient";

    const STATUS_NOT_YET_SUBMITTED = "NotYetSubmitted";
    const STATUS_SUBMITTED = "Submitted";
    const STATUS_AWAITING_PAYMENT = "AwaitingPayment";
    const STATUS_COMPLETE = "Complete";
    const STATUS_CANCELLED = "Cancelled";

    const UPDATE_STATUS_SUBMITTED = 'Submitted';

    /**
     * Built the order from the JSON response got from the API
     *
     * @param array $jsonOrder
     * @return Order
     */
    public static function buildFromJSON($jsonOrder) {
        $order = new Order();
        $order->setId($jsonOrder[Order::FIELD_ID]);
        $order->setRecipientName($jsonOrder[Order::FIELD_RECIPIENT_NAME]);
        $order->setAddress1($jsonOrder[Order::FIELD_ADDRESS1]);
        $order->setAddress2($jsonOrder[Order::FIELD_ADDRESS2]);
        $order->setAddressTownOrCity($jsonOrder[Order::FIELD_ADDRESS_TOWN_OR_CITY]);
        $order->setStateOrCounty($jsonOrder[Order::FIELD_STATE_OR_COUNTY]);
        $order->setPostalOrZipCode($jsonOrder[Order::FIELD_POSTAL_OR_ZIP_CODE]);
        $order->setCountryCode($jsonOrder[Order::FIELD_COUNTRY_CODE]);
        $order->setDestinationCountryCode($jsonOrder[Order::FIELD_DESTINATION_COUNTRY_CODE]);
        $order->setPrice(doubleval($jsonOrder[Order::FIELD_PRICE]));
        $order->setShippingInfo(ShippingInfo::buildFromJSON($jsonOrder[Order::FIELD_SHIPPING_INFO]));
        $order->setStatus($jsonOrder[Order::FIELD_STATUS]);
        $order->setPayment($jsonOrder[Order::FIELD_PAYMENT]);
        $order->setPaymentUrl($jsonOrder[Order::FIELD_PAYMENT_URL]);
        $order->setQualityLevel($jsonOrder[Order::FIELD_QUALITY_LEVEL]);

        $photos = array();
        if(array_key_exists(Order::FIELD_PHOTOS, $jsonOrder)) {
            $jsonPhoto = $jsonOrder[Order::FIELD_PHOTOS];
            if (is_array($jsonPhoto)) {
                foreach ($jsonPhoto as $photo) {
                    array_push($photos, Photo::buildFromJSON($photo));
                }
            }
        }
        $order->setPhotos($photos);

        return $order;
    }

    /**
     * @var string
     */
    private $id = null;
    /**
     * Who the order should be addressed to
     * @var string
     */
    private $recipientName;
    /**
     * 1st line of recipient address (optional on create, needed by submit)
     * @var string
     */
    private $address1;
    /**
     * 2nd line of recipient address (optional)
     * @var string
     */
    private $address2 = null;
    /**
     * Town or City in the address (optional on create, needed by submit)
     * @var string
     */
    private $addressTownOrCity;
    /**
     * State or County in the address (optional on create, needed by submit)
     * @var string
     */
    private $stateOrCounty;
    /**
     * Postal code or Zip code of recipient (optional on create, needed by submit)
     * @var string
     */
    private $postalOrZipCode;
    /**
     * Country code of the country where the order should be printed
     * @see Country
     * @var string
     */
    private $countryCode;
    /**
     * Country code of the country where the order will be shipped
     * @see Country
     * @var string
     */
    private $destinationCountryCode;
    /**
     * @var double
     */
    private $price = 0;
    /**
     * See STATUS_* constants from this class
     * @var string
     */
    private $status = null;
    /**
     * @see ShippingInfo
     * @var ShippingInfo
     */
    private $shippingInfo;
    /**
     * Payment option for order, can be either InvoiceMe or InvoiceRecipient
     * @var string
     */
    private $payment;
    /**
     * @var string
     */
    private $paymentUrl = null;
    /**
     * Quality Level for order, can be either Pro or Standard
     * @see Catalogue::QUALITY_STANDARD
     * @see Catalogue::QUALITY_PRO
     * @var string
     */
    private $qualityLevel;
    /**
     * @see Photo
     * @var array
     */
    private $photos = array();

    function __construct()
    {
    }

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
    public function getRecipientName(): string
    {
        return $this->recipientName;
    }

    /**
     * @param string $recipientName
     */
    public function setRecipientName(string $recipientName)
    {
        $this->recipientName = $recipientName;
    }

    /**
     * @return string
     */
    public function getAddress1(): string
    {
        return $this->address1;
    }

    /**
     * @param string $address1
     */
    public function setAddress1(string $address1)
    {
        $this->address1 = $address1;
    }

    /**
     * @return string
     */
    public function getAddress2(): string
    {
        return $this->address2;
    }

    /**
     * @param string $address2
     */
    public function setAddress2(string $address2 = null)
    {
        $this->address2 = $address2;
    }

    /**
     * @return string
     */
    public function getAddressTownOrCity(): string
    {
        return $this->addressTownOrCity;
    }

    /**
     * @param string $addressTownOrCity
     */
    public function setAddressTownOrCity(string $addressTownOrCity = null)
    {
        $this->addressTownOrCity = $addressTownOrCity;
    }

    /**
     * @return string
     */
    public function getStateOrCounty(): string
    {
        return $this->stateOrCounty;
    }

    /**
     * @param string $stateOrCounty
     */
    public function setStateOrCounty(string $stateOrCounty = null)
    {
        $this->stateOrCounty = $stateOrCounty;
    }

    /**
     * @return string
     */
    public function getPostalOrZipCode(): string
    {
        return $this->postalOrZipCode;
    }

    /**
     * @param string $postalOrZipCode
     */
    public function setPostalOrZipCode(string $postalOrZipCode = null)
    {
        $this->postalOrZipCode = $postalOrZipCode;
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     */
    public function setCountryCode(string $countryCode = null)
    {
        $this->countryCode = $countryCode;
    }

    /**
     * @return string
     */
    public function getDestinationCountryCode(): string
    {
        return $this->destinationCountryCode;
    }

    /**
     * @param string $destinationCountryCode
     */
    public function setDestinationCountryCode(string $destinationCountryCode = null)
    {
        $this->destinationCountryCode = $destinationCountryCode;
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
     * @return ShippingInfo
     */
    public function getShippingInfo(): ShippingInfo
    {
        return $this->shippingInfo;
    }

    /**
     * @param ShippingInfo $shippingInfo
     */
    public function setShippingInfo(ShippingInfo $shippingInfo)
    {
        $this->shippingInfo = $shippingInfo;
    }

    /**
     * @return string
     */
    public function getStatus(): string
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
     * @return string
     */
    public function getPayment(): string
    {
        return $this->payment;
    }

    /**
     * @param string $payment
     */
    public function setPayment(string $payment)
    {
        $this->payment = $payment;
    }

    /**
     * @return string
     */
    public function getPaymentUrl()
    {
        return $this->paymentUrl;
    }

    /**
     * @param string $paymentUrl
     */
    public function setPaymentUrl(string $paymentUrl = null)
    {
        $this->paymentUrl = $paymentUrl;
    }

    /**
     * @return string
     */
    public function getQualityLevel(): string
    {
        return $this->qualityLevel;
    }

    /**
     * @param string $qualityLevel
     */
    public function setQualityLevel(string $qualityLevel = null)
    {
        $this->qualityLevel = $qualityLevel;
    }

    /**
     * @return array
     */
    public function getPhotos(): array
    {
        return $this->photos;
    }

    /**
     * @param array $photos
     */
    public function setPhotos(array $photos = array())
    {
        $this->photos = $photos;
    }
}