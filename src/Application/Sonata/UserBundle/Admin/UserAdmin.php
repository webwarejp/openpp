<?php

namespace Application\Sonata\UserBundle\Admin;

use Sonata\UserBundle\Admin\Entity\UserAdmin as BaseUserAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class UserAdmin extends BaseUserAdmin
{
    protected $baseRouteName = 'admin_application_sonata_user';
    protected $baseRoutePattern = 'application/user';

    /**
     * {@inheritdoc}
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->andWhere(
            $query->expr()->not($query->expr()->like($query->getRootAlias() . '.roles', ':param'))
        );
        $query->setParameter('param', '%ADMIN%');

        return $query;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        ->with('General')
        ->add('username')
        ->add('email')
        ->add('plainPassword', 'text', array(
                'required' => (!$this->getSubject() || is_null($this->getSubject()->getId()))
        ))
        ->end()
        ->with('Groups')
        ->add('groups', 'sonata_type_model', array(
                'required' => false,
                'expanded' => true,
                'multiple' => true
        ))
        ->end()
        ->with('Profile')
        ->add('dateOfBirth', 'birthday', array('required' => false))
        ->add('firstname', null, array('required' => false))
        ->add('lastname', null, array('required' => false))
        ->add('website', 'url', array('required' => false))
        ->add('biography', 'text', array('required' => false))
        ->add('gender', 'sonata_user_gender', array(
                'required' => true,
                'translation_domain' => $this->getTranslationDomain()
        ))
        ->add('locale', 'locale', array('required' => false))
        ->add('timezone', 'timezone', array('required' => false))
        ->add('phone', null, array('required' => false))
        ->end()
        ->with('Social')
        ->add('facebookUid', null, array('required' => false))
        ->add('facebookName', null, array('required' => false))
        ->add('twitterUid', null, array('required' => false))
        ->add('twitterName', null, array('required' => false))
        ->add('gplusUid', null, array('required' => false))
        ->add('gplusName', null, array('required' => false))
        ->end()
        ;

        $formMapper
        ->with('Security')
        ->add('token', null, array('required' => false))
        ->add('twoStepVerificationCode', null, array('required' => false))
        ->end()
        ;
    }
}
