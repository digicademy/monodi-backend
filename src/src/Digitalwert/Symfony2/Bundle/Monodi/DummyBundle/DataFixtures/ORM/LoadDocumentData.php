<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\DummyBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Document;

/**
 * Description of LoadDocumentData
 *
 * @author digitalwert
 */
class LoadDocumentData  
  extends AbstractFixture 
  implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        
        //
        $document1 = new Document();
        $document1->setFilename('testdocument.mei.xml');
        $document1->setTitle('Test Dokument 1');
        $document1->setCreatedAt(new \DateTime('yesterday'));
        $document1->setUpdatedAt(new \DateTime('now'));
        $document1->setEditedAt(new \DateTime('now'));
        $document1->setRev('00000000000');
        $document1->setProcessNumber(1);
        $document1->setEditionNumber(1);
        
        // Referenzen
        $document1->setFolder($this->getReference('folder-p1/c2/c1'));
        $document1->setOwner($this->getReference('user-admin'));
        $document1->setGroup($this->getReference('group-member'));
        $document1->setEditor($this->getReference('user-test1'));
        
        
        $manager->persist($document1);
        
        $manager->flush();
        
    }
        
    /**
     * {@inheritDoc}
     */
    public function getOrder() {
        return 5; // the order in which fixtures will be loaded
    }
}
