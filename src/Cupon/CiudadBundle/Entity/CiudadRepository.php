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
}