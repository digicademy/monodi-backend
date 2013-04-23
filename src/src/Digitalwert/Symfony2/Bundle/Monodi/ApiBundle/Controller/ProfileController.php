<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class ProfileController extends Controller
{
    /**
     * Gibt die Liste der Profile zurück
     * 
     * @ApiDoc(
     * )
     * 
     * @Route("/profile")
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
     * )
     * 
     * @Route("/profile/{slug}")
     * @Method({"POST"})
     * @Template()
     */
    public function getProfileAction($slug)
    {
    }

    /**
     * @Route("/profile/{slug}")
     * @Method({"POST"})
     * @Template()
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
     * @Template()
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
     * @Template()
     */
    public function patchProfileAction($slug)
    {
    }

}
