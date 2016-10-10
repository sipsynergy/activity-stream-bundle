<?php

namespace Sipsynergy\ActivityStreamBundle\Streamable\Renderer;

use Sipsynergy\ActivityStreamBundle\Model\ActionInterface;


/**
 * Provides renderers for the actions
 */
class RendererProvider
{
    protected $renderers;
    protected $defaultRenderer;


    /**
     * RendererProvider constructor.
     *
     * @param RendererInterface $defaultRenderer
     */
    public function __construct(RendererInterface $defaultRenderer)
    {
        $this->renderers = [];
        $this->defaultRenderer = $defaultRenderer;
    }


    /**
     * @param RendererInterface $renderer
     */
    public function addRenderer(RendererInterface $renderer)
    {
        $this->renderers[] = $renderer;
        $renderer->setProvider($this);
    }


    /**
     * @return array
     */
    public function getRenderers()
    {
        return $this->renderers;
    }


    /**
     * @param ActionInterface $action
     *
     * @return mixed|RendererInterface
     */
    public function resolve(ActionInterface $action)
    {
        foreach ($this->getRenderers() as $renderer) {
            if ($renderer->supports($action)) {
                $renderer->setAction($action);

                return $renderer;
            }
        }

        $this->defaultRenderer->setProvider($this);
        $this->defaultRenderer->setAction($action);

        return $this->defaultRenderer;
    }
}
