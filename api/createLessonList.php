<? 
    if(isset($_POST['submit'])) {
        
        require_once("../etc/modules/database.php");
        $database = new DatabaseOkkiCMS;
        
        require_once("../env.php");
        $db = $database->connect($mainConnection);

        $new_uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4));
        $uuid = $_POST['uuid'] ?? null;
        $mainUUID = $_POST['main-uuid'] ?? null;
        $name = $_POST['title'] ?? null;
        $content = $_POST['content'] ?? null;

        if($uuid!== null) {

            $database->start($db,"INSERT INTO `{$uuid}_lesson_list` (
                `uuid`,
                `title`,
                `content`,
                `time`
            ) VALUES (?, ?, ?, ?)",[$new_uuid,$name,$content,time()]);

            $database->start($db,"CREATE TABLE IF NOT EXISTS `{$new_uuid}_topic`(
                `uuid` varchar(255),
                `title` varchar(100),
                `content` text,
                `media_type` varchar(10),
                `media` varchar(255),
                `time` varchar(255)
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
        }

        // header("Location: ../?location=admin_course&&uuid={$uuid1}");
        echo "?location=admin_list_lesson_potok&&uuid={$uuid}&&main_uuid={$mainUUID}";


    }
?>