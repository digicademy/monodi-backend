<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Klasse Stellt Command zum Pushen des Repos eines nutzers bereit
 * 
 */
class RepoCheckCommand extends ContainerAwareCommand
{
    /**
     *
     * @var type 
     */
    protected $em;
    
    /**
     * 
     * @DI\Inject("digitalwert_monodi_common.git.repositorymanager")
     * @var \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\Git\RepositoryManager
     */
    protected $gitRepositoryManager;
    
    /**
     * 
     * @DI\Inject("digitalwert_monodi_common.existdb.manager") 
     * @var \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\ExistDb\ExistDbManager
     */
    protected $existRepositoryManager;    
    
    /**
     *
     * @var \Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\DocumentRepository
     */
    protected $documentRepository;
    
    /** 
     * NutzerManager
     * @var \FOS\UserBundle\Doctrine\UserManager
     * @DI\Inject("fos_user.user_manager")
     */
    protected $userManager;
    
    /**
     * Configuration
     */
    protected function configure()
    {
        $this
            ->setName('digitalwert-monodi:repo:check')
            ->setDescription('Push the Repos of a user')
            ->addArgument('username', InputArgument::REQUIRED, 'Sets the user by name', null)
            ->addOption('fix-strategy', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'How to fix errors', null)
            ->setHelp(<<<EOT
The <info>%command.name%</info>command ckecks all repos for errors.

  <info>php %command.full_name% [--fix-strategy=...] user</info>
   
EOT
        );
    }
    
    /**
     * 
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->gitRepositoryManager = $this->getContainer()->get('digitalwert_monodi_common.git.repositorymanager');
        $this->existRepositoryManager = $this->getContainer()->get('digitalwert_monodi_common.existdb.manager');
        $this->userManager = $this->getContainer()->get('fos_user.user_manager');        
        $this->em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $this->documentRepository = $this->em->getRepository('Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Document');
        
        $report = array();
        $filelist = array();
        
        $display = array(
            'id' => 5,
            'file' => 20, 
            'database' => 10,
            'git' => 10,
            'existdb' => 10,
        );
        
        $user = $this->userManager->findUserByUsername($input->getArgument('username'));
        if($user) {
            $output->writeln('User for test is: ' . $user);            
            
            $q = $this->em->createQuery('SELECT d.id, d.filename FROM Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Document d');
            $results = $q->getArrayResult();
            
            \Doctrine\Common\Util\Debug::dump($results);
            
            // Check database
            foreach($results as $row) {           
                
                $status = array(
                    'id' => $row['id'],
                    'file' => '', 
                    'database' => 'OK',
                    'git' => 'OK',
                    'existdb' => 'OK',
                );
                
                try {
                    $document = $this->documentRepository->find($row['id']);
                    
                    // document exists in the repo?
                    $filepath = $this->gitRepositoryManager->getDocumentPathnameInRepo($document, $user);
                    if(!file_exists($filepath)) {
                        $status['git'] = 'ERROR';
                    }
                    $status['file'] = $filepath;
                    
                    $filelist[] = $filepath;
                    
                    $display['file'] = (strlen($filepath) > $display['file']) ?  
                            strlen($filepath) + 2 : $display['file'];                    
                    
                } catch (\Digitalwert\Guzzle\ExistDb\Exception\DocumentNotFoundException $e) {
                    $output->writeln('ExistDb-Error:' . $e->getMessage() );
                    $status['existdb'] = 'ERROR';
                    $status['git'] = 'NONE';
                }
                
                $report[] = $status;
            }
            // check GIT
            $repoRoot = $this->gitRepositoryManager->buildPath($user);
            
            // check ExistDB
            
            // echo data
            foreach($report as $line) {
                $str = '|' . str_pad($line['id'], $display['id'], " ", STR_PAD_BOTH);
                $str .= '|' . str_pad($line['file'], $display['file'], " ", STR_PAD_BOTH);
                $str .= '|' . str_pad($line['database'], $display['database'], " ", STR_PAD_BOTH);
                $str .= '|' . str_pad($line['git'], $display['git'], " ", STR_PAD_BOTH);
                $str .= '|' . str_pad($line['existdb'], $display['existdb'], " ", STR_PAD_BOTH) . '|';
                       
                $output->writeln($str);
            }
            
        }        
        //$output->writeln(sprintf('Added a new client with name <info>%s</info> and public id <info>%s</info>.', $client->getName(), $client->getPublicId()));        
    }
    
    protected function logMessages() {
        
    }
    
}

