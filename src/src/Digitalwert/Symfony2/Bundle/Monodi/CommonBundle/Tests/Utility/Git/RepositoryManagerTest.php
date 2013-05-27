<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Tests\Utility\Git;

use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\VersionControlSystemRepos;
use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\User;
use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\Git\RepositoryManager;
use Monolog\Logger;

/**
 * Description of RepositoryManagerTest
 * 
 * http://blog.sznapka.pl/fully-isolated-tests-in-symfony2/
 *
 * @author digitalwert
 */
class RepositoryManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * 
     * @test
     */
    public function testInitRepos() {
        
        $container = new User();
        $container->setEmail('test@test.digitalwert.net');
        $container->setLastname('Tester');
        $container->setFirstname('Test');
        
        $repo = new VersionControlSystemRepos();  
        
        $container->setVersionControlSystemRepos($repo);
        
        $remote = 'git@github.com:mischka/monodi-test.git';
        $logger = new Logger();
                
        $manager = new RepositoryManager($remote, $logger);
        $manager->createRepo($container);
        
//        $manager->addDocument();
//        $manager->findDocument();
        
    }
}
