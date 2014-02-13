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
        $ciudades = $em->getRepository('CiudadBundle:Ciudad')->findAll();

        return $this->render(
            'CiudadBundle:Default:listaCiudades.html.twig', 
            array('ciudades' => $ciudades, 'ciudadActual' => $ciudad)
        );
    }
}
