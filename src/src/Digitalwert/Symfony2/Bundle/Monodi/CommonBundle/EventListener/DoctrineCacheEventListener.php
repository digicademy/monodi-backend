<?php
/**
 * Created by PhpStorm.
 * User: digitalwert
 * Date: 04.06.14
 * Time: 16:27
 */

namespace Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
// for doctrine 2.4: Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use JMS\DiExtraBundle\Annotation as DI;
use Psr\Log\LoggerInterface;
use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Folder;
use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Document;
use Doctrine\Common\Cache\ApcCache;

/**
 * Class DoctrineCacheEventListener
 * @package Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\EventListener
 *
 * @see http://www.gregfreeman.org/2012/invalidating-the-result-cache-in-doctrine-symfony2/
 *
 * @DI\Service("monodi.doctrine.event_listener.doctrine_cache", public=false)
 * @DI\DoctrineListener(
 *   events = {
 *    "prePersist",
 *    "preUpdate",
 *    "preRemove"
 *   },
 *   connection = "default",
 *   lazy = true,
 *   priority = 0
 * )
 */
class DoctrineCacheEventListener 
{
    const DEFAULT_TTL = 3600;

    const CACHE_KEY_DOCTRINE_FOLDER_NODES_ARRAY = '_folder_nodes_hierarchy_array_id_';
    const CACHE_KEY_DOCTRINE_FOLDER_CHILDREN = '_folder_children_id_';
    const CACHE_KEY_CONTROLLER_FOLDER = '_folder_metadata_path_';

    /**
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $this->flush($args);
    }

    /**
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->flush($args);
    }

    /**
     *
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        $this->flush($args);
    }

    protected function flush(LifecycleEventArgs $args)
    {
        $em = $args->getEntityManager();
        $uow = $em->getUnitOfWork();
        $entity = $args->getEntity();

        $flush = false;

        if($entity instanceof Folder) {
            $flush = true;
        }

        if($entity instanceof Document) {
            $changeSet = $uow->getEntityChangeSet($entity);
            if($changeSet['folder']
                || $changeSet['title']
                || $changeSet['rev']
                || $changeSet['filename']
            ) {
                $flush = true;
            }
        }

        if($flush) {

            /**
             * http://docs.doctrine-project.org/en/2.0.x/reference/caching.html
             */
            $em
                ->getConfiguration()
                ->getResultCacheImpl()
                ->delete(static::CACHE_KEY_DOCTRINE_FOLDER_NODES_ARRAY . '*')
            ;

            $cacheDriver = new ApcCache();
            $cacheDriver->delete(static::CACHE_KEY_CONTROLLER_FOLDER . '*');
        }
    }

} 