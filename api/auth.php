<? 
    if(isset($_POST['submit'])) {
        
        require_once("../etc/modules/database.php");
        $database = new DatabaseOkkiCMS;
        
        require_once("../env.php");
        $db = $database->connect($mainConnection);

        $auth = isset($_POST['auth'])?htmlspecialchars($_POST['auth']):'not_found_1212';
        $pass = isset($_POST['pass'])?htmlspecialchars($_POST['pass']):'not_found_1212';;

        $authCheck = $database->fetch($db, "SELECT `uuid`,`name` FROM `users` WHERE (`email`=? OR `phone`=?) AND `password`=?",[$auth,$auth,$pass]);

        if($authCheck!==false) {
            $last = base64_encode($authCheck['uuid']."_".time());
            $database->start($db,"UPDATE `users` SET `last`=? WHERE `uuid`=?",[$last,$authCheck['uuid']]);
            setcookie("auth", $last, time() + 3600, "/");
            setcookie("name", $authCheck['name'], time() + 3600, "/");
        }

        $authCheck!==false?header("Location: {$mainURL}/?location=all"):header("Location: {$mainURL}/?location=auth&&input=wrong");


    }
?>