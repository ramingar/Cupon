<?php 
namespace Cupon\OfertaBundle\Twig\Extension;

class CuponExtension extends \Twig_Extension
{
    public function getName()
    {
        return 'cupon';
    }
    
    public function getFunctions()
    {
        return array(
            'descuento' => new \Twig_Function_Method($this, 'descuento')
        );
    }
    
    public function getFilters() 
    {
        return array(
            'mostrar_como_lista' => new \Twig_Filter_Method($this, 'mostrarComoLista', 
                array('is_safe' => array('html')))
        );
    }

    
    /**
     * Devuelve el porcentaje aplicado de descuento según el precio 
     * rebajado del artículo.
     * @param int $precio El precio del artículo rebajado.
     * @param int $descuento La cantidad de dinero que te ahorras.
     * @param int $decimales (Opcional) El número de decimales con el que se muestra el descuento.
     */
    public function descuento($precio, $descuento, $decimales = 0)
    {
        if (!is_numeric($precio) || !is_numeric($descuento)) {
            return '-';
        }
        
        if ($descuento == 0 || $descuento == null) {
            return '0%';
        }
        
        $precio_original = $precio + $descuento;
        $porcentaje = ($descuento / $precio_original) * 100;
        
        return '-' . number_format($porcentaje, $decimales) . '%'; 
    }
    
    /**
     * Filtro para mostrar un valor como una lista.
     * @param string $value El valor que se quiere mostrar como una lista.
     * @param string $tipo (Opcional) Qué tipo de lista se quiere mostrar. Por defecto 'ul'.
     */
    public function mostrarComoLista($value, $tipo='ul')
    {
        $html  = "<" . $tipo . ">\n";
        $html .= "    <li>" . str_replace("\n", "</li>\n <li>", $value) . "</li>\n";
        $html .= "</" . $tipo . ">\n";

        return $html;
    }
}

?>