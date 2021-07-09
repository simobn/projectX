<?php
/**
 * Class Database
 * @package app\Core
 * @author mohammedd benouijem <mbenouijem@gmail.com>
 */

namespace app\Core;
class Database
{
    public \PDO $pdo;
    private string $host;
    private string $port;
    private string $dbname;
    public function __construct(array $config)
    {
        $this->host = $config['host'];
        $this->port = $config['port'];
        $this->dbname = $config['db_name'];
        $dsn = "mysql:host=$this->host;port=$this->port;dbname=$this->dbname" ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';

        $this->pdo = new \PDO($dsn ,$user , $password);

        //make pdo throws exceptions on errors
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE , \PDO::ERRMODE_EXCEPTION);
    }

    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();

        $newMigrations = [];
        $files  =   scandir(Application::$ROOT_DIR.'/Migrations');
        $toApplyMigrations = array_diff($files,$appliedMigrations);
//        var_dump($toApplyMigrations);
        foreach ($toApplyMigrations as $migration){
            if($migration === '.' || $migration === '..'){
                continue;
            }
            require_once Application::$ROOT_DIR."/Migrations/$migration";
            $className = pathinfo($migration,PATHINFO_FILENAME);
            $instance = new $className();
            $this->log("applying migration $migration");
            $instance->up();
            $this->log("applied migration $migration");
            $newMigrations[] = $migration;
        }

        if(!empty($newMigrations)){
            $this->saveMigrations($newMigrations);
        }
        else{
            $this->log('nothing to migrate');
        }
    }

    public function createMigrationsTable()
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
                            id INT AUTO_INCREMENT PRIMARY KEY ,
                            migration VARCHAR(255),
                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
                            ) ENGINE=InnoDB;");
    }

    public function getAppliedMigrations()
    {
        $statement = $this->pdo->prepare("SELECT migration FROM migrations");
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    private function saveMigrations(array $migrations)
    {
        $str = implode(',',array_map(fn($m)=> "('$m')",$migrations)) ;
        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $str");
        $statement->execute();
    }

    protected function log(string $message){
        echo '[ '.date('Y-m-d H:i:s').' ] '.$message.PHP_EOL;
    }
}