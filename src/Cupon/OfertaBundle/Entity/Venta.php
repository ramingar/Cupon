<?php
namespace Cupon\OfertaBundle\Entity;
 
use Doctrine\ORM\Mapping as ORM;
 
/** @ORM\Entity */
class Venta
{
    /** @ORM\Column(type="datetime") */
    protected $fecha;
 
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Cupon\OfertaBundle\Entity\Oferta")
     */
    protected $oferta;
 
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Cupon\UsuarioBundle\Entity\Usuario")
     */
    protected $usuario;
 
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
        return $this;
    }
 
    public function getFecha()
    {
        return $this->fecha;
    }
 
    public function setOferta(\Cupon\OfertaBundle\Entity\Oferta $oferta)
    {
        $this->oferta = $oferta;
        return $this;
    }
 
    public function getOferta()
    {
        return $this->oferta;
    }
 
    public function setUsuario(\Cupon\UsuarioBundle\Entity\Usuario $usuario)
    {
        $this->usuario = $usuario;
        return $this;
    }
 
    public function getUsuario()
    {
        return $this->usuario;
    }
}