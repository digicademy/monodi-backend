<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('filename')
            ->add('rev')
            ->add('title')
            ->add('createdAt')
            ->add('editedAt')
            ->add('updatedAt')
            ->add('processNumber')
            ->add('editionNumber')
            ->add('owner')
            ->add('group')
            ->add('editor')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Document'
        ));
    }

    public function getName()
    {
        return 'digitalwert_symfony2_bundle_monodi_commonbundle_documenttype';
    }
}
