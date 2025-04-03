[![Latest Stable Version](http://poser.pugx.org/nerdysouth/stripe-bundle/v)](https://packagist.org/packages/nerdysouth/stripe-bundle) [![Total Downloads](http://poser.pugx.org/nerdysouth/stripe-bundle/downloads)](https://packagist.org/packages/nerdysouth/stripe-bundle) [![Latest Unstable Version](http://poser.pugx.org/nerdysouth/stripe-bundle/v/unstable)](https://packagist.org/packages/nerdysouth/stripe-bundle) [![License](http://poser.pugx.org/nerdysouth/stripe-bundle/license)](https://packagist.org/packages/nerdysouth/stripe-bundle) [![PHP Version Require](http://poser.pugx.org/nerdysouth/stripe-bundle/require/php)](https://packagist.org/packages/nerdysouth/stripe-bundle)

# Stripe Bundle for Symfony

## Description

This bundle helps developers do a Stripe integration in a Symfony application for processing payments. The bundle allows you to generate a redirect URL for one-time or recurring subscription payments, using parameters like success URL, failure URL, amount, and optional product product/subscription description. The bundle also adds a route for webhooks and fires a custom event on all webhooks from Stripe, as well as stores Transactions and their status using Doctrine, so that logging and tracking successful payments and subscriptions, and other events, is a breeze.

For now, this bundle allows you to:

- Easily create one-time and subscription payment links
- Listen and handle stripe webhooks as Symfony events
- Log & view successful payments and subscriptions in your database

## Next Steps

- Add Stripe sync to custom doctrine models (i.e. Users, custom objects)

## Installation

Install the stripe-bundle package with composer:

`composer require nerdysouth/stripe-bundle`

Add the following lines to your `config/routes.yaml` file (modify the path if you prefer a different path):

```
nerdysouth_stripe_webhook:
  path: /webhook/stripe
  controller: NerdySouth\StripeBundle\Controller\StripeWebhookController::handleWebhook
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

Run a composer update to ensure the additional able is added:

`php bin/console doctrine:schema:update -f`

## Support & Contributing

- Please open any issues regarding new features you think would help, or bugs you find in using this application.

Contributions are welcome and encouraged. If you would like to contribute, here is how you can help:

Fork the project.
Create a topic branch from master .
Make some commits to improve the project.
Push this branch to your GitHub project.
Open a Pull Request on GitHub.
Explain what your code does or how it helps.
