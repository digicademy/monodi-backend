<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),           
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new JMS\AopBundle\JMSAopBundle(),
            new JMS\DiExtraBundle\JMSDiExtraBundle($this),
            new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
            
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),
            new Nelmio\ApiDocBundle\NelmioApiDocBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new FOS\OAuthServerBundle\FOSOAuthServerBundle(),
            
            new JMS\SerializerBundle\JMSSerializerBundle(),
            new FOS\RestBundle\FOSRestBundle(),
            new SimpleThings\FormSerializerBundle\SimpleThingsFormSerializerBundle(),
            
            new Mopa\Bundle\BootstrapBundle\MopaBootstrapBundle(),
            
            // Für Geomon DoctrineExtensions
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            
            /*
             * 
             */
            new Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\DigitalwertMonodiCommonBundle(),
            new Digitalwert\Symfony2\Bundle\Monodi\FrontendBundle\DigitalwertMonodiFrontendBundle(),
            new Digitalwert\Symfony2\Bundle\Monodi\ApiBundle\DigitalwertMonodiApiBundle(),
            new Digitalwert\Symfony2\Bundle\Monodi\ClientBundle\DigitalwertMonodiClientBundle(),
            new Digitalwert\Symfony2\Bundle\Monodi\AdminBundle\DigitalwertMonodiAdminBundle(),
            
            new Digitalwert\Symfony2\Bundle\Monodi\UserBundle\DigitalwertMonodiUserBundle(),
            new Digitalwert\Symfony2\Bundle\Monodi\OAuthServerBundle\DigitalwertMonodiOAuthServerBundle(),
            
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            //$bundles[] = new Acme\DemoBundle\AcmeDemoBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            
            $bundles[] = new Digitalwert\Symfony2\Bundle\Monodi\DummyBundle\DigitalwertMonodiDummyBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
