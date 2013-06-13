<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\ExistDb;

use Digitalwert\Guzzle\ExistDb\ExistDbClient; 
use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Document;

/**
 * Klasse für den Zuriff auf die eXistDd
 * 
 * 
 *
 * @author digitalwert
 */
class ExistDbManager 
{
    /**
     * Client für den REST-Style-Zugriff auf die ExistDb
     * 
     * @var \Digitalwert\Guzzle\ExistDb\ExistDbClient
     */
    protected $client;
    
    /**
     * Stanarduri für die Collectionauswahl
     * 
     * @var string
     */
    protected $defaultCollection;
    
    /**
     * Konstruktor 
     * 
     * @param \Digitalwert\Guzzle\ExistDb\ExistDbClient $client
     * @param string $defaultCollection
     */
    public function __construct(
      ExistDbClient $client,
      $defaultCollection = 'apps/monodi/data'
    ) {
        $this->client = $client;
        $this->defaultCollection = $defaultCollection;
    }
    
    /**
     * Speichert/Aktualisiert ein Document in der Existdb
     * 
     * @param \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Document $document
     * @param string $collection
     * @return boolean
     * 
     * @throws \Digitalwert\Guzzle\ExistDb\Exception\ServiceResponseException
     */
    public function storeDocument(Document $document, $collection = null) {
        
        $collection = $collection ? $collection : $this->defaultCollection; 
        
        $content = $document->getContent();
        
        try {
            $this->client->store(array(
              'collection' => $collection,
              'document'   => $this->buildDocumentIdentification($document),
              'data'       => $content,
            ));
        } catch (\Digitalwert\Guzzle\ExistDb\Exception\ServiceResponseException $e) {
            throw $e;
        }
        
        return true;
    }
    
    /**
     * Gibt den Inhalt eines Dokumentes aus der eXistDb zurück
     * 
     * @param  \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Document $document
     * @param  string $collection abweichung von der Defaultcollection
     * 
     * @return \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Document
     * @throws \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\ExistDb\ServiceResponseException
     */
    public function retrieveDocument(Document $document, $collection = null) {
        $collection = $collection ? $collection : $this->defaultCollection; 
        try {
            $model = $this->client->retrieve(array(
              'collection' => $collection,
              'document'   => $this->buildDocumentIdentification($document),
            ));
            $document->setContent((string)$model);
        } catch(\Digitalwert\Guzzle\ExistDb\Exception\ServiceResponseException $e) {            
            throw $e;
        }
        return $document;
    }
    
    /**
     * Löscht ein Dokument in der ExistDb
     * 
     * @param \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Document $document
     * @param string $collection
     * @return boolean
     * @throws \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\ExistDb\ServiceResponseException
     */
    public function removeDocument(Document $document, $collection = null) {
        $collection = $collection ? $collection : $this->defaultCollection; 
        try {
            $this->client->remove(array(
              'collection' => $collection,
              'document'   => $this->buildDocumentIdentification($document),
            ));
        } catch(\Digitalwert\Guzzle\ExistDb\Exception\ServiceResponseException $e) {            
            throw $e;
        }    
        return true;        
    }
    
    /**
     * 
     * @param array $criteria
     */
    public function query($criteria) {
        // Angedacht um suchanfragen zu fomulieren
    }
    
    /**
     * Erstellt den Pfad unter welchen sich das Dokument in der eXistdb befinden muss
     * 
     * @param \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Document $document
     * @return string
     */
    protected function buildDocumentIdentification(Document $document) {
        $filename = $document->getFilename();
        
        if(($folder = $document->getFolder())) {
            // Subcollections ersteinmal verhindern
            $filename = str_replace('/', '_', $folder->getSlug()). '_' . $filename;
            
            \Doctrine\Common\Util\Debug::dump($folder);
        }
        
        return $filename;
    }
}