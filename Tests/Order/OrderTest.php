<?php

namespace Buendon\PwintyBundle\Tests\Order;


use Buendon\PwintyBundle\Catalogue\Catalogue;
use Buendon\PwintyBundle\Catalogue\ShippingRatesItem;
use Buendon\PwintyBundle\Order\Order;
use Buendon\PwintyBundle\Order\Photo;
use Buendon\PwintyBundle\Order\Shipment;
use Buendon\PwintyBundle\Order\ShippingInfo;
use Buendon\PwintyBundle\Tests\AbstractTestPwinty;
use Symfony\Bundle\SecurityBundle\Tests\Functional\WebTestCase;

class OrderTest extends AbstractTestPwinty
{
    /**
     * @param Order $expected
     * @param Order $actual
     * @param bool $mustHaveId
     */
    protected function checkOrder($expected, $actual, $mustHaveId) {
        if($mustHaveId) {
            $this->assertNotEmpty($actual->getId(), "The order must have an id");
        }
        else {
            $this->assertNull($actual->getId(), "The order must not have an id");
        }
        $this->assertEquals($expected->getStatus(), $actual->getStatus(), "Wrong status");
        $this->assertEquals($expected->getRecipientName(), $actual->getRecipientName(), "Wrong RecipientName");
        $this->assertEquals($expected->getAddress1(), $actual->getAddress1(), "Wrong Address1");
        $this->assertEquals($expected->getAddress2(), $actual->getAddress2(), "Wrong Address2");
        $this->assertEquals($expected->getAddressTownOrCity(), $actual->getAddressTownOrCity(), "Wrong AddressTownOrCity");
        $this->assertEquals($expected->getStateOrCounty(), $actual->getStateOrCounty(), "Wrong StateOrCounty");
        $this->assertEquals($expected->getPostalOrZipCode(), $actual->getPostalOrZipCode(), "Wrong PostalOrZipCode");
        $this->assertEquals($expected->getCountryCode(), $actual->getCountryCode(), "Wrong CountryCode");
        $this->assertEquals($expected->getDestinationCountryCode(), $actual->getDestinationCountryCode(), "Wrong DestinationCountryCode");
        $this->assertEquals($expected->getPayment(), $actual->getPayment(), "Wrong Payment");
        $this->assertEquals($expected->getPaymentUrl(), $actual->getPaymentUrl(), "Wrong PaymentUrl");
        $this->assertEquals($expected->getQualityLevel(), $actual->getQualityLevel(), "Wrong QualityLevel");

        $actualShippingInfo = $actual->getShippingInfo();
        $expectedShippingInfo = $expected->getShippingInfo();
        $this->assertEquals($expectedShippingInfo->getPrice(), $actualShippingInfo->getPrice(), "Wrong Price");
        $this->assertEquals(count($expectedShippingInfo->getShipments()), count($actualShippingInfo->getShipments()), "Wrong number of Shipping Info");

        $actualPhotos = $actual->getPhotos();
        $expectedPhotos = $expected->getPhotos();
        $this->assertEquals(count($expectedPhotos), count($actualPhotos), "Wrong number of photos");
    }

    protected function checkPhoto(Photo $expected, Photo $actual,
                                  $mustHaveAnId, $mustHaveAPreviewUrl) {
        $this->assertEquals($expected->getStatus(), $actual->getStatus(), "Wrong status");
        if($mustHaveAnId) {
            $this->assertNotEmpty($actual->getId());
        }
        $this->assertEquals($expected->getType(), $actual->getType(), "Wrong Type");
        $this->assertEquals($expected->getUrl(), $actual->getUrl(), "Wrong URL");
        $this->assertEquals($expected->getCopies(), $actual->getCopies(), "Wrong copies");
        $this->assertEquals($expected->getSizing(), $actual->getSizing(), "Wrong sizing");
        $this->assertEquals($expected->getMd5Hash(), $actual->getMd5Hash(), "Wrong MD5");
        if($mustHaveAPreviewUrl) {
            $this->assertNotEmpty($actual->getPreviewUrl());
            $this->assertNotEmpty($actual->getThumbnailUrl());
        }
    }

