<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\DiExtraBundle\Annotation as DI;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;

use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Document;

/**
 * 
 * http://williamdurand.fr/2012/08/02/rest-apis-with-symfony2-the-right-way/
 * https://github.com/FriendsOfSymfony/FOSRestBundle/blob/master/Resources/doc/index.md
 * 
 * @Route("/documents")
 */
class DocumentController 
//  extends 
  extends FOSRestController
{   
    
    /** @DI\Inject("doctrine.orm.entity_manager") */
    private $em;

    /** @DI\Inject("session") */
    private $session;
    
    /**
     * @var \Symfony\Component\Security\Core\SecurityContextInterface
     * @DI\Inject("security.context", required = false)
     */
    private $securityContext;

    
    /**
     * 
     * @ApiDoc()
     * 
     * @Route("/")
     * @Method({"OPTIONS"})
     */
    public function optionsDocumentsAction()
    {
    }
    
    
    /**
     * Legt ein neues Dokument an
     * 
     * @ApiDoc() 
     * 
     * @Route("/")
     * @Method({"POST"})
     */
    public function postDocumentsAction()
    {
    }
    
    /**
     * Aktuallisiert eine Liste von Dokumenten (diff)
     * 
     * ApiDoc()
     * 
     * @Route("/")
     * @Method({"PATCH"})
     */
    public function patchDocumentsAction()
    {
    }
    
    /**
     * Gibt ein Dokument zurück
     * 
     * @ApiDoc(
     *   ressource=true,   
     *   output="Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Document"
     * )
     * 
     * @Route("/{id}.{_format}", 
     *   requirements={
     *     "_format" = "(xml|json)"}, 
     *   defaults={
     *     "_format" = "xml"
     *   }
     * )
     * ParamConverter("id", class="DigitalwertMonodiCommonBundle:Document", options={}
     * @Method({"GET"})
     * 
     * @Rest\View(
     *   serializerGroups={"detail"}
     * )
     */
    public function getDocumentAction($id)
    {
        $document = $this
          ->em
          ->getRepository('Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Document')
          ->find($id)
        ;
        
        if(!$document) {
            throw new NotFoundHttpException('Document not found');
        }
        
        //$user = $securityContext->getToken()->getUser();
        //var_dump(get_class($this->securityContext->getToken()->getUser()));
        //$user = $this->securityContext->getUser();
        //$this->em->getRepository('')->findOneByIdForUser($id, $user);
        
//        $document = new Document();
//        $document->setRev('cfeacede1212');
//        $document->setTitle('Test des Titles');
//        $document->setFilename('fobar.buz.mei');
//        $document->setProcessNumber(123434);
//        $document->setCreatedAt(new \DateTime('yesterday'));
//        $document->setEditedAt(new \DateTime('now'));
//        $document->setEditionNumber(123456700);
        
        return $document;
    }
    /**
     * Aktualisiert ein Dokument
     * 
     * @ApiDoc(
     *   input="Digitalwert\Symfony2\Bundle\Monodi\ApiBundle\Form\Type\DocumentFormType"
     * )
     * 
     * @Route("/{id}.{_format}", 
     *   requirements={
     *     "_format" = "(xml|json)"}, 
     *   defaults={
     *     "_format" = "xml"
     *   }
     * )
     * @Method({"PUT"})
     */
    public function putDocumentAction($id) {
        $document = $this
          ->em
          ->getRepository('Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Document')
          ->find($id)
        ;
        
        if(!$document) {
            throw new NotFoundHttpException('Document not found');
        }
    }

    /**
     * Aktualisiert ein Dokument
     * 
     * ApiDoc()
     * 
     * @Route("/{id}")
     * @Method({"PATCH"})
     */
    public function patchDocumentAction($id)
    {
        
    }

    /**
     * Löscht das angegeben Dokument
     * 
     * @ApiDoc(
     *   statusCodes={
     *     204="Returned when successful",
     *     403="Returned when the user is not authorized to access the document",  
     *     404="Returned when the document was not found"
     *   }
     * )
     * 
     * @Route("/{id}")
     * @Method({"DELETE"})
     * 
     * @Rest\View(statusCode=204)
     */
    public function deleteDocumentAction($id)
    {
    }

}
