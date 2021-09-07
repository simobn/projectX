<?php


class m003_product{
    public function up()
    {
        $db = \app\Core\Application::$app->db;
        $SQL = "CREATE TABLE products (
                   id INT AUTO_INCREMENT PRIMARY KEY ,
                   product_name VARCHAR(255) NOT NULL ,
                   created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
                ) ENGINE=InnoDB;";
        $db->pdo->exec($SQL);

    }

    public function down()
    {
        $db = \app\Core\Application::$app->db;
        $SQL = "DROP TABLE products ";
        $db->pdo->exec($SQL);
    }
}
