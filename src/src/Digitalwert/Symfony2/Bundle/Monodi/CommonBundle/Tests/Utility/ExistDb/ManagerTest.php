<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Tests\Utility\ExistDb;

use Digitalwert\Guzzle\ExistDb\ExistDbClient;
use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Document;
use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\ExistDb\ExistDbManager as Manager;
use Monolog\Logger;

/**
 * Description of ManagerTest
 *
 * @author digitalwert
 */
class ManagerTest extends \PHPUnit_Framework_TestCase
{
    CONST COLLECTION = 'apps/monodi/data';
    /**
     * testobject
     * @var Manager
     */
    protected $object;
    
    /**
     * 
     */
    public function setUp() {
        
        $collection = 'apps/monodi/data';
        $client = ExistDbClient::factory(array(
            'base_url' => 'https://adwserv9.adwmainz.net/exist/rest/db/',
            'username' => 'monodi',
            'password' => 'tLZ5BölTwq!qdUög',
        ));
        
        $this->object = new Manager(
          $client, $collection
        );
    }
    
    public function collection() {
        //'Guzzle\Http\Exception\ClientErrorResponseException'
    }
    
    
    /**
     * Prüft ob ein vorhandenes Dokument geladen werden kann
     * @test
     */
    public function retrieve() {
        
        $document = new Document();
        $document->setName('unittest.mei');
        $document->setFilename('unittest.mei');
        //$document->setContent('<unit>TEST</unit>');
        
        $document = $this->object->retrieveDocument($document);

        $this->assertEquals(
            "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<unit>TEST</unit>\n",
            $document->getContent()
        );
    }
    
    /**
     * Prüft ob ein neues Dokument in der eXistdb angelegt werden kann
     * @test
     */
    public function create() {
        $filename = 'test-create-' . time() . '.mei';
        $document = new Document();
        $document->setName($filename);
        $document->setFilename($filename);
        $document->setContent(self::dummyContent());
        
        $this->object->storeDocument($document);
        //var_dump($document->getContent());
    }
    
    /**
     * Prüfe ob Dokument überschriben werden kann
     * @test
     */
    public function update() {
        $document = new Document();
        $document->setName('unittest-update.mei');
        $document->setFilename('unittest-update.mei');
        $document->setContent(self::dummyContent());
        
        $this->assertTrue($this->object->storeDocument($document));
    }
    
    /**
     * Prüfe ob Dokumente gelöscht werden können
     * @test
     */
    public function removedelete() {
        $document = new Document();
        $document->setName('unittest-delete.mei');
        $document->setFilename('unittest-delete.mei');
        $document->setContent(self::dummyContent());
            
        $this->assertTrue($this->object->storeDocument($document));
        $this->assertTrue($this->object->removeDocument($document));
    } 
    
    public function query() {
        
    }
    
    /**
     * Gibt dummy Content zurück
     * 
     * @return string
     */
    protected static function dummyContent() {
        return '<?xml version="1.0" encoding="UTF-8"?>
<mei xmlns="http://www.music-encoding.org/ns/mei">
  <meiHead>
    <fileDesc>
      <titleStmt>
        <title/>
      </titleStmt>
      <pubStmt/>
      <sourceDesc>
        <source/>
      </sourceDesc>
    </fileDesc>
  </meiHead>
  <music>
    <body>
      <mdiv>
        <score>
          <section>
            <staff>
              <layer>
                <sb label=""/>
                <syllable>
                  <syl></syl>
                </syllable>
              </layer>
            </staff>
          </section>
        </score>
      </mdiv>
    </body>
  </music>
</mei>';        
    }
}

