<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VersionControlSystemReposType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password')
            ->add('uri')
            ->add('type')
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
        return 'digitalwert_symfony2_bundle_monodi_commonbundle_versioncontrolsystemrepostype';
    }
}
