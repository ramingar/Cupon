<?php
namespace Cupon\OfertaBundle\Util;

/**
* 
*/
class Util
{
    private $codificacion;

    public function __construct($codificacion = 'utf-8')
    {
        $this->codificacion = $codificacion;
    }

    static public function getSlug($cadena, $separador = '-')
    {
        // Código copiado de http://cubiq.org/the-perfect-php-clean-url-generator
        $slug = iconv($codificacion, 'ASCII//TRANSLIT', $cadena);
        $slug = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $slug);
        $slug = strtolower(trim($slug, $separador));
        $slug = preg_replace("/[\/_|+ -]+/", $separador, $slug);

        return $slug;
    }
 
    public function setCodificacion($codificacion)
    {
        $this->codificacion = $codificacion;
    }
}
