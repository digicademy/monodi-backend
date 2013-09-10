<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
//            ->add('usernameCanonical')
            ->add('email')
//            ->add('emailCanonical')
//            ->add('salt')
            ->add('plainPassword', 'password', 
              array(
                'label' => 'Password',
                'required' => false
              )
            )
            ->add('title')
            ->add('salutation')
            ->add('firstname')
            ->add('lastname')
            ->add('enabled')
//            ->add('lastLogin')
            ->add('locked',null, array('required' => false))
//            ->add('expired')
//            ->add('expiresAt', 'date', 
//              array(
//                'widget' => 'single_text', 
//                'datepicker' => true
//              )
//            )
//            ->add('confirmationToken')
//            ->add('passwordRequestedAt')
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
//            ->add('credentialsExpired')
//            ->add('credentialsExpireAt')
            ->add('groups')
//            ->add('versionControlSystemRepos', 
//              new VersionControlSystemReposType(), 
//              array(
//                'label' => 'vcs' 
//              )
//            )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\User',
            'cascade_validation' => true,
        ));
    }

    public function getName()
    {
        return 'digitalwert_symfony2_bundle_monodi_adminbundle_usertype';
    }
}
