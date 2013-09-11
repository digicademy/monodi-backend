<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('roles', 
              null,
              array(
                'allow_add' => true,
                'allow_delete' => true, // should render default button, change text with widget_remove_btn
                'prototype' => true,
                'widget_add_btn' => array('label' => "add now", 'attr' => array('class' => 'btn btn-primary')),
                'show_legend' => false, // dont show another legend of subform
                'options' => array( // options for collection fields
                  'label_render' => false,
                  'widget_control_group' => false,
                  'widget_remove_btn' => array('label' => "remove now", 'attr' => array('class' => 'btn')),
                  'attr' => array('class' => 'input-large'),
                )
              )
            )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Group'
        ));
    }

    public function getName()
    {
        return 'digitalwert_monodi_admin_grouptype';
    }
}
