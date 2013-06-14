<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class DigitalwertMonodiCommonExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader(
           $container, 
           new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.xml');
            
        /*
         * Regestrierte die Configparameter für die Services
         * @see http://symfony.com/doc/2.2/cookbook/bundles/extension.html#configuring-services-and-setting-parameters
         * 
         * - digitalwert_monodi_common.existdb.uri
         * - digitalwert_monodi_common.existdb.collection
         * - digitalwert_monodi_common.existdb.username
         * - digitalwert_monodi_common.existdb.password
         * - digitalwert_monodi_common.git.remote.uri
         * - digitalwert_monodi_common.git.local.base
         */
        $container->setParameter(
            'digitalwert_monodi_common.existdb.username',
            $config['existdb']['username']
        );
        $container->setParameter(
            'digitalwert_monodi_common.existdb.password',
            $config['existdb']['password']
        );
        $container->setParameter(
            'digitalwert_monodi_common.existdb.uri',
            $config['existdb']['uri']
        );
        $container->setParameter(
            'digitalwert_monodi_common.existdb.collection',
            $config['existdb']['collection']
        );
        
        $container->setParameter(
            'digitalwert_monodi_common.git.local.base',
            $config['git']['local']['base']
        );        
        $container->setParameter(
            'digitalwert_monodi_common.git.remote.uri',
            $config['git']['remote']['uri']
        );
    }
}
