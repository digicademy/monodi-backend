<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Digitalwert\Symfony2\Bundle\Monodi\OAuthServerBundle\Entity;

use FOS\OAuthServerBundle\Entity\RefreshToken as BaseRefreshToken;
use Doctrine\ORM\Mapping as ORM;
use FOS\OAuthServerBundle\Model\ClientInterface;  
use Symfony\Component\Security\Core\User\UserInterface; 
/**
 * 
 * @ORM\Table(name="oauth_refresh_token") 
 * @ORM\Entity
 */
class RefreshToken extends BaseRefreshToken
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $client;

    /**
     * @ORM\ManyToOne(targetEntity="Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\User")
     */
    protected $user;
    
        
    public function getClient()  
    {  
        return $this->client;  
    }  
  
    public function setClient(ClientInterface $client)  
    {  
        $this->client = $client;
        return $this;
    }  
  
    public function getUser()  
    {  
        return $this->user;  
    }  
  
    public function setUser(UserInterface $user)  
    {  
        $this->user = $user;  
        return $this;
    } 
}
