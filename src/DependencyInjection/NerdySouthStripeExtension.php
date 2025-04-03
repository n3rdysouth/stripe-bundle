<?php

namespace NerdySouth\StripeBundle\DependencyInjection;

use Symfony\Bundle\FrameworkBundle\DependencyInjection\Configuration;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class NerdySouthStripeExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        // Process and validate user-defined bundle configuration
        $configuration = new Configuration('nerdysouth_stripe');
        $config = $this->processConfiguration($configuration, $configs);

        // Set parameters for use in services
        $container->setParameter('nerdysouth_stripe.api_key', '%env(STRIPE_SECRET_KEY)%');
        $container->setParameter('nerdysouth_stripe.webhook_secret', '%env(STRIPE_WEBHOOK_SECRET)%');

        // Load service definitions
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../../config'));
        $loader->load('services.yaml');
    }
}