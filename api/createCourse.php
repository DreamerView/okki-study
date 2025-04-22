<? 
    if(isset($_POST['submit'])) {
        
        require_once("../etc/modules/database.php");
        $database = new DatabaseOkkiCMS;
        
        require_once("../env.php");
        $db = $database->connect($mainConnection);

        $authCheck = false;
        if(isset($_COOKIE['auth'])) {
            $auth = $_COOKIE['auth'];
            $authCheck = $database->fetch($db, "SELECT `uuid` FROM `users` WHERE `last`=? AND (`status`=? OR `status`=?)", [$auth, 'admin', 'author']);
        }

        if($authCheck!==false) {

            $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4));
            $name = $_POST['course-title'];
            $type = $_POST['course-type'];
            $text = $_POST['course-text'];
            $price = $_POST['course-price'];


            $media = "empty";

            $author = $authCheck['uuid'];

            if(isset($_FILES['image'])&&$_FILES['image']['size']>=1) {
                require_once("uploadImage.php");
                $media = $newFilename ?? null;
            }

            $database->start($db,"INSERT INTO `course` (
                `uuid`,
                `type`,
                `header`,
                `media`,
                `content`,
                `price`,
                `language`,
                `author`,
                `time`,
                `live`,
                `live_time`
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",[$uuid,$type,$name,$media,$text,$price,"kz",$author,time(),"",""]);

            if($type==="potok") {
                $database->start($db,"CREATE TABLE IF NOT EXISTS `{$uuid}_potok`(
                    `uuid` varchar(255),
                    `status` varchar(20),
                    `title` varchar(100),
                    `time` varchar(255)
                ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
            }

            // header("Location: ../?location=admin_course&&uuid={$uuid}");
            echo "?location=admin_all";

        } else {
            echo "?location=all";
        }


    }
?>