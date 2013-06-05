<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\Git\RepositoryContainer;

/**
 * User
 * 
 * @see https://github.com/FriendsOfSymfony/FOSUserBundle/blob/master/Resources/doc/index.md
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\UserRepository")
 * 
 * @Serializer\ExclusionPolicy("ALL")
 * @Serializer\XmlRoot(name="profile")
 */
class User extends BaseUser implements RepositoryContainer
{
    /**
     * Anrede für männliche Nutzer
     */
    const SALUTATION_Mr = 'Herr';
    
    /**
     * Anrede für weibliche Nutzer
     */
    const SALUTATION_Ms = 'Frau';
    
    /**
     * Primärschlüssel 
     * 
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     * @Serializer\Expose
     * @Serializer\Groups({"list","detail","profile"})
     * @Serializer\XmlAttribute
     */
    protected $id;
    
    /**
     * Nutzername
     * 
     * @var string
     * 
     * @Serializer\Expose
     * @Serializer\Groups({"list","detail","profile"})
     */
    protected $username;
    
    /**
     * Nutzer-Email 
     * 
     * @var string
     * 
     * @Assert\NotBlank
     * @Assert\Email
     * 
     * @Serializer\Expose
     * @Serializer\Groups({"list","detail","profile"})
     */
    protected $email;
    
    /**
     * Anrede des Nutzers
     * 
     * @var string
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     * @Assert\NotBlank
     * @Assert\Choice(callback = "getSalutations")
     * 
     * @Serializer\Expose
     * @Serializer\Groups({"list","detail","profile"})
     */
    protected $salutation;
    
    /**
     * Titel des Nutzers
     * 
     * @var string
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     * Assert\NotEmpty
     * Assert\
     * 
     * @Serializer\Expose
     * @Serializer\Groups({"list","detail","profile"})
     */
    protected $title;
    
    /**
     * Vorname 
     * 
     * @var string
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     * @Assert\NotBlank
     * 
     * @Serializer\Expose
     * @Serializer\Groups({"list","detail","profile"})
     */
    protected $firstname;
    
    /**
     * Nachname des Nutzers
     * 
     * @var string
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     * @Assert\NotBlank
     * 
     * @Serializer\Expose
     * @Serializer\Groups({"list","detail","profile"})
     */
    protected $lastname;
    
    /**
     * Nutzergruppen
     * 
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
     * Gibt die Möglichen Anreden zurück
     * 
     * @return array
     */
    static public function getSalutations() {
        return array(
          self::SALUTATION_Mr,
          self::SALUTATION_Ms,
        );
    }
    
    /**
     * Konstruktor
     */
    public function __construct()
    {
        //$this->groups = new \Doctrine\Common\Collections\ArrayCollection();
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
    
    /**
     * 
     * @return \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\VersionControlSystemRepos
     */
    public function getVersionControlSystemRepos() {
       return $this->versionControlSystemRepos;
    }
    
    /**
     * 
     * @param \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\VersionControlSystemRepos $repos
     * @return void
     */
    public function setVersionControlSystemRepos(VersionControlSystemRepos $repos) {
       $this->versionControlSystemRepos = $repos;
    }
    
    /**
     * Setzt den Nachname
     * 
     * @param string $lastname
     * @return \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\User
     */
    public function setLastname($lastname) {
        $this->lastname = $lastname;
        return $this;
    }
    
    /**
     * Gibt den Nachname zurück
     * 
     * @return string
     */
    public function getLastname() {
        return $this->lastname;
    }
    
    /**
     * Setzt den Vorname
     * 
     * @param string $firstname
     * @return \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\User
     */
    public function setFirstname($firstname) {
        $this->firstname = $firstname;
        return $this;
    }
    
    /**
     * Gibt den Vornamen zurück
     * 
     * @return string
     */
    public function getFirstname() {
        return $this->firstname;
    }
        
    /**
     * Setzt die Anrede des Nutzers
     * 
     * @param string $salutation
     * @return \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\User
     */
    public function setSalutation($salutation) {
        $this->salutation = $salutation;
        return $this;
    }
    
    /**
     * Gibt die Anrede des Nutzers zurück
     * 
     * @return string
     */
    public function getSalutation() {
        return $this->salutation;
    }
    
    /**
     * Setzt den Titel des Nutzers
     * 
     * @param string $title
     * @return \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\User
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }
    
    /**
     * Gibt den Titel des Nutzers zurück
     * 
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    public function getDisplayName() {
        
        return trim($this->getFirstname() . ' ' . $this->getLastname());
    }
    
    
    public function getRepository() {
        return $this->getVersionControlSystemRepos();
    }
    
    public function getRepositoryPath() {
        return $this->getUsernameCanonical();
    }
}
