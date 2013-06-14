<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\Git;

use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Document;
use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\VersionControlSystemRepos as VCSRepos;
use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\Git\RepositoryContainer;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Klasse zum
 * DI\Service(name="")
 */
class RepositoryManager
{   
    
    const REMOTE_MASTER = 'origin';
    
    protected $logger;
    
    protected $remote;
    
    protected $localBase;
    
    /**
     *
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * 
     * @param type $localBase
     * @param type $remote
     * @param type $logger
     */
    public function __construct($localBase, $remote, $logger) {
        //$this->adapter;  
        $this->localBase = $localBase;
        $this->remote = $remote;
        $this->logger = $logger;
        
        $this->filesystem = new Filesystem();
    }
    
    /**
     * Gibt an ob ein Reposetory existiert
     * 
     * @param Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\Git\RepositoryContainer $container
     * @return boolean
     */
    public function existsRepo(RepositoryContainer $container) {
//        $path = $container->getRepository()->getPath();
        
        $path = $this->buildPath($container);
        
        if($this->filesystem->exists($path)) {
            
            try {
                $gitRepo = \Git::open($path);
                
                if(\Git::is_repo($gitRepo)) {
                    return true;
                }
            } catch(\Exception $e) {
                // $e->getMessage() == Repository path '' does not exist
            }
        }
        return false;
    }
    
    /**
     * Erstellt das angegebene Reposetory
     * 
     * @param Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\Git\RepositoryContainer $container
     * @return boolean
     */
    public function createRepo(RepositoryContainer $container) {
        
        $path = $this->buildPath($container);

        if(!$this->filesystem->exists($path)) {
            $this->filesystem->mkdir($path);
        }
        
        $gitRepo = \Git::create($path);
        
        if(\Git::is_repo($gitRepo)) {
            $this->configRepo($container);         
            return true;
        }
        return false;
    }

    /**
     * 
     * @param Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\Git\RepositoryContainer $container
     * @param string|array $files
     */
    public function add(RepositoryContainer $container, $files = null) {
        $gitRepo = $this->fromEntityToGitRepository($container);
        
        if($files === null) {
            
          $gitRepo->add();
          
        } else {
          if(is_array($files)) {
            foreach($files as $key => $file) {
              if(!is_string($file)) {
                 if($file instanceof Document) {
                     $files[$key] = $this->dumpDocumentToRepo($file, $container);
                 }
              }
            }
          } elseif($files instanceof Document) {
              $files = $this->dumpDocumentToRepo($files, $container);
          }
            
          $gitRepo->add($files);
        }        
    }
    
    /**
     * 
     * @param Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\Git\RepositoryContainer $container
     * @param string $message
     */
    public function commit(RepositoryContainer $container, $message = '') {
        $gitRepo = $this->fromEntityToGitRepository($container);
        
        if($this->status($container)) {
            $res = $gitRepo->commit($message);
            //var_dump($res);
        }

    }
    
    public function push(RepositoryContainer $container, $remote = self::REMOTE_MASTER) {
        $gitRepo = $this->fromEntityToGitRepository($container);
    }  
    
    public function pull(RepositoryContainer $container) {
        $gitRepo = $this->fromEntityToGitRepository($container);
    }
    
    public function fetch(RepositoryContainer $container) {
        $gitRepo = $this->fromEntityToGitRepository($container);
    }
    
    public function tag(RepositoryContainer $container) {
        $gitRepo = $this->fromEntityToGitRepository($container);
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
    
    
    protected function status(RepositoryContainer $container) {
        
        $gitRepo = $this->fromEntityToGitRepository($container);
        
        $status = $gitRepo->run('status --porcelain');
        
        return $status;
    }
    
    /**
     * 
     * @param \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\VersionControlSystemRepos $repository
     * @return \Git2\Repository
     * @throws \RuntimeException
     */
    protected function fromEntityToGitRepository(RepositoryContainer $container) {
//        $path = $container->getRepository()->getPath();
        $path = $this->buildPath($container);
        
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
    
    protected function buildPath(RepositoryContainer $container) {        
//        $path = $container->getRepository()->getPath();
//        $slug = str_replace(' ', '.', strtolower($container->getDisplayName()));  
        $slug = $container->getRepositoryPath();
        $path = $this->localBase . '/'. $slug;

        return $path;
    }
    
    /**
     * Schriebt ein Document in das Dateisystem um es dem 
     */
    protected function dumpDocumentToRepo(Document $document, RepositoryContainer $container) {
        // Dateiarbeit
        $sub = $document->getFolder()->getSlug();
        
        $base = $this->buildPath($container);
        
        $path = $base . '/' . $sub;
        
        $filename = $document->getFilename();
        
        $pathname = $path . '/' . $filename;
        
        if(!$this->filesystem->exists($path)) {
            $this->filesystem->mkdir($path);
        }
        
        $file = new \SplFileObject($pathname, "w");
        $file->fwrite($document->getContent());
        $file->fflush();
        $pathname = realpath($pathname);
        unset($file);
        
        return $pathname;
    }
    
}