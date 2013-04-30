<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity;

use FOS\UserBundle\Entity\GroupManager as BaseGroupManager;

/**
 * Description of GroupManager
 *
 * @author digitalwert
 */
class GroupManager 
  extends BaseGroupManager
{
   /**
    * {@inheritDoc}
    */
   public function findGroupById($id) {
     return $this->repository->find($id);
   }
}

