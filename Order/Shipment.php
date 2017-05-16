<?php

namespace Buendon\PwintyBundle\Order;


class Shipment
{
    const FIELD_SHIPMENT_ID = "shipmentId";
    const FIELD_IS_TRACKED = "isTracked";
    const FIELD_TRACKING_NUMBER = "trackingNumber";
    const FIELD_TRACKING_URL = "trackingUrl";
    const FIELD_EARLIEST_ESTIMATED_ARRIVAL_DATE = "earliestEstimatedArrivalDate";
    const FIELD_LATEST_ESTIMATED_ARRIVAL_DATE = "latestEstimatedArrivalDate";
    const FIELD_SHIPPED_ON = "shippedOn";
    const FIELD_CARRIER = "carrier";
    const FIELD_PHOTO_IDS = "photoIds";

    public static function buildFromJSON($jsonShipment) {
        $shipment = new Shipment();
        $shipment->setShipmentId($jsonShipment[Shipment::FIELD_SHIPMENT_ID]);
        $shipment->setIsTracked(boolval($jsonShipment[Shipment::FIELD_IS_TRACKED]));
        $shipment->setTrackingNumber($jsonShipment[Shipment::FIELD_TRACKING_NUMBER]);
        $shipment->setTrackingUrl($jsonShipment[Shipment::FIELD_TRACKING_URL]);
        $shipment->setEarliestEstimatedArrivalDate(new \DateTime($jsonShipment[Shipment::FIELD_EARLIEST_ESTIMATED_ARRIVAL_DATE]));
        $shipment->setLatestEstimatedArrivalDate(new \DateTime($jsonShipment[Shipment::FIELD_LATEST_ESTIMATED_ARRIVAL_DATE]));
        $shipment->setShippedOn(new \DateTime($jsonShipment[Shipment::FIELD_SHIPPED_ON]));
        $shipment->setCarrier($jsonShipment[Shipment::FIELD_CARRIER]);
        $shipment->setPhotoIds($jsonShipment[Shipment::FIELD_PHOTO_IDS]);
        return $shipment;
    }

    /**
     * @var string
     */
    private $shipmentId;
    /**
     * @var bool
     */
    private $isTracked;
    /**
     * @var string
     */
    private $trackingNumber;
    /**
     * @var string
     */
    private $trackingUrl;
    /**
     * @var \DateTime
     */
    private $earliestEstimatedArrivalDate;
    /**
     * @var \DateTime
     */
    private $latestEstimatedArrivalDate;
    /**
     * @var \DateTime
     */
    private $shippedOn;
    /**
     * @var string
     */
    private $carrier;
    /**
     * @var array
     */
    private $photoIds;

    /**
     * @return string
     */
    public function getShipmentId(): string
    {
        return $this->shipmentId;
    }

    /**
     * @param string $shipmentId
     */
    public function setShipmentId(string $shipmentId = null)
    {
        $this->shipmentId = $shipmentId;
    }

    /**
     * @return bool
     */
    public function isTracked(): bool
    {
        return $this->isTracked;
    }

    /**
     * @param bool $isTracked
     */
    public function setIsTracked(bool $isTracked)
    {
        $this->isTracked = $isTracked;
    }

    /**
     * @return string
     */
    public function getTrackingNumber(): string
    {
        return $this->trackingNumber;
    }

    /**
     * @param string $trackingNumber
     */
    public function setTrackingNumber(string $trackingNumber = null)
    {
        $this->trackingNumber = $trackingNumber;
    }

    /**
     * @return string
     */
    public function getTrackingUrl(): string
    {
        return $this->trackingUrl;
    }

    /**
     * @param string $trackingUrl
     */
    public function setTrackingUrl(string $trackingUrl = null)
    {
        $this->trackingUrl = $trackingUrl;
    }

    /**
     * @return \DateTime
     */
    public function getEarliestEstimatedArrivalDate(): \DateTime
    {
        return $this->earliestEstimatedArrivalDate;
    }

    /**
     * @param \DateTime $earliestEstimatedArrivalDate
     */
    public function setEarliestEstimatedArrivalDate(\DateTime $earliestEstimatedArrivalDate = null)
    {
        $this->earliestEstimatedArrivalDate = $earliestEstimatedArrivalDate;
    }

    /**
     * @return \DateTime
     */
    public function getLatestEstimatedArrivalDate(): \DateTime
    {
        return $this->latestEstimatedArrivalDate;
    }

    /**
     * @param \DateTime $latestEstimatedArrivalDate
     */
    public function setLatestEstimatedArrivalDate(\DateTime $latestEstimatedArrivalDate = null)
    {
        $this->latestEstimatedArrivalDate = $latestEstimatedArrivalDate;
    }

    /**
     * @return \DateTime
     */
    public function getShippedOn(): \DateTime
    {
        return $this->shippedOn;
    }

    /**
     * @param \DateTime $shippedOn
     */
    public function setShippedOn(\DateTime $shippedOn = null)
    {
        $this->shippedOn = $shippedOn;
    }

    /**
     * @return string
     */
    public function getCarrier(): string
    {
        return $this->carrier;
    }

    /**
     * @param string $carrier
     */
    public function setCarrier(string $carrier = null)
    {
        $this->carrier = $carrier;
    }

    /**
     * @return array
     */
    public function getPhotoIds(): array
    {
        return $this->photoIds;
    }

    /**
     * @param array $photoIds
     */
    public function setPhotoIds(array $photoIds = array())
    {
        $this->photoIds = $photoIds;
    }
}