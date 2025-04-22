<? 
    if(isset($_POST['submit'])) {
        
        require_once("../etc/modules/database.php");
        $database = new DatabaseOkkiCMS;
        
        require_once("../env.php");
        $db = $database->connect($mainConnection);

        $new_uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4));
        $uuid = $_POST['uuid'] ?? null;
        $mainUUID = $_POST['uuid-selected'] ?? null;
        $selectedUUID = $_POST['uuid-lesson-selected'] ?? null;
        $title = $_POST['topic-title'] ?? null;
        $content = $_POST['content'] ?? null;
        $media = $_POST['topic-media'] ?? null;

        if($uuid!== null) {
            $database->start($db,"INSERT INTO `{$uuid}_topic` (
                `uuid`,
                `title`,
                `content`,
                `media_type`,
                `media`,
                `time`
            ) VALUES (?, ?, ?, ?, ?, ?)",[$new_uuid,$title,$content,"link",$media,time()]);
        }

        echo "?location=admin_list_lesson_potok&&uuid={$selectedUUID}&&main_uuid={$mainUUID}";

    }
?>