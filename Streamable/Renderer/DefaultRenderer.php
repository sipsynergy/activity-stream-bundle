<?php

namespace Sipsynergy\ActivityStreamBundle\Streamable\Renderer;

use Sipsynergy\ActivityStreamBundle\Model\ActionInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * Default renderer for the actions.
 */
class DefaultRenderer extends Renderer
{

    /**
     * @param ActionInterface $action
     *
     * @return bool
     */
    public function supports(ActionInterface $action)
    {
        return true;
    }
}
