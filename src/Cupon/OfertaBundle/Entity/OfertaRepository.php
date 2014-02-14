<?php
namespace Cupon\OfertaBundle\Entity;

use Doctrine\ORM\EntityRepository;

class OfertaRepository extends EntityRepository
{
	/**
	* Encuentra la oferta del día para la ciudad indicada.
	*
	* @param string $ciudad
	* @return \Cupon\OfertaBundle\Entity\Oferta Oferta
	*/
    public function findOfertaDelDia($ciudad)
    {
        $hoy = new \DateTime('today - 1 second');

        $em = $this->getEntityManager();

        // Al hacer fetch JOIN nos ahorramos una consulta porque en la plantilla
        // ya no se realizará el lazy loading para recuperar los datos de la tienda.
        $qb = $em->createQueryBuilder();
        $qb->select(array('o', 'c', 't'))
           ->from('OfertaBundle:Oferta', 'o')
           ->join('o.ciudad', 'c')
           ->join('o.tienda', 't')
           ->where('c.slug = :ciudad')
           ->andwhere('o.fechaPublicacion = :fecha_publicacion')
           ->setParameter('ciudad', $ciudad)
           ->setParameter('fecha_publicacion', $hoy)
           ->setMaxResults(1);
        
        
        /* Mismo resultado pero con DQL */
        /*
        $query = $em->createQuery('
            SELECT o, c, t
            FROM OfertaBundle:Oferta o
            JOIN o.ciudad c 
            JOIN o.tienda t 
            WHERE c.slug = :ciudad and o.fechaPublicacion = :fecha_publicacion
        ');
        $query->setParameter('ciudad', 'barcelona');
        $query->setParameter('fecha_publicacion', $hoy);
        $query->setMaxResults(1);
        $oferta = $query->getResult();
        */

        $oferta = $qb->getQuery()->getResult();

        return $oferta;
    }

    /**
    * Devuelve una oferta dado el slug de la ciudad y el slug de esa oferta.
    * @param string $ciudad El slug de la ciudad donde está la oferta.
    * @param string $slug El slug de la oferta que se desea ver en detalle.
    */
    public function findOferta($ciudad, $slug)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select(array('o', 'c', 't'))
           ->from('OfertaBundle:Oferta', 'o')
           ->join('o.ciudad', 'c')
           ->join('o.tienda', 't')
           ->where('c.slug = :ciudad')
           ->andwhere('o.slug = :slug')
           ->andwhere('o.revisada = true')
           ->setParameter('ciudad', $ciudad)
           ->setParameter('slug', $slug)
           ->setMaxResults(1);

        return $qb->getQuery()->getResult();
    }

    /**
    * Devuelve una lista de ofertas que se han publicado con anterioridad
    * en otras ciudades.
    * @param string $ciudad El slug de la ciudad. Las ofertas serán de otras ciudades.
    */
    public function findRelacionadas($ciudad)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select(array('o', 'c'))
           ->from('OfertaBundle:Oferta', 'o')
           ->join('o.ciudad', 'c')
           ->where('c.slug != :ciudad')
           ->andwhere('o.fechaPublicacion <= :fecha')
           ->andwhere('o.revisada = true')
           ->orderBy('o.fechaPublicacion', 'DESC')
           ->setParameter('ciudad', $ciudad)
           ->setParameter('fecha', new \DateTime('today'))
           ->setMaxResults(5);

        return $qb->getQuery()->getResult();
    }
}