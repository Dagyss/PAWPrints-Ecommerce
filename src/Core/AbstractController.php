<?php

namespace Paw\Core;

use Paw\Core\ModelFactory;
use Monolog\Logger;
use Twig\Environment;

class AbstractController {
    /** @var Environment $twig Instancia de Twig para renderizar plantillas */
    protected Environment $twig;

    /** @var string Ruta antigua a vistas PHP (ya no se usa) */
    public string $viewsDir = "";

    /** @var array Menú de navegación que se pasará a Twig */
    public array $menu_nav = [];

    /** @var string|null Nombre de la clase de modelo asociado (si aplica) */
    public ?string $modelName = null;

    /** @var object|null Instancia del modelo (si se creó) */
    public ?object $model = null;

    /** @var ModelFactory Para crear instancias de modelos dinámicamente */
    protected ModelFactory $modelFactory;

    /** @var Logger El logger de la aplicación */
    protected Logger $logger;

    /**
     * Constructor original: inicializa logger, menú y modelo (si corresponde).
     * @param Logger $log
     */
    public function __construct(Logger $log) {
        $this->logger = $log;
        $this->viewsDir = __DIR__ . "/../App/views/";
        $this->modelFactory = new ModelFactory($log);

        // Definición del menú global
        $this->menu_nav = [
            [
                "href" => "/books",
                "route_name" => "Libros"
            ],
            [
                "href" => "/News",
                "route_name" => "Novedades"
            ],
            [
                "href" => "/offer",
                "route_name" => "Ofertas"
            ],
            [
                "href" => "/best-seller",
                "route_name" => "Más vendidos"
            ],
            [
                "href" => "/branches",
                "route_name" => "Sucursales"
            ],
            [
                "href" => "/about-us",
                "route_name" => "Nosotros"
            ],
            [
                "href" => "/create-book",
                "route_name" => "Crear Libro"
            ],
        ];

        if (!is_null($this->modelName)) {
            $this->model = $this->modelFactory->make($this->modelName);
        }
    }

    /**
     * Setter que inyectará la instancia de Twig desde el Router.
     * @param Environment $twig
     */
    public function setTwig(Environment $twig): void
    {
        $this->twig = $twig;
    }

    /**
     * Método de ayuda para renderizar una plantilla Twig.
     * @param string $template Nombre de la plantilla (p. ej. "home.twig")
     * @param array  $data     Array asociativo de variables que se pasan a la plantilla
     */
    protected function render(string $template, array $data = []): void
    {
        // Siempre que quieras acceder al menú, pasa 'menu_nav' en cada render.
        // Sin embargo, podrías registrar 'menu_nav' como global en Twig si prefieres.
        $data['menu_nav'] = $this->menu_nav;

        // Renderiza y envía el HTML generado
        echo $this->twig->render($template, $data);
    }

    /**
     * Método que crea o retorna una instancia de modelo dado su nombre de clase.
     * @param string $modelClass
     * @return object
     */
    public function getModel(string $modelClass): object
    {
        return $this->modelFactory->make($modelClass);
    }
}