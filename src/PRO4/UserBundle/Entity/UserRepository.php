<?php

namespace PRO4\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function findUsersInProject(\PRO4\ProjectBundle\Entity\Project $project)
    {
        return $this->createQueryBuilder('u')
	            ->innerJoin('u.projects', 'p', 'WITH', 'p.projectId = :projectId')
    			->setParameter('projectId', $project);
    }
}