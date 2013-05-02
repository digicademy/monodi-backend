<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * @Route("/profile")
 */
class ProfileController extends Controller
{
    /**
     * Gibt die Liste der Profile zurück
     * 
     * @ApiDoc(
     * )
     * 
     * @Route("/")
     * @Method({"GET"})
     * @Template()
     */
    public function getProfilesAction()
    {
        //$userManager = $container->get('fos_user.user_manager');
    }

    /**
     * Gibt ein einzelnes Profile zurück
     * 
     * @ApiDoc(
     *   statusCodes={
     *     200="Returned when successful",
     *     403="Returned when the user is not authorized to access the profile",
     *     404="Returned when the given profile was not found"     
     *   }
     * )
     * 
     * @Route("/{slug}")
     * @Method({"POST"})
     * @Template()
     */
    public function getProfileAction($slug)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        //$user->getUsername();
        
        $userManager = $this->getUserManager();
        $profile = $userManager->findUserBy(array('slug' => $slug));
        
    }

    /**
     * @Route("/{slug}")
     * @Method({"POST"})
     */
    public function postProfileAction($slug)
    {
    }

    /**
     * 
     * @ApiDoc(
     * )
     * 
     * @Route("/profile")
     * @Method({"PUT"})
     */
    public function putProfileAction()
    {
    }

    /**
     * 
     * @ApiDoc(
     * )
     * 
     * @Route("/profile/{slug}")
     * @Method({"PATCH"})
     */
    public function patchProfileAction($slug)
    {
    }
    
    /**
     * 
     * @return \FOS\UserBundle\Doctrine\UserManager
     */
    protected function getUserManager() {
        return $this->container->get('fos_user.user_manager');
    }

}
