<?php
/**
 * Class Application
 * @author mohammedd benouijem <mbenouijem@gmail.com>
 */
namespace app\Core;

class Application
{
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public Database $db;
    public Controller $controller;
    public static Application $app;
    /**
     * Application constructor.
     */
    public function __construct($rootPath , array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->controller = new Controller();
        $this->request = new Request();
        $this->response = new Response();
        $this->db = new Database($config['db']);
        $this->router = new Router($this->request,$this->response);
    }

    public function run()
    {
        echo $this->router->resolve();
    }

    /**
     * @return Controller
     */
    public function getController(): Controller
    {
        return $this->controller;
    }

    /**
     * @param Controller $controller
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }
}