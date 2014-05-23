## Highlights del libro *Desarrollo web ágil con Symfony*

[TOC]


### Capítulo 1
 - Para estar informado sobre Symfony
 - Git - comandos básicos
 - Git - .gitignore

### Capítulo 2
 - Organización de los Bundles

### Capítulo 3
(como requisito, evidentemente, tendrás que haber instalado LAMP)
 - Instalación de Composer
 - Creación de un proyecto Symfony
 - Actualizar tu proyecto a la última versión de Symfony
 - Generar un Bundle (instrucción `generate:bundle` (error autoload -> hacerlo todo desde una instrucción como más abajo se explica))

### Capítulo 4
 - Primer enrutamiento / Creación de la página estática "ayuda" / Primera plantilla twig
 - Primera regla con variable en el enrutamiento -> Todas las páginas estáticas en una regla
 - Problema de la barra del final en una ruta (trailing slash)
 - Redirección a una regla de enrutamiento ya hecha

### Capítulo 5
 - Crear una entidad (acuérdate de añadir `__toString()` al final)
 - `__construct()` -> para asignar valores en la creación de un registro (fecha de alta de un usuario)
 - Tipos de datos del ORM Doctrine2
 - `php app/console generate:doctrine:entities TiendaBundle` -> genra getters y setters
 - `php app/console doctrine:generate:entity` -> wizard para generar una entidad desde cero
 - `php app/console doctrine:database:create` -> crea la BBDD desde las clases de PHP
 - `php app/console doctrine:schema:update --force` -> actualizar el esquema de la BBDD (si ha sufrido cambios después de creada)
 - `$em = $this->getDoctrine()->getManager();` -> recuperar el Entity Manager
 - `$em->getRepository('XXXBundle:XXX')->find();` -> buscar un id
 - `$em->getRepository('XXXBundle:XXX')->findOneBy(array(<clave=>valor>));` -> buscar 1 registro
 - `$em->getRepository('XXXBundle:XXX')->findBy(array(<clave/valor>));` -> buscar n registros
 - `$em->getRepository('XXXBundle:XXX')->findBy(array(<clave/valor>) [, registrosDevueltos, posPrimeroDevuelto]);` -> para paginar
 - `$em->getRepository('XXXBundle:XXX')->find<One>By<PropiedadCamelCase>(xxx);` -> hacer búsquedas
 - Crear una entidad de tipo Ofertas y guardarla en la BBDD
use Cupon\OfertaBundle\Entity\Oferta;
 
``` php
$oferta = new Oferta();
 
$oferta->setNombre('Lorem Ipsum ...');
$oferta->setPrecio(10.99);
// ... completar todas las propiedades ...
 
$em = $this->getDoctrine()->getManager();
$em->persist($oferta);
$em->flush();
```
