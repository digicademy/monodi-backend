<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Folder
 *
 * @ORM\Table(name="monodi_folder")
 * @ORM\Entity(
 *   repositoryClass="Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\FolderRepository"
 * )
 * @Gedmo\Tree(type="nested")
 * 
 * @UniqueEntity({"title","parent"})
 * 
 * @Serializer\ExclusionPolicy("ALL")
 * @Serializer\XmlRoot(name="folder")
 */
class Folder 
{
    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;
    
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
    private $id;

    /**
     * @var string
     * 
     * @ORM\Column(name="title", type="string", length=255)
     * 
     * @Assert\NotBlank()
     * 
     * @Serializer\Expose
     * @Serializer\Groups({"list","detail"})
     */
    private $title;    
    
    /**
     * Slug des Titles
     * 
     * @var sting
     * 
     * @Gedmo\Slug(fields={"title"}, handlers={
     *   @Gedmo\SlugHandler(class="Gedmo\Sluggable\Handler\TreeSlugHandler", options={
     *     @Gedmo\SlugHandlerOption(name="parentRelationField", value="parent"),
     *     @Gedmo\SlugHandlerOption(name="separator", value="/")
     *   })
     * }, separator="-", updatable=true)
     * @ORM\Column(length=255, unique=true, nullable=true)
     * 
     * @Serializer\Expose
     * @Serializer\Groups({"list","detail"})
     * @Serializer\XmlAttribute
     * @Serializer\SerializedName(value="path")
     */
    private $slug;
    
    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     */
    private $lft;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     */
    private $rgt;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     */
    private $lvl;
    
    /**
     * @Gedmo\TreeRoot
     * @ORM\Column(name="root", type="integer", nullable=true)
     * 
     * @Serializer\Expose
     * @Serializer\Groups({"list","detail"})
     * @Serializer\XmlAttribute
     */
    private $root;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Folder", inversedBy="children", cascade={"persist"})
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Folder", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     * 
     * @Serializer\Expose
     * @Serializer\Groups({"list","detail"})
     * @Serializer\XmlList(entry="folder")
     * @Serializer\SerializedName(value="folders")
     */
    private $children;
    
    
    /**
     *
     * @ORM\OneToMany(targetEntity="Document", mappedBy="folder")
     * @ORM\OrderBy({"metadataSorting" = "ASC"})
     * 
     * @Serializer\Expose
     * @Serializer\Groups({"list","detail"})
     * @Serializer\XmlList(entry="document")
     */
    protected $documents;
    
    /**
     * String Cast
     * @return string
     */
    public function __toString() {
        return (string)$this->getSlug();
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
     * Set title
     *
     * @param string $title
     * @return Folder
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
    
    public function getSlug() {
        return $this->slug;
    }
    
    /**
     * 
     * @param \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Folder $parent
     */
    public function setParent(Folder $parent) {
        $this->parent = $parent;    
    }

    public function getParent() {
        return $this->parent;   
    }
    
    public function getChildren() {
        return $this->children;
    }
    
    /**
     * Gibt die Anzahl der Unterverzeichnisse zurück
     * 
     * @Serializer\Groups({"list","detail"})
     * @Serializer\VirtualProperty
     * @Serializer\XmlAttribute
     * 
     * @return integer
     */
    public function getChildrenCount() {
        return (integer)count($this->children);
    }
    
    /**
     * Gibt die Anzahl der im Verzeichnis enthalten Dokumente zurück
     * 
     * @Serializer\Groups({"list","detail"})
     * @Serializer\VirtualProperty
     * @Serializer\XmlAttribute
     * 
     * @return integer
     */
    public function getDocumentCount() {
        return (integer)count($this->documents);
    }
    
    /**
     * Gibt an ob Verzeichnis Dokumente und/oder Verzeichnisse enthält
     * 
     * @return boolean
     */
    public function isEmpty() {
        if(($this->getChildrenCount() == 0)
          && ($this->getDocumentCount() == 0)
        ) {
            return true;
        }
        return false;
    }
}
