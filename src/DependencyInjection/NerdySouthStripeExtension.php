<?php

namespace NerdySouth\StripeBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class NerdySouthStripeExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        // Define default parameters directly from environment variables
        $container->setParameter('nerdysouth_stripe.api_key', '%env(STRIPE_SECRET_KEY)%');
        $container->setParameter('nerdysouth_stripe.webhook_secret', '%env(STRIPE_WEBHOOK_SECRET)%');

        // Load the service definitions from services.yaml
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../../config'));
        $loader->load('services.yaml');
    }
}