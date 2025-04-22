<? 
    $uuid = $_GET['uuid'] ?? null;
    require_once("db.php");
    $db = $database->connect($mainConnection);
    if($uuid!==null) {
        $check = $database->fetch($db,"SELECT `uuid`,`header` FROM `course` WHERE `uuid`=?",[$uuid]);
        if($check===false) $uuid=null;
        else {
            $select = $database->fetchAll($db,"SELECT `uuid`,`title` FROM `{$uuid}_potok`");
            $select = array_reverse($select);
        }
    }
?>
<? if($uuid!==null) { ?>
<div class="mt-5 block_animation">
    <h1>Курстың потоктары</h1>
    <p class="mt-5">Курс таңдалды: <b class="badge bg-body-secondary fs-6 text-black"><?=$check['header'];?></b></p>
    <button data-bs-toggle="modal" data-bs-target="#createCoursePotok" class="createPotok btn btn-lg btn-primary mt-4">Поток құрастыру <i class="bi bi-person-plus-fill"></i></button>
    <table class="table table-striped mt-5">
        <thead>
            <tr>
                <th>Аты</th>
                <th>Іс-қимыл</th>
            </tr>
        </thead>
        <tbody>
            <? foreach($select as $row): ?>
            <tr>
                <td><?=$row['title'];?></td>
                <td>
                    <a data-page class="btn btn-success" href="?location=admin_list_lesson_potok&&uuid=<?=$row['uuid'];?>&&main_uuid=<?=$uuid;?>"><i class="bi bi-plus-lg"></i></a>
                    <button data-title="<?=$row['title'];?>" data-uuid-selected="<?=$uuid;?>" data-uuid="<?=$row['uuid'];?>" data-bs-toggle="modal" data-bs-target="#editCoursePotok" class="btn btn-warning clickEditPotok" type="button"><i class="bi bi-pencil-fill"></i></button>
                    <a data-page href="?location=admin_potok_add&&uuid=<?=$uuid;?>&&potok_uuid=<?=$row['uuid'];?>" class="ms-2 btn btn-primary"><i class="bi bi-person-fill-add"></i></a>
                    <a  data-page href="?location=admin_potok_remove&&uuid=<?=$uuid;?>&&potok_uuid=<?=$row['uuid'];?>" class="ms-2 btn btn-danger" ><i class="bi bi-person-fill-dash"></i></a>
                </td>
            </tr>
            <? endforeach; ?>
            
        </tbody>
    </table>
</div>
<script>
    function action() {
        document.querySelector("button.createPotok").addEventListener("click",()=>{
            document.querySelector("#course-potok-uuid").value = "<?=$uuid;?>";
        });
        const potoks = document.querySelectorAll(".clickEditPotok");
        potoks.forEach(potok=>{
            potok.addEventListener("click",()=> {
                const uuid = potok.getAttribute("data-uuid");
                const uuidSelected = potok.getAttribute("data-uuid-selected");
                const title = potok.getAttribute("data-title");
                document.querySelector("#course-potok-edit-uuid").value=uuid;
                document.querySelector("#course-potok-edit-uuid-selected").value=uuidSelected;
                document.querySelector("#editPotokResult").innerText=title;
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
