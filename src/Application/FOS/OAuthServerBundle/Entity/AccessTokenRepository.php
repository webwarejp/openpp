<?php
namespace Application\FOS\OAuthServerBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Query\Expr\Join;
use Application\FOS\OAuthServerBundle\Entity\AccessToken;

/**
 * AccessTokenRepository
 *
 */
class AccessTokenRepository extends EntityRepository
{
    public function findByClientAndToken($access_token, $client_id, $client_secret)
    {
        list($id, $random_id) = explode('_', $client_id);

        if($id == null
        || $random_id == null
        || $client_secret == null)
        {
            return null;
        }

        $params = [
            'token'       => $access_token
            , 'id' => $id
            , 'random_id' => $random_id
            , 'secret'    => $client_secret
        ];

        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('fuu.id, oat.expiresAt')
            ->from('Application\FOS\OAuthServerBundle\Entity\AccessToken' , 'oat')
            ->innerJoin('oat.client', 'oc')
            ->innerJoin('oat.user'  , 'fuu')
            ->where('oat.token       = :token')
            ->andwhere('oc.id        = :id')
            ->andWhere('oc.randomId = :random_id')
            ->andWhere('oc.secret    = :secret')
            ->setParameters($params);
        return $qb->getQuery()->getOneOrNullResult();
    }

}