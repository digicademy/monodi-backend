<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\ApiBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class DigitalwertMonodiApiExtension extends Extension 
  implements PrependExtensionInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }
    
    /**
     * {@inheritDoc}
     * @see http://symfony.com/doc/current/cookbook/bundles/prepend_extension.html
     */
    public function prepend(ContainerBuilder $container) {
        $bundles = $container->getParameter('kernel.bundles');
        
        if(isset($bundles['twig'])) {
            
          $configs = $container->getExtensionConfig('twig');
          // use the Configuration class to generate a config array with the settings ``twig``
          $config = $this->processConfiguration(new Configuration(), $configs);
          if (!isset($config['exception_controller'])) {
              /*
               * @see https://github.com/FriendsOfSymfony/FOSRestBundle/blob/master/Resources/doc/4-exception-controller-support.md
               */
              //$config['exception_controller'] = 'FOS\RestBundle\Controller\ExceptionController::showAction';
              //$container->prependExtensionConfig('twig', $config);
          }
        }        
    }
}
