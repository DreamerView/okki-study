<? 
    if(isset($_POST['submit'])) {
        
        require_once("../etc/modules/database.php");
        $database = new DatabaseOkkiCMS;
        
        require_once("../env.php");
        $db = $database->connect($mainConnection);

        $selectedUUID = $_POST['potok-edit-uuid-selected'] ?? null;
        $uuid = $_POST['potok-edit-uuid'] ?? null;
        $name = $_POST['course-potok-edit-title'] ?? null;

        if($uuid!== null) {

            $database->start($db,"UPDATE `{$selectedUUID}_potok` SET `title`=? WHERE `uuid`=?",[$name,$uuid]);
        }

        echo "?location=admin_potok&&uuid={$selectedUUID}";

    }
?>