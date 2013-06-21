<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use JMS\DiExtraBundle\Annotation as DI;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

//use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Document;
use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Folder;
//use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\FolderRepository;
use Digitalwert\Symfony2\Bundle\Monodi\ApiBundle\Form\Type\FolderFormType;


/**
 * Klasse 
 * 
 * @see https://www.dropbox.com/developers/core/docs#metadata
 * 
 * Route("/metadata")
 */
class MetadataController extends Controller
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
     *   name = "monodi_api_metadata_get",
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
     *   name = "monodi_api_metadata_get_root",
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
     * Anlegen eines neune Folders
     * 
     * @ApiDoc(
     *   input="Digitalwert\Symfony2\Bundle\Monodi\ApiBundle\Form\Type\FolderFormType",
     *   statusCodes={
     *     204="Returned when successful",
     *     400="Returned when the requests was missmatched",
     *     403="Returned when the user is not authorized to access the folder",  
     *     404="Returned when the folder was not found"
     *   }
     * )
     * 
     * @Route("/metadata/{path}.{_format}", 
     *   name = "monodi_api_metadata_post",
     *   requirements={
     *     "_format" = "(xml|json)",
     *     "path" = "[a-z_-\d\/]+"
     *   }, 
     *   defaults={"_format" = "xml"}
     * )   
     * @Method({"POST"})
     */
    public function postFolderAction(Request $request, $path) {
        
        $parent = $this->findFolderByPath($path);
        
        // New Folder
        $folder = new Folder();
        $folder->setParent($parent);
        
        return $this->processForm($folder, $request,  201);
    }
    
    
    /**
     * Löscht ein Verzeichnis
     * 
     * @ApiDoc(
     *   statusCodes={
     *     204="Returned when successful",
     *     403="Returned when the user is not authorized to access the folder or folder not empty",
     *     404="Returned when the folder was not found"
     *   }
     * )
     * 
     * @Route("/metadata/{path}.{_format}", 
     *   name = "monodi_api_metadata_delete",
     *   requirements={
     *     "_format" = "(xml|json)",
     *     "path" = "[a-z_-\d\/]+"
     *   }, 
     *   defaults={"_format" = "xml"}
     * )   
     * @Method({"DELETE"})
     * Rest\View(statusCode=204)
     */
    public function deleteFolderAction(Request $request, $path) {
        $folder = $this->findFolderByPath($path);
        if(!$folder->isEmpty()) {
            throw new AccessDeniedHttpException('folder is not empty');
        }
        try {
            $logger = $this->get('logger');

            $this->em->remove($folder);
            $this->em->flush();

            $this->em->getConnection()->commit();

        } catch (Exception $e) {

            $this->em->getConnection()->rollback();
            $this->em->close();
            throw $e;
        }

        $response = new Response();
        $response->setStatusCode(204);
        return $response;
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
            $folder = $this->findFolderByPath($path);
           
            //$folderRepository->getChildren($folder);
        }
        
        return $folderRepository->getChildren($folder, true, null, 'asc', false);
    }
    
    /**
     * Sucht ein Verzeichnis anhand seines Slugs
     * 
     * @param string $path
     * @return \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Folder
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function findFolderByPath($path) {
        
        /** @var \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\FolderRepository */
        $folderRepository = $this->em
          ->getRepository('Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Folder');
        
        $folder = $folderRepository->findOneBy(array('slug' => $path));           
        if(!$folder) {
            throw $this->createNotFoundException('Unable to find folder entity.');
        }
        return $folder;
    }
    
    /**
     * Validiert das gesendete Formular gibt entsprchent dem Ergebnis 
     * den Response zurück
     * 
     * @param \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Folder $folder
     * @param integer $statusCode
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function processForm(Folder $folder, Request $request, $statusCode = 204) {

        $form = $this->createForm(new FolderFormType(), $folder);

        $form->bind($request);
        
        if ($form->isValid()) {
            
            $this->em->getConnection()->beginTransaction(); // suspend auto-commit
            try {
                $logger = $this->get('logger');

                $this->em->persist($folder);
                $this->em->flush();
                
                $this->em->getConnection()->commit();
                
            } catch (Exception $e) {
                
                $this->em->getConnection()->rollback();
                $this->em->close();
                throw $e;
            }
            
            $response = new Response();
            $response->setStatusCode($statusCode);

            // set the `Location` header only when creating new resources
            if (201 === $statusCode) {
                $response->headers->set('Location',
                    $this->generateUrl(
                        'monodi_api_metadata_get', array(
                            'path' => $folder->getSlug()
                        ),
                        true // absolute
                    )
                );
            }

            return $response;
        }

        return View::create($form, 400);
    }

}
