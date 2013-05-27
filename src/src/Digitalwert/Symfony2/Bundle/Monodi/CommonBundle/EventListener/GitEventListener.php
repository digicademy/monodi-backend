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
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Document;
use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\Git\RepositoryManager as RepoManager;
/**
 * Description of GitEventListener
 *
 * @author digitalwert
 * 
 * @see http://symfony.com/doc/master/cookbook/doctrine/event_listeners_subscribers.html
 * @see http://jmsyst.com/bundles/JMSDiExtraBundle/master/annotations#service
 * @see http://symfony.com/doc/master/components/event_dispatcher/introduction.html#event-dispatcher-using-event-subscribers
 * 
 * DI\Tag("doctrine.event_listener", attributes = {"event" = "postGenerateSchema", lazy=true})
 * @DI\Service
 * @DI\DoctrineListener(
 *   events = {
 *     "prePersist", 
 *     "preUpdate"
 *   },
 *   connection = "default",
 *   lazy = true,
 *   priority = 0
 * )
 */
class GitEventListener 
{   
    
    private $manager;
    
    /**
     * Monolog des Systems
     * 
     * @var \Symfony\Component\HttpKernel\Log\LoggerInterface
     * DI\Inject("logger")
     */
    private $logger;
        
    /**
     * 
     * @DI\InjectParams({
     *     "manager" = @DI\Inject("digitalwert_monodi_common.git.repositorymanager")
     *     "logger" = @DI\Inject("logger")
     * })
     * 
     */
    public function __construct(
      \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\Git\RepositoryManager $manager, 
      \Symfony\Component\HttpKernel\Log\LoggerInterface $logger
    ) {
        $this->manager = $manager;
        $this->logger = $logger;
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
            
            $user = $entity->getEditor();
            $this->manager->existsRepo($user);
            
            
            $this->logger->debug('prePersist Document');
        }
    }
    
    
    public function preUpdate(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        // perhaps you only want to act on some "Document" entity
        if ($entity instanceof Document) {
            
        }
    }
    
    public function postPersist(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        // perhaps you only want to act on some "Document" entity
        if ($entity instanceof Document) {
            
        }
    }
    
    public function postUpdate(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        // perhaps you only want to act on some "Document" entity
        if ($entity instanceof Document) {
            
        }
    }
    
    public function postRemove(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        // perhaps you only want to act on some "Document" entity
        if ($entity instanceof Document) {
            
        }
    }
    
    

}