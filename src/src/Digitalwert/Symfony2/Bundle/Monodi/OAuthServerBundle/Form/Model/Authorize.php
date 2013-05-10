<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\OAuthServerBundle\Form\Model;  

use Symfony\Component\Validator\Constraints as Assert;

class Authorize  
{  
    /**
     * Gibt an ob der Zugriff erlaubt wird
     * 
     * @var boolean
     * 
     * @Assert\True(message="Please check the checkbox to allow access to your profile.")
     */
    protected $allowAccess;  
    
    /**
     * 
     * @return boolean
     */
    public function getAllowAccess()  
    {  
        return $this->allowAccess;  
    }  
    
    /**
     * 
     * @param boolean $allowAccess
     * 
     * @return \Digitalwert\Symfony2\Bundle\Monodi\OAuthServerBundle\Form\Model\Authorize
     */
    public function setAllowAccess($allowAccess)  
    {  
        $this->allowAccess = $allowAccess; 
        return $this;
    }  
}