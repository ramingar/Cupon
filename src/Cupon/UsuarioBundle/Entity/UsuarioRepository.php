<?php
namespace Cupon\UsuarioBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UsuarioRepository extends EntityRepository
{
    public function findTodasLasCompras($usuario)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select(array('v', 'o', 't'))
           ->from('OfertaBundle:Venta', 'v')
           ->join('v.oferta', 'o')
           ->join('o.tienda', 't')
           ->where('v.usuario = :usuario')
           ->orderBy('v.fecha', 'DESC')
           ->setParameter('usuario', $usuario);

        $compras = $qb->getQuery()->getResult();
        return $compras;
    }
}