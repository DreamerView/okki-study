<? 
    if(isset($_POST['submit'])) {
        
        require_once("../etc/modules/database.php");
        $database = new DatabaseOkkiCMS;
        
        require_once("../env.php");
        $db = $database->connect($mainConnection);
        $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4));
        $name = isset($_POST['registerName'])?htmlspecialchars($_POST['registerName']):'';
        $surname = isset($_POST['registerSurname'])?htmlspecialchars($_POST['registerSurname']):'';
        $phone = isset($_POST['registerPhone'])?htmlspecialchars($_POST['registerPhone']):'';
        $email = isset($_POST['registerEmail'])?htmlspecialchars($_POST['registerEmail']):'';
        $password = isset($_POST['registerPassword'])?htmlspecialchars($_POST['registerPassword']):'';

        $emailCheck = $database->fetch($db, "SELECT `uuid` FROM `users` WHERE `email`=? ",[$email]);

        if($emailCheck!==false) {
            header("Location: {$mainURL}/?location=register&&email=busy");
            exit();
        }

        $phoneCheck = $database->fetch($db, "SELECT `uuid` FROM `users` WHERE `phone`=? ",[$phone]);

        if($phoneCheck!==false) {
            header("Location: {$mainURL}/?location=register&&phone=busy"); 
            exit();
        }

        $last = base64_encode($uuid."_".time());

        $database->start($db,"INSERT INTO `users` (
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
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",[$uuid,$name,$surname,$phone,$email,"user","",time(),"","",$password, $last]);

        $database->start($db,"CREATE TABLE IF NOT EXISTS `{$uuid}_courses`(
            `uuid` varchar(255),
            `sub_uuid` varchar(255),
            `time` varchar(255),
            `status` varchar(64)
        ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

        $database->start($db,"CREATE TABLE IF NOT EXISTS `{$uuid}_notification`(
            `uuid` varchar(255),
            `title` varchar(255),
            `content` text,
            `status` varchar(64)
        ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

        setcookie("auth", $last, time() + 3600, "/");
        setcookie("name", $name, time() + 3600, "/");

        header("Location: {$mainURL}/?location=all");


    }
?>