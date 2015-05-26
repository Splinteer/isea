<?php

namespace isea\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('mail', "email")
            ->add('password', "password")
        ;
        if(!$options['public']){
            $builder
                ->add('admin', 'choice', array(
            'expanded' => true,
            'choices' => array('1' => 'Administrateur', '0' => 'Utilisateur'),
            'data' => '0',
        ))
            ->add('fonction')
            ->add('photo', 'url')
            ;
        }
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'isea\AppBundle\Entity\User',
            'public' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'isea_appbundle_user';
    }
}
