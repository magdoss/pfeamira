<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/backend",name="backend_index")
     */
    public function dashbordAction()
    {
        return $this->render('@App/Dashbord/index.html.twig');
    }

    /**
     * @Route("/")
     */
    public function defaultAction()
    {

        return $this->redirectToRoute("backend_index");
    }

}
