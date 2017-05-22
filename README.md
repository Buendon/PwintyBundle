# Introduction

This Symfony Bundle propose a service to communicate with the [Pwinty](http://www.pwinty.com) API.

It uses the simple PHP implementation from [php-pwinty](https://github.com/Buendon/php-pwinty) and adds on top of it:
* An oriented-object API
* A Symfony service that can be used in a Symfony project.

**Warning:** This bundle still in construction, hence there is no official release yet.

# Installation

Update your composer.json in your Symfony project:

```
    "repositories" : [{
        "type": "vcs",
        "url": "https://github.com/Buendon/php-pwinty"
    }],
    ...
    "require": {
        ...
        "pwinty/php-pwinty" : "dev-api_2.3",
        "buendon/pwinty-bundle": "dev-master"
    },
    ...
```

Then, run ```composer update buendon/pwinty-bundle pwinty/php-pwinty```

**Note that** you need to declare a specific GitHub repository for the php-pwinty bundle.

Indeed, this one is a fork of [Pwinty/php-pwinty](https://github.com/Pwinty/php-pwinty).

A push request needs to be sent to the original one in order for it to be compatible with the 2.3 version of the Pwinty API.

This will be done when this module will be released.

# Configuration

Edit your ```config.yml``` file and add this:
```
    buendon_pwinty:
        apiType: 'sandbox'
        merchantId: 'yourPwintyMerchantId'
        apiKey: 'yourPwintyAPIKey'
```

The ```apiType``` can take the following values:
* sandbox
* production

This will be used to configure the [Pwinty URL](http://www.pwinty.com/ApiDocs/Overview/2_3#URLs) for the requests.

As it is stated in the Pwinty documentation, the tests and developments must be done with the sandbox ```apiType``` 
if you don't want to be billed with the submitted orders.

# Usage

```php
    <?php
    
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Buendon\PwintyBundle\Catalogue\Catalogue;
    use Buendon\PwintyBundle\Order\OrderException;
    use Buendon\PwintyBundle\Order\Photo;
    use Buendon\PwintyBundle\Service\PwintyService;
    use Buendon\PwintyBundle\Order\Order;
    
    class OrderController extends Controller
    {
        public function createOrderAction() {
            $service = $this->container->get(PwintyService::NAME);
    
    
            $order = new Order();
            $order->setRecipientName("Chuck Norris");
            $order->setAddress1("123 Some Road");
            $order->setAddress2("Some place");
            $order->setAddressTownOrCity("Some town");
            $order->setStateOrCounty("Some state");
            $order->setPostalOrZipCode("12345");
            $order->setCountryCode("FR");
            $order->setDestinationCountryCode("FR");
            $order->setPayment(Order::PAYMENT_INVOICE_ME);
            $order->setQualityLevel(Catalogue::QUALITY_STANDARD);
    
            try {
                $response = $service->createOrder($order);
            }
            catch (OrderException $e) {
                // If the call fails, it will throw an exception
                // Handle here the error
            }
    
            // The response will give you the order Id you can use to track it within the Pwinty API
            $response->getId();
        }
    
        public function getOrderDetailsAction() {
            $orderId = '12357';
            $service = $this->container->get(PwintyService::NAME);
    
            try {
                $order = $service->getOrder($orderId);
            }
            catch (OrderException $e) {
                // If the call fails, it will throw an exception
                // Handle here the error
            }
        }
    
        public function getOrderSubmissionStatusAction() {
            $orderId = '12357';
            $service = $this->container->get(PwintyService::NAME);
    
            try {
                // Give the Submision status
                // See Pwinty documentation for details
                $submissionStatus = $service->getOrderSubmissionStatus($orderId);
            }
            catch (OrderException $e) {
                // If the call fails, it will throw an exception
                // Handle here the error
            }
        }
    
        public function addPhotoToOrderAction() {
            $orderId = '12357';
            $service = $this->container->get(PwintyService::NAME);
            $photo = new Photo();
            $photo->setType('9x12_cm');
            $photo->setSizing(Photo::SIZING_CROP);
            $photo->setCopies(10);
            $photo->setFile("Path/to/the/picture");
    
            try {
                $service->addPhoto($orderId, $photo);
            }
            catch (OrderException $e) {
                // If the call fails, it will throw an exception
                // Handle here the error
            }
        }
        
        public function submitOrderAction() {
            // Once you have added all the pictures, you need to submit the order
            $orderId = '12357';
            $service = $this->container->get(PwintyService::NAME);
    
            try {
                $service->updateOrderStatus($orderId, Order::UPDATE_STATUS_SUBMITTED);
            }
            catch (OrderException $e) {
                // If the call fails, it will throw an exception
                // Handle here the error
            }
        }
    }
```

