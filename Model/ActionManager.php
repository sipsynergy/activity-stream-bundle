<?php

namespace Sipsynergy\ActivityStreamBundle\Model;

use Sipsynergy\ActivityStreamBundle\Streamable\StreamableInterface;

use Symfony\Component\Security\Core\SecurityContext;
use Sipsynergy\ActivityStreamBundle\Entity\Action;


abstract class ActionManager implements ActionManagerInterface
{

    protected $securityContext;


    /**
     * @param SecurityContext $securityContext
     */
    public function __construct(SecurityContext $securityContext)
    {
        $this->securityContext = $securityContext;
    }


    /**
     * Returns an empty Action instance
     *
     * @return Action
     */
    public function createAction()
    {
        $class  = $this->getClass();
        $action = new $class;

        return $action;
    }


    /**
     * @param       $actor
     * @param array $orderBy
     * @param null  $limit
     * @param null  $offset
     *
     * @return mixed
     */
    public function findStreamByActor($actor, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->findStreamBy(array('actorId' => $actor->getId()), $orderBy, $limit, $offset);
    }


    /**
     * @param array $actorIds
     * @param array $orderBy
     * @param null  $limit
     * @param null  $offset
     *
     * @return mixed
     */
    public function findStreamByActors(array $actorIds, array $orderBy = null, $limit = null, $offset = null)
    {
    }


    /**
     * @param       $target
     * @param array $orderBy
     * @param null  $limit
     * @param null  $offset
     *
     * @return mixed
     */
    public function findStreamByTarget($target, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->findStreamBy(array(
            'targetId'   => $target->getId(),
            'targetType' => get_class($target),
        ), $orderBy, $limit, $offset);
    }


    /**
     * @param                     $verb
     * @param StreamableInterface $target
     * @param null                $actionObject
     * @param null                $actor
     *
     * @throws \LogicException
     */
    public function send($verb, StreamableInterface $target = null, $actionObject = null, $actor = null)
    {
        $actor = $actor ?: $this->securityContext->getToken()->getUser();
        if (null === $actor) {
            throw new \LogicException('You must be logged');
        }

        $action = $this->createAction();
        $action->setVerb($verb);
        $action->setActor($actor);

        if (null !== $target) {
            $action->setTarget($target);
        }

        if (null !== $actionObject) {
            $action->setActionObject($actionObject);
        }

        $this->updateAction($action);
    }
}