    /**
     * Creates a simple order with one shipment type and one picture to print 10 times
     */
    public function testCreateOrder() {
        echo "Initiate the order";

        $expectedOrder = new Order();
        $expectedOrder->setRecipientName("Chuck Norris");
        $expectedOrder->setAddress1("123 Some Road");
        $expectedOrder->setAddress2("Some place");
        $expectedOrder->setAddressTownOrCity("Some town");
        $expectedOrder->setStateOrCounty("Some state");
        $expectedOrder->setPostalOrZipCode("12345");
        $expectedOrder->setCountryCode("FR");
        $expectedOrder->setDestinationCountryCode("FR");
        $expectedOrder->setPayment(Order::PAYMENT_INVOICE_ME);
        $expectedOrder->setQualityLevel(Catalogue::QUALITY_STANDARD);

        $orderResponse = $this->getService()->createOrder($expectedOrder);

        echo "Update the expected order";

        // Apparently, an empty order get, at least the Shipping price for the chosen Print type.
        // But the Shipping items array still empty
        $catalogue = $this->getService()->getCatalogue("FR", Catalogue::QUALITY_STANDARD);
        $shippingRates = $catalogue->getShippingRateForBandType(ShippingRatesItem::BAND_PRINT);
        $catalogueItem = $catalogue->getItemByName('9x12_cm');

        $shippingInfo = new ShippingInfo();
        $shippingInfo->setPrice($shippingRates->getPriceUSD());

        $expectedOrder->setShippingInfo($shippingInfo);
        $expectedOrder->setStatus(Order::STATUS_NOT_YET_SUBMITTED);
        $expectedOrder->setPrice($shippingRates->getPriceUSD());

        echo "Check the expected order vs the one received in the response";

        $this->checkOrder($expectedOrder, $orderResponse, true);
        $this->assertEquals($expectedOrder->getPrice(), $orderResponse->getPrice(), "Wrong price");

        echo "Add a photo to the order";

        $expectedPhoto = new Photo();
        $expectedPhoto->setType('9x12_cm');
        $expectedPhoto->setSizing(Photo::SIZING_CROP);
        $expectedPhoto->setCopies(10);

        $picturePath = WebTestCase::$kernel->locateResource('@BuendonPwintyBundle/Tests/Resources/DSC04353.JPG');
        $expectedPhoto->setFile($picturePath);

        $photoResponse = $this->getService()->addPhoto($orderResponse->getId(), $expectedPhoto);

        echo "Update the expected photo";
        $expectedPhoto->setStatus(Photo::STATUS_OK);

        echo "Check the expected photo against the on received in the response";
        $this->checkPhoto($expectedPhoto, $photoResponse, true, true);

        echo "Get the current order status";
        $submissionStatusResponse = $this->getService()->getOrderSubmissionStatus($orderResponse->getId());

        echo "Check that the order is ready to be submitted";
        $this->assertTrue($submissionStatusResponse->isValid(), "Order status should be valid");
        $this->assertEquals($orderResponse->getId(), $submissionStatusResponse->getId(), "Submission status id should be equal to the order id");

        echo "Submit the order";
        $this->getService()->updateOrderStatus($orderResponse->getId(), Order::UPDATE_STATUS_SUBMITTED);

        echo "Get the current order state from the server";
        $orderResponse = $this->getService()->getOrder($orderResponse->getId());

        echo "Update the expected order state";
        $shipment = new Shipment();
        $shipment->setIsTracked($shippingRates->isTracked());
        $shippingInfo->setShipments(array($shipment));

        $expectedOrder->setShippingInfo($shippingInfo);
        $expectedOrder->setPhotos(array($expectedPhoto));
        $expectedOrder->setStatus(Order::STATUS_SUBMITTED);

        echo "Check the expected order vs the one received from the server";
        $this->checkOrder($expectedOrder, $orderResponse, true);

        // Pwinty provides rounded prices within the API.
        // As a consequence, if you estimate the order final price from the print unit price and the shipping price,
        // you'll not get exactly the final price given by the API.
        //
        // So, the comparison will compute the lower and upper bounds by using the API prices minus 1 cents and plus 1 cents.
        //
        $lowerPrice = 10 * ($catalogueItem->getPriceUSD() - 1) + ($shippingRates->getPriceUSD() - 1);
        $upperPrice = 10 * ($catalogueItem->getPriceUSD() + 1) + ($shippingRates->getPriceUSD() + 1);
        $this->assertTrue($lowerPrice <= $orderResponse->getPrice() && $orderResponse->getPrice() <= $upperPrice, "Price is not in the estimation range: ".$lowerPrice." <= ".$orderResponse->getPrice()." <= ".$upperPrice);
    }
}