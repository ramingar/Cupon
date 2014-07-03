<?php
namespace Cupon\OfertaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends Controller
{
    /**
    * Muestra la portada que corresponde a la ciudad que se le pasa por parámetro.
    * @param string $ciudad El slug de la ciudad de la que se quiere ver la portada.
    */
    public function portadaAction($ciudad = null)
    {
        /* El siguiente código ya no es necesario.                                              */
        /* En el archivo app/config/routing.yml está contemplada la posibilidad de que el       */
        /* usuario no indique la ciudad en la url (lo cual es lógico). Véase la ruta _portada.  */
        /*
        // Si desde la url no se pasa una ciudad, obtenemos la ciudad por defecto y
        // redirigimos a la página <webcupon>/{ciudad}
        // Los parámetros globales de la aplicación se encuentran en app/config/config.yml
        if ($ciudad == null){
            $ciudad = $this->container->getParameter('cupon.ciudad_por_defecto');

            return new RedirectResponse($this->generateUrl('portada', array('ciudad' => $ciudad)));
        }
        */

        $em = $this->getDoctrine()->getManager();
        $oferta = $em->getRepository('OfertaBundle:Oferta')->findOfertaDelDia($ciudad);

        if (!$oferta) {
            throw $this->createNotFoundException(
                'No se ha encontrado la oferta del día en la ciudad seleccionada.'
            );
        }

        return $this->render(
            'OfertaBundle:Default:portada.html.twig',
            array('oferta' => $oferta)
        );
    }

    /**
    * Muestra la página del detalle para la oferta y ciudad que se le pasa por parámetro.
    * @param string $ciudad El slug de la ciudad donde está la oferta.
    * @param string $slug El slug de la oferta que se desea ver en detalle.
    */
    public function ofertaAction($ciudad, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $oferta = $em->getRepository('OfertaBundle:Oferta')->findOferta($ciudad, $slug);
        

        if (!$oferta) {
            throw $this->createNotFoundException('No existe la oferta');
        }
        
        $relacionadas = $em->getRepository('OfertaBundle:Oferta')->findRelacionadas($ciudad);

        return $this->render(
            'OfertaBundle:Default:detalle.html.twig', 
            array('oferta' => $oferta, 'relacionadas' => $relacionadas)
        );
    }
}
