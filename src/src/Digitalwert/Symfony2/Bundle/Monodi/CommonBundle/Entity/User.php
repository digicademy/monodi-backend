<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 * 
 * @see https://github.com/FriendsOfSymfony/FOSUserBundle/blob/master/Resources/doc/index.md
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\UserRepository")
 */
class User 
  extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToMany(targetEntity="Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Group")
     * @ORM\JoinTable(name="fos_user_user_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;
    
    /**
     * @var VersionControlSystemRepos
     * 
     * @ORM\OneToOne(targetEntity="VersionControlSystemRepos")
     * @ORM\JoinColumn(name="version_control_system_repos_id", referencedColumnName="id")
     */
    protected $versionControlSystemRepos;
    
    /**
     * Konstruktor
     */
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * get expiresAt
     * 
     * @return \DateTime
     */
    public function getExpiresAt() {
        return $this->expiresAt;
    }
    
    /**
     * get credentialsExpireAt
     * 
     * @return \DateTime
     */
    public function getCredentialsExpireAt() {
        return $this->credentialsExpireAt;
    }
}
