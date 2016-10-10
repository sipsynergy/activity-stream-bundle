<?php
namespace Sipsynergy\ActivityStreamBundle\Twig\Extension;

use Sipsynergy\ActivityStreamBundle\Model\ActionInterface;
use Sipsynergy\ActivityStreamBundle\Streamable\StreamableInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class TimeExtension
 */
class TimeExtension extends \Twig_Extension
{
    protected $helper;

    public function __construct(TimeHelper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * Returns a list of global functions to add to the existing list.
     *
     * @return array An array of global functions
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction(
                'time_diff',
                array($this, 'diff'),
                array('is_safe' => array('html'))
            ),
        );
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter(
                'ago',
                array($this, 'diff'),
                array('is_safe' => array('html'))
            ),
        );
    }

    public function diff($since = null, $to = null)
    {
        return $this->helper->diff($since, $to);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'time';
    }
}
