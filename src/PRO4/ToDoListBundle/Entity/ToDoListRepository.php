<?php

namespace PRO4\ToDoListBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ToDoListRepository extends EntityRepository {
	
    public function findToDoListsForProject(\PRO4\ProjectBundle\Entity\Project $project, array $departments) {
        $qb = $this->createQueryBuilder('t')
				->where('t.project = :project')
				->andwhere('t.department is null')
				->orwhere('t.department IN (:departments)')
				->orderBy('t.name', 'ASC')
				->andwhere('t.completed = :completed')
    			->setParameters(
    				array(
						'project' => $project,
						'departments' => $departments,
						'completed' => false,
					)
				);

    	return $qb;
    }
}