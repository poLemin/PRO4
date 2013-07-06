<?php

namespace PRO4\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository {
    public function findUsersInProject(\PRO4\ProjectBundle\Entity\Project $project) {
        return $this->createQueryBuilder('u')
	            ->innerJoin('u.projects', 'p', 'WITH', 'p.projectId = :projectId')
    			->setParameter('projectId', $project->getProjectId());
    }
    
    public function findUsersInProjectNotInDepartment(\PRO4\ProjectBundle\Entity\Project $project, \PRO4\ProjectBundle\Entity\Department $department) {
        $qb = $this->findUsersInProject($project);
        
        $qbDepartment = $this->createQueryBuilder('user')
	            ->innerJoin('user.departments', 'd', 'WITH', 'd.departmentId = :departmentId');
        
    	return $qb
    			->where($qb->expr()->notIn('u.userId', $qbDepartment->getDql()))
    			->setParameter('departmentId', $department->getDepartmentId());
    }
}