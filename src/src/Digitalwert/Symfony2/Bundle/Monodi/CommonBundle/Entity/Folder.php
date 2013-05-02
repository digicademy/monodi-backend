<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Folder
 *
 * @ORM\Table(name="monodi_folder")
 * @ORM\Entity(
 *   repositoryClass="Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\FolderRepository"
 * )
 * @Gedmo\Tree(type="nested")
 */
class Folder implements \Gedmo\Tree\Node
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
     */
    private $id;

    /**
     * @var string
     * 
     * @ORM\Column(name="title", type="string", length=255)
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
     * @ORM\Column(length=255, unique=true)
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
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Folder", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Folder", mappedBy="parent")
     */
    private $children;
    
    
    /**
     *
     * @ORM\OneToMany(targetEntity="Document", mappedBy="folder_id")
     */
    protected $documents;
    
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
    
    public function getSlug()
    {
        return $this->slug;
    }

    public function setParent(Category $parent)
    {
        $this->parent = $parent;    
    }

    public function getParent()
    {
        return $this->parent;   
    }
}
