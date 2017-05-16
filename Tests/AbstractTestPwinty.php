<?php

namespace Buendon\PwintyBundle\Tests;


use Buendon\PwintyBundle\Service\PwintyService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class AbstractTestPwinty extends WebTestCase
{

    /**
     * @var PwintyService
     */
    private $service;

    /**
     * @before
     */
    public function setUp() {
        $client = static::createClient();
        $this->service = $client->getContainer()->get(PwintyService::NAME);
        $this->assertTrue($this->service->isSandbox(), "Test must against the sandbox API");
    }

    public function getService() {
        return $this->service;
    }
}