<?php
    try {
        require_once("etc/modules/database.php");
        $database = new DatabaseOkkiCMS;

        require_once("env.php");

        $database->delete($mainConnection);
        $database->create($mainConnection);


        $mainDatabase = $database->connect($mainConnection);

        $database->start($mainDatabase, "CREATE TABLE IF NOT EXISTS `course`(
            `uuid` varchar(255),
            `type` varchar(20),
            `header` varchar(100),
            `media` varchar(255),
            `content` text,
            `price` varchar(20),
            `language` varchar(5),
            `author` varchar(255),
            `time` varchar(255),
            `live` text,
            `live_time` varchar(255)
        ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

        $database->start($mainDatabase, "CREATE TABLE IF NOT EXISTS `users`(
            `uuid` varchar(255),
            `name` varchar(64),
            `surname` varchar(64),
            `phone` varchar(64),
            `email` varchar(64),
            `status` varchar(64),
            `image` varchar(255),
            `time` varchar(255),
            `location` varchar(255),
            `ip_last` varchar(255),
            `password` varchar(64),
            `last` varchar(255)
        ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

        $database->start($mainDatabase,"INSERT INTO `users` (
            `uuid`,
            `name`,
            `surname`,
            `phone`,
            `email`,
            `status`,
            `image`,
            `time`,
            `location`,
            `ip_last`,
            `password`,
            `last`
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",["root","Administrator","","0000000000","admin@gmail.com","admin","",time(),"","","M2raumOp", ""]);

        echo "Congratulations! Database activated!";
    } catch(Exception $e) {
        echo "An error occurred: " . $e->getMessage();
    }
?>
