<?php
/**
 * Created by PhpStorm.
 * User: taniguchi
 * Date: 8/12/15
 * Time: 18:14
 */
namespace Application\FOS\OAuthServerBundle\Form\Model;

class Authorize
{
    protected $allowAccess;

    public function getAllowAccess()
    {
        return $this->allowAccess;
    }

    public function setAllowAccess($allowAccess)
    {
        $this->allowAccess = $allowAccess;
    }
}
