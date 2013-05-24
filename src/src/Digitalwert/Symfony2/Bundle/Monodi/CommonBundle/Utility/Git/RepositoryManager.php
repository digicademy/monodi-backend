<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\Git;

use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\VersionControlSystemRepos as VCSRepos;
/**
 * 
 * @DI\Service(name="")
 */
class RepositoryManager
{    
    protected $repository;
    
    protected $logger;
    
    public function __construct($logger) {
        //$this->adapter;       
        
        $this->logger = $logger;
    }
    
    
    public function createRepo(VCSRepos $repository) {
        
        $gitRepo = \Git2\Repository::init("/path/to/repo",true);
        
    }

    
    public function add() {
        
    }
    
    public function commitRepos($data, $message = "") {
        
    }
    
    public function pushRepos(VCSRepos $repository) {
        
    }   
    
    protected function fromEntityToGitRepository(VCSRepos $repository) {
        $path = $repository->getPath();
        $gitRepo = new \Git2\Repository($path);
        
        if(!$gitRepo->exists()) {
            throw new \RuntimeException("Reposetory does not exists");
        }
        return $gitRepo;
    }
    
    
    
}