<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Tests\Utility\Git;

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
     */
    public function testInitRepos() {
        
        $logger = new Logger();
                
        $manager = new RepositoryManager($logger);
        $manager->initRepos();
    }
}
