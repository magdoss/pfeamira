<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;




class SmsController extends Controller
{
    /**
     * @Route("/backend/sms",name="sms_page")
     */
    public function indexAction(Request $request)
    {


        return $this->render('@App/Sms/index.html.twig'

        );
    }
    /**
     * @Route("/backend/sms",name="sendsms_route")
     */
    public function sendsmsAction(Request $request)
    {
        $mobile=$request->get('mobile');
        $message=$request->get('message');
        $url='';





    }




    /**
     * @Route("/backend/sms/add",name="sms_add_page")
     */
    public function addAction()
    {



        return $this->render('@Backend/Sms/add.html.twig');
    }





}