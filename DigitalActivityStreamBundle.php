<?php

namespace Sipsynergy\ActivityStreamBundle;

use Sipsynergy\ActivityStreamBundle\Doctrine\Event\ActionSubscriber;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Sipsynergy\ActivityStreamBundle\DependencyInjection\Compiler\RendererPass;
use Sipsynergy\ActivityStreamBundle\DependencyInjection\Compiler\ResolverPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class DigitalActivityStreamBundle
 */
class DigitalActivityStreamBundle extends Bundle
{

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new RendererPass());
        $container->addCompilerPass(new ResolverPass());
    }
}
