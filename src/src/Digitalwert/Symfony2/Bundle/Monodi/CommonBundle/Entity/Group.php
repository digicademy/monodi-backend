<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity;

use FOS\UserBundle\Entity\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_group")
 * 
 * @UniqueEntity("name")
 */
class Group extends BaseGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
     protected $id;
     
     
     /**
      * @var array
      */
     protected $roles;
     
     /**
      * 
      * @param string $name
      * @param array $roles
      */
     public function __construct($name, $roles = array()) {
       parent::__construct($name, $roles);
       if(empty($this->roles)) {
           $this->roles = array();
       }
     }
     
     /**
      * für String-Konvertierung
      * 
      * @return string
      */
     public function __toString() {
         return (string)$this->getName();
     }
     
     
}
