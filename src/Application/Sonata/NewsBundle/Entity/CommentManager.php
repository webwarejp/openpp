<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Application\Sonata\NewsBundle\Entity;

use Sonata\CoreBundle\Model\BaseEntityManager;
use Sonata\CoreBundle\Model\ManagerInterface;
use Sonata\NewsBundle\Model\CommentInterface;
use Doctrine\Common\Persistence\ManagerRegistry;

use Sonata\NewsBundle\Model\CommentManagerInterface;
use Sonata\NewsBundle\Model\PostInterface;
use Sonata\NewsBundle\Entity\CommentManager AS BaseCommentManager;

use Sonata\DatagridBundle\Pager\Doctrine\Pager;
use Sonata\DatagridBundle\ProxyQuery\Doctrine\ProxyQuery;

class CommentManager extends BaseCommentManager implements CommentManagerInterface
{

    /**
     * Update the number of comment for a comment
     *
     * @param null|\Sonata\NewsBundle\Model\PostInterface $post
     *
     * @return void
     */
    public function updateCommentsCount(PostInterface $post = null)
    {
        $commentTableName = $this->getObjectManager()->getClassMetadata($this->getClass())->table['name'];
        $postTableName    = $this->getObjectManager()->getClassMetadata($this->postManager->getClass())->table['name'];

        $this->getConnection()->beginTransaction();
        $this->getConnection()->query(sprintf('UPDATE %s SET comments_count = 0' , $postTableName));
        $this->getConnection()->query(sprintf('UPDATE %s u SET comments_count = (SELECT count(*) FROM %s AS c WHERE c.post_id = u.id AND c.status = 1 GROUP BY c.post_id)'
            , $postTableName, $commentTableName));

        $this->getConnection()->commit();
    }
}
