<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\OAuthServerBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use JMS\DiExtraBundle\Annotation as DI;
use Digitalwert\Symfony2\Bundle\Monodi\OAuthServerBundle\Client;

/**
 * Klasse fürgt 
 * 
 * 
 * http://monodi.symfony2.dev/app_dev.php/oauth/v2/auth?client_id=1_2rhsh9vp7hkw4s4gg4w848cs4s8cg0kgcoskskc44swss00oco&response_type=code&redirect_uri=http%3A%2F%2Fwww.google.com
 * 
 * http://monodi.symfony2.dev/app_dev.php/oauth/v2/token?client_id=1_2rhsh9vp7hkw4s4gg4w848cs4s8cg0kgcoskskc44swss00oco&client_secret=3wnenj80d6yos8kgwoko8oksgscsg4kw8gsgw4ko88kksgscws&grant_type=authorization_code&redirect_uri=http%3A%2F%2Fwww.google.com&code=NmIzYTM2ODQwZmM0YTM2NTJlOWJkYmU4MmExNDJkYmZkNWJiNjRkYzRjOWZmMTA5NzkyMzVjNmZlYWM1N2JjNQ
 * 
 */
class ClientCreateCommand extends ContainerAwareCommand
{
    /**
     * @DI\Inject("fos_oauth_server.client_manager.default")
     * @var 
     */
    protected $clientManager;
    
    /**
     * 
     */
    protected function configure()
    {
        $this
            ->setName('digitalwert-monodi:oauth-server:client:create')
            ->setDescription('Creates a new client')
            ->addArgument('name', InputArgument::REQUIRED, 'Sets the client name', null)
            ->addOption('redirect-uri', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Sets redirect uri for client. Use this option multiple times to set multiple redirect URIs.', null)
            ->addOption('grant-type', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Sets allowed grant type for client. Use this option multiple times to set multiple grant types..', null)
            ->setHelp(<<<EOT
The <info>%command.name%</info>command creates a new client.

  <info>php %command.full_name% [--redirect-uri=...] [--grant-type=...] name</info>
   
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
        $this->clientManager = $this->getContainer()->get('fos_oauth_server.client_manager.default');
        /** @var \Digitalwert\Symfony2\Bundle\Monodi\OAuthServerBundle\Client  */
        $client = $this->clientManager->createClient();
        $client->setName($input->getArgument('name'));
        $client->setRedirectUris($input->getOption('redirect-uri'));
        $client->setAllowedGrantTypes($input->getOption('grant-type'));
        
        $this->clientManager->updateClient($client);
        
        $output->writeln(sprintf('Added a new client with name <info>%s</info> and public id <info>%s</info>.', $client->getName(), $client->getPublicId()));        
    }
}

