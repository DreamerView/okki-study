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

        if($uuid!== null) {
            $database->start($db,"DELETE FROM `{$uuid}_topic` WHERE `uuid`=?",[$selfUUID]);
        }

        echo "?location=admin_list_lesson_potok&&uuid={$selectedUUID}&&main_uuid={$mainUUID}";

    }
?>