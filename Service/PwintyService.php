<?php

namespace Buendon\PwintyBundle\Service;

use Buendon\PwintyBundle\Order\Photo;
use Buendon\PwintyBundle\Order\SubmissionStatus;
use pwinty\PhpPwinty;
use Buendon\PwintyBundle\Catalogue\Catalogue;
use Buendon\PwintyBundle\Catalogue\CatalogueNotFoundException;
use Buendon\PwintyBundle\Order\OrderException;
use Buendon\PwintyBundle\Order\Order;

class PwintyService
{
    const NAME = "buendon_pwinty.pwinty_service";

    private $pwinty;
    private $apiType;

    public function __construct($apiType, $merchantId, $apiKey)
    {
        $this->apiType = $apiType;
        $this->pwinty = new PhpPwinty(array(
            'api'        => $apiType,
            'merchantId' => $merchantId,
            'apiKey'     => $apiKey
        ));
    }

    public function isSandbox() {
        return $this->apiType != 'production';
    }

    /**
     * Get the list of the supported countries and their associated information.
     * 
     * @return array
     */
    public function getCountries() {
        return $this->pwinty->getCountries();
    }

    /**
     * @param $countryCode
     * @param $quality
     * @return Catalogue The catalogue for the given countryCode and quality
     * @throws CatalogueNotFoundException
     */
    public function getCatalogue($countryCode, $quality) {
        $jsonResponse = $this->pwinty->getCatalogue($countryCode, $quality);

        if(array_key_exists(Catalogue::FIELD_ERROR_MESSAGE, $jsonResponse) && $jsonResponse[Catalogue::FIELD_ERROR_MESSAGE] != "") {
            throw new CatalogueNotFoundException($jsonResponse[Catalogue::FIELD_ERROR_MESSAGE]);
        }
        else if($jsonResponse == 0) {
            throw new CatalogueNotFoundException($this->pwinty->last_error);
        }
        return new Catalogue($jsonResponse);
    }

    /**
     * @param Order $order
     * @return Order The updated order with the order Id set.
     * @throws OrderException
     */
    public function createOrder($order) {
        $response = $this->pwinty->createOrder(
            $order->getRecipientName(),
            $order->getAddress1(),
            $order->getAddress2(),
            $order->getAddressTownOrCity(),
            $order->getStateOrCounty(),
            $order->getPostalOrZipCode(),
            $order->getCountryCode(),
            $order->getDestinationCountryCode(),
            false,
            $order->getPayment(),
            $order->getQualityLevel());

        if($response == 0) {
            throw new OrderException("Order creation failed: ".$this->pwinty->last_error);
        }

        return Order::buildFromJSON($response);
    }

    /**
     * @param string $orderId
     * @param Photo $photo
     * @return Photo
     * @throws OrderException
     */
    public function addPhoto(string $orderId, Photo $photo): Photo {
        $response = $this->pwinty->addPhoto(
            $orderId,
            $photo->getType(),
            $photo->getUrl(),
            $photo->getCopies(),
            $photo->getSizing(),
            $photo->getPriceToUser(),
            $photo->getMd5Hash(),
            $photo->getFile());

        if($response == 0) {
            throw new OrderException("Add photo failed: ".$this->pwinty->last_error);
        }

        return Photo::buildFromJSON($response);
    }

    /**
     * @param string $orderId
     * @return SubmissionStatus
     * @throws OrderException
     */
    public function getOrderSubmissionStatus(string $orderId) {
        $response = $this->pwinty->getOrderStatus($orderId);

        if($response == 0) {
            throw new OrderException("Failed to get order status with id=".$orderId.": ".$this->pwinty->last_error);
        }

        return new SubmissionStatus($response);
    }

    /**
     * @param string $orderId
     * @param string $status
     * @throws OrderException
     */
    public function updateOrderStatus(string $orderId, string $status) {
        $response = $this->pwinty->updateOrderStatus($orderId, $status);

        if($response == 0) {
            throw new OrderException("Failed to update order status with id=".$orderId." and status ".$status.": ".$this->pwinty->last_error);
        }
        else if(is_array($response) & array_key_exists('errorMessage', $response) && $response['errorMessage'] != null && $response['errorMessage'] != '') {
            throw new OrderException("Failed to update order status with id=".$orderId." and status ".$status.": ".$response['errorMessage']);
        }
    }

    /**
     * @param string $id
     * @return Order
     * @throws OrderException
     */
    public function getOrder(string $id): Order {
        $response = $this->pwinty->getOrder($id);
        if($response == 0) {
            throw new OrderException("Failed to get order details with id=".$id.": ".$this->pwinty->last_error);
        }
        return Order::buildFromJSON($response);
    }
}