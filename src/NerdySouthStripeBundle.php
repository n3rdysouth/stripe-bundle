<?php

namespace NerdySouth\StripeBundle;

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class NerdySouthStripeBundle extends Bundle
{
    public function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->add('nerdysouth_stripe_webhook', '/webhook/stripe')
            ->controller('NerdySouth\StripeBundle\Controller\StripeWebhookController::handleWebhook')
            ->methods(['POST']);
    }
}