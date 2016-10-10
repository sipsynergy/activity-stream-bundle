<?php

namespace Sipsynergy\ActivityStreamBundle\Streamable\Renderer;

use Sipsynergy\ActivityStreamBundle\Model\ActionInterface;
use Sipsynergy\ActivityStreamBundle\Streamable\StreamableInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * Renderer is the abstract class used by all built-in render-ers.
 */
abstract class Renderer implements RendererInterface
{
    /** @var RendererProvider */
    protected $provider;

    /** @var ActionInterface */
    protected $action;

    /** @var \Symfony\Bundle\FrameworkBundle\Routing\Router  */
    protected $router;


    /**
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }


    /**
     * @param ActionInterface $action
     *
     * @return mixed
     */
    abstract public function supports(ActionInterface $action);


    /**
     * @return null|string
     */
    public function getActorUrl()
    {
        if (!$actor = $this->getAction()->getActor()) {
            return null;
        }

        return $this->generateUrl($actor);
    }


    /**
     * @return null|string
     */
    public function getTargetUrl()
    {
        if (!$target = $this->getAction()->getTarget()) {
            return null;
        }

        return $this->generateUrl($target);
    }


    /**
     * @return null|string
     */
    public function getActionObjectUrl()
    {
        if (!$object = $this->getAction()->getActionObject()) {
            return null;
        }

        return $this->generateUrl($object);
    }


    /**
     * @return string
     */
    public function getTemplate()
    {
        return 'DigitalActivityStreamBundle:Action:action.html.twig';
    }


    /**
     * @param RendererProvider $provider
     */
    public function setProvider(RendererProvider $provider)
    {
        $this->provider = $provider;
    }


    /**
     * @return RendererProvider
     */
    public function getProvider()
    {
        return $this->provider;
    }


    /**
     * @param ActionInterface $action
     */
    function setAction(ActionInterface $action)
    {
        $this->action = $action;
    }


    /**
     * @return ActionInterface
     */
    public function getAction()
    {
        return $this->action;
    }


    /**
     * @return array
     */
    public function getTemplateParams()
    {
        return array(
            'action'            => $this->getAction(),
            'target_url'        => $this->getTargetUrl(),
            'action_object_url' => $this->getActionObjectUrl(),
            'actor_url'         => $this->getActorUrl(),
        );
    }


    /**
     * @param StreamableInterface $entity
     *
     * @return string
     */
    protected function generateUrl(StreamableInterface $entity)
    {
        $pathParams = $entity->getAbsolutePathParams();

        if (!isset($pathParams['route']) || !isset($pathParams['parameters'])) {
            return null;
        }

        return $this->router->generate($pathParams['route'], $pathParams['parameters']);
    }
}
