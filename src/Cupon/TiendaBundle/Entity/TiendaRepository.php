<?php 
namespace Cupon\TiendaBundle\Entity;

use Doctrine\ORM\EntityRepository;

class TiendaRepository extends EntityRepository
{
    /**
     * Devuelve las últimas ofertas publicadas por la tienda indicada.
     * @param int $tienda_id El id de la tienda
     * @param int $cantidad (Opcional) La cantidad de ofertas que se quiere recuperar
     */
    public function findUltimasOfertasPublicadas($tienda_id, $cantidad = 10)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select(array('o', 't'))
           ->from('OfertaBundle:Oferta', 'o')
           ->join('o.tienda', 't')
           ->where('o.tienda = :tienda_id')
           ->andWhere('o.revisada = true')
           ->andWhere('o.fechaPublicacion < :fecha')
           ->orderBy('o.fechaExpiracion', 'DESC')
           ->setParameter('tienda_id', $tienda_id)
           ->setParameter('fecha', new \DateTime('today'))
           ->setMaxResults($cantidad);
        
        return $qb->getQuery()->getResult();
    }
    
    /**
     * Devuelve una lista de tiendas que están en la misma ciudad que la tienda indicada.
     * @param unknown $tienda Tienda desde la que se quiere saber qué tiendas cercanas tiene.
     * @param unknown $ciudad La ciudad de la que se desea la lista de tiendas.
     * @param number $cantidad (Opcional) El número de tiendas deseadas.
     */
    public function findCercanas($tienda, $ciudad, $cantidad = 5)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select(array('t', 'c'))
           ->from('TiendaBundle:Tienda', 't')
           ->join('t.ciudad', 'c')
           ->where('c.slug = :ciudad')
           ->andWhere('t.slug != :tienda')
           ->setParameter('ciudad', $ciudad)
           ->setParameter('tienda', $tienda)
           ->setMaxResults($cantidad);
        return $qb->getQuery()->getResult();
    }
}

?>