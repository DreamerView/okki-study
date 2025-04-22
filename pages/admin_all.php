<? 
    require_once("db.php");
    $db = $database->connect($mainConnection);
    $authCheck = false;
    if(isset($_COOKIE['auth'])) {
        $auth = $_COOKIE['auth'];
        $authCheck = $database->fetch($db, "SELECT `uuid` FROM `users` WHERE `last`=? AND (`status`=? OR `status`=?)", [$auth, 'admin', 'author']);
    }
    if($authCheck!==false) {
        $select = $database->fetchAll($db,"SELECT `header`,`uuid`,`price`,`type`,`content` FROM `course` WHERE `author`=?",[$authCheck['uuid']]);
        $select = array_reverse($select);
?>
    <div class="mt-5 block_animation">
        <h1>Барлық курстар</h1>
        <button data-bs-toggle="modal" data-bs-target="#createCourse" class="btn btn-lg btn-primary mt-4">Курс құрастыру <i class="bi bi-journal-plus"></i></button>
        <table class="table table-striped mt-5">
            <thead>
                <tr>
                    <th>Аты</th>
                    <th>Іс-қимыл</th>
                </tr>
            </thead>
            <tbody>
                <? foreach($select as $row): 
                    $type = "";
                    switch($row['type']) {
                        case "potok": $type = "Потоктық"; break;
                        case "always": $type = "Постоянный"; break;
                        default: $type = ""; break;
                    }
                    ?>
                <tr>
                    <td><?=$row['header'];?></td>
                    <td>
                        <!-- <a data-page class="btn btn-success" href="?location=admin_list_lesson&&uuid=<?=$row['uuid'];?>"><i class="bi bi-plus-lg"></i></a> -->
                        <button data-title="<?=$row['header'];?>" data-content="<?=$row['content'];?>" data-type="<?=$row['type'];?>" data-price="<?=$row['price'];?>" data-uuid="<?=$row['uuid'];?>" data-bs-toggle="modal" data-bs-target="#editCourse" class="ms-2 btn btn-warning clickEdit" type="button"><i class="bi bi-pencil-fill"></i></button>
                        <button class="ms-2 btn btn-danger" type="button"><i class="bi bi-trash-fill"></i></button>
                        <button data-title="<?=$row['header'];?>" data-content="<?=$row['content'];?>" data-type="<?=$type;?>" data-price="<?=$row['price'];?>" data-bs-toggle="modal" data-bs-target="#infoCourse" class="ms-2 btn btn-info clickInfo" type="button"><i class="bi bi-info-circle-fill"></i></button>
                        <a data-page class="ms-2 btn btn-primary" href="?location=admin_potok&&uuid=<?=$row['uuid'];?>"><i class="bi bi-person-fill-add"></i></a>
                    </td>
                </tr>
                <? endforeach; ?>
                
            </tbody>
        </table>
    </div>
    <script>
        function action() {
            const potoks = document.querySelectorAll(".clickEdit");
            potoks.forEach(potok=>{
                potok.addEventListener("click",()=> {
                    const uuid = potok.getAttribute("data-uuid");
                    const title = potok.getAttribute("data-title");
                    const content = potok.getAttribute("data-content");
                    const price = potok.getAttribute("data-price");
                    const type = potok.getAttribute("data-type");
                    document.querySelector("#course-edit-name").value=title;
                    document.querySelector("#course-edit-type").value=type;
                    document.querySelector("#course-edit-price").value=price;
                    document.querySelector("#course-edit-text").value=content;
                    document.querySelector("#course-edit-uuid").value=uuid;
                });
            });
            const courses = document.querySelectorAll(".clickInfo");
            courses.forEach(course=>{
                course.addEventListener("click",()=> {
                    const title = course.getAttribute("data-title");
                    const content = course.getAttribute("data-content");
                    const price = course.getAttribute("data-price");
                    const type = course.getAttribute("data-type");
                    document.querySelector("#course-info-title").innerText=title;
                    document.querySelector("#course-info-type").innerText=type;
                    document.querySelector("#course-info-price").innerText=price;
                    document.querySelector("#course-info-content").innerText=content;
                });
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
    <div class="my-5 mx-1 row justify-content-center">
        <div class="col-lg-8 col-12 bg-body-secondary p-5 rounded-4 text-center">
            <h1 class="mb-4">Құқық жеткіліксіз</h1>
            <p>Өкінішке орай сізде құқық жеткіліксіз!</p>
            <a data-page class="mt-3 btn btn-lg btn-primary" href="?location=all">Үйге</a>
        </div>
    </div>
<? } ?>
