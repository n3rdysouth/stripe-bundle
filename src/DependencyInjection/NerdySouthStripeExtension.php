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
        $configuration = $this->processConfiguration(new Configuration(), $configs);
        
        $container->setParameter('nerdysouth_stripe.webhook_secret', $configuration['webhook_secret'] ?? null);
    }
}