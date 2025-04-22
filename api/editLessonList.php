<? 
    if(isset($_POST['submit'])) {
        
        require_once("../etc/modules/database.php");
        $database = new DatabaseOkkiCMS;
        
        require_once("../env.php");
        $db = $database->connect($mainConnection);

        $uuid = $_POST['uuid'] ?? null;
        $selectedUUID = $_POST['lesson_uuid'] ?? null;
        $mainUUID = $_POST['main-uuid'] ?? null;
        $name = $_POST['title'] ?? null;
        $content = $_POST['content'] ?? null;

        if($uuid!== null) {

            $database->start($db,"UPDATE `{$selectedUUID}_lesson_list` SET `title`=?, `content`=? WHERE `uuid`=?",[$name,$content,$uuid]);
        }

        echo "?location=admin_list_lesson_potok&&uuid={$selectedUUID}&&main_uuid={$mainUUID}";

    }
?>