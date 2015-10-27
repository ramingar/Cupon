## Highlights del libro *Desarrollo web ágil con Symfony*

[TOC]

### Capítulo 1
 - Para estar informado sobre Symfony
 - Según el libro de Javier Eguiluz, solo van a usarse las anotaciones para configurar la validación de la información, así que tendría que investigar también cómo usarlas para el enrutamiento o para la seguridad.
 - Git - comandos básicos
 - Git - .gitignore

### Capítulo 2
 - Organización/estructura de los Bundles
 - Orden recomendado para aplicar la filosofía Symfony: entidades > bundles > enrutamiento.
 - Según el libro, el coste de un artículo se carga directamente en la tarjeta del comprador. Tengo que mirar por mi cuenta cómo funcionan las pasarelas de pago.

### Capítulo 3
(como requisito, evidentemente, tendrás que haber instalado LAMP)
 - Instalación de Composer
 - Creación de un proyecto Symfony
 - Comprobar que Symfony se puede usar con la configuración de tu pc `php app/check.php` (tiene que estar todo OK, incluso los opcionales)
 - Comprobar que Symfony se instaló correctamente `php app/console`
 - Configurar tu proyecto Symfony `http://cupon.local/config.php`
 - Actualizar tu proyecto a la última versión de Symfony
 - Generar un Bundle (instrucción `generate:bundle` (error autoload -> hacerlo todo desde una instrucción como más abajo se explica))
 - NOTA: si lo que quieres es clonar un proyecto symfony desde github, primero tendrás que hacer el `git clone` y, dentro de la carpeta que se habrá generado con el proyecto, hacer `composer update` (no install!!).

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
 - Crear una entidad de tipo Ofertas y guardarla en la BBDD:

``` php
use Cupon\OfertaBundle\Entity\Oferta;

$oferta = new Oferta();

$oferta->setNombre('Lorem Ipsum ...');
$oferta->setPrecio(10.99);
// ... completar todas las propiedades ...

$em = $this->getDoctrine()->getManager();
$em->persist($oferta);
$em->flush();
```
 - Para borrar una entidad:

```php
$em = $this->getDoctrine()->getManager();

$usuario = $em->getRepository('UsuarioBundle:Usuario')->findOneByDni('12345678L');

$em->remove($usuario);
$em->flush();
```
 - Instalar/crear los fixtures
 - `php app/console doctrine:fixtures:load` -> ¡Cuidado que purga la BBDD! Si no quieres borrarlos: `php app/console doctrine:fixtures:load --append`
 - Función para el cálculo de SLUGS!:

```php
static public function getSlug($cadena, $separador = '-')
{
    // Código copiado de http://cubiq.org/the-perfect-php-clean-url-generator
    $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $cadena);
    $slug = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $slug);
    $slug = strtolower(trim($slug, $separador));
    $slug = preg_replace("/[\/_|+ -]+/", $separador, $slug);
 
    return $slug;
}
```
 - Generar entidades desde BBDD

###Capítulo 6
 - TWIG - `{{ path('pagina_estatica', { 'pagina': 'ayuda' }) }}`
 - TWIG - `{{ 'now' | date('Y') }}`
 - TWIG - `{{ asset('uploads/images/' ~ oferta.rutaFoto) }}`
<em>
```text
«La función asset() de Twig genera la URL pública del elemento que se le pasa (imagen, archivo CSS o JavaScript). En la mayoría de proyectos Symfony2 la carpeta pública es web/ (el valor por defecto que utiliza Symfony) por lo que las URL generadas por asset() son del tipo /web/...»
```
</em>

 - TWIG - `{{ oferta.fechaExpiracion | date() }}`
 <em>
```text
«La propiedad fecha_expiracion de la entidad guarda la fecha como un objeto de tipo DateTime. Si utilizas la instrucción {{ oferta.fechaExpiracion }} Twig muestra un error porque no sabe convertir el valor DateTime en una cadena de texto. Así que siempre que muestres una fecha en una plantilla, no olvides añadir el filtro date()».
```
</em>
 - YAML - `{ resource: "%kernel.root_dir%/config/routing.yml" }` -> la primera clave equivale al directorio donde se encuentra la clase AppKernel.php (casi siempre app/)
 - Trabajar en entornos de ejecución
 - Opción `$kernel = new AppKernel('prod', false);`, ¿la aplicación debe ejecutarse en modo debug? -> valor `%kernel.debug%`
 - Opciones de depuración (barra, profiler, logs)
 - Barra de depuración -> tiempo carga de la página - lazy loading (mejorar rendimiento)
 - Profile -> routing -> ordenar rutas para mejorar rendimiento
 - Monolog
 - Añadir mensajes de log. Ejemplo:

