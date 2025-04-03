<?php

namespace NerdySouth\StripeBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class NerdySouthStripeBundle extends Bundle
{
    /**
     * Load the routes for this bundle.
     */
    public function configureRoutes(RoutingConfigurator $routes): void
    {
        // Import your routes from config/routes.yaml in the bundle
        $routes->import(__DIR__ . '/Resources/config/routes.yaml');
    }
}