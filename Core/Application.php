<?php
namespace app\Core;
use app\Core\Db\Database;

class Application
{
    public string $layout = 'main';
    public string $userClass;
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public Database $db;
    public Controller $controller;
    public static Application $app;
    public ?UserModel $user;
    public View $view;
    /**
     * Application constructor.
     */
    public function __construct($rootPath , array $config)
    {
        $this->userClass = $config['userClass'];

        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->controller = new Controller();
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->view = new View();
        $this->db = new Database($config['db']);
        $this->router = new Router($this->request,$this->response);

        $primaryValue = $this->session->get('user');
        if($primaryValue){
            $primaryKey = (new $this->userClass())->primaryKey();
            $this->user = (new $this->userClass())->findOne([$primaryKey => $primaryValue]);
        }
        else{
            $this->user = null;
        }
    }

    public static function isGuest(): bool
    {
        return !self::$app->user;
    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        }catch (\Exception $exception){
            $this->response->setStatusCode($exception->getCode());
            echo $this->view->renderView('_error',[
                'exception'     =>  $exception
            ]);
        }
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

    public function login(UserModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryKeyValue = $user->{$primaryKey};
        $this->session->set('user', $primaryKeyValue);
        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }
}