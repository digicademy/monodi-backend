<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * @Route("/documents")
 */
class DocumentController 
  extends Controller
{   
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
     * @ApiDoc()
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
     *   ressource=true
     * )
     * 
     * @Route("/{id}")
     * ParamConverter("post", class="DigitalwertMonodiCommonBundle:Document", options={}
     * @Method({"GET"})
     */
    public function getDocumentAction($id)
    {
    }
    /**
     * Aktualisiert ein Dokument
     * 
     * @ApiDoc()
     * 
     * @Route("/{id}")
     * @Method({"PUT"})
     */
    public function putDocumentAction($id)
    {
    }

    /**
     * Aktualisiert ein Dokument
     * 
     * @ApiDoc()
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
     *     201="Returned when successful",
     *     403="Returned when the user is not authorized to access the document",  
     *     404="Returned when the document was not found"
     *   }
     * )
     * 
     * @Route("/{id}")
     * @Method({"DELETE"})
     */
    public function deleteDocumentAction($id)
    {
    }

}