<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Document
 *
 * @ORM\Table(name="monodi_document")
 * @ORM\Entity(repositoryClass="Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\DocumentRepository")
 * @ORM\HasLifecycleCallbacks
 * @Gedmo\Loggable
 */
class Document
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
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255)
     */
    protected $filename;

    /**
     * @var string
     *
     * @ORM\Column(name="rev", type="string", length=64)
     */
    protected $rev;
        
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="createdAt", type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * 
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="editedAt", type="datetime")
     */
    protected $editedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    protected $updatedAt;

    /**
     * @var string
     * 
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="processNumber", type="string", length=255)
     */
    protected $processNumber;

    /**
     * @var integer
     *
     * @ORM\Column(name="editionNumber", type="integer")
     */
    protected $editionNumber;
    
    /**
     * Besitzer des Dokuments (Datenbank)
     * 
     * @var User
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    protected $owner;    
    
    /**
     * Nutzergruppe des Dokuments
     * 
     * @var Group
     * @ORM\OneToOne(targetEntity="Group")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     */
    protected $group;
    
    /**
     * letzter Bearbeiter des Dokuments (Datenbank)
     * 
     * @var User
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="editor_id", referencedColumnName="id")
     */
    protected $editor;
    
    /**
     * Gibt an in welchem Verzeichnis sich das Dokument befindet
     * 
     * @var Folder
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="folder_id", referencedColumnName="id")
     */
    protected $folder;
    
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
     * Set name
     *
     * @param string $name
     * @return Document
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set filename
     *
     * @param string $filename
     * @return Document
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    
        return $this;
    }

    /**
     * Get filename
     *
     * @return string 
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set rev
     *
     * @param string $rev
     * @return Document
     */
    public function setRev($rev)
    {
        $this->rev = $rev;
    
        return $this;
    }

    /**
     * Get rev
     *
     * @return string 
     */
    public function getRev()
    {
        return $this->rev;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Document
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Document
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set editedAt
     *
     * @param \DateTime $editedAt
     * @return Document
     */
    public function setEditedAt($editedAt)
    {
        $this->editedAt = $editedAt;
    
        return $this;
    }

    /**
     * Get editedAt
     *
     * @return \DateTime 
     */
    public function getEditedAt()
    {
        return $this->editedAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Document
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set processNumber
     *
     * @param string $processNumber
     * @return Document
     */
    public function setProcessNumber($processNumber)
    {
        $this->processNumber = $processNumber;
    
        return $this;
    }

    /**
     * Get processNumber
     *
     * @return string 
     */
    public function getProcessNumber()
    {
        return $this->processNumber;
    }

    /**
     * Set editionNumber
     *
     * @param integer $editionNumber
     * @return Document
     */
    public function setEditionNumber($editionNumber)
    {
        $this->editionNumber = $editionNumber;
    
        return $this;
    }

    /**
     * Get editionNumber
     *
     * @return integer 
     */
    public function getEditionNumber()
    {
        return $this->editionNumber;
    }
    
    public function getContent() {
        
    }
    
    public function setContent() {
        
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preSaveGit() {
        //        $git->add();
//        $git->commit("");
        $this->rev;
    }
    
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function saveExistDb() {
        //$existDb->save($content);                
    }
    
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function saveGit() {

//        $git->push();
//
    }
    
    /**
     * @ORM\PostRemove()
     */
    public function removeExistDb() {
        
    }
    
    /**
     * @ORM\PostRemove()
     */
    public function removeGit() {
        
    }
}
