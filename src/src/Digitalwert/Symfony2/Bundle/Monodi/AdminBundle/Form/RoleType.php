<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RoleType 
  extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
    }
    
    public function getName() {
        return 'digitalwert_symfony2_bundle_monodi_adminbundle_roletype';
    }
}
