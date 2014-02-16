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
                array('is_safe' => array('html'))),
            'cuenta_atras' => new \Twig_Filter_Method($this, 'cuentaAtras', 
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
    
    /**
     * Visualiza una cuenta atrás (en javascript) para llegar a un tiempo dado.
     * @param date $fecha Tiempo sobre el que se efectuará la cuenta atrás.
     */
    public function cuentaAtras($fecha)
    {
        $fecha = $fecha->format('Y,') . ($fecha->format('m')-1) . $fecha->format(',d,H,i,s');
        $html = <<<EOJ
        <script type="text/javascript">
            function muestraCuentaAtras()
            {
                var cuentaAtras = '';
                var horas, minutos, segundos;
                var ahora = new Date();
                var fechaExpiracion = new Date($fecha);
                var falta = Math.floor((fechaExpiracion.getTime() - ahora.getTime()) / 1000);

                if (falta < 0) {
                    cuentaAtras = '-';
                }
                else{
                    horas = Math.floor(falta/3600);
                    falta = falta % 3600;
                    minutos = Math.floor(falta/60);
                    falta = falta % 60;
                    segundos = Math.floor(falta);

                    cuentaAtras = (horas    < 10 ? '0' + horas    : horas   ) + 'h'
                                + (minutos  < 10 ? '0' + minutos  : minutos ) + 'm'
                                + (segundos < 10 ? '0' + segundos : segundos) + 's';

                    setTimeout('muestraCuentaAtras()', 1000);
                }
                document.getElementById('tiempo').innerHTML = 
                    '<strong>Faltan: </strong>' + cuentaAtras;
            }
            muestraCuentaAtras();
        </script>
EOJ;
        
        return $html;
    }
}
