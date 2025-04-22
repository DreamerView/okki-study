<? 
    $mainUUID = $_GET['main_uuid'] ?? null;
    $uuid = $_GET['uuid'] ?? null;
    require_once("db.php");
    $db = $database->connect($mainConnection);
    if($mainUUID!==null && $uuid!==null) {
        $check = $database->fetch($db,"SELECT `uuid`,`header` FROM `course` WHERE `uuid`=?",[$mainUUID]);
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
    <p class="mt-5">Курс таңдалды: <b class="badge bg-body-secondary fs-6 text-black"><?=$check['header'];?></b></p>
    <button data-bs-toggle="modal" data-bs-target="#createCourseLessonList" class="createTopic btn btn-lg btn-primary mt-4">Бөлім құру <i class="bi bi-plus-square-dotted"></i></button>
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
                    <div class="d-flex gap-3 flex-wrap mb-4">
                        <button 
                            data-bs-toggle="modal" 
                            data-bs-target="#createTopic" 
                            data-main-uuid="<?=$mainUUID;?>" 
                            data-list-uuid="<?=$uuid;?>" 
                            data-uuid="<?=$row['uuid'];?>" 
                            class="btn btn-primary createTopic">
                            Сабақ қосу <i class="bi bi-plus-lg"></i>
                        </button>
                        <button 
                            data-bs-toggle="modal" 
                            data-bs-target="#editCourseLessonList" 
                            data-main-uuid="<?=$mainUUID;?>"  
                            data-list-uuid="<?=$uuid;?>" 
                            data-uuid="<?=$row['uuid'];?>" 
                            data-title="<?=$row['title'];?>" 
                            data-content="<?=$row['content'];?>" 
                            class="clickEditLesson btn btn-warning">
                            Бөлімді өзгерту <i class="bi bi-pencil-fill"></i>
                        </button>
                        <button 
                            data-bs-toggle="modal" 
                            data-bs-target="#deleteCourseLessonList" 
                            data-main-uuid="<?=$mainUUID;?>" 
                            data-list-uuid="<?=$uuid;?>" 
                            data-uuid="<?=$row['uuid'];?>" 
                            class="clickDeleteLesson btn btn-danger">
                            Бөлімді жою <i class="bi bi-trash3-fill"></i>
                        </button>
                    </div>
                    <? 
                        $getTopic = $database->fetchAll($db,"SELECT `uuid`,`title`,`content`,`media` FROM `{$row['uuid']}_topic`");
                        foreach($getTopic as $topic):
                    ?>
                    <div class="d-flex gap-3 mb-3 align-items-center">
                        <button class="btn btn-primary" href=""><i class="bi bi-collection-play-fill"></i></button>
                        <p class="fs-5 my-auto"><?=$topic['title'];?></p>
                        <div class="ms-auto">
                            <a 
                                data-page
                                title="Тапсырма" 
                                class="btn btn-primary" 
                                href="?location=all">
                                <i class="bi bi-list-task"></i>
                            </a>
                            <button
                                title="Өзгерту" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editTopic"
                                data-main-uuid="<?=$mainUUID;?>" 
                                data-list-uuid="<?=$uuid;?>" 
                                data-uuid="<?=$row['uuid'];?>"
                                data-topic-uuid="<?=$topic['uuid'];?>" 
                                data-topic-title="<?=$topic['title'];?>" 
                                data-topic-content="<?=$topic['content'];?>" 
                                data-topic-media="<?=$topic['media'];?>" 
                                class="editTopic btn btn-warning">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                            <button 
                                title="Жою"
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteTopic"
                                data-main-uuid="<?=$mainUUID;?>" 
                                data-list-uuid="<?=$uuid;?>" 
                                data-uuid="<?=$row['uuid'];?>"
                                data-topic-uuid="<?=$topic['uuid'];?>" 
                                class="deleteTopic btn btn-danger">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                        </div>
                    </div>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
        <? endforeach; ?>
    </div>

    <!-- Accordian -->
</div>
<script>
    function action() {
        document.querySelector("button.createTopic").addEventListener("click",()=> {
            document.querySelector("#course-lesson-list-uuid").value = "<?=$uuid;?>";
            document.querySelector("#main-course-lesson-list-uuid").value = "<?=$mainUUID;?>";
        })
        const potoks = document.querySelectorAll(".clickEditLesson");
        potoks.forEach(potok=>{
            potok.addEventListener("click",()=> {
                const uuid = potok.getAttribute("data-uuid");
                const listUuid = potok.getAttribute("data-list-uuid");
                const mainUuid = potok.getAttribute("data-main-uuid");
                const uuidSelected = potok.getAttribute("data-title");
                const title = potok.getAttribute("data-content");
                document.querySelector("#course-list-lesson-uuid").value=uuid;
                document.querySelector("#course-list-lesson-uuid-selected").value=listUuid;
                document.querySelector("#main-course-list-lesson-uuid").value=mainUuid;
                document.querySelector("#course-list-lesson-title").value=uuidSelected;
                document.querySelector("#course-list-lesson-content").value=title;
            })
        });
        const rms = document.querySelectorAll(".clickDeleteLesson");
        rms.forEach(rm=>{
            rm.addEventListener("click",()=> {
                const uuid = rm.getAttribute("data-uuid");
                const listUuid = rm.getAttribute("data-list-uuid");
                const mainUuid = rm.getAttribute("data-main-uuid");
                document.querySelector("#delete-course-list-lesson-uuid").value=uuid;
                document.querySelector("#delete-course-list-lesson-uuid-selected").value=listUuid;
                document.querySelector("#delete-course-list-lesson-uuid-main").value=mainUuid;
            })
        });
        const createTopic = document.querySelectorAll(".createTopic");
        createTopic.forEach(topic=>{
            topic.addEventListener("click",()=> {
                const uuid = topic.getAttribute("data-uuid");
                const listUuid = topic.getAttribute("data-list-uuid");
                const mainUuid = topic.getAttribute("data-main-uuid");
                document.querySelector("#create-topic-uuid").value=uuid;
                document.querySelector("#create-topic-uuid-lesson-selected").value=listUuid;
                document.querySelector("#create-topic-uuid-selected").value=mainUuid;
            })
        });

        const editTopic = document.querySelectorAll(".editTopic");
        editTopic.forEach(topic=>{
            topic.addEventListener("click",()=> {
                const uuid = topic.getAttribute("data-uuid");
                const listUuid = topic.getAttribute("data-list-uuid");
                const mainUuid = topic.getAttribute("data-main-uuid");
                const topicID = topic.getAttribute("data-topic-uuid");
                const topicTitle = topic.getAttribute("data-topic-title");
                const topicContent = topic.getAttribute("data-topic-content");
                const topicMedia = topic.getAttribute("data-topic-media");
                document.querySelector("#edit-topic-uuid").value=uuid;
                document.querySelector("#edit-topic-uuid-lesson-selected").value=listUuid;
                document.querySelector("#edit-topic-uuid-selected").value=mainUuid;
                document.querySelector("#edit-topic-title").value=topicTitle;
                document.querySelector("#edit-topic-content").value=topicContent;
                document.querySelector("#edit-topic-media").value=topicMedia;
                document.querySelector("#edit-topic-self-uuid").value=topicID;
            })
        });

        const deleteTopic = document.querySelectorAll(".deleteTopic");
        deleteTopic.forEach(topic=>{
            topic.addEventListener("click",()=> {
                const uuid = topic.getAttribute("data-uuid");
                const listUuid = topic.getAttribute("data-list-uuid");
                const mainUuid = topic.getAttribute("data-main-uuid");
                const topicID = topic.getAttribute("data-topic-uuid");
                document.querySelector("#delete-topic-uuid").value=uuid;
                document.querySelector("#delete-topic-uuid-lesson-selected").value=listUuid;
                document.querySelector("#delete-topic-uuid-selected").value=mainUuid;
                document.querySelector("#delete-topic-self-uuid").value=topicID;
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
