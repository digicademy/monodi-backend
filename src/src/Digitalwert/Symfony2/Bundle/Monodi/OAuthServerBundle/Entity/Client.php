<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\OAuthServerBundle\Entity;

use FOS\OAuthServerBundle\Entity\Client as BaseClient;
use Doctrine\ORM\Mapping as ORM;

/**
 * Klasse welche einen Db
 * 
 * @link https://github.com/FriendsOfSymfony/FOSOAuthServerBundle/blob/master/Resources/doc/index.md
 * 
 * @ORM\Table(name="oauth_client") 
 * @ORM\Entity
 */
class Client extends BaseClient
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct() 
    {
        parent::__construct();
        // your own logic
    }
    
    /**
     * 
     * @var string
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $name;
    
    /**
     * Gitb den Namen des Client zurück
     * 
     * @return string
     */
    public function getName()  
    {  
        return $this->name;  
    }  
    
    /**
     * Setzt den Namen des Clients
     * 
     * @param string $name
     * @return \Digitalwert\Symfony2\Bundle\Monodi\OAuthServerBundle\Entity\Client
     */  
    public function setName($name)  
    {  
        $this->name = $name;
        return $this;
    }
}

