<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\OAuthServerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Bundle-Klasse für die Anpassung der 
 * 
 * @see http://tools.ietf.org/html/rfc6749
 * @see https://github.com/FriendsOfSymfony/FOSOAuthServerBundle/blob/master/Resources/doc/index.md
 * @see http://blog.logicexception.com/2012/04/securing-syfmony2-rest-service-wiith.html
 * 
 * http://blog.vjeux.com/2012/javascript/github-oauth-login-browser-side.html
 */
class DigitalwertMonodiOAuthServerBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent()  
    {  
        return 'FOSOAuthServerBundle';  
    }
}
