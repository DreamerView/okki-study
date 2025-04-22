<? 
    $uuid = $_GET['uuid'] ?? null;
    require_once("db.php");
    $db = $database->connect($mainConnection);
    if($uuid!==null) {
        $check = $database->fetch($db,"SELECT `uuid`,`header` FROM `course` WHERE `uuid`=?",[$uuid]);
        if($check===false) $uuid=null;
        else {
            $info = $database->fetch($db,"SELECT `header`,`content`,`time` FROM `course` WHERE `uuid`=?",[$uuid]);
            $potok = $database->fetch($db,"SELECT `uuid`,`title` FROM `{$uuid}_potok` ORDER BY `time` DESC");
            $authCheck = false;
            if(isset($_COOKIE['auth'])) {
                $auth = $_COOKIE['auth'];
                $authCheck = $database->fetch($db, "SELECT `uuid` FROM `users` WHERE `last`=?", [$auth]);
            }
            if($authCheck!==false) {
                if($potok!==false) {
                    $users = $database->fetch($db,"SELECT `uuid`,`status` FROM `{$uuid}_users` WHERE `uuid`=? AND `sub_uuid`=?",[$authCheck['uuid'],$potok['uuid']]);
                }
            }
        }
    }
?>
<? if($uuid!==null) { ?>
<div class="mt-5 block_animation">
    <h1><?=$info['header'];?></h1>
    <p class="mt-4">Курс құрылды: <span class="badge bg-body-secondary text-black fs-6 fw-normal py-2"><i class="bi bi-clock me-1"></i> <?=date("H:m, d.m.y", $info['time']);?><span></p>
    <p class="mt-4"><?=$info['content'];?></p>
    <? if($potok!==false): ?>
    <? if($authCheck!==false) { ?>
        <form data-form method="POST" action="api/sendRequestToPotok.php">
            <input type="hidden" name="course-uuid" value="<?=$uuid;?>">
            <? if($users!==false) { ?>
                <? if($users['status']==='waiting') { ?>
                    <div class="my-5 mx-1 row justify-content-center">
                        <div class="col-lg-8 col-12 bg-body-secondary p-5 rounded-4 text-center">
                            <h1 class="mb-4">Заявка тасталынды</h1>
                            <p>Заявка <b>"<?=$potok['title'];?>"</b> тасталынды. Күтіңіз.</p>
                            <button class="mt-3 btn btn-lg btn-warning" type="button">Күтіңіз</button>
                        </div>
                    </div>
                <? } else { ?>
                    <div class="my-5 mx-1 row justify-content-center">
                        <div class="col-lg-8 col-12 bg-body-secondary p-5 rounded-4 text-center">
                            <h1 class="mb-4">Құттықтаймыз!</h1>
                            <p>Құттықтаймыз! Сіз <b>"<?=$potok['title'];?>"</b> тіркелдіңіз.</p>
                            <a data-page class="mt-3 btn btn-lg btn-success" href="?location=course_list_lesson_potok&&uuid=<?=$uuid;?>">Кіру</a>
                        </div>
                    </div>
                <? } ?>
            <? } else { ?>
                    <div class="my-5 mx-1 row justify-content-center">
                        <div class="col-lg-8 col-12 bg-body-secondary p-5 rounded-4 text-center">
                            <h1 class="mb-4">Поток ашық</h1>
                            <p>Поток <b>"<?=$potok['title'];?>"</b> ашық. Заявка тастауға үлгеріңіз.</p>
                            <input type="hidden" name="course-uuid" value="<?=$uuid;?>">
                            <input type="hidden" name="sub-uuid" value="<?=$potok['uuid'];?>">
                            <button class="mt-3 btn btn-lg btn-primary type="submit" name="submit">Заявка тастау</button>
                        </div>
                    </div>
            <? } ?>
        </form>
    <? } else { ?>
        <div class="my-5 mx-1 row justify-content-center">
            <div class="col-lg-8 col-12 bg-body-secondary p-5 rounded-4 text-center">
                <h1 class="mb-4">Жүйеге кіріңіз</h1>
                <p>Жүйеге кіріңіз потоктың заявкасына тапсыру үшін</p>
                <a data-page class="mt-3 btn btn-lg btn-primary" href="?location=auth">Кіру</a>
            </div>
        </div>
    <? } ?>
    <? endif;?>
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
