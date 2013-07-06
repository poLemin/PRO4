<?php

namespace PRO4\ToDoListBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ListItemRepository extends EntityRepository {
	
    public function findOpenItemsForToDoList(\PRO4\ToDoListBundle\Entity\ToDoList $toDoList) {
		return $this->findItemsForToDoList($toDoList, false);
    }
    
    private function findItemsForToDoList(\PRO4\ToDoListBundle\Entity\ToDoList $toDoList, $completed) {
    	 $qb = $this->createQueryBuilder('l')
				->where('l.toDoList = :toDoList')
				->andwhere('l.completed = :completed')	
				->orderBy('l.name', 'ASC')
    			->setParameters(
    				array(
						'toDoList' => $todoList,
						'completed' => $completed,
					)
				);

    	return $qb;
    }
}