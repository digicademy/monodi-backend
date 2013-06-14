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
class GitPushCommand extends ContainerAwareCommand
{
    /**
     * @DI\Inject("fos_oauth_server.client_manager.default")
     * @var 
     */
    protected $reposetoryManager;
    
    /**
     * Configuration
     */
    protected function configure()
    {
        $this
            ->setName('digitalwert-monodi:git:push')
            ->setDescription('Push the Repos of a user')
            ->addArgument('user', InputArgument::REQUIRED, 'Sets the client name', null)
            ->addOption('redirect-uri', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Sets redirect uri for client. Use this option multiple times to set multiple redirect URIs.', null)
            ->setHelp(<<<EOT
The <info>%command.name%</info>command pushs the Git-Repos of a user.

  <info>php %command.full_name% [--redirect-uri=...] user</info>
   
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
        $this->clientManager->updateClient($client);
        
        //$output->writeln(sprintf('Added a new client with name <info>%s</info> and public id <info>%s</info>.', $client->getName(), $client->getPublicId()));        
    }
}

