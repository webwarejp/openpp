<?php
/**
 * This file is part of the <name> project.
 *
 * (c) <yourname> <youremail>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Openpp\OAuthServerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 *
 */
class ApplicationOpenppOAuthServerBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'OpenppOAuthServerBundle';
    }
}