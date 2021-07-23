<?php


class m0002_add_password_column{

    public function up()
    {
        $db = \app\Core\Application::$app->db;
        $db->pdo->exec("ALTER TABLE users ADD COLUMN password VARCHAR(255) NOT NULL;");
    }

    public function down()
    {
        $db = \app\Core\Application::$app->db;
        $db->pdo->exec("ALTER TABLE users DROP COLUMN password ;");
    }
}