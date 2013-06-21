<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\DiExtraBundle\Annotation as DI;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;

use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Document;
use Digitalwert\Symfony2\Bundle\Monodi\ApiBundle\Form\Type\DocumentFormType;

/**
 * 
 * http://williamdurand.fr/2012/08/02/rest-apis-with-symfony2-the-right-way/
 * https://github.com/FriendsOfSymfony/FOSRestBundle/blob/master/Resources/doc/index.md
 * 
 * @Route("/documents")
 */
class DocumentController extends FOSRestController
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
     * @ApiDoc(
     *   ressource=true,   
     *   output="Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Document"
     * )
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
     * @ApiDoc(
     *   input="Digitalwert\Symfony2\Bundle\Monodi\ApiBundle\Form\Type\DocumentFormType",
     *   statusCodes={
     *     204="Returned when successful",
     *     400="Returned when validation faild",
     *     403="Returned when the user is not authorized to access the document",  
     *     404="Returned when the document was not found"
     *   }
     * ) 
     * 
     * @Route("/")
     * @Method({"POST"})
     */
    public function postDocumentsAction(Request $request) {
        
        $user = $this->securityContext->getToken()->getUser();
        
        $document = new Document();
        
        $document->setOwner($user);
        $document->setEditor($user);
        //$document->setGroup($user->getGroups()->first());
        
        return $this->processForm($document, $request,  201);
    }
    
    /**
     * Aktuallisiert eine Liste von Dokumenten (diff)
     * 
     * ApiDoc()
     * 
     * @Route("/")
     * @Method({"PATCH"})
     */
    public function patchDocumentsAction(Request $request)
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
        $document = $this->findDocumentById($id);      
           
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
     *   name = "monodi_api_document_get",
     *   requirements={
     *     "_format" = "(xml|json)"}, 
     *   defaults={
     *     "_format" = "xml"
     *   }
     * )
     * @Method({"PUT"})
     */
    public function putDocumentAction(Request $request, $id) {
        
        $document = $this->findDocumentById($id);
        
        return $this->processForm($document, $request,  204);
    }

    /**
     * Aktualisiert ein Dokument
     * 
     * ApiDoc()
     * 
     * @Route("/{id}.{_format}", 
     *   name = "monodi_api_document_patch",
     *   requirements={
     *     "_format" = "(xml|json)"}, 
     *   defaults={
     *     "_format" = "xml"
     *   }
     * )
     * @Method({"PATCH"})
     */
    public function patchDocumentAction($id)
    {
        $document = $this->findDocumentById($id);
    }

    /**
     * Löscht das angegeben Dokument
     * 
     * @ApiDoc(
     *   statusCodes={
     *     204="Returned when successful",
     *     403="Returned when the user is not authorized to delete the document",  
     *     404="Returned when the document was not found"
     *   }
     * )
     * 
     * @Route("/{id}.{_format}", 
     *   name = "monodi_api_document_delete",
     *   requirements={
     *     "_format" = "(xml|json)"}, 
     *   defaults={
     *     "_format" = "xml"
     *   }
     * )
     * 
     * @Method({"DELETE"})
     * 
     * @Rest\View(statusCode=204)
     */
    public function deleteDocumentAction(Request $request, $id)
    {
        /** @var \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\User */
        $user = $this->securityContext->getToken()->getUser();
        $document = $this->findDocumentById($id);
        $owner = $document->getOwner();

        /**
         * @todo mit hilfe von security-annotation abfangen
         */
        if(!$user->isUser($owner)) {
           if(!$user->isSuperAdmin()) {
                throw new AccessDeniedHttpException('User not allowd to delete the document');
           }
        }
        
        try {
            $logger = $this->get('logger');
            
            $this->em->remove($document);
            $this->em->flush();
                
            $this->em->getConnection()->commit();
                
        } catch (Exception $e) {
            $this->em->getConnection()->rollback();
            $this->em->close();
            throw $e;
        }
        
    }
    
    /**
     * Sucht ein Dokument anhand der
     * 
     * @param type $id
     * @return type
     * 
     * @throws NotFoundHttpException
     */
    protected function findDocumentById($id) {
        $document = $this
          ->em
          ->getRepository('Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Document')
          ->find($id)
        ;
        
        if(!$document) {
            throw new NotFoundHttpException('Document not found');
        }
        
        //$user = $securityContext->getToken()->getUser();
        //$user = $securityContext->getToken()->getUser();
        //var_dump(get_class($this->securityContext->getToken()->getUser()));
        //$user = $this->securityContext->getUser();
        //$this->em->getRepository('')->findOneByIdForUser($id, $user);
        
        return $document;
    }
    
    
    /**
     * Validiert das gesendete Formular gibt entsprchent dem Ergebnis 
     * den Response zurück
     * 
     * @param \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Document $document
     * @param integer $statusCode
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function processForm(Document $document, Request $request, $statusCode = 204) {

        $form = $this->createForm(new DocumentFormType(), $document);

        $form->bind($request);
        
        if ($form->isValid()) {
            
            $this->em->getConnection()->beginTransaction(); // suspend auto-commit
            try {
                $logger = $this->get('logger');
                $logger->debug(__METHOD__);
                $logger->debug($request->getContent());

                $this->em->persist($document);
                $this->em->flush();
                
                $this->em->getConnection()->commit();
                
            } catch (Exception $e) {
                
                $this->em->getConnection()->rollback();
                $this->em->close();
                throw $e;
            }          
            
            $logger->debug('AFTER-FLUSH');
            $logger->debug($document->getContent());
            
            $response = new Response();
            $response->setStatusCode($statusCode);
            $response->headers->set('X-RessourceIdent', $document->getId());

            // set the `Location` header only when creating new resources
            if (201 === $statusCode) {
                $response->headers->set('Location',
                    $this->generateUrl(
                        'monodi_api_document_get', array('id' => $document->getId()),
                        true // absolute
                    )
                );
            }

            return $response;
        }

        return View::create($form, 400);
    }
}
