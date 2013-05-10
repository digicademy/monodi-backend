<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\OAuthServerBundle\Form\Type;  
  
use Symfony\Component\Form\FormBuilderInterface;  
use Symfony\Component\Form\AbstractType;  
  
class AuthorizeFormType extends AbstractType  
{  
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)  
    {  
        $builder->add('allowAccess', 'checkbox', array(  
            'label' => 'Allow access',  
        ));  
    }
    
    /**
     * {@inheritdoc}
     */
    public function getDefaultOptions(array $options)  
    {  
        return array('data_class' => 'Digitalwert\Symfony2\Bundle\Monodi\OAuthServerBundle\Form\Model\Authorize');  
    }  
    
    /**
     * {@inheritdoc}
     */
    public function getName()  
    {  
        return 'digitalwert_monodi_oauth_server_auth';  
    }  
      
} 
