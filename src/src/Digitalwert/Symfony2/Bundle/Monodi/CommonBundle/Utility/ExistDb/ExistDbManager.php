<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\ExistDb;

use Digitalwert\Guzzle\ExistDb\ExistDbClient; 
use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Document;

/**
 * Description of ExistDbManager
 *
 * @author digitalwert
 */
class ExistDbManager 
{
    
    protected $client;
    
    protected $defaultCollection;
    
    public function __construct(
      ExistDbClient $client,
      $defaultCollection = 'apps/monodi/data'
    ) {
        $this->client = $client;
        $this->defaultCollection = $defaultCollection;
    }
    
    
    public function storeDocument(Document $document, $collection = null) {
        
        $collection = $collection ? $collection : $this->defaultCollection; 
        
        $content = $document->getContent();
        $this->client->store(array(
          'collection' => $collection,
          'document'   => $this->buildDocumentIdentification($document),
          'data'       => $content,
        ));
        
    }
    
    public function retrieveDocument(Document $document) {
        $collection = $collection ? $collection : $this->defaultCollection; 
        
        $model = $this->client->retrieve(array(
          'collection' => $collection,
          'document'   => $this->buildDocumentIdentification($document),
        ));
        $document->setContent((string)$model);
        
        return $document;
    }
    
    public function deleteDocument(Document $document) {
        
    }
    
    public function query() {
        
    }
    
    
    protected function buildDocumentIdentification(Document $document) {
        
    }
}