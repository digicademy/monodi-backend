<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\User;
use Digitalwert\Symfony2\Bundle\Monodi\ApiBundle\Form\Type\ProfileFormType;

use JMS\DiExtraBundle\Annotation as DI;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * @Route("/profile")
 */
class ProfileController 
//  extends Controller
  extends FOSRestController
{ 
    /** @DI\Inject("doctrine.orm.entity_manager") */
    private $em;
    
    /** @DI\Inject("fos_user.user_manager") */
    private $userManager;
    
    /** @DI\Inject("security.context") */
    private $securityContext;
    
    /**
     * Gibt die Liste der Profile zurück
     * 
     * ApiDoc(
     * )
     * 
     * @Route("/")
     * @Method({"GET"})
     */
    public function getProfilesAction()
    {
        //$userManager = $container->get('fos_user.user_manager');
    }

    /**
     * Gibt ein einzelnes Profile zurück 
     * 
     * @ApiDoc(   
     *   ressource=true,
     *   output="Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\User",
     *   statusCodes={
     *     200="Returned when successful",
     *     403="Returned when the user is not authorized to access the profile",
     *     404="Returned when the given profile was not found"     
     *   }
     * )
     * 
     * @Route("/{slug}.{_format}",
     *   name="monodi_api_profile_get",
     *   requirements={
     *     "_format" = "(xml|json)",
     *     "slug" = "[a-z_-\d]+"
     *   }, 
     *   defaults={"_format" = "xml"}
     * )
     * @Method({"GET"})
     * 
     * @Rest\View(
     *   serializerGroups={"profile"},
     *   templateVar="profile"
     * )
     */
    public function getProfileAction($slug) {        
        $profile = $this->findUserBySlug($slug);
        return $profile;        
    }

    /**
     * Legt ein neues Profil an
     * 
     * @Route("/")
     * @Method({"POST"})
     */
    public function postProfileAction() {
        //$profile = new User();
        throw AccessDeniedHttpException('Profile can only be updated');
    }

    /**
     * Aktualisiert ein Profil
     * 
     * @var Request $request
     * @var string $slug 
     * 
     * @ApiDoc(
     *   input="Digitalwert\Symfony2\Bundle\Monodi\ApiBundle\Form\Type\ProfileFormType"
     * )
     * 
     * @Route("/{slug}.{_format}",
     *   name="monodi_api_profile_put",
     *   requirements={
     *     "_format" = "(xml|json)",
     *     "slug" = "[a-z_-\d]+"
     *   }, 
     *   defaults={"_format" = "xml"}
     * )
     * @Method({"PUT"})
     * @Rest\View(
     *   serializerGroups={"profile"},
     *   templateVar="profile"
     * )
     */
    public function putProfileAction(Request $request, $slug) {
        
        //var_dump($request->getContent(), $request->request, $slug);
        
        $profile = $this->findUserBySlug($slug);
        
        return $this->processForm($profile, $request,  204);
    }

    /**
     * 
     * ApiDoc(
     * )
     * 
     * @Route("/profile/{slug}")
     * @Method({"PATCH"})
     */
    public function patchProfileAction($slug) {
        
    }
    
    /**
     * 
     * @return \FOS\UserBundle\Doctrine\UserManager
     */
    protected function getUserManager() {
        return $this->userManager;
        //return $this->container->get('fos_user.user_manager');
    }
    
    /**
     * Sucht einen Nutzer hand dessen Nutzernames
     * 
     * @param string $slug
     * 
     * @throws NotFoundHttpException
     * @throws AccessDeniedHttpException
     * 
     * @return \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\User
     */
    protected function findUserBySlug($slug) {
        
        //$user = $this->get('security.context')->getToken()->getUser();
        $user = $this->securityContext->getToken()->getUser();
        
        $userManager = $this->getUserManager();
        $profile = $userManager->findUserBy(array('username' => $slug));
        
        if(!$profile) {
            throw new NotFoundHttpException('Profile not found');
        }
        
        if(!$profile->isEnabled() || $profile->isExpired()) {
            throw new NotFoundHttpException('Profile not found');
        }
     
//        if(!$user->isUser($profile)) {
//           if(!$user->isSuperAdmin()) {
//                throw new AccessDeniedHttpException('User not allowd to access profile');
//           }
//        }
        
        return $profile;
    }
    
    /**
     * Validiert das gesendete Formular gibt entsprchent dem Ergebnis 
     * den Response zurück
     * 
     * @param \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\User $profile
     * @param integer $statusCode
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function processForm(User $profile, Request $request, $statusCode = 204) {

        $form = $this->createForm(new ProfileFormType(), $profile);
        
        //var_dump($this->getRequest()->);
        
        //$form->bind($this->getRequest());
        $form->bind($request);
        
        if ($form->isValid()) {
            
            $this->em->persist($profile);
            $this->em->flush();

            $response = new Response();
            $response->setStatusCode($statusCode);

            // set the `Location` header only when creating new resources
            if (201 === $statusCode) {
                $response->headers->set('Location',
                    $this->generateUrl(
                        'monodi_api_profile_get', array('slug' => $profile->getUsername()),
                        true // absolute
                    )
                );
            }

            return $response;
        }

        return View::create($form, 400);
    }

}
