<?php

/**
 * Created by PhpStorm.
 * User: taniguchi
 * Date: 8/12/15
 * Time: 18:03
 */
namespace Application\FOS\OAuthServerBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AuthorizeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('allowAccess', 'checkbox', array(
            'label' => 'Allow access',
        ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\FOS\OAuthServerBundle\Form\Model\Authorize',
        ));
    }

    public function getName()
    {
        return 'application_fos_oauth_server_authorize';
    }
}
