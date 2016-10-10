<?php
namespace Sipsynergy\ActivityStreamBundle\Doctrine\Event;

use Sipsynergy\ActivityStreamBundle\Model\ActionManagerInterface;
use Sipsynergy\ActivityStreamBundle\Streamable\Resolver\ResolverInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Class ActionSubscriber
 */
class ActionSubscriber
{

    /**
     * @var \Sipsynergy\ActivityStreamBundle\Streamable\Resolver\ResolverInterface
     */
    protected $streamableResolver;


    /**
     * @param \Sipsynergy\ActivityStreamBundle\Streamable\Resolver\ResolverInterface $streamableResolver
     */
    public function __construct(ResolverInterface $streamableResolver)
    {
        $this->streamableResolver = $streamableResolver;
    }


    /**
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $eventArgs
     */
    public function postLoad(LifecycleEventArgs $eventArgs)
    {
        $action    = $eventArgs->getEntity();
        $className = get_class($action);
        $em        = $eventArgs->getEntityManager();
        $metadata  = $em->getClassMetadata($className);

        if ($metadata->reflClass->implementsInterface('Sipsynergy\ActivityStreamBundle\Model\ActionInterface')) {

            if ($this->streamableResolver->supports($eventArgs, $action->getActorType())) {
                $actorReflProp = $metadata->reflClass->getProperty('actor');
                $actorReflProp->setAccessible(true);
                $actorReflProp->setValue(
                    $action, $this->streamableResolver->resolve($eventArgs, $action->getActorType(), $action->getActorId())
                );
            }

            if ($this->streamableResolver->supports($eventArgs, $action->getTargetType())) {
                $targetReflProp = $metadata->reflClass->getProperty('target');
                $targetReflProp->setAccessible(true);
                $targetReflProp->setValue(
                    $action, $this->streamableResolver->resolve($eventArgs, $action->getTargetType(), $action->getTargetId())
                );
            }

            if (null !== $action->getActionObjectType() && $this->streamableResolver->supports($eventArgs, $action->getActionObjectType())) {
                $actionObjReflProp = $metadata->reflClass->getProperty('actionObject');
                $actionObjReflProp->setAccessible(true);
                $actionObjReflProp->setValue(
                    $action, $this->streamableResolver->resolve($eventArgs, $action->getActionObjectType(), $action->getActionObjectId())
                );
            }
        }
    }
}
