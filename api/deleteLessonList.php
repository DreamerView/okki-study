<? 
    if(isset($_POST['submit'])) {
        
        require_once("../etc/modules/database.php");
        $database = new DatabaseOkkiCMS;
        
        require_once("../env.php");
        $db = $database->connect($mainConnection);

        $uuid = $_POST['uuid'] ?? null;
        $mainUUID = $_POST['main-uuid'] ?? null;
        $selectedUUID = $_POST['lesson_uuid'] ?? null;
        if($uuid!== null) {
            $database->start($db,"DELETE FROM `{$selectedUUID}_lesson_list` WHERE `uuid`=?",[$uuid]);
            $database->start($db,"DROP TABLE IF EXISTS `{$uuid}_topic`");
        }

        echo "?location=admin_list_lesson_potok&&uuid={$selectedUUID}&&main_uuid={$mainUUID}";

    }
?>