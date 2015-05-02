<?php
namespace Cupon\OfertaBundle\Entity;

use Doctrine\ORM\EntityRepository;

class OfertaRepository extends EntityRepository
{
    public function findOfertaDelDia($ciudad)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery(
            'SELECT o, c, t 
            FROM OfertaBundle:Oferta o 
            JOIN o.ciudad c 
            JOIN o.tienda t
            WHERE c.slug = :ciudad 
            AND o.fechaPublicacion = :fechaPublicacion 
            AND o.revisada = true 
            ORDER BY o.fechaPublicacion DESC'
        );
        $consulta->setParameters(array(
            'ciudad' => $ciudad,
            'fechaPublicacion' => new \DateTime('today - 1 sec')
        ));
        $consulta->setMaxResults(1);
        
        return $consulta->getSingleResult();
        
    }
}