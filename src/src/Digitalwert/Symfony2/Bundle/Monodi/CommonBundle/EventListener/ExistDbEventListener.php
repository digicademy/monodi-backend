<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\EventListener;

//use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
// for doctrine 2.4: Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Document;
use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\ExistDb\ExistDbManager as Manager;
/**
 * Description of GitEventListener
 *
 * @author digitalwert
 * 
 * @see http://symfony.com/doc/master/cookbook/doctrine/event_listeners_subscribers.html
 * @see http://jmsyst.com/bundles/JMSDiExtraBundle/master/annotations#service
 * @see http://symfony.com/doc/master/components/event_dispatcher/introduction.html#event-dispatcher-using-event-subscribers
 * 
 * 
 * DI\Tag("doctrine.event_listener", attributes = {"event" = "postGenerateSchema", lazy=true})
 * 
 * @DI\Service("monodi.doctrine.existdb", public=false) 
 * @DI\DoctrineListener(
 *   events = {
 *    "postLoad",
 *    "prePersist", 
 *    "preUpdate",
 *    "postPersist", 
 *    "postUpdate",
 *    "postRemove"
 *   },
 *   connection = "default",
 *   lazy = true,
 *   priority = 0
 * )
 */
class ExistDbEventListener 
{   
    /**
     *
     * @var Manager
     */
    protected $existdb;
    
    /**
     * Monolog des Systems
     * 
     * @var \Symfony\Component\HttpKernel\Log\LoggerInterface
     * DI\Inject("logger")
     */
    private $logger;
        
    /**
     * "git" = DI\Inject("monodi.vcs.client")
     * 
     * @DI\InjectParams({
     *     "manager" = @DI\Inject("digitalwert_monodi_common.existdb.manager"),
     *     "logger" = @DI\Inject("logger")
     * })
     * 
     */
    public function __construct(Manager $manager, LoggerInterface $logger) {
        
        $this->logger = $logger;
        $this->existdb = $manager;
    } 
    
    /**
     * 
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        // perhaps you only want to act on some "Document" entity
        if ($entity instanceof Document) {
            $this->logger->debug('prePersist Document');
            
        }
    }
    
    
    public function preUpdate(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
        
        $this->logger->debug(__METHOD__);

        // perhaps you only want to act on some "Document" entity
        if ($entity instanceof Document) {
            
        }
    }
    
    public function postPersist(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
        
        $this->logger->debug(__METHOD__);

        // perhaps you only want to act on some "Document" entity
        if ($entity instanceof Document) {
            
        }
    }
    
    public function postUpdate(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
        
        $this->logger->debug(__METHOD__);

        // perhaps you only want to act on some "Document" entity
        if ($entity instanceof Document) {
            
        }
    }
    
    public function postRemove(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
        
        $this->logger->debug(__METHOD__);

        // perhaps you only want to act on some "Document" entity
        if ($entity instanceof Document) {
            
        }
    }
    
    public function postLoad(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();       
        
        // perhaps you only want to act on some "Document" entity
        if ($entity instanceof Document) {
            
            $this->logger->debug(__METHOD__);
            $entity = $this->existdb->retrieveDocument($entity);
            //$entity->setContent(trim('<mei></mei>'));
        }
    }

}