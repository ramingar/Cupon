<?php
namespace Cupon\CiudadBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Cupon\OfertaBundle\Util\Util;

// La anotación @ORM\Table(name="Ciudad") no hace nada ya que Doctrine2 va a coger el
// nombre de la clase -que es Ciudad-. Simplemente, lo he añadido para ver cómo podría
// haber cambiado de forma fácil el nombre de la tabla que creará Doctrine2.
/**
* @ORM\Entity
* @ORM\Table(name="Ciudad")
*/
class Ciudad
{
    /** 
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue
    */
    protected $id;

    /** @ORM\Column(type="string", length=100) */
    protected $nombre;
    
    /** @ORM\Column(type="string", length=100) */
    protected $slug;    // el nombre de la ciudad preparado para incluirlo en una url

    public function getId()
    {
        return $this->id;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        $this->slug = Util::getSlug($nombre);

        return $this;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function __toString()
    {
        return $this->getNombre();
    }

}

