<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VersionControlSystemRepos
 *
 * @ORM\Table(name="monodi_version_control_system_repos")
 * @ORM\Entity(repositoryClass="Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\VersionControlSystemReposRepository")
 */
class VersionControlSystemRepos
{
    const TYPE_GIT = 'git';
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    protected $password;

    /**
     * @var string
     *
     * @ORM\Column(name="uri", type="string", length=255)
     */
    protected $uri;
    
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    protected $type;


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
     * Set username
     *
     * @param string $username
     * @return VersionControlSystemRepos
     */
    public function setUsername($username)
    {
        $this->username = $username;
    
        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return VersionControlSystemRepos
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set uri
     *
     * @param string $uri
     * @return VersionControlSystemRepos
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    
        return $this;
    }

    /**
     * Get uri
     *
     * @return string 
     */
    public function getUri()
    {
        return $this->uri;
    }
}
