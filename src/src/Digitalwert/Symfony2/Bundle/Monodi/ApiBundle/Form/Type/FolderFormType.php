<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\ApiBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * FormularType für den Ordnerzugriff
 *
 * @author digitalwert
 */
class FolderFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder->add('title');        
    }
    
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Folder',
            'csrf_protection'   => false,
        ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'folder';
    }   
}

