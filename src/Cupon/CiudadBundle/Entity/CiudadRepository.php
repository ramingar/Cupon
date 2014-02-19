<?php
namespace Cupon\CiudadBundle\Entity;

use Doctrine\ORM\EntityRepository;

class CiudadRepository extends EntityRepository
{
	/**
	* Devuelve todos los registros de la tabla Ciudad ordenados por
	* orden alfabético según el campo slug.
	*/
    public function findTodosAlfabetico() 
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('c')
           ->from('CiudadBundle:Ciudad', 'c')
           ->orderBy('c.slug', 'ASC');
        return $qb->getQuery()->getResult();
    }
    
    /**
     * Devuelve las ciudades cercanas a la activa.
     * (En realidad devuelve cinco ciudades cualesquiera que no sean la activa).
     * @param int $ciudad_id El id de la ciudad activa.
     * @param int $cuantas El número de ciudades cercanas que se desean.
     */
    public function findCercanas($ciudad_id, $cuantas)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('c')
           ->from('CiudadBundle:Ciudad', 'c')
           ->where('c.id != :ciudad_id')
           ->orderBy('c.nombre', 'ASC')
           ->setParameter('ciudad_id', $ciudad_id)
           ->setMaxResults($cuantas);
        
        return $qb->getQuery()->getResult();
    }
}