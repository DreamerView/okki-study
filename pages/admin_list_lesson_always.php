<? 
    $uuid = $_GET['uuid'] ?? null;
    require_once("db.php");
    $db = $database->connect($mainConnection);
    if($uuid!==null) {
        $check = $database->fetch($db,"SELECT `uuid`,`header` FROM `course` WHERE `uuid`=?",[$uuid]);
        if($check===false) $uuid=null;
        else {
            $select = $database->fetchAll($db,"SELECT `uuid`,`title`,`content` FROM `{$uuid}_lesson_list`");
            $select = array_reverse($select);
        }
    }
?>
<? if($uuid!==null) { ?>
<div class="mt-5 block_animation">
    <h1>Курс еңгізу</h1>
    <p class="mt-4">Курс таңдалды: <b class="badge bg-body-secondary fs-6 text-black"><?=$check['header'];?></b></p>
    <button data-bs-toggle="modal" data-bs-target="#createCourseLessonList" class="btn btn-lg btn-primary mt-4">Курс еңгізу <i class="bi bi-plus-square-dotted"></i></button>
    <!-- Accordian -->
    <div class="accordion-borderless mt-5" id="accordionExample">
        <? foreach($select as $row): ?>
        <div class="accordion-item my-2">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed fw-bold bg-body-secondary fs-5 px-4 py-3 rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#item_<?=$row['uuid'];?>" aria-expanded="false" aria-controls="item_<?=$row['uuid'];?>">
                    <?=$row['title'];?>
                </button>
            </h2>
            <div id="item_<?=$row['uuid'];?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body p-4">
                    <p><?=$row['content'];?><p>
                    <div class="d-flex gap-3 flex-wrap">
                        <button class="btn btn-primary">Сабақ қосу <i class="bi bi-plus-lg"></i></button>
                        <button data-bs-toggle="modal" data-bs-target="#editCourseLessonList"  data-list-uuid="<?=$uuid;?>" data-uuid="<?=$row['uuid'];?>" data-title="<?=$row['title'];?>" data-content="<?=$row['content'];?>" class="clickEditLesson btn btn-warning">Сабақ өзгерту <i class="bi bi-pencil-fill"></i></button>
                        <button data-bs-toggle="modal" data-bs-target="#deleteCourseLessonList" data-list-uuid="<?=$uuid;?>" data-uuid="<?=$row['uuid'];?>" class="clickDeleteLesson btn btn-danger">Сабақты жою <i class="bi bi-trash3-fill"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <? endforeach; ?>
    </div>

    <!-- Accordian -->
</div>
<script>
    function action() {
        document.querySelector("#course-lesson-list-uuid").value = "<?=$uuid;?>";
        const potoks = document.querySelectorAll(".clickEditLesson");
        potoks.forEach(potok=>{
            potok.addEventListener("click",()=> {
                const uuid = potok.getAttribute("data-uuid");
                const listUuid = potok.getAttribute("data-list-uuid");
                const uuidSelected = potok.getAttribute("data-title");
                const title = potok.getAttribute("data-content");
                document.querySelector("#course-list-lesson-uuid").value=uuid;
                document.querySelector("#course-list-lesson-uuid-selected").value=listUuid;
                document.querySelector("#course-list-lesson-title").value=uuidSelected;
                document.querySelector("#course-list-lesson-content").value=title;
            })
        });
        const rms = document.querySelectorAll(".clickDeleteLesson");
        rms.forEach(rm=>{
            rm.addEventListener("click",()=> {
                const uuid = rm.getAttribute("data-uuid");
                const listUuid = rm.getAttribute("data-list-uuid");
                document.querySelector("#delete-course-list-lesson-uuid").value=uuid;
                document.querySelector("#delete-course-list-lesson-uuid-selected").value=listUuid;
            })
        });
    }
    if(document.querySelector("#course-potok-uuid")) {
        action();
    } else {
        document.addEventListener('DOMContentLoaded', function() {
            action();
        });
    }
</script>
<? } else { ?>
    <div class="mt-4">
        <h1>Not found</h1>
    </div>
<? } ?>
