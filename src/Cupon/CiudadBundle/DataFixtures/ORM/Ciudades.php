<?php

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Cupon\CiudadBundle\Entity\Ciudad;

class Ciudades implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $ciudades = array(
            array('nombre' => 'Madrid', 'slug' => 'madrid'),
            array('nombre' => 'Barcelona', 'slug' => 'barcelona'),
            // ...
        );

        foreach ($ciudades as $ciudad) {
            $entidad = new Ciudad();

            $entidad->setNombre($ciudad['nombre']);
            $entidad->setSlug($ciudad['slug']);

            $manager->persist($entidad);
        }

        $manager->flush();
    }
}