<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * @Route("/metadata")
 */
class MetadataController extends Controller
{
    /**
     * Gibt Metainforamtion zu Verzeichnien oder Dateien zurück
     * 
     * @ApiDoc( 
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
     * @Route("/{path}")
     * @Method({"GET"})
     * @Template()
     */
    public function getAction($path)
    {
        //https://github.com/l3pp4rd/DoctrineExtensions/blob/master/doc/tree.md
        return new \Symfony\Component\HttpFoundation\Response("", 200);
    }

}
