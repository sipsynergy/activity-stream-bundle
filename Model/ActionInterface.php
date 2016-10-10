<?php

namespace Sipsynergy\ActivityStreamBundle\Model;

/**
 * Interface ActionInterface.
 */
interface ActionInterface
{

    public function getId();


    public function getActorType();


    public function getActor();


    public function getVerb();


    public function getTargetType();


    public function getTarget();


    public function getActionObjectType();


    public function getActionObject();


    public function setActorType($actorType);


    public function setActor($actor);


    public function setVerb($verb);


    public function setTargetType($targetType);


    public function setTarget($target);


    public function setActionObjectType($actionOjectType);


    public function setActionObject($actionObject);
}