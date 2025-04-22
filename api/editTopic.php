<? 
    if(isset($_POST['submit'])) {
        
        require_once("../etc/modules/database.php");
        $database = new DatabaseOkkiCMS;
        
        require_once("../env.php");
        $db = $database->connect($mainConnection);

        $uuid = $_POST['uuid'] ?? null;
        $selfUUID = $_POST['self-uuid'] ?? null;
        $mainUUID = $_POST['uuid-selected'] ?? null;
        $selectedUUID = $_POST['uuid-lesson-selected'] ?? null;
        $title = $_POST['topic-title'] ?? null;
        $content = $_POST['content'] ?? null;
        $media = $_POST['topic-media'] ?? null;

        if($uuid!== null) {
            $database->start($db,"UPDATE `{$uuid}_topic` SET `title`=?,`content`=?,`media`=? WHERE `uuid`=?",[$title,$content,$media,$selfUUID]);
        }

        echo "?location=admin_list_lesson_potok&&uuid={$selectedUUID}&&main_uuid={$mainUUID}";

    }
?>