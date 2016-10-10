<?php
namespace Sipsynergy\ActivityStreamBundle\Twig\Extension;

use Sipsynergy\ActivityStreamBundle\Model\ActionInterface;
use Sipsynergy\ActivityStreamBundle\Streamable\StreamableInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ActionExtension
 */
class ActionExtension extends \Twig_Extension
{
    protected $container;


    /**
     * ActionExtension constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    /**
     * Returns a list of global functions to add to the existing list.
     *
     * @return array An array of global functions
     */
    public function getFunctions()
    {
        return [
            'activity_stream_render' => new \Twig_Function_Method(
                $this, 'render', [
                'is_safe' => ['html'],
            ]
            ),
        ];
    }


    /**
     * Returns the action html.
     *
     * @return array An array of global functions
     */
    public function render(ActionInterface $action)
    {
        $renderer = $this->container->get('activity_stream.renderer_provider')->resolve($action);

        try {
            return trim($this->container->get('templating')->render($renderer->getTemplate(), $renderer->getTemplateParams()));
        } catch(\Exception $e) {
            // If rendering failed that's most likely due to entity not missing (a.k.a. removed).
        }
    }


    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'activity_stream_action';
    }
}