```php
$log = $this->get('logger');
$log->addInfo('Generada la portada en '.$tiempo.' milisegundos');
```
 - Caché para la búsqueda de errores
 - Parámetros de configuración globales. ¿Cómo recuperarlos? -> `$this->container->getParameter('nombre_del_parametro')`
 - RedirectResponse -> `return new RedirectResponse($this->generateUrl('portada', array('ciudad' => $ciudad)));`
 - Redirecciones en los archivos de enrutado:

```yaml
defaults: { _controller: FrameworkBundle:Redirect:redirect,
                 route: portada, ciudad: '%cupon.ciudad_por_defecto%' }
```
 - Repositorios propios (OfertaRepository.php)
 - DQL (yo, normalmente, uso CreateQueryBuilder)
 - DQL (JOIN, fetch JOIN)
 - TWIG - `app.request.attributes.has('ciudad')` -> para acceder a los parámetros de la url. Usar `app.request` te da acceso al objeto Request desde la plantilla (el objeto que contiene toda la información relacionada con la petición del usuario).
 - `app.request.attributes.get('ciudad')`
 - Objeto Request - `$this->getRequest();` (para controladores que hereden de Controller de Symfony). `$this->container->get('request');` (si el controlador no hereda del de Symfony)
 - Instrucción `<<<EOF   XXXX   EOF;`

###Capítulo 7
 - Web assets - stylesheets, javascript, images - (web/css, web/js) o (<.bundle.>/Resources/public/css, <.bundle.>/Resources/public/js, <.bundle.>/Resources/public/images)
 - si se meten en un bundle, después hay que *instalarlos*: `php app/console assets:install --symlink`
 - web/css -> {{ asset('css/estilos.css') }} (TWIG)
 - dentro de un bundle -> {{ asset('bundles/oferta/css/comun.css') }} (TWIG)
 - Versionando los archivos web (CACHÉ)

```yaml
# app/config/config.yml
framework:
    # ...
    templating: { engines: ['twig'], assets_version: 1.3 }
```
 - YAML - enrutamiento - `requirements` -> para añadir condiciones que se deben cumplir para que la ruta se tenga en cuenta.
 - TWIG - render() - `{{ render(controller('CiudadBundle:Default:listaCiudades')) }}` -> inserta el resultado de la acción listaCiudadesAction() del controlador DefaultController.php del bundle CiudadBundle
 - HTML - uso de atributos `data-` -> HTML5 permite crear atributos propios, estos deben empezar por data- y pueden almacenar cualquier información. Así que se guarda en `data-url` el valor de la url al que tiene que ir si hace clic en ese elemento.
 - TWIG - url() - `{{ url('ciudad_cambiar', { 'ciudad': ciudad.slug }) }}` -> genera una url, a partir del valor de una clave de enrutamiento, y la inserta en el html.
 - TWIG - variables globales -> accesibles en cualquier plantilla de TWIG:

```yaml
twig:
    # ...
    globals:
        ciudad_por_defecto: %cupon.ciudad_por_defecto%
```
 - TWIG - `{% include %}` -> incluir una plantilla TWIG en ese lugar: `{% include 'OfertaBundle:Default:includes/oferta.html.twig' %}`
 - TWIG - extensiones opcionales de twig: TEXT y DEBUG. TEXT -> truncate y wordwrap. DEBUG -> dump.
 - CREACIÓN DE EXTENSIONES DE TWIG - EOJ en Symfony
 - Resumen creación de una página: ruta, acción, repositorio y plantilla.

### Capítulo 8
 - YAML - prefix -> para que Symfony2 prefije una cadena delante de todas las rutas definidas en un archivo de enrutamiento de un bundle.
 - Seguridad - ACCESOS a las páginas.
 - Seguridad - ROLES, creación de PROVEEDORES.
 - Seguridad - Creación del formulario de login.
 - Seguridad - Remember me
 - Seguridad - Redirige a una página después del login
 - Inyección de dependencias

### Anexo: Inyección de dependencias
 - [Inciso]: guardar mensajes en un archivo, bbdd o enviarlos por mail.
 - Constructor injection.
 - Setter injection.
 - Property injection.
 - Contenedor de inyección de dependencias.
 - Crear un servicio a partir de una clase PHP:

```yaml
# app/config/config.yml
services:
    cupon.utilidades:
        class: Cupon\OfertaBundle\Util\Util
```
 - Parámetros del contenedor de Symfony2 más usados (kernel.environment, kernel.logs_dir, etc.).
 - Inyectar un servicio en otro (arguments y uso de @).
 - Servicios de Symfony2 más usados (request, doctrine, logger, mailer, etc.).