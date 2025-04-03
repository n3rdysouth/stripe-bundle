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
        $configuration = new Configuration('nerdy_south_stripe');
        $config = $this->processConfiguration($configuration, $configs);

        // Set parameters for use in services
        $container->setParameter('nerdysouth_stripe.webhook_secret', $config['webhook_secret'] ?? null);

        // Load service definitions
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../../config'));
        $loader->load('services.yaml');
    }
}