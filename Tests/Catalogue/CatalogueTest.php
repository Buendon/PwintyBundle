<?php

namespace Buendon\PwintyBundle\Tests\Catalogue;

use Buendon\PwintyBundle\Catalogue\Catalogue;
use Buendon\PwintyBundle\Catalogue\ShippingRatesItem;
use Buendon\PwintyBundle\Country\Country;
use Buendon\PwintyBundle\Tests\AbstractTestPwinty;

class CatalogueTest extends AbstractTestPwinty
{
    const COUNTRIES = array(
        "GB",
        "FR"
    );

    /**
     * @return array
     */
    public function countriesProvider() {
        $data = array();
        foreach (CatalogueTest::COUNTRIES as $country) {
            $data[$country] = array($country);
        }
        return $data;
    }

    /**
     * @param string $countryCode
     * @test
     * @dataProvider countriesProvider
     */
    public function testGetCountries($countryCode) {
        $countries = $this->getService()->getCountries();
        $this->assertTrue(is_array($countries));

        $countryFound = false;

        foreach ($countries as $country) {
            if($country[Country::FIELD_COUNTRY_CODE] == $countryCode) {
                $countryFound = true;
                $this->assertArrayHasKey(Country::FIELD_NAME, $country);
                $this->assertArrayHasKey(Country::FIELD_HAS_PRODUCTS, $country);
                $this->assertArrayHasKey(Country::FIELD_ERROR_MESSAGE, $country);
            }
        }

        $this->assertTrue($countryFound);
    }

    /**
     * @param string $countryCode
     * @test
     * @dataProvider countriesProvider
     */
    public function testHasCatalogueWithQualityStandard($countryCode) {
        $this->getService()->getCatalogue($countryCode, Catalogue::QUALITY_STANDARD);
    }

    /**
     * @param string $countryCode
     * @test
     * @dataProvider countriesProvider
     */
    public function testHasCatalogueWithQualityStandardAndPrints($countryCode) {
        $catalogue =
            $this->getService()->getCatalogue($countryCode, Catalogue::QUALITY_STANDARD);
        $catalogue->getShippingRateForBandType('Prints');
    }

    /**
     * @param string $countryCode
     * @test
     * @dataProvider countriesProvider
     */
    public function testHasCatalogueWithBrandPrint($countryCode) {
        $catalogue = $this->getService()->getCatalogue($countryCode, Catalogue::QUALITY_STANDARD);
        $items = $catalogue->getItemsForShippingBandType(ShippingRatesItem::BAND_PRINT);
        $this->assertTrue(count($items) > 0);
    }

    /**
     * @test
     */
    public function testHasItem() {
        $catalogue = $this->getService()->getCatalogue("FR", Catalogue::QUALITY_STANDARD);

        $item = $catalogue->getItemByName('9x12_cm');
        $this->assertNotNull($item, 'Item 9x12_cm not found');
        $this->assertEquals(ShippingRatesItem::BAND_PRINT, $item->getShippingBand(), "Wrong item shipping band");
    }

    /**
     * @test
     * @expectedException \Buendon\PwintyBundle\Catalogue\ShippingRateNotFoundException
     * @expectedExceptionMessage Shipping rate not found for shipping band type UNKNOWN
     */
    public function testWrongShippingBand() {
        $catalogue = $this->getService()->getCatalogue('FR', Catalogue::QUALITY_STANDARD)
            ->getShippingRateForBandType('UNKNOWN');
    }

    /**
     * @test
     * @expectedException \Buendon\PwintyBundle\Catalogue\CatalogueNotFoundException
     * @expectedExceptionMessage Country with code UNKNOWN not found
     */
    public function testWrongCountryCode() {
        $this->getService()->getCatalogue("UNKNOWN", Catalogue::QUALITY_STANDARD);
    }

    /**
     * @test
     * @expectedException \Buendon\PwintyBundle\Catalogue\CatalogueNotFoundException
     * @expectedExceptionMessage QualityLevel UNKNOWN not found
     */
    public function testWrongQualityLevel() {
        $this->getService()->getCatalogue("FR", "UNKNOWN");
    }

    /**
     * @test
     * @expectedException \Buendon\PwintyBundle\Catalogue\CatalogueItemNotFoundException
     * @expectedExceptionMessage Item UNKNOWN not found
     */
    public function testCatalogueItemNotFound() {
        $this->getService()->getCatalogue("FR", Catalogue::QUALITY_STANDARD)->getItemByName('UNKNOWN');
    }
}
