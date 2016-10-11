<?php

namespace Sipsynergy\ActivityStreamBundle\Entity;

use Sipsynergy\ActivityStreamBundle\Model\ActionInterface;
use Sipsynergy\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Action
 *
 *     <entity name="Sipsynergy\ActivityStreamBundle\Entity\Action" table="activity_stream_action">
 *
 * <id name="id" column="id" type="integer">
 * <generator strategy="AUTO" />
 * </id>
 *
 * <field name="actorType" column="actor_type" type="string" length="255" />
 *
 * <field name="verb" column="verb" type="string" length="255" />
 *
 * <field name="targetType" column="target_type" type="string" length="255" nullable="true" />
 *
 * <field name="actionObjectType" column="action_object_type" type="string" length="255" nullable="true" />
 *
 * <field name="createdAt" column="created_at" type="datetime" />
 */


/**
 * Action entity describing the actor acting out a verb (on an optional target).
 * Nomenclature based on http://martin.atkins.me.uk/specs/activitystreams/atomactivity
 *
 * Generalized Format:
 *
 *   <actor> <verb> <time>
 *   <actor> <verb> <target> <time>
 *   <actor> <verb> <action_object> <target> <time>
 *
 * Examples:
 *
 *   <justquick> <reached level 60> <1 minute ago>
 *   <brosner> <commented on> <pinax/pinax> <2 hours ago>
 *   <washingtontimes> <started follow> <justquick> <8 minutes ago>
 *   <mitsuhiko> <closed> <issue 70> on <mitsuhiko/flask> <about 3 hours ago>
 *
 * __toString() Representation:
 *
 *   justquick reached level 60 1 minute ago
 *   mitsuhiko closed issue 70 on mitsuhiko/flask 3 hours ago
 *
 * HTML Representation::
 *   <a href="http://oebfare.com/">brosner</a> commented on <a href="http://github.com/pinax/pinax">pinax/pinax</a> 2 hours ago
 *
 * @ORM\Table(name="activity_stream_actions",indexes={@ORM\Index(name="action_idx", columns={"actor_id", "actor_type", "date_added"})})
 * @ORM\Entity(repositoryClass="Sipsynergy\ActivityStreamBundle\EntityRepository\ActionRepository")
 */
class Action implements ActionInterface
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="verb", type="string")
     */
    private $verb;

    /**
     * @var integer
     *
     * @ORM\Column(name="actor_id", type="integer")
     */
    private $actorId;

    /**
     * @var string
     *
     * @ORM\Column(name="actor_type", type="string")
     */
    private $actorType;

    /**
     * @var integer
     *
     * @ORM\Column(name="target_id", type="integer", nullable=true)
     */
    private $targetId;

    /**
     * @var string
     *
     * @ORM\Column(name="target_type", type="string", nullable=true)
     */
    private $targetType;

    /**
     * @var integer
     *
     * @ORM\Column(name="action_object_id", type="integer", nullable=true)
     */
    private $actionObjectId;

    /**
     * @var string
     *
     * @ORM\Column(name="action_object_type", type="string", nullable=true)
     */
    private $actionObjectType;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_added", type="datetime")
     */
    private $date_added;


    protected $actor;
    protected $target;
    protected $actionObject;


    public function __construct()
    {
        $this->date_added = new \DateTime;
    }


    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->hasTarget()) {
            if ($this->hasActionObject()) {
                return sprintf('%s %s %s on %s %s', $this->getActor(), $this->getVerb(), $this->getActionObject(), $this->getTarget(), $this->getCreatedAt());
            } else {
                return sprintf('%s %s %s', $this->getActor(), $this->getVerb(), $this->getTarget(), $this->getDateAdded());
            }
        }
        return sprintf('%s %s %s', $this->getActor(), $this->getVerb(), $this->getDateAdded()->format('Y-m-d H:i:s'));
    }


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @param int $actionObjectId
     */
    public function setActionObjectId($actionObjectId)
    {
        $this->actionObjectId = $actionObjectId;
    }


    /**
     * @return int
     */
    public function getActionObjectId()
    {
        return $this->actionObjectId;
    }


    /**
     * @param mixed $actorId
     */
    public function setActorId($actorId)
    {
        $this->actorId = $actorId;
    }


    /**
     * @return mixed
     */
    public function getActorId()
    {
        return $this->actorId;
    }


    /**
     * @param int $targetId
     */
    public function setTargetId($targetId)
    {
        $this->targetId = $targetId;
    }


    /**
     * @return int
     */
    public function getTargetId()
    {
        return $this->targetId;
    }


    public function getActorType()
    {
        return $this->actorType;
    }


    public function getActor()
    {
        return $this->actor;
    }


    public function getVerb()
    {
        return $this->verb;
    }


    public function getTargetType()
    {
        return $this->targetType;
    }


    public function getTarget()
    {
        return $this->target;
    }


    public function getActionObjectType()
    {
        return $this->actionObjectType;
    }


    public function getActionObject()
    {
        return $this->actionObject;
    }


    public function setActorType($actorType)
    {
        $this->actorType = $actorType;
    }


    public function setActor($actor)
    {
        $this->actorId   = $actor->getId();
        $this->actorType = get_class($actor);
        $this->actor     = $actor;
    }


    public function setVerb($verb)
    {
        $this->verb = $verb;
    }


    public function setTargetType($targetType)
    {
        $this->targetType = $targetType;
    }


    public function setTarget($target)
    {
        $this->targetId   = $target->getId();
        $this->targetType = get_class($target);
        $this->target     = $target;
    }


    public function setActionObjectType($actionObjectType)
    {
        $this->actionObjectType = $actionObjectType;
    }


    public function setActionObject($actionObject)
    {
        $this->actionObjectId   = $actionObject->getId();
        $this->actionObjectType = get_class($actionObject);
        $this->actionObject     = $actionObject;
    }


    public function hasTarget()
    {
        return (bool)$this->getTarget();
    }


    public function hasActionObject()
    {
        return (bool)$this->getActionObject();
    }


    /**
     * @return \DateTime
     */
    public function getDateAdded()
    {
        return $this->date_added;
    }


    /**
     * @return \DateTime
     */
    public function getDateModified()
    {
        return $this->date_modified;
    }
}