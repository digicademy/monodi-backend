<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\DummyBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\User;

/**
 * Description of LoadUserData
 * 
 * http://symfony.com/doc/current/bundles/DoctrineFixturesBundle/index.htmll
 *
 * @author digitalwert
 */
class LoadUserData 
  extends AbstractFixture 
  implements OrderedFixtureInterface,
    ContainerAwareInterface
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
        
        /** @var \FOS\UserBundle\Doctrine\UserManager */
        $userManager = $this->container->get('fos_user.user_manager');
        
        $userRoot = $userManager->createUser();
        $userRoot->setUsername('root');
        $userRoot->setPlainPassword('oopp');
        $userRoot->setEnabled(true);
        $userRoot->setEmail('kay.petzold@digitalwert.de');
        $userRoot->addRole('ROLE_SUPER_ADMIN');
        
        $userAdmin = $userManager->createUser();
        $userAdmin->setUsername('admin');
        $userAdmin->setEmail('admin.monodi@digitalwert.net');
        $userAdmin->setPlainPassword('test');
        $userAdmin->setEnabled(true);
        $userAdmin->addRole('ROLE_ADMIN');
        $userAdmin->addGroup($this->getReference('group-admin'));
        
        $userTest1 = $userManager->createUser();
        $userTest1->setUsername('tester1');
        $userTest1->setPlainPassword('test');
        $userTest1->setEnabled(true);
        $userTest1->setEmail('test1.monodi@digitalwert.net');
        $userTest1->addRole('ROLE_USER');
        $userTest1->addGroup($this->getReference('group-member'));
        
        $userManager->updateUser($userRoot, false);
        $userManager->updateUser($userAdmin, false);
        $userManager->updateUser($userTest1, false);
//        $manager->persist($userRoot);
//        $manager->persist($userAdmin);
//        $manager->persist($userTest1);
        
        $manager->flush();
        
        $this->addReference('user-root', $userRoot);
        $this->addReference('user-admin', $userAdmin);
        $this->addReference('user-test1', $userTest1);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder() {
        return 3; // the order in which fixtures will be loaded
    }
}

