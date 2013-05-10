<?php
/*
 * 
 */
namespace Digitalwert\Symfony2\Bundle\Monodi\OAuthServerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;  
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;  

use FOS\OAuthServerBundle\Controller\AuthorizeController as BaseAuthorizeController;  
use JMS\DiExtraBundle\Annotation as DI;
use Digitalwert\Symfony2\Bundle\Monodi\OAuthServerBundle\Form\Model\Authorize;  
use Digitalwert\Symfony2\Bundle\Monodi\OAuthServerBundle\Entity\Client;  

/**
 * 
 * 
 */
class AuthorizeController extends BaseAuthorizeController  
{  
    /**
     * @DI\Inject("security.context")
     * @var \Symfony\Component\Security\Core\SecurityContext
     */
    private $securityContext;
    
    /**
     * @DI\Inject("digitalwert_monodi_oauth_server.authorize.form")
     * @var \Digitalwert\Symfony2\Bundle\Monodi\OAuthServerBundle\Form\Type\AuthorizeFormType
     */
    private $form;
    
    /**
     * @DI\Inject("digitalwert_monodi_oauth_server.authorize.form_handler")
     * @var \Digitalwert\Symfony2\Bundle\Monodi\OAuthServerBundle\Form\Handler\AuthorizeFormHandler
     */
    private $formHandler;
    
    /**
     * @DI\Inject("fos_oauth_server.client_manager.default")
     * @var \FOS\OAuthServerBundle\Model\ClientInterface
     */
    private $clientManager;
    
    /**
     * 
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return Response
     * @throws NotFoundHttpException
     * 
     * Route("/hello/{name}")
     * @Template()
     */
    public function authorizeAction(Request $request)  
    {  
        if (!$request->get('client_id')) {  
            throw new NotFoundHttpException("Client id parameter {$request->get('client_id')} is missing.");  
        }  
          
        //$clientManager = $this->container->get('fos_oauth_server.client_manager.default');  
        $clientManager = $this->clientManager;
        $client = $clientManager->findClientByPublicId($request->get('client_id'));  
          
        if (!($client instanceof Client)) {  
            throw new NotFoundHttpException("Client {$request->get('client_id')} is not found.");  
        }  
          
        //$user = $this->container->get('security.context')->getToken()->getUser();  
        $user = $this->securityContext->getToken()->getUser();
          
        //$form = $this->container->get('acme_oauth_server.authorize.form');
        $form = $this->form;
        
        //$formHandler = $this->container->get('acme_oauth_server.authorize.form_handler');
        $formHandler = $this->formHandler;
          
        $authorize = new Authorize();  
          
        if (($response = $formHandler->process($authorize)) !== false) {  
            return $response;  
        }  
                  
//        return $this->container->get('templating')->renderResponse('DigitalwertMonodiOAuthServerBundle:Authorize:authorize.html.twig', array(  
//            'form' => $form->createView(),  
//            'client' => $client,  
//        ));  
        return array(
          'form' => $form->createView(),  
          'client' => $client, 
        );
    }  
 
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name)
    {
        return array('name' => $name);
    }
}
