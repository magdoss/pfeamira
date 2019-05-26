<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
//use AppBundle\Entity\Formation;



class ServiceController extends Controller
{
    /**
     * @Route("/backend/service",name="service_page")
     */
    public function indexAction()
    {


        return $this->render('@App/Service/index.html.twig'

        );
    }


    /**
     * @Route("/backend/service/add",name="service_add_page")
     */
    public function addAction()
    {


            return $this->render('@App/Service/add.html.twig', array());


    }


}