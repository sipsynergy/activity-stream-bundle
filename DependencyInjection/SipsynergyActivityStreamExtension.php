<?php

namespace Sipsynergy\ActivityStreamBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class SipsynergyActivityStreamExtension extends Extension
{

    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $loader->load('resolver.xml');
        $loader->load('renderer.xml');
        $loader->load('twig.xml');
        $loader->load('orm.xml');

        $container->setParameter('activity_stream.renderer.default_class', $config['renderer']['default_class']);
    }
}
