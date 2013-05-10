<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Bundle-Klasse um das FOSUserBundle anpassen
 * 
 * @see 
 */
class DigitalwertMonodiUserBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent()  
    {  
        return 'FOSUserBundle';  
    }
}
