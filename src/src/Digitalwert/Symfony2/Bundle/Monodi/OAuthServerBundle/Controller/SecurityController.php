<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\OAuthServerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;  
use Symfony\Component\HttpFoundation\Request;  
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
  
class SecurityController extends Controller  
{  
    /**
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return Response
     * 
     * @Template()
     */
    public function loginAction(Request $request)  
    {  
        $session = $request->getSession();  
          
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {  
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);  
        } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {  
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);  
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);  
        } else {  
            $error = '';  
        }  
  
        if ($error) {  
            $error = $error->getMessage(); // WARNING! Symfony source code identifies this line as a potential security threat.  
        }  
          
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);  
  
//        return $this->render('DigitalwertMonodiOAuthServerBundle:Security:login.html.php', array(  
//            'last_username' => $lastUsername,  
//            'error'         => $error,  
//        ));  
        return array(  
           'last_username' => $lastUsername,  
           'error'         => $error,  
        );
    }  
      
    public function loginCheckAction(Request $request)  
    {  
          
    }  
} 
