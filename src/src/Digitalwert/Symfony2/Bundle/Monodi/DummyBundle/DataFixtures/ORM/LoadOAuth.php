<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Digitalwert\Symfony2\Bundle\Monodi\DummyBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OAuth2\OAuth2;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Description of LoadOAuth
 *
 * @author digitalwert
 */
class LoadOAuth extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        
        $this->clientManager = $this->container
          ->get('fos_oauth_server.client_manager.default')
        ;
        
        $redirectUris = array(
          'https://monodi.corpus-monodicum.de/',
          'https://adwserv9.adwmainz.net/',
          'http://notengrafik.dw-dev.de/',
          'http://monodi.symfony2.dev/',
        );
        
        $allowedGrantTypes = array(
            OAuth2::GRANT_TYPE_AUTH_CODE,
            OAuth2::GRANT_TYPE_IMPLICIT,
            OAuth2::GRANT_TYPE_REFRESH_TOKEN,
        );
        
        /** @var \Digitalwert\Symfony2\Bundle\Monodi\OAuthServerBundle\Client  */
        $client = $this->clientManager->createClient();
        
        $client->setName('MonodiClient');
        $client->setRedirectUris($redirectUris);
        $client->setAllowedGrantTypes($allowedGrantTypes);
        
        //$this->clientManager->updateClient($client);
        
        $manager->persist($client);
        $manager->flush();
        
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder() {
        return 6; // the order in which fixtures will be loaded
    }
}