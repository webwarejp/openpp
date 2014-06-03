<?php

namespace Acme\HelpBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array('label' => 'お名前', 'required' => true))
            ->add('mailaddress', 'repeated', array(
                'type' => 'email',
                'invalid_message' => 'The password fields must match.',
                'options' => array('attr' => array('class' => 'password-field')),
                'required' => true,
                'first_options'  => array('label' => 'メールアドレス'),
                'second_options' => array('label' => 'Repeat メールアドレス'),
            ))
            ->add('body', 'textarea', array('label' => 'お問い合わせ', 'required' => true))
            ->add('gender', 'choice', array(
            'choices'   => array('m' => 'Male', 'f' => 'Female'),
            'required'  => false,
            'label' => '性別',
            'expanded' => true,
            'multiple' => false,
            'empty_value' => false ))
            ->add('availability', 'choice', array(
                'choices'   => array(
                    'morning'   => 'Morning',
                    'afternoon' => 'Afternoon',
                    'evening'   => 'Evening',
                ),
                'multiple'  => true,
            ))
            ->add('public', 'checkbox', array(
                'label'     => '個人情報の取り扱いに同意する',
                'required'  => false,
                'mapped' => false));

        ;

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\HelpBundle\Entity\Contact'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'acme_helpbundle_contact';
    }
}
