<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\VersionControlSystemRepos;

/**
 * 
 */
class VersionControlSystemReposType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password')
            ->add('uri')
//            ->add('type', 'choise', array(
//              'choices' => array(
//                VersionControlSystemRepos::TYPE_GIT => 'Git', 
//              ),
//            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\VersionControlSystemRepos'
        ));
    }

    public function getName()
    {
        return 'digitalwert_symfony2_bundle_monodi_adminbundle_versioncontrolsystemrepostype';
    }
}
