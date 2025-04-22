<? 
    if(isset($_POST['submit'])) {
        
        require_once("../etc/modules/database.php");
        $database = new DatabaseOkkiCMS;
        
        require_once("../env.php");
        $db = $database->connect($mainConnection);

        $new_uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4));
        $uuid = $_POST['uuid'] ?? null;
        $name = $_POST['course-potok-title'] ?? null;

        if($uuid!== null) {

            $database->start($db,"INSERT INTO `{$uuid}_potok` (
                `uuid`,
                `status`,
                `title`,
                `time`
            ) VALUES (?, ?, ?, ?)",[$new_uuid,"open",$name,time()]);

            $database->start($db,"CREATE TABLE IF NOT EXISTS `{$new_uuid}_lesson_list`(
                `uuid` varchar(255),
                `title` varchar(100),
                `content` text,
                `time` varchar(255)
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

            $database->start($db,"CREATE TABLE IF NOT EXISTS `{$uuid}_users`(
                `uuid` varchar(255),
                `sub_uuid` varchar(255),
                `time` varchar(255),
                `status` varchar(64)
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
        }

        // $database->start($db,"CREATE TABLE IF NOT EXISTS `{$uuid}_lesson_list`(
        //     `uuid` varchar(255)
        // ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

        // header("Location: ../?location=admin_course&&uuid={$uuid1}");
        echo "?location=admin_potok&&uuid={$uuid}";


    }
?>