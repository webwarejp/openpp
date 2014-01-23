<?php

namespace Application\Sonata\UserBundle\Admin;

use Sonata\UserBundle\Admin\Entity\UserAdmin as BaseUserAdmin;

class AdminUserAdmin extends BaseUserAdmin
{
    protected $baseRouteName = 'admin_application_sonata_adminuser';
    protected $baseRoutePattern = 'application/adminuser';
    
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->andWhere(
                $query->expr()->like($query->getRootAlias() . '.roles', ':param')
        );
        $query->setParameter('param', '%ADMIN%');
    
        return $query;
    }
}