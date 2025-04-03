<?php

namespace NerdySouth\StripeBundle\Routing;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class StripeRouteLoader implements LoaderInterface
{
    private bool $isLoaded = false;

    private ?LoaderResolverInterface $resolver = null;

    public function load(mixed $resource, string $type = null): RouteCollection
    {
        if ($this->isLoaded) {
            throw new \RuntimeException('Do not add this loader twice.');
        }

        // Create a route collection
        $routes = new RouteCollection();

        // Define your routes
        $routes->add('nerdysouth_stripe_webhook', new Route(
            '/webhook/stripe',  // URL path
            [
                '_controller' => 'NerdySouth\\StripeBundle\\Controller\\StripeWebhookController::handleWebhook'
            ]
        ));

        $this->isLoaded = true;

        return $routes;
    }

    public function supports(mixed $resource, string $type = null): bool
    {
        return 'nerdysouth_stripe' === $type;
    }

    public function setResolver(LoaderResolverInterface $resolver): void
    {
        $this->resolver = $resolver;
    }

    public function getResolver(): LoaderResolverInterface
    {
        return $this->resolver;
    }
}