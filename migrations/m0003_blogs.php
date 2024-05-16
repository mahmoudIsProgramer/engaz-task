<?php

use app\core\Application;
 

class m0003_blogs {
    public function up()
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE blogs (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                content TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                deleted_at TIMESTAMP NULL 
            )  ENGINE=INNODB;";
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = Application::$app->db;
        $SQL = "DROP TABLE blogs;";
        $db->pdo->exec($SQL);
    }
}