<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\DummyBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\User;

/**
 * Legt die Testnutzer an
 * 
 * http://symfony.com/doc/current/bundles/DoctrineFixturesBundle/index.htmll
 *
 * @author digitalwert
 */
class LoadTestUserData 
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
        
        // Nutzer ngb
        
        // thomas.weber@notengrafik.com
        $user01 = $userManager->createUser();
        $user01->setUsername('thomas.weber');
        $user01->setSalutation('Herr');
        $user01->setFirstname('Thomas');
        $user01->setLastname('Weber');
        $user01->setPlainPassword('weber');
        $user01->setEnabled(true);
        $user01->setEmail('thomas.weber@notengrafik.com');
        $user01->addRole('ROLE_USER');
        $user01->addGroup($this->getReference('group-tester'));
        
        //assistenz@notengrafik.com
        $user02 = $userManager->createUser();
        $user02->setUsername('assistenz');
        $user02->setLastname('Assistenz');
        $user02->setPlainPassword('assistenz');
        $user02->setEnabled(true);
        $user02->setEmail('assistenz@notengrafik.com');
        $user02->addRole('ROLE_USER');
        $user02->addGroup($this->getReference('group-tester'));
        
        //wolff@notengrafik.com
        $user03 = $userManager->createUser();
        $user03->setUsername('werner.wolff');
        $user03->setSalutation('Herr');
        $user03->setFirstname('Werner J.');
        $user03->setLastname('Wolff');
        $user03->setPlainPassword('wolff');
        $user03->setEnabled(true);
        $user03->setEmail('wolff@notengrafik.com');
        $user03->addRole('ROLE_USER');
        $user03->addGroup($this->getReference('group-tester'));
        
        //hadas.peery@notengrafik.com
        $user04 = $userManager->createUser();
        $user04->setUsername('hadas.peery');
        $user04->setSalutation('Herr');
        $user04->setFirstname('Hadas');
        $user04->setLastname('Peery');
        $user04->setPlainPassword('peery');
        $user04->setEnabled(true);
        $user04->setEmail('hadas.peery@notengrafik.com');
        $user04->addRole('ROLE_USER');
        $user04->addGroup($this->getReference('group-tester'));
        
        //ngb@notengrafik.com
        $user05 = $userManager->createUser();
        $user05->setUsername('ngb');
        $user05->setLastname('ngb');
        $user05->setPlainPassword('ngb');
        $user05->setEnabled(true);
        $user05->setEmail('ngb@notengrafik.com');
        $user05->addRole('ROLE_USER');
        $user05->addGroup($this->getReference('group-tester'));
        
        //Würzburg:
        //andreas.haug@uni-wuerzburg.de
        $user06 = $userManager->createUser();
        $user06->setUsername('andreas.haug');
        $user06->setSalutation('Herr');
        $user06->setFirstname('Andreas');
        $user06->setLastname('Haug');
        $user06->setPlainPassword('peery');
        $user06->setEnabled(true);
        $user06->setEmail('andreas.haug@uni-wuerzburg.de');
        $user06->addRole('ROLE_USER');
        $user06->addGroup($this->getReference('group-tester'));
        
        //elaine.stratton_hild@uni-wuerzburg.de
        $user07 = $userManager->createUser();
        $user07->setUsername('elaine.stratton_hild');
        $user07->setSalutation('Frau');
        $user07->setFirstname('Elaine');
        $user07->setLastname('Stratton Hild');
        $user07->setPlainPassword('stratton_hild');
        $user07->setEnabled(true);
        $user07->setEmail('elaine.stratton_hild@uni-wuerzburg.de');
        $user07->addRole('ROLE_USER');
        $user07->addGroup($this->getReference('group-tester'));
        
        //konstantin.voigt@uni-wuerzburg.de
        $user08 = $userManager->createUser();
        $user08->setUsername('konstantin.voigt');
        $user08->setSalutation('Herr');
        $user08->setFirstname('Konstantin');
        $user08->setLastname('Voigt');
        $user08->setPlainPassword('voigt');
        $user08->setEnabled(true);
        $user08->setEmail('konstantin.voigt@uni-wuerzburg.de');
        $user08->addRole('ROLE_USER');
        $user08->addGroup($this->getReference('group-tester'));
        
        //david.catalunya@gmail.com
        $user09 = $userManager->createUser();
        $user09->setUsername('david.catalunya');
        $user09->setSalutation('Herr');
        $user09->setFirstname('David');
        $user09->setLastname('Catalunya');
        $user09->setPlainPassword('catalunya');
        $user09->setEnabled(true);
        $user09->setEmail('david.catalunya@gmail.com');
        $user09->addRole('ROLE_USER');
        $user09->addGroup($this->getReference('group-tester'));
        
        //isabel.kraft@uni-wuerzburg.de
        $user10 = $userManager->createUser();
        $user10->setUsername('isabel.kraft');
        $user10->setSalutation('Frau');
        $user10->setFirstname('Isabel');
        $user10->setLastname('Kraft');
        $user10->setPlainPassword('kraft');
        $user10->setEnabled(true);
        $user10->setEmail('isabel.kraft@uni-wuerzburg.de');
        $user10->addRole('ROLE_USER');
        $user10->addGroup($this->getReference('group-tester'));
        
        //Mainz:
        //torsten.schrade@adwmainz.de
        $user11 = $userManager->createUser();
        $user11->setUsername('torsten.schrade');
        $user11->setSalutation('Herr');
        $user11->setFirstname('Torsten');
        $user11->setLastname('Schrade');
        $user11->setPlainPassword('schrade');
        $user11->setEnabled(true);
        $user11->setEmail('torsten.schrade@adwmainz.de');
        $user11->addRole('ROLE_USER');
        $user11->addGroup($this->getReference('group-tester'));
        
        //Gabriele.Buschmeier@adwmainz.de
        $user12 = $userManager->createUser();
        $user12->setUsername('gabriele.buschmeier');
        $user12->setSalutation('Herr');
        $user12->setFirstname('Gabriele');
        $user12->setLastname('Buschmeier');
        $user12->setPlainPassword('buschmeier');
        $user12->setEnabled(true);
        $user12->setEmail('gabriele.buschmeier@adwmainz.de');
        $user12->addRole('ROLE_USER');
        $user12->addGroup($this->getReference('group-tester'));
        //
        //anna.neovesky@adwmainz.de
        $user13 = $userManager->createUser();
        $user13->setUsername('anna.neovesky');
        $user13->setSalutation('Frau');
        $user13->setFirstname('Anna');
        $user13->setLastname('Neovesky');
        $user13->setPlainPassword('neovesky');
        $user13->setEnabled(true);
        $user13->setEmail('anna.neovesky@adwmainz.de');
        $user13->addRole('ROLE_USER');
        $user13->addGroup($this->getReference('group-tester'));
                
        //plaksin@uni-mainz.de
        $user14 = $userManager->createUser();
        $user14->setUsername('anna.plaksin');
        $user14->setSalutation('Frau');
        $user14->setFirstname('Anna');
        $user14->setLastname('Plaksin');
        $user14->setPlainPassword('plaksin');
        $user14->setEnabled(true);
        $user14->setEmail('plaksin@uni-mainz.de');
        $user14->addRole('ROLE_USER');
        $user14->addGroup($this->getReference('group-tester'));
        
        $userManager->updateUser($user01, false); 
        $userManager->updateUser($user02, false); 
        $userManager->updateUser($user03, false); 
        $userManager->updateUser($user04, false); 
        $userManager->updateUser($user05, false); 
        $userManager->updateUser($user06, false); 
        $userManager->updateUser($user07, false); 
        $userManager->updateUser($user08, false); 
        $userManager->updateUser($user09, false); 
        $userManager->updateUser($user10, false); 
        $userManager->updateUser($user11, false); 
        $userManager->updateUser($user12, false); 
        $userManager->updateUser($user13, false); 
        $userManager->updateUser($user14, false); 
        
        $manager->flush();

    }

    /**
     * {@inheritDoc}
     */
    public function getOrder() {
        return 7; // the order in which fixtures will be loaded
    }
}

