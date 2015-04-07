<?php

namespace Cupon\OfertaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function ayudaAction()
    {
//         return new Response('<h1>Ayuda</h1>');
        return $this->render('OfertaBundle:Default:ayuda.html.twig');
    }
    
}
