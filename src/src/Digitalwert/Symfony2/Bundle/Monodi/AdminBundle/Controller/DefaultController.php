<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Start-Controller des Adminbereiches
 * 
 * https://wrapbootstrap.com/theme/black-forest-admin-template-WB019KF70
 * 
 * @Route("/")
 */
class DefaultController extends Controller
{
    /**
     * Dashboard
     * 
     * @Route("/", name="admin_dashboard")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}
