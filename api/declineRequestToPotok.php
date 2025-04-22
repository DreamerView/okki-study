<? 
    if(isset($_POST['submit'])) {
        
        require_once("../etc/modules/database.php");
        $database = new DatabaseOkkiCMS;
        
        require_once("../env.php");
        $db = $database->connect($mainConnection);

        $uuid = isset($_POST['course-uuid'])?htmlspecialchars($_POST['course-uuid']):null;
        $user_uuid = isset($_POST['user-uuid'])?htmlspecialchars($_POST['user-uuid']):null;
        $sub_uuid = isset($_POST['sub-uuid'])?htmlspecialchars($_POST['sub-uuid']):null;
        $lazy = isset($_POST['lazy'])?htmlspecialchars($_POST['lazy']):'no';

        $authCheck = false;
        if(isset($_COOKIE['auth'])) {
            $auth = $_COOKIE['auth'];
            $authCheck = $database->fetch($db, "SELECT `uuid` FROM `users` WHERE `last`=? AND (`status`=? OR `status`=?)", [$auth, 'admin', 'author']);
        }

        if($authCheck!==false) {
            if($uuid!==null) {
                $database->start($db,"DELETE FROM `{$uuid}_users` WHERE `uuid`=? AND `sub_uuid`=?",[$user_uuid,$sub_uuid]);
                $database->start($db,"DELETE FROM `{$user_uuid}_courses` WHERE `uuid`=? AND `sub_uuid`=?",[$uuid,$sub_uuid]);
                if($lazy==='yes') {
                    echo "?location=admin_potok&&uuid={$uuid}";
                } else {
                    header("Location: {$mainURL}/?location=admin_potok&&uuid={$uuid}");
                }
                exit();
            }
        }


    }
?>