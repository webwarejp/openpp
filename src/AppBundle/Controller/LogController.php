<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class LogController extends Controller
{
    /**
     * @Route("/log")
     * @Template()
     */
    public function logAction()
    {
        // retrieve the notification backend
        $backend = $this->container->get('sonata.notification.backend');
        
        // create and publish a message
        $backend->createAndPublish('logger', array(
                'level' => 'info',
                'message' => 'hello'
        ));

        return array(
                // ...
            );
    }

}
