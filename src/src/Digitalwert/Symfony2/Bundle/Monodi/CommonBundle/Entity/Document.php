<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

/**
 * Document
 *
 * @ORM\Table(name="monodi_document")
 * @ORM\Entity(repositoryClass="Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\DocumentRepository")
 * @ORM\HasLifecycleCallbacks
 * 
 * @Gedmo\Loggable
 * 
 * @Serializer\ExclusionPolicy("ALL")
 * @Serializer\XmlRoot(name="document")
 */
class Document
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     * @Serializer\Expose
     * @Serializer\Groups({"list","detail"})
     * @Serializer\XmlAttribute
     */
    protected $id;

    /**
     * Referenz zur GIT Datei (Pfad rlativ zum Nutzer-Reposetory)
     * 
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255)
     * 
     * @Serializer\Expose
     * @Serializer\Groups({"list","detail"})
     */
    protected $filename;

    /**
     * Reversion im GIT als MD5 Hash
     * 
     * @var string
     *
     * @ORM\Column(name="rev", type="string", length=64, nullable=true)
     * 
     * @Serializer\Expose
     * @Serializer\Groups({"list","detail"})
     * @Serializer\XmlAttribute
     */
    protected $rev;
        
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * 
     * @Serializer\Expose
     * @Serializer\Groups({"list", "detail"})
     */
    protected $title;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="createdAt", type="datetime")
     * 
     * @Serializer\Expose
     * @Serializer\Groups({"list", "detail"})
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * 
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="editedAt", type="datetime")
     * 
     * @Serializer\Expose
     * @Serializer\Groups({"list", "detail"})
     */
    protected $editedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime")
     *
     * @Serializer\Expose
     * @Serializer\Groups({"detail"})
     */
    protected $updatedAt;

    /**
     * Enthält die letzte Vorgangsnummer des Dokumentes 
     * 
     * @var string
     * 
     * @ORM\Column(name="processNumber", type="string", length=255, nullable=true)
     * 
     * @Serializer\Expose
     * @Serializer\Groups({"detail"})
     */
    protected $processNumber;

    /**
     * Nummer innerhalb einer Edition
     * 
     * @var integer
     *
     * @ORM\Column(name="editionNumber", type="integer", nullable=true)
     * 
     * @Serializer\Expose
     * @Serializer\Groups({"detail"})
     */
    protected $editionNumber;
    
    /**
     * Besitzer des Dokuments (Datenbank)
     * 
     * @var User
     * 
     * @ORM\ManyToOne(targetEntity="User", inversedBy="owner_id")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    protected $owner;    
    
    /**
     * Nutzergruppe des Dokuments
     * 
     * @var Group
     * 
     * @ORM\ManyToOne(targetEntity="Group", inversedBy="group_id")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     */
    protected $group;
    
    /**
     * letzter Bearbeiter des Dokuments (Datenbank)
     * 
     * @var User
     * 
     * @ORM\ManyToOne(targetEntity="User", inversedBy="editor_id")
     * @ORM\JoinColumn(name="editor_id", referencedColumnName="id")
     */
    protected $editor;
    
    /**
     * Gibt an in welchem Verzeichnis sich das Dokument befindet
     * 
     * @var Folder
     * 
     * @ORM\ManyToOne(targetEntity="Folder", inversedBy="folder_id")
     * @ORM\JoinColumn(name="folder_id", referencedColumnName="id")
     */
    protected $folder;
    
    
    /**
     * Hält den Body Temporär vor
     * 
     * @var string 
     */
    protected $content;
    
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
    
    /**
     * Setzt den Besitzer des Dokuments
     * 
     * @param \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\User $owner
     * 
     * @return Document
     */
    public function setOwner(User $owner) {
        $this->owner = $owner;
        return $this;
    }
    
    /**
     * Gibt den Besitzer des Dokuments zurück
     * 
     * @return \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\User
     */
    public function getOwner() {
        return $this->owner;
    }
    
    /**
     * Setzt die Nutzergruppe des Dukuments
     * 
     * @param \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Group $group
     * 
     * @return Document
     */
    public function setGroup(Group $group) {
        $this->group = $group;
        return $this;
    }
    
    /**
     * Gibt die Nutzergruppe das Dokuments zurück
     * 
     * @return \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Group
     */
    public function getGroup() {
        return $this->group;
    }
    
    /**
     * Setzt den Bearbeiter des Dukuments
     * 
     * @param \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\User $editor
     * 
     * @return \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Document
     */
    public function setEditor(User $editor) {
        $this->editor = $editor;
        return $this;
    }
    
    /**
     * Gibt den letzten Bearbeiter des Dokuments zurück 
     * 
     * @return User
     */
    public function getEditor() {
        return $this->editor;
    }
    
    /**
     * Setzt das Verzeichnis in welchem sich das Dukument befindet
     * 
     * @param \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Folder $folder
     * 
     * @return \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Document
     */
    public function setFolder(Folder $folder) {
        $this->folder = $folder;
        return $this;
    }
    
    /**
     * Gibt das Verzeichnis in welchem sich das Dokument befindet zurück
     * 
     * @return Folder
     */
    public function getFolder() {
      return $this->folder;  
    }
    
    /**
     * 
     * @Serializer\VirtualProperty
     * @Serializer\Groups({"detail"})
     */
    public function getContent() {
//        return $this->content;                
        return '<?xml version="1.0" encoding="UTF-8"?>
<mei xmlns="http://www.music-encoding.org/ns/mei">
  <meiHead>
    <fileDesc>
      <titleStmt>
        <title/>
      </titleStmt>
      <pubStmt/>
      <sourceDesc>
        <source/>
      </sourceDesc>
    </fileDesc>
  </meiHead>
  <music>
    <body>
      <mdiv>
        <score>
          <section>
            <staff>
              <layer>
                <sb label=""/>
                <syllable>
                  <syl></syl>
                </syllable>
              </layer>
            </staff>
          </section>
        </score>
      </mdiv>
    </body>
  </music>
</mei>';
    }
    
    /**
     * Set den Inhalt des Documents
     * 
     * @param string $content
     * 
     * @return Document
     */
    public function setContent($content) {
        $this->content = $content;
        return $this;
    }
    
    
/*
 * SECTION EventListeners
 */    
    
    /**
     * ORM\PrePersist()
     * ORM\PreUpdate()
     */
    public function preSaveGit() {
        //        $git->add();
//        $git->commit("");
        $this->rev;
    }
    
    /**
     * ORM\PostPersist()
     * ORM\PostUpdate()
     */
    public function saveExistDb() {
        //$existDb->save($content);                
    }
    
    /**
     * ORM\PostPersist()
     * ORM\PostUpdate()
     */
    public function saveGit() {

//        $git->push();
//
    }
    
    /**
     * ORM\PostRemove()
     */
    public function removeExistDb() {
        
    }
    
    /**
     * ORM\PostRemove()
     */
    public function removeGit() {
        
    }
    
    /**
     * ORM\PostLoad()
     */
    public function readExistDb() {
        $this->setContent(trim('
<mei></mei>
        '));
    }
}
