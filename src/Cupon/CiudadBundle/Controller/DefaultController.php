<?php

namespace Cupon\CiudadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends Controller
{
	/**
	* Cambia a una ciudad determinada (cuando se selecciona desde la lista de ciudades).
	* @param string $ciudad La ciudad a la que se debe redirigir.
	*/
    public function cambiarAction($ciudad)
    {
        return new RedirectResponse(
            $this->generateUrl( 'portada', array('ciudad' => $ciudad))
        );
    }

    /**
    * Devuelve el listado de todas las ciudades.
    * @param string Slug de la ciudad que está actualmente seleccionada.
    * @return La lista de ciudades de la bbdd y la que actualmente está seleccionada.
    */
    public function listaCiudadesAction($ciudad)
    {
        $em = $this->getDoctrine()->getManager();
        //$ciudades = $em->getRepository('CiudadBundle:Ciudad')->findAll();
        $ciudades = $em->getRepository('CiudadBundle:Ciudad')->findTodosAlfabetico();

        return $this->render(
            'CiudadBundle:Default:listaCiudades.html.twig', 
            array('ciudades' => $ciudades, 'ciudadActual' => $ciudad)
        );
    }
    
    /**
     * Devuelve las cinco ofertas más recientes de la ciudad y un listado con las 
     * cinco ciudades más cercanas a la ciudad activa.
     * @param string El slug de la ciudad para la que se quiere la información.
     */
    public function recientesAction($ciudad)
    {
        $em = $this->getDoctrine()->getManager();
        $ciudad    = $em->getRepository('CiudadBundle:Ciudad')->findOneBySlug($ciudad);
        $cercanas  = $em->getRepository('CiudadBundle:Ciudad')->findCercanas ($ciudad->getId(), 5);
        $recientes = $em->getRepository('OfertaBundle:Oferta')->findRecientes($ciudad->getId(), 5);
        
        return $this->render('CiudadBundle:Default:recientes.html.twig',
            array(
                'ciudad'    => $ciudad,
                'cercanas'  => $cercanas,
                'ofertas' => $recientes
            )
        );
    }
}
