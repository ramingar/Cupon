<?php

namespace Cupon\TiendaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
	/**
	 * A partir de la ciudad y del nombre de la tienda, muestra la
	 * página de esa tienda.
	 * @param string $ciudad El slug de la ciudad en la que se encuentra.
	 * @param string $tienda El slug de la tienda.
	 */
    public function portadaAction($ciudad, $tienda)
    {
        $em = $this->getDoctrine()->getManager();
        $datosCiudad   = $em->getRepository('CiudadBundle:Ciudad')->findOneBySlug($ciudad);
        $datosTienda   = $em->getRepository('TiendaBundle:Tienda')->findOneBy(
                             array('ciudad' => $datosCiudad->getId(), 'slug' => $tienda)
                         );
        
        if (!$datosTienda){
            throw $this->createNotFoundException('No existe esta tienda');
        }

        $ofertasTienda = $em->getRepository('TiendaBundle:Tienda')
                            ->findUltimasOfertasPublicadas($datosTienda->getId());

        $cercanas = $em->getRepository('TiendaBundle:Tienda')->findCercanas(
                        $datosTienda->getSlug(),
                        $datosTienda->getCiudad()->getSlug(),
                        5
                    );

        return $this->render('TiendaBundle:Default:portada.html.twig', array(
                             'tienda'   => $datosTienda,
                             'ofertas'  => $ofertasTienda,
                             'cercanas' => $cercanas
                      ));
    } 
}
