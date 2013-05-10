<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Digitalwert\Symfony2\Bundle\Monodi\OAuthServerBundle\Entity;

use FOS\OAuthServerBundle\Entity\AccessToken as BaseAccessToken;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="oauth_access_token") 
 * @ORM\Entity
 */
class AccessToken extends BaseAccessToken
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
}
