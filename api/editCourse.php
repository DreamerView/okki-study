<? 
    if(isset($_POST['submit'])) {
        $root = $_SERVER['DOCUMENT_ROOT'];
        require_once("../etc/modules/database.php");
        $database = new DatabaseOkkiCMS;
        
        require_once("../env.php");
        $db = $database->connect($mainConnection);

        $uuid = $_POST['course-edit-uuid'] ?? null;
        $type = $_POST['course-edit-type'] ?? null;
        $price = $_POST['course-edit-price'] ?? null;
        $title = $_POST['course-edit-title'] ?? null;
        $text = $_POST['course-edit-text'] ?? null;

        $authCheck = false;
        if(isset($_COOKIE['auth'])) {
            $auth = $_COOKIE['auth'];
            $authCheck = $database->fetch($db, "SELECT `uuid` FROM `users` WHERE `last`=? AND (`status`=? OR `status`=?)", [$auth, 'admin', 'author']);
        }

        if($authCheck!==false) {

            if($uuid!==null) {
                $select = $database->fetch($db,"SELECT `media`,`uuid` FROM `course` WHERE `uuid`=?",[$uuid]);
                if($uuid!==false) {
                    $uuid = $select['uuid'];
                    $media = null;
                    if(isset($_FILES['image'])&&$_FILES['image']['size']>=1) {
                        require_once("uploadImage.php");
                        $media = $newFilename ?? null;
                        $img = $select['media'];
                        $dir = "{$root}/source/uploads/{$img}"; 
                        function deleteDirectory($dir) {
                            if (!is_dir($dir)) {
                                return false;
                            }
                            $files = array_diff(scandir($dir), array('.', '..'));
                            foreach ($files as $file) {
                                (is_dir("$dir/$file")) ? deleteDirectory("$dir/$file") : unlink("$dir/$file");
                            }
                            return rmdir($dir);
                        } 
                        deleteDirectory($dir);
                    }
                }
                } else {
                    $uuid = null;
                }

            if($uuid!== null) {
                $database->start($db,"UPDATE `course` SET `header`=?, `type`=?, `content`=?, `price`=? WHERE `uuid`=?",[$title,$type,$text,$price,$uuid]);
                if($media!==null) $database->start($db,"UPDATE `course` SET `media`=? WHERE `uuid`=?",[$media,$uuid]);
            }

            echo "?location=admin_all";
        
        } else {
            echo "?location=all";
        }

    }
?>