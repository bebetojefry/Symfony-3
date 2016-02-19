<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Lsw\ApiCallerBundle\Call\HttpGetJson;
use AppBundle\Form\ApiType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig');
    }
    
    /**
     * @Route("/api", name="api", options={"expose"=true})
     */
    public function apiAction(Request $request){
        $output = $this->get('api_caller')->call(new HttpGetJson($this->getParameter('api_endpoint'), array('username' => 'leadership01' ,'appname' => 'CHARGE_CODE_REQUEST')));
        $serializer = $this->get('jms_serializer');
        $apis = $serializer->deserialize(json_encode($output), 'ArrayCollection<AppBundle\Modal\Api>', 'json');
        $api = $apis[0];

        $form = $this->createForm('AppBundle\Form\ApiType', $api);
        $code = 'FORM';
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isValid()){
                $code = "REFRESH";
                $api = $form->getData();
                $output = $serializer->serialize($api, 'json');
            } else {
                $code = "FORM_REFRESH";
            }
        }
        
        $body = $this->renderView('default/api.html.twig',
            array('form' => $form->createView())
        );
        
        return new Response(json_encode(array('code' => $code, 'data' => $body)));
    }
}
