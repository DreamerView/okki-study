<? 
    if(isset($_POST['submit'])) {
        
        require_once("../etc/modules/database.php");
        $database = new DatabaseOkkiCMS;
        
        require_once("../env.php");
        $db = $database->connect($mainConnection);

        $uuid = isset($_POST['course-uuid'])?htmlspecialchars($_POST['course-uuid']):null;
        $sub_uuid = isset($_POST['sub-uuid'])?htmlspecialchars($_POST['sub-uuid']):null;
        $lazy = isset($_POST['lazy'])?htmlspecialchars($_POST['lazy']):'no';

        $authCheck = false;
        if(isset($_COOKIE['auth'])) {
            $auth = $_COOKIE['auth'];
            $authCheck = $database->fetch($db, "SELECT `uuid` FROM `users` WHERE `last`=?", [$auth]);
        }

        if($authCheck!==false) {
            if($uuid!==null) {
                $checkUser = $database->fetch($db,"SELECT `uuid` FROM `{$uuid}_users` WHERE `uuid`=? AND `sub_uuid`=?",[$authCheck['uuid'],$sub_uuid]);
                if($checkUser!==false) {
                    header("Location: {$mainURL}/?location=all");
                    exit();
                }
                $database->start($db,"INSERT INTO `{$uuid}_users` (
                    `uuid`,
                    `sub_uuid`,
                    `time`,
                    `status`
                ) VALUES (?, ?, ?, ?)",[$authCheck['uuid'],$sub_uuid,time(),'waiting']);

                $database->start($db,"INSERT INTO `{$authCheck['uuid']}_courses` (
                    `uuid`,
                    `sub_uuid`,
                    `time`,
                    `status`
                ) VALUES (?, ?, ?, ?)",[$uuid,$sub_uuid,time(),'waiting']);

                if($lazy==='yes') {
                    echo "?location=course_list_potok&&uuid={$uuid}";
                } else {
                    header("Location: {$mainURL}/?location=course_list_potok&&uuid={$uuid}");
                }
                exit();
            }
        }


    }
?>