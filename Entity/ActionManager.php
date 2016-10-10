<?php
namespace Sipsynergy\ActivityStreamBundle\Entity;

use Sipsynergy\ActivityStreamBundle\Model\ActionInterface;
use Sipsynergy\ActivityStreamBundle\Model\ActionManager as BaseActionManager;
use Sipsynergy\ActivityStreamBundle\Repository\ActionRepositoryInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Class ActionManager
 */
class ActionManager extends BaseActionManager
{
    protected $em;
    protected $class;
    protected $repository;


    /**
     * @param EntityManager   $em
     * @param                 $class            Action entity class.
     * @param SecurityContext $securityContext
     */
    public function __construct(EntityManager $em, $class, SecurityContext $securityContext)
    {
        $this->em           = $em;
        $this->repository   = $em->getRepository($class);
        $this->class        = $em->getClassMetadata($class)->name;
//        if ($this->repository instanceof ActionRepositoryInterface) {
//            throw new \LogicException('Action entity repository has to implement ActionRepositoryInterface');
//        }

        parent::__construct($securityContext);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return $this->class;
    }
    
    /**
     * {@inheritDoc}
     */
    public function findOneStreamBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }
    
    /**
     * {@inheritDoc}
     */
    public function findStreamBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
    }


    /**
     * @param ActionInterface $action
     * @param bool            $andFlush
     */
    public function updateAction(ActionInterface $action, $andFlush = true)
    {
        $this->em->persist($action);
        if ($andFlush) {
            $this->em->flush();
        }
    }
}