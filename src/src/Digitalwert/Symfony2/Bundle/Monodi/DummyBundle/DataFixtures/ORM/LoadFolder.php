<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\DummyBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Folder;

/**
 * Description of LoadFolder
 * 
 * /
 * |-Title of Parent 1
 * |  |-child 1 of Parent 1
 * |  |-child 2 of Parent 1
 * |     |-child 1 of child 2 of Parent
 * |
 * |- 
 * Band I
           Aachen
               Aa 13
                •	Dokument 1
                •	Dokument 2
	
               Aa 16
               B 25
            Trier
              T 15
              Ps 6
Band II
	...
Editorenordner
          Müller
             Mein Ordner 1
                  Dokument 3
                      …
             Mein Ordner 2
          Meier
          Schulze

 *
 * @author digitalwert
 */
class LoadFolder  
  extends AbstractFixture 
  implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        $parent1 = new Folder();
        $parent1->setTitle('Title of Parent 1');
        
        $child1 = new Folder();
        $child1->setTitle('child 1 of Parent 1');        
        $child1->setParent($parent1);
        
        $child2 = new Folder();
        $child2->setTitle('child 2 of Parent 1');        
        $child2->setParent($parent1);
        
        $child2child1 = new Folder($parent1);
        $child2child1->setTitle('child 1 of child 2 of Parent 1');        
        $child2child1->setParent($child2);
        
        $manager->persist($parent1);
        $manager->persist($child1);
        $manager->persist($child2);
        $manager->persist($child2child1);
        $manager->flush();

        $this->addReference('folder-p1', $parent1);
        $this->addReference('folder-p1/c1', $child2);        
        $this->addReference('folder-p1/c2', $child2);
        $this->addReference('folder-p1/c2/c1', $child2child1);
        
        /*
         * Test-Kategorie nach Konzept
         */
        $parent2 = new Folder();
        $parent2->setTitle('Band I');
        
        $c1p2 = new Folder();
        $c1p2->setTitle('Aachen');
        $c1p2->setParent($parent2);
        
        $c1c1p2 = new Folder();
        $c1c1p2->setTitle('Aa 13');
        $c1c1p2->setParent($c1p2);
        
        $c2c1p2 = new Folder();
        $c2c1p2->setTitle('Aa 16');
        $c2c1p2->setParent($c1p2);
        
        $c3c1p2 = new Folder();
        $c3c1p2->setTitle('B 25');
        $c3c1p2->setParent($c1p2);
        
        $c2p2 = new Folder();
        $c2p2->setTitle('Trier');
        $c2p2->setParent($parent2);
        
        $c1c2p2 = new Folder();
        $c1c2p2->setTitle('T 15');
        $c1c2p2->setParent($c2p2);
        
        $c2c2p2 = new Folder();
        $c2c2p2->setTitle('Ps 6');
        $c2c2p2->setParent($c2p2);
              
              
        
        $manager->persist($parent2);
        $manager->persist($c1p2);
        $manager->persist($c1c1p2);
        $manager->persist($c2c1p2);
        $manager->persist($c3c1p2);
        $manager->persist($c2p2);
        $manager->persist($c1c2p2);
        $manager->persist($c2c2p2);
        $manager->flush();

        $this->addReference('folder-p2', $parent2);
        $this->addReference('folder-p2/c1', $c1p2);        
        $this->addReference('folder-p2/c1/c1', $c1c1p2);
        $this->addReference('folder-p2/c1/c2', $c2c1p2);
        $this->addReference('folder-p2/c1/c3', $c3c1p2);
        $this->addReference('folder-p2/c2', $c2p2);        
        $this->addReference('folder-p2/c2/c1', $c1c2p2);
        $this->addReference('folder-p2/c2/c2', $c2c2p2);
       
        // Band 2
        
        $parent3 = new Folder();
        $parent3->setTitle('Band II');
        
        $manager->persist($parent3);
        $manager->flush();

        $this->addReference('folder-p3', $parent3);
        
        // Nutzerordner
        
        $home = new Folder();
        $home->setTitle('Editorenordner');
        
        $c1ph = new Folder();
        $c1ph->setTitle('Müller');
        $c1ph->setParent($home);
        
        $c1c1ph = new Folder();
        $c1c1ph->setTitle('Mein Ordner 1');
        $c1c1ph->setParent($c1ph);
        
        $c2c1ph = new Folder();
        $c2c1ph->setTitle('Mein Ordner 2');
        $c2c1ph->setParent($c1ph);
        
        $c2ph = new Folder();
        $c2ph->setTitle('Schulze');
        $c2ph->setParent($home);
        
        $c3ph = new Folder();
        $c3ph->setTitle('Meier');
        $c3ph->setParent($home);
        
        $manager->persist($home);
        $manager->persist($c1ph);
        $manager->persist($c1c1ph);
        $manager->persist($c2c1ph);        
        $manager->persist($c2ph);
        $manager->persist($c3ph);
        $manager->flush();

        $this->addReference('folder-ph', $parent2);
        $this->addReference('folder-ph/c1', $c1ph);        
        $this->addReference('folder-ph/c1/c1', $c1c1ph);
        $this->addReference('folder-ph/c1/c2', $c2c1ph);
        $this->addReference('folder-ph/c2', $c2ph); 
        $this->addReference('folder-ph/c3', $c3ph); 
        
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder() {
        return 4; // the order in which fixtures will be loaded
    }
}