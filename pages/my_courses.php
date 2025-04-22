<? 
    require_once("db.php");
    $db = $database->connect($mainConnection);

    $uuid = isset($_POST['course-uuid'])?htmlspecialchars($_POST['course-uuid']):null;

    $authCheck = false;
    if(isset($_COOKIE['auth'])) {
        $auth = $_COOKIE['auth'];
        $authCheck = $database->fetch($db, "SELECT `uuid` FROM `users` WHERE `last`=?", [$auth]);
    }
    if($authCheck!==false) {
        $select = $database->fetchAll($db,"SELECT `uuid` FROM `{$authCheck['uuid']}_courses`");
        $select = array_reverse($select);
        function truncate_text($text, $max_length = 86) {
            // Проверяем длину текста
            if (strlen($text) > $max_length) {
                // Если текст длиннее 64 символов, обрезаем его и добавляем многоточие
                return substr($text, 0, $max_length) . ' ...';
            } else {
                // Если текст короче или равен 64 символам, возвращаем его без изменений
                return $text;
            }
        }
    }
?>
<? if($authCheck!==false) { ?>
<div class="mt-5 block_animation">
    <h2 class="mt-5">Менің курстарым</h2>
    <div class="row py-5" style="">
        <!--  -->
        <? foreach($select as $rows): 
                $type = "";
                $row = $database->fetch($db,"SELECT `header`,`uuid`,`price`,`type`,`content`,`media` FROM `course` WHERE `uuid`=?",[$rows['uuid']]);
                switch($row['type']) {
                    case "potok": $type = "Потоктық"; break;
                    case "always": $type = "Постоянный"; break;
                    default: $type = ""; break;
                }
                ?>
        <div class="col-6 col-md-4 col-lg-3">
        <div class="border-0 mb-5">
            <? if($row['media']!=='empty') { ?>
                <img src="source/uploads/<?=$row['media'];?>/300/<?=$row['media'];?>" class="bg-body-secondary custom-promo rounded-4" alt="..." loading="lazy">
            <? } else {?> 
                <img src="source/images/600x600.svg" class="bg-body-secondary custom-promo rounded-4" alt="..." loading="lazy">
            <? } ?>
            <div class="mt-4">
                <h5 class="" style="height:48px;"><?=truncate_text($row['header'],50);?></h5>
                <p class="text-secondary" style="height:48px;"><?=truncate_text(nl2br($row['content']));?></p>
                <p>Бағасы: <b class="text-primary fs-5"><?=$row['price'];?> ₸</b></p>
                <a data-page href="?location=course_list_<?=$row['type'];?>&&uuid=<?=$row['uuid'];?>" class="btn btn-primary rounded-3">Толығырақ</a></li>
            </div>
        </div>
            </div>
        <? endforeach; ?>
        <!--  -->
    </div>
    <!-- <nav aria-label="Page navigation example">
        <ul class="pagination mt-5 d-flex justify-content-center">
            <li class="page-item mr-2"><a class="page-link bg bg-dark text-light" href="#">Артқа</a></li>
            <li class="page-item"><a class="page-link bg bg-dark text-light" href="#">1</a></li>
            <li class="page-item"><a class="page-link bg bg-dark text-light" href="#">2</a></li>
            <li class="page-item"><a class="page-link bg bg-dark text-light" href="#">3</a></li>
            <li class="page-item ml-2"><a class="page-link bg bg-dark text-light pl-2" href="#">Алға</a>
            </li>
        </ul>
    </nav> -->
    <!-- Add your content here -->
</div>
<? } ?>