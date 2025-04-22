<? 
    $uuid = $_GET['uuid'] ?? null;
    require_once("db.php");
    $db = $database->connect($mainConnection);
    $authCheck = false;
    if(isset($_COOKIE['auth'])) {
        $auth = $_COOKIE['auth'];
        $authCheck = $database->fetch($db, "SELECT `uuid` FROM `users` WHERE `last`=?", [$auth]);
    }
    if($uuid!==null) {
        $check = $database->fetch($db,"SELECT `uuid`,`header` FROM `course` WHERE `uuid`=?",[$uuid]);
        if($check===false) $uuid=null;
        else {
            $info = $database->fetch($db,"SELECT `header`,`content`,`time` FROM `course` WHERE `uuid`=?",[$uuid]);
            $potok = $database->fetch($db,"SELECT `uuid` FROM `{$uuid}_potok` ORDER BY `time` DESC");
            if($potok!==false) {
                $users = $database->fetch($db,"SELECT `uuid`,`status` FROM `{$uuid}_users` WHERE `uuid`=? AND `sub_uuid`=?",[$authCheck['uuid'],$potok['uuid']]);
            }
            $select = [];
            if($potok!==false) {
                $select = $database->fetchAll($db,"SELECT `uuid`,`title`,`content` FROM `{$potok['uuid']}_lesson_list`");
            }
            $select = array_reverse($select);
        }
    }
?>
<? if($authCheck===false) { ?>
    <div class="my-5 mx-1 row justify-content-center">
        <div class="col-lg-8 col-12 bg-body-secondary p-5 rounded-4 text-center">
            <h1 class="mb-4">Жүйеге кіріңіз</h1>
            <p>Курсты толық деңгейде қолдану үшін, жүйеге кіріңуіңізді сұраймыз.</p>
            <a data-page class="mt-3 btn btn-lg btn-primary" href="?location=auth">Кіру</a>
        </div>
    </div>
<? } else if($users===false) { ?>
    <div class="my-5 mx-1 row justify-content-center">
        <div class="col-lg-8 col-12 bg-body-secondary p-5 rounded-4 text-center">
            <h1 class="mb-4">Құқық жоқ</h1>
            <p>Өкінішке орай сізде құқық жоқ материалды көруге.</p>
            <a data-page class="mt-3 btn btn-lg btn-primary" href="?location=all">Үйге</a>
        </div>
    </div>
<? } else if($uuid!==null) { ?>
<div class="mt-5 block_animation">
    <h1><?=$info['header'];?></h1>
    <p class="mt-4">Курс құрылды: <span class="badge bg-body-secondary text-black fs-6 fw-normal py-2"><i class="bi bi-clock me-1"></i> <?=date("H:m, d.m.y", $info['time']);?><span></p>
    <p class="mt-4"><?=$info['content'];?></p>
    <!-- Accordian -->
    <div class="accordion-borderless col-lg-10 col-12 mx-auto mt-5" id="accordionExample">
        <? foreach($select as $row): ?>
        <div class="accordion-item my-3">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed fw-bold bg-body-secondary fs-5 px-4 py-3 rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#item_<?=$row['uuid'];?>" aria-expanded="false" aria-controls="item_<?=$row['uuid'];?>">
                    <i class="bi bi-journal-bookmark-fill me-3"></i><?=$row['title'];?>
                </button>
            </h2>
            <div id="item_<?=$row['uuid'];?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body p-4">
                    <p><?=$row['content'];?><p>
                    <? 
                        $getTopic = $database->fetchAll($db,"SELECT `uuid`,`title`,`time` FROM `{$row['uuid']}_topic`");
                        foreach($getTopic as $topic):
                    ?>
                    <a data-page href="?location=course_list_lesson_potok_select&&uuid=<?=$uuid;?>&&selected_uuid=<?=$row['uuid'];?>&&topic_uuid=<?=$topic['uuid'];?>" class="mt-2 btn btn-outline-primary fs-5 w-100 text-start d-flex align-items-center">
                        <i class="bi bi-collection-play-fill me-3 fs-4"></i>
                        <?=$topic['title'];?>
                        <span class="ms-auto text-secondary fs-6"><i class="bi bi-clock me-1"></i> <?=date("H:m, d.m.y", $topic['time']);?></span>
                    </a>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
        <? endforeach; ?>
    </div>

    <!-- Accordian -->
</div>
<? } else { ?>
    <div class="my-5 mx-1 row justify-content-center">
        <div class="col-lg-8 col-12 bg-body-secondary p-5 rounded-4 text-center">
            <h1 class="mb-4">Бет табылмады</h1>
            <p>Өкінішке орай бет табылмады.</p>
            <a data-page class="mt-3 btn btn-lg btn-primary" href="?location=all">Үйге</a>
        </div>
    </div>
<? } ?>
