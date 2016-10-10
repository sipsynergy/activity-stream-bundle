<?php

namespace Sipsynergy\ActivityStreamBundle\Streamable;

/**
 * Interface StreamableInterface.
 */
interface StreamableInterface
{

    /**
     * Return an array for the form
     *
     * array(
     *   'route' => $routeName,
     *   'parameters' => array(key => value, ...)
     * )
     *
     * @return array
     */
    public function getAbsolutePathParams();


    /**
     * String that will be presented in action stream used by the renderer.
     *
     * @return mixed
     */
    public function getStreamString();


    /**
     * @return integer
     */
    public function getId();
}
