<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\Git;

use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\VersionControlSystemRepos as VCSRepos;
use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\Git\RepositoryContainer;
/**
 * 
 * @DI\Service(name="")
 */
class RepositoryManager
{   
    
    const REMOTE_MASTER = 'origin';
    
    protected $logger;
    
    protected $remote;

    
    public function __construct($remote, $logger) {
        //$this->adapter;       
        $this->remote = $remote;
        $this->logger = $logger;
    }
    
    /**
     * Gibt an ob ein Reposetory existiert
     * 
     * @param \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\VersionControlSystemRepos $repository     * 
     * @return boolean
     */
    public function existsRepo(RepositoryContainer $repository) {
        $path = $repository->getPath();
        $gitRepo = \Git::open($path);
        if(!\Git::is_repo($gitRepo)) {
            return false;
        }
        return true;
    }
    
    /**
     * Erstellt das angegebene Reposetory
     * 
     * @param \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\VersionControlSystemRepos $repository
     * @return boolean
     */
    public function createRepo(RepositoryContainer $container) {

        $path = $container->getRepository()->getPath();        
        $gitRepo = \Git::create($path);
        
        if(\Git::is_repo($gitRepo)) {
                     
            return true;
        }
        return false;
    }

    /**
     * 
     * @param \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\VersionControlSystemRepos $repository
     * @param string|array $files
     */
    public function add(RepositoryContainer $repository, $files = null) {
        $gitRepo = $this->fromEntityToGitRepository($repository);
        if($files === null) {
          $gitRepo->add();
        } else {
          $gitRepo->add($files);
        }        
    }
    
    /**
     * 
     * @param \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\VersionControlSystemRepos $repository
     * @param string $message
     */
    public function commit(RepositoryContainer $repository, $message = "") {
        $gitRepo = $this->fromEntityToGitRepository($repository);
        $gitRepo->commit($message);
    }
    
    public function push(RepositoryContainer $container, $remote = self::REMOTE_MASTER) {
        
    }  
    
    public function pull() {
        
    }
    
    public function fetch() {
        
    }
    
    public function tag() {
        
    } 
    
    /**
     * Nimmt alle einstellungen für das Reposetory vor
     * 
     * @param \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\VersionControlSystemRepos $repository
     */
    protected function configRepo(RepositoryContainer $container) {
      
      $gitRepo = $this->fromEntityToGitRepository($container);
      
      $name = $container->getDisplayName();
      $email = $container->getEmail();
      
      $gitRepo->run('config user.name "' . $name . '"');
      $gitRepo->run('config user.email "' . $email . '"');
       
      //$url = 'git@github.com:mischka/monodi-test.git';
      $gitRepo->run('remote add ' . self::REMOTE_MASTER . ' ' . $this->remote);
    }
    
    /**
     * 
     * @param \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\VersionControlSystemRepos $repository
     * @return \Git2\Repository
     * @throws \RuntimeException
     */
    protected function fromEntityToGitRepository(RepositoryContainer $container) {
        $path = $container->getRepository()->getPath();
//        $gitRepo = new \Git2\Repository($path);
//        if(!$gitRepo->exists()) {
//            throw new \RuntimeException("Reposetory does not exists");
//        }        
        $gitRepo = \Git::open($path);
        if(!\Git::is_repo($gitRepo)) {
            throw new \RuntimeException("Reposetory does not exists");
        }
        
        return $gitRepo;
    }   
    
}