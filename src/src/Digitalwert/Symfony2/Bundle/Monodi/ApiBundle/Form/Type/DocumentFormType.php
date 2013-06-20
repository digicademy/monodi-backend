<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\ApiBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of DocumentFormType
 *
 * @author digitalwert
 */
class DocumentFormType 
  extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
//        $builder->add('title');  
        $builder->add('filename');  
        $builder->add('content');
        
        $builder->add('folder', 'entity', array(
            'class' => 'Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Folder',
            'query_builder' => function(EntityRepository $er) {
//                return $er->createQueryBuilderForDocumentFormTypeChoice();
                return $er->createQueryBuilder('f')
                    ->where('f.lvl >= 2')
                    ->orderBy('f.slug', 'ASC')
                ;
            },
            'invalid_message' => 'Angegebener Ordner kann nicht verwendet werden.',
        ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Entity\Document',
            'csrf_protection'   => false,
        ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'document';
    }   
}

