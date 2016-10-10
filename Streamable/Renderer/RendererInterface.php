<?php

namespace Sipsynergy\ActivityStreamBundle\Streamable\Renderer;

use Sipsynergy\ActivityStreamBundle\Model\ActionInterface;

/**
 * Provides renderers for the actions
 */
interface RendererInterface
{
    function getActorUrl();
    function getTargetUrl();
    function getActionObjectUrl();
    function getTemplate();
    function getTemplateParams();
    function setProvider(RendererProvider $provider);
    function getProvider();
    function setAction(ActionInterface $action);
    function getAction();
    function supports(ActionInterface $action);
}