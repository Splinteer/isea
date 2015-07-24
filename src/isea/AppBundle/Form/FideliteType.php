<?php

namespace isea\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FideliteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('raison', 'text', array(
                'label' => 'Raison sociale',
                'required' => true,
                'attr'=>array('placeholder' => 'Raison sociale')))
            ->add('adresse', 'text', array(
                'required' => true,
                'attr'=>array('placeholder' => 'Adresse')))
            ->add('cp', 'text', array(
                'label' => 'Code postale',
                'required' => true,
                'attr'=>array('placeholder' => 'Code postale')))
            ->add('ville', 'text', array(
                'required' => true,
                'attr'=>array('placeholder' => 'Ville')))
            ->add('telephone', 'text', array(
                'label' => 'Téléphone',
                'required' => true,
                'attr'=>array('placeholder' => 'Téléphone')))
            ->add('email', 'email', array(
                'label' => 'Adresse email',
                'required' => true,
                'attr'=>array('placeholder' => 'Adresse email')))
            ->add('fax', 'text', array(
                'attr'=>array('placeholder' => 'Fax')))
            ->add('cgu', 'checkbox', array(
                'label' => "Accepter les CGU",
                'required' => true,))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'isea\AppBundle\Entity\Fidelite'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'isea_appbundle_fidelite';
    }
}
