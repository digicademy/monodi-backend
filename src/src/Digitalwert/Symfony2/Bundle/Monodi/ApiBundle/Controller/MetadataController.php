<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use JMS\DiExtraBundle\Annotation as DI;
use FOS\RestBundle\Controller\Annotations as Rest;
//use FOS\RestBundle\View\View;
//use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

//use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Document;
use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Folder;
//use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\FolderRepository;


/**
 * Klasse 
 * 
 * @see https://www.dropbox.com/developers/core/docs#metadata
 * 
 * Route("/metadata")
 */
class MetadataController 
  extends Controller
{
    /** 
     * @var \Doctrine\ORM\EntityManager
     * @DI\Inject("doctrine.orm.entity_manager") 
     */
    private $em;
    
    /**
     * @var \Symfony\Component\Security\Core\SecurityContextInterface
     * @DI\Inject("security.context", required = false)
     */
    private $securityContext;
    
    
    /**
     * Gibt Metainforamtion zu Verzeichnien oder Dateien zurück
     * 
     * @todo dokumente sollten als referenzlinks ausgegeben werden (relationen)
     * 
     * @ApiDoc( 
     *   output="Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Folder",
     *   statusCodes={
     *     200="Returned when successful",
     *     403="Returned when the user is not authorized to access the Ressource",
     *     404={
     *       "Returned when the given file or folder was not found"
     *     },
     *     406="Returned when there are too many file entries to return."
     *   }
     * )
     * 
     * @Route("/metadata/{path}.{_format}", 
     *   requirements={
     *     "_format" = "(xml|json)",
     *     "path" = "[a-z_-\d\/]+"
     *   }, 
     *   defaults={"_format" = "xml"}
     * )
     * @Method({"GET"})
     * 
     * @Rest\View(
     *   serializerGroups={"list"},
     *   templateVar="metadata"
     * )
     */
    public function getAction($path) {
        
        $folder = $this->findByPath($path);
        
        $metadata = array(
            'metadata' => array(
                'folders' => array(
                   $folder  
                ),
            ),
        );
//        \Doctrine\Common\Util\Debug::dump($folder);
        $data = $folder;
        
//        /** @var \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\FolderRepository */
//        $folderRepository = $this->em
//          ->getRepository('Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Folder');
//        
//        $arrayTree = $folderRepository->childrenHierarchy();
//        
//        $htmlTree = $folderRepository->childrenHierarchy(
//            null, /* starting from root nodes */
//            false, /* true: load all children, false: only direct */
//            array(
//                'decorate' => true,
//                'representationField' => 'slug',
//                'html' => true
//            )
//        );
//        //var_dump($arrayTree);
//        //var_dump($htmlTree);
//        
//        $data = $arrayTree;
        //https://github.com/l3pp4rd/DoctrineExtensions/blob/master/doc/tree.md
        //return new \Symfony\Component\HttpFoundation\Response("", 200);
        return $data;
    }
    
    /**
     * Gibt Metainforamtion zu Root zurück
     * 
     * @ApiDoc( )
     * 
     * @Route("/metadata.{_format}", 
     *
     *   requirements={
     *     "_format" = "(xml|json)"
     *   }, 
     *   defaults={"_format" = "xml"}
     * )
     * @Method({"GET"})     
     * 
     * @Rest\View(serializerGroups={"list"})
     */
    public function getRootAction() {
        
        return $this->getAction(null);
    }    
        
    
    /**
     * Sucht das übergeben Verzeichnis
     * 
     * @param string $path
     * 
     * @return Folder
     */
    protected function findByPath($path) {
        
        $folder = null;
        
        /** @var \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\FolderRepository */
        $folderRepository = $this->em
          ->getRepository('Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Folder');
        
        if(null !== $path) {
            $folder = $folderRepository->findOneBy(array('slug' => $path));           
            if(!$folder) {
               throw $this->createNotFoundException('Unable to find folder entity.');
            }
           
            //$folderRepository->getChildren($folder);
        }
        
        return $folderRepository->getChildren($folder, true, null, 'asc', false);
    }

}
