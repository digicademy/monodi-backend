<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\DummyBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Group;


/**
 * Description of LoadGroupData
 *
 * @author digitalwert
 */
class LoadGroupData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager) {
        // Administrator
        $groupAdmin = new Group('Administrator');
        $groupAdmin->addRole('ROLE_ADMIN');
        
        // Mitarbeiter
        $groupMember = new Group('Member');
        $groupMember->addRole('ROLE_USER');
            
        // Tester
        $groupTester = new Group('Tester');
        $groupTester->addRole('ROLE_USER');
        
        
        $manager->persist($groupAdmin);
        $manager->persist($groupMember);
        $manager->persist($groupTester);
        $manager->flush();

        $this->addReference('group-admin', $groupAdmin);
        $this->addReference('group-member', $groupMember);
        $this->addReference('group-tester', $groupTester);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder() {
        return 1; // the order in which fixtures will be loaded
    }
}

