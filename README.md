[![Latest Stable Version](http://poser.pugx.org/nerdysouth/stripe-bundle/v)](https://packagist.org/packages/nerdysouth/stripe-bundle) [![Total Downloads](http://poser.pugx.org/nerdysouth/stripe-bundle/downloads)](https://packagist.org/packages/nerdysouth/stripe-bundle) [![Latest Unstable Version](http://poser.pugx.org/nerdysouth/stripe-bundle/v/unstable)](https://packagist.org/packages/nerdysouth/stripe-bundle) [![License](http://poser.pugx.org/nerdysouth/stripe-bundle/license)](https://packagist.org/packages/nerdysouth/stripe-bundle) [![PHP Version Require](http://poser.pugx.org/nerdysouth/stripe-bundle/require/php)](https://packagist.org/packages/nerdysouth/stripe-bundle)

# Stripe Bundle for Symfony

## Description

This bundle helps developers do a Stripe integration in a Symfony application for processing payments. The bundle allows you to generate a redirect URL for one-time or recurring subscription payments, using parameters like success URL, failure URL, amount, and optional product or subscription description. The bundle also adds a route for webhooks and fires a custom event on all webhooks from Stripe, as well as stores Transactions and their status using Doctrine, so that logging and tracking successful payments and subscriptions, and other events, is a breeze.

For now, this bundle allows you to:

- Easily create one-time and subscription payment links
- Listen and handle stripe webhooks as Symfony events
- Log & view successful payments and subscriptions in your database

## Next Steps

- Add ability to pass custom metadata into transactions and subscriptions

## Installation

Install the stripe-bundle package with composer:

`composer require nerdysouth/stripe-bundle`

Add the following lines to your `config/routes.yaml` file (modify the path if you prefer a different path):

```
nerdysouth_stripe_webhook:
  path: /webhook/stripe
  controller: NerdySouth\StripeBundle\Controller\StripeWebhookController::handle
  methods: [POST]
```

Add the following lines to your `config/packages/doctrine.yaml` file:

```
doctrine:
    orm:
        mappings:
            NerdySouthStripeBundle:
                is_bundle: true
                type: attribute
                dir: Entity
                prefix: NerdySouth\StripeBundle\Entity
                alias: NerdySouthStripeBundle
```

Run a doctrine schema update to ensure the additional table is added:

`php bin/console doctrine:schema:update -f`

# Generating Payment Links

Here is an example controller which will redirect the user to your payment page.

```
<?php

namespace App\Controller;

use NerdySouth\StripeBundle\Service\PaymentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'test')]
    public function test(PaymentService $paymentService)
    {
        return $this->redirect($paymentService->createPaymentUrl(
            29.99,
            'USD',
            'https://www.google.com', // url when successfully paid
            'https://www.google.com', // url on cancel or failure
            true, // change to false if not a subscription
            'Test Product or Subscription'
        ));
    }
}
```

## Event Handling

This bundle dispatches a `NerdySouth\StripeBundle\Event\StripeEvent` when a webhook is received, with a name that is equal to what Stripe uses as an event "type". For example, values like `checkout.session.completed` or `payment_intent.succeeded` - the event has methods like `getEventType()` and `getEventData()` to get the event type and the JSON data received in the webhook.

Doing custom code to update your own objects is as simple as creating your own event subscriber which listens for the events you care about.

## Support & Contributing

- Please open any issues regarding new features you think would help, or bugs you find in using this application.

Contributions are welcome and encouraged. If you would like to contribute, here is how you can help:

Fork the project.
Create a topic branch from master .
Make some commits to improve the project.
Push this branch to your GitHub project.
Open a Pull Request on GitHub.
Explain what your code does or how it helps.
