<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\DummyBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\VersionControlSystemRepos;


/**
 * Description of LoadVersionControlSystemReposData
 *
 * @author digitalwert
 */
class LoadVersionControlSystemReposData  
  extends AbstractFixture 
  implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager) {
        // Admin Git-Repos
        
        // Test 1 Git-Repos
        
        // Test 2 Git-Repos
        
        // FooBar Git-Repos
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder() {
        return 2; // the order in which fixtures will be loaded
    }
}
