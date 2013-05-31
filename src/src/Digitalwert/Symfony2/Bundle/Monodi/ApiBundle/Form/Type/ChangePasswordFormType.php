<?php
/**
 * Datei für die Klasse {@link ChangePasswordFormType}
 *
 * LICENSE: Einige Lizenz Informationen
 *
 * @category   Symfony2
 * 
 * @copyright  Copyright (c) 2005-2013 digitalwert
 * @license    http://www.digitalwert.de/license
 * @version    GIT: $Id:$
 */
namespace Digitalwert\Symfony2\Bundle\Monodi\ApiBundle\Form\Type;

use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;

/**
 * Klasse zur Validierung beim Passwordänderen über die API
 *
 * @see        Link zu einer für das Verständnis des Codes notwendigen Dokumentation
 *
 * @author     Kay Petzold <kay.petzold@digitalwert.de>
 * @category   Symfony2
 * @copyright  Copyright (c) 2009-2013 digitalwert (http://www.digitalwert.de)
 * @license    http://www.digitalwert.de/license   
 * @link       http://wiki.intern/Kategorie:${Projekt}
 * @version    1.0
 * @since      1.0
 */
class ChangePasswordFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('current_password', 'password', array(
            'label' => 'form.current_password',
            'description' => 'form.current_password',
            'translation_domain' => 'FOSUserBundle',
            'mapped' => false,
            'constraints' => new UserPassword(),
        ));
        $builder->add('new', 'password', array(
            'label' => 'form.new_password',
            'description' => 'form.new_password',
            'translation_domain' => 'FOSUserBundle',
            'constraints' => new UserPassword(),
        ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Digitalwert\Symfony2\Bundle\Monodi\ApiBundle\Form\Model\ChangePassword',
            'intention'  => 'change_password',
            'csrf_protection'   => false,
        ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'password';
    }
}
