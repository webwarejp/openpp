<?php

namespace Application\FOS\OAuthServerBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use OAuth2\OAuth2;

class ClientAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('publicId', 'doctrine_orm_string')
            ->add('allowedGrantTypes')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('name')
            ->add('redirectUris')
            ->add('allowedGrantTypes')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('redirectUris', 'sonata_type_native_collection', array('type' => 'url', 'allow_add' => true, 'allow_delete' => true, 'by_reference' => false))
            ->add('allowedGrantTypes', 'sonata_type_native_collection', array('type' => 'choice', 'allow_add' => true, 'allow_delete' => true, 'by_reference' => false
                ,'options'  => array(
                    'choices'   => array(
                        OAuth2::GRANT_TYPE_AUTH_CODE                    => "Authorization Code Grant Flow"
                        , OAuth2::GRANT_TYPE_IMPLICIT                   => "Implicit Grant Flow"
                        , OAuth2::GRANT_TYPE_USER_CREDENTIALS           => "Resource Owner Password Credentials Grant Flow"
                        , OAuth2::GRANT_TYPE_CLIENT_CREDENTIALS         => "Client Credentials Grant Flow"
                        )
                    )
                )
            );
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name')
            ->add('redirectUris')
            ->add('publicId')
            ->add('secret')
            ->add('allowedGrantTypes')
        ;
    }
}
