<?php

namespace Cupon\OfertaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function portadaAction($ciudad = null)
    {
        
        /*
         * Si la ciudad no es pasada como parámetro,
         * este código redirige a la portada con la ciudad por defecto
         * asignada como parámetro.
         * (Comentado porque la redirección se ejecuta desde el enrutado). 

        if (null == $ciudad) {
            $ciudad = $this->container
            ->getParameter('cupon.ciudad_por_defecto');
        
            return new RedirectResponse(
                $this->generateUrl('portada', array('ciudad' => $ciudad))
            );
        }
        */
        
        $em = $this->getDoctrine()->getManager();
        $oferta = $em->getRepository('OfertaBundle:Oferta')->findOneBy(array(
            'ciudad' => $ciudad,
            'fechaPublicacion' => new \DateTime('today - 1 sec')
        ));
        
        if (!$oferta) {
            throw $this->createNotFoundException(
                'No se ha encontrado la oferta del día en la ciudad seleccionada'
            );
        }
        
        return $this->render(
            'OfertaBundle:Default:portada.html.twig',
            array('oferta'=>$oferta)
        );
    }
    
}
