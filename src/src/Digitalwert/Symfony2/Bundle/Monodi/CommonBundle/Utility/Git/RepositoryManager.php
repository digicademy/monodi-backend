<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\Git;

use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Document;
use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\VersionControlSystemRepos as VCSRepos;
use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\Git\RepositoryContainer;
use Symfony\Component\Filesystem\Filesystem;


use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\Git\Adapter\GitPhp\GitPhp as GitHandler;


/**
 * Klasse zum
 * DI\Service(name="")
 */
class RepositoryManager
{   
    
    const REMOTE_MASTER = 'origin';

    const LOCAL_MASTER = 'master';
    
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
                $gitRepo = GitHandler::open($path);
                
                if(GitHandler::is_repo($gitRepo)) {
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
        
        $gitRepo = GitHandler::create($path);
        
        if(GitHandler::is_repo($gitRepo)) {
            $this->configRepo($container);         
            return true;
        }
        return false;
    }

    /**
     * Setzt eine Dokument auf die Stage
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
            
          $this->logger->debug($gitRepo->add($files));
        }        
    }
    
    /**
     * Löscht eine Datei aus dem Dateisystem und dem Git Repo
     *
     * <code>
     *   git rm
     * </code>
     * 
     * @param \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\Git\RepositoryContainer $container
     * @param string|array $files
     */
    public function delete(RepositoryContainer $container, $files) {
        $gitRepo = $this->fromEntityToGitRepository($container);

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

        if (is_array($files)) $files = '"'.implode('" "', $files).'"';

        if(!empty($files)) {
            $res = $gitRepo->run("rm -f $files ");
            $this->logger->debug($res);

        }
    }
    
    /**
     * Verschiebt die Dokumente innerhalb eine Repo
     *
     * <code>
     *   git mv
     * </code>
     *
     * @param \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\Git\RepositoryContainer $container
     * @param string|Document $old
     * @param string |Document $new
     */
    public function move(RepositoryContainer $container, $old, $new) {
        $gitRepo = $this->fromEntityToGitRepository($container);

        if(empty($old)) {
          throw new \InvalidArgumentException('Old must be an existing file');
        }

        if(empty($new)) {
            throw new \InvalidArgumentException('new could not be empty');
        }

        if($old instanceof Document) {
            $old =  $this->getDocumentPathnameInRepo($old, $container);
        }

        if($new instanceof Document) {
            $new =  $this->getDocumentPathnameInRepo($new, $container);
        }

        $res = $gitRepo->run('mv "' . $old . '" "' . $new . '"');
        $this->logger->debug($res);

    }


    /**
     * Fügt ein commit in das Lokale Repo aus
     * 
     * @param Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\Git\RepositoryContainer $container
     * @param string $message
     * 
     * @return string reversion des commits
     */
    public function commit(RepositoryContainer $container, $message = '') {
        $gitRepo = $this->fromEntityToGitRepository($container);
        $rev = null;
        if($this->status($container)) {
            $res = $gitRepo->commit($message);
            $this->logger->debug($res);
            // [master 91575ee]
            $rev = substr($res, (strpos($res, ']') - 7));
            $this->logger->debug($res);
        }
        return $rev;
    }
    
    public function push(RepositoryContainer $container, $remote = self::REMOTE_MASTER) {
        $gitRepo = $this->fromEntityToGitRepository($container);
        //$res = $gitRepo->run('push');
        //$this->logger->debug($res);
    }


    /**
     *
     * <code>
     *   git pull -f origin master
     * </code>
     *
     * @param RepositoryContainer $container
     */
    public function pull(RepositoryContainer $container, $remote = self::REMOTE_MASTER) {
        $gitRepo = $this->fromEntityToGitRepository($container);
        //$res = $gitRepo->run('pull -f ' . $remote . ' ' . self::LOCAL_MASTER);
        //$this->logger->debug($res);
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

        /** @var \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\Git\Adapter\GitPhp\GitRepository $gitRepo */
        $gitRepo = GitHandler::open($path);
        if(!GitHandler::is_repo($gitRepo)) {
            throw new \RuntimeException("Reposetory does not exists");
        }

        $gitRepo->setSshKeyFile('/var/www/dev.symfony2.monodi/src/app/config/ssh/github.rsa');
        
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

    protected function getDocumentPathnameInRepo(Document $document, RepositoryContainer $container) {
        // Dateiarbeit
        $sub = $document->getFolder()->getSlug();

        $base = $this->buildPath($container);

        $path = $base . '/' . $sub;

        $filename = $document->getFilename();

        $pathname = $path . '/' . $filename;

        if(!$this->filesystem->exists($path)) {
            $this->filesystem->mkdir($path);
        }

        $pathname = realpath($pathname);

        return $pathname;
    }
    
}