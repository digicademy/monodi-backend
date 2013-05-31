<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\ApiBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Klasse für das Formular zur Validurung des Nutzer-Profils
 *
 * @author digitalwert
 */
class ProfileFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder->add('email', null, array(
            'description' => 'Nutzer-Email',
        ));        
        $builder->add('lastname');
        $builder->add('firstname');
        $builder->add('title');
        $builder->add('salutation');
    }
    
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\User',
            'csrf_protection'   => false,
        ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'profile';
    }   
}

