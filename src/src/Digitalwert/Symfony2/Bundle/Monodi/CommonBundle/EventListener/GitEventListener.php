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
 *    "prePersist", 
 *    "preUpdate",
 *    "postPersist", 
 *    "postUpdate",
 *    "preRemove",
 *    "postRemove"
 *   },
 *   connection = "default",
 *   lazy = true,
 *   priority = 0
 * )
 */
class GitEventListener 
{
    /**
     * Handler für den Zugriff auf das GitRepository
     *
     * @var \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\Git\RepositoryManager
     */
    private $manager;
    
    /**
     * Monolog des Systems
     * 
     * @var \Symfony\Component\HttpKernel\Log\LoggerInterface
     * DI\Inject("logger")
     */
    private $logger;
        
    /**
     * Konstruktor
     *
     * @DI\InjectParams({
     *     "manager" = @DI\Inject("digitalwert_monodi_common.git.repositorymanager"),
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
     * Event
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args) {
        $this->preSave($args);
    }

    /**
     * Event
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args) {
        $this->preSave($args);
    }

    /**
     * Event
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args) {
        $this->postSave($args);
    }

    /**
     * Event
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args) {
        $this->postSave($args);
    }
    
    
    /**
     * Event
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function preRemove(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        // perhaps you only want to act on some "Document" entity
        if ($entity instanceof Document) {
            $this->logger->debug('BEFORE' . __METHOD__);
            $user = $entity->getEditor();

            $this->manager->pull($user);

            $this->manager->delete($user, $entity);

            $this->manager->commit($user, $entity->getFilename() . ' was removed from git');

            $this->logger->debug('AFTER' . __METHOD__);
        }        
    }


    /**
     * Event
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     * @throws \Exception
     */
    public function postRemove(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        // perhaps you only want to act on some "Document" entity
        if ($entity instanceof Document) {
            $this->logger->debug('BEFORE' . __METHOD__);

            $user = $entity->getEditor();            
            $this->manager->push($user);

            $this->logger->debug('AFTER' . __METHOD__);
        }
    }
    
    /**
     * Speichert den inhalte des Documents im GitRepository
     * 
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    protected function preSave(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        // perhaps you only want to act on some "Document" entity
        if ($entity instanceof Document) {
            
            $this->logger->debug('BEFORE' . __METHOD__);
            $this->logger->debug($entity->getContent());
            
            $user = $entity->getEditor();
            if(!$this->manager->existsRepo($user)) {
                //try to create
                $this->manager->createRepo($user);
            }
            
            $this->manager->pull($user);
            
            //Check for Move
            if($entity->hasMoved()) {
                $old = $entity->getOrigFolder()->getSlug() . '/' . $entity->getOrigFilename();

                $this->manager->move($user, $old, $entity);
                $this->manager->commit($user,
                    $old . ' moved to ' . $entity->getFolder()->getSlug() . '/' . $entity->getFilename()
                );
            }

            // Add the Stuff
            $this->manager->add($user, $entity);
            $this->manager->commit($user, 'Systemcommit für ' . $user->getEmail());
            
            $this->logger->debug('AFTER' . __METHOD__);
            $this->logger->debug($entity->getContent());
            
            $this->logger->debug('prePersist Document');
        }
        
    }
    
    /**
     * Pusht den Inhalt des GitRepoitories zum Remote-Master
     * 
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    protected function postSave(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        // perhaps you only want to act on some "Document" entity
        if ($entity instanceof Document) {
            //throw new \Exception('TEST des GIT');
            $user = $entity->getEditor();
            
            $this->logger->debug('BEFORE' . __METHOD__);
            $this->logger->debug($entity->getContent());
            
            $this->manager->push($user);
            
            $this->logger->debug('AFTER' . __METHOD__);
            $this->logger->debug($entity->getContent());            
        }        
    }
}