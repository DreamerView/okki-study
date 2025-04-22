<? 
    $uuid = $_GET['uuid'] ?? null;
    $selectedUUID = $_GET['selected_uuid'] ?? null;
    $topicUUID = $_GET['topic_uuid'] ?? null;
    if($selectedUUID===null) $uuid = null;
    if($topicUUID===null) $uuid = null;
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
            $info = $database->fetch($db,"SELECT `header`,`content` FROM `course` WHERE `uuid`=?",[$uuid]);
            $potok = $database->fetch($db,"SELECT `uuid` FROM `{$uuid}_potok` ORDER BY `time` DESC");
            if($authCheck!==false) {
                if($potok!==false) {
                    $users = $database->fetch($db,"SELECT `uuid`,`status` FROM `{$uuid}_users` WHERE `uuid`=? AND `sub_uuid`=?",[$authCheck['uuid'],$potok['uuid']]);
                }
            }
            $select = $database->fetch($db,"SELECT `uuid` FROM `{$potok['uuid']}_lesson_list` WHERE `uuid`=?",[$selectedUUID]);
            $lessons = $database->fetchAll($db,"SELECT `uuid`,`title`,`content` FROM `{$potok['uuid']}_lesson_list`");
            if($select===false) $uuid=null;
            else {
                $getTopic = $database->fetch($db,"SELECT `title`,`media`,`content`,`time` FROM `{$select['uuid']}_topic` WHERE `uuid`=?",[$topicUUID]);
                if($getTopic===false) $uuid=null;
                $playlist = $database->fetchAll($db,"SELECT `uuid`,`title`,`media`,`content`,`time` FROM `{$select['uuid']}_topic`");
                $url = $getTopic['media'];

                function getYouTubeVideoID($url) {
                    // Проверяем, если URL пустой
                    if (empty($url)) {
                        return false;
                    }
                
                    // Обрабатываем ссылки на прямые трансляции
                    if (strpos($url, 'youtube.com/live/') !== false) {
                        // Извлекаем идентификатор трансляции
                        preg_match('/\/live\/([^?\/]+)/', $url, $matches);
                        return isset($matches[1]) ? $matches[1] : false;
                    }
                
                    // Обрабатываем ссылки на видео вида "youtu.be"
                    if (preg_match('/youtu\.be\/([^\/\?]+)/', $url, $matches)) {
                        return isset($matches[1]) ? $matches[1] : false;
                    }
                
                    // Обрабатываем ссылки на видео вида "youtube.com/watch"
                    if (preg_match('/youtube\.com\/watch\?v=([^&]+)/', $url, $matches)) {
                        return isset($matches[1]) ? $matches[1] : false;
                    }
                
                    // Обрабатываем ссылки на видео вида "youtube.com/embed"
                    if (preg_match('/youtube\.com\/embed\/([^\/\?]+)/', $url, $matches)) {
                        return isset($matches[1]) ? $matches[1] : false;
                    }
                
                    return false;
                }
                
                // Пример использования                
                
                // Получить идентификатор видео из URL
                $video_id = getYouTubeVideoID($url);
                
                // Создать iframe с использованием полученного идентификатора видео
                if ($video_id) {
                    $iframe_code = '<iframe style="" class="custom-player d-flex rounded-4 bg-body-secondary" src="" data-src="'.$mainURL.'/pages/iframeRead.php?url='.$video_id.'"  loading="lazy"></iframe>';
                    // $iframe_code = '<div class="custom-player rounded-4 bg-body-secondary" id="playerPreloader"></div><div class="plyr__video-embed" style="display:none;" id="player"><iframe class="custom-player rounded-4 bg-body-secondary" src="https://www.youtube-nocookie.com/embed/' . $video_id . '?autoplay=1&&rel=0&&color=white&&hl=ko&&iv_load_policy=3&&modestbranding=1&&showinfo=0" allowfullscreen allowtransparency allow="autoplay" loading="lazy"></iframe></div>';
                } else {
                    $iframe_code = 'Не удалось извлечь идентификатор видео из URL.';
                }
            }
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
<div class="block_animation py-5">
    <h1><?=$getTopic['title'];?></h1>
    <p class="mt-4">Жарияланды: <span class="badge bg-body-secondary text-black fs-6 fw-normal py-2"><i class="bi bi-clock me-1"></i> <?=date("H:m, d.m.y", $getTopic['time']);?><span></p>
    <!-- Player -->
    <div class="row mt-sm-5 mt-3">
        <div class="col-12 col-lg-8 col-xxl-9">
            <?=$iframe_code;?>
            <div class="bg-body-secondary mt-sm-3 mt-4 p-3 rounded-4">
                <h2 class="fs-5 fw-bold mb-4"><i class="bi bi-chat-quote-fill me-2"></i>Сипаттама</h2>
                <p><?=nl2br($getTopic['content']);?></p>
            </div>
        </div>
        <div class="col-12 col-lg-4 col-xxl-3 mt-4 mt-lg-0">
            <div class="border border-2 border-light p-4 h-100 rounded-4">
                <h2 class="mb-5 fs-3">Жалғасы</h2>
                <div class="list-group">
                    <? foreach($playlist as $play): 
                        if($play['uuid']===$topicUUID) {
                            $attr = 'class="list-group-item list-group-item-action active" aria-current="true"';
                        } else {
                            $attr = 'class="list-group-item list-group-item-action"';
                        }   
                    ?>
                    <a data-page href="?location=course_list_lesson_potok_select&&uuid=<?=$uuid;?>&&selected_uuid=<?=$selectedUUID;?>&&topic_uuid=<?=$play['uuid'];?>" <?=$attr;?> ><i class="bi bi-collection-play-fill me-3"></i><?=$play['title'];?></a>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Player -->

    <!-- Description -->
    <!-- <p class="mt-sm-5 mt-4"><?=nl2br($getTopic['content']);?></p> -->
    <!-- Description -->

    <!-- Lessons -->
    <h1 class="text-center py-sm-5 py-4">Сабақтар</h1>
    <div class="accordion-borderless col-lg-10 col-12 mx-auto" id="accordionExample">
        <? foreach($lessons as $row): ?>
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
    <!-- Lessons -->

</div>
<script>
    // Получаем все элементы iframe
    var iframes = document.querySelectorAll('iframe');

    // Проходимся по всем iframe
    iframes.forEach(function(iframe) {
        // Получаем значение data-src из атрибута data-src
        var videoSrc = iframe.getAttribute('data-src');

        // Загружаем данные из data-src
        setTimeout(()=>{
            iframe.src = videoSrc;
        },[255]);
    });

</script>
<? } else { ?>
    <div class="my-5 mx-1 row justify-content-center">
        <div class="col-lg-8 col-12 bg-body-secondary p-5 rounded-4 text-center">
            <h1 class="mb-4">Бет табылмады</h1>
            <p>Өкінішке орай бет табылмады.</p>
            <a data-page class="mt-3 btn btn-lg btn-primary" href="?location=all">Үйге</a>
        </div>
    </div>
<? } ?>
