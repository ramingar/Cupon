<?php

namespace Cupon\OfertaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function portadaAction()
    {
        $em = $this->getDoctrine()->getManager();
        $oferta = $em->getRepository('OfertaBundle:Oferta')->findOneBy(array(
            'ciudad' => $this->container->getParameter('cupon.ciudad_por_defecto'),
            'fechaPublicacion' => new \DateTime('today - 1 sec')
        ));
        
        return $this->render(
            'OfertaBundle:Default:portada.html.twig',
            array('oferta'=>$oferta)
        );
    }
    
}
