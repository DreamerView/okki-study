<? 
    $uuid = $_GET['uuid'] ?? null;
    $potok_uuid = $_GET['potok_uuid'] ?? null;
    require_once("db.php");
    $db = $database->connect($mainConnection);
    if($uuid!==null) {
        $check = $database->fetch($db,"SELECT `uuid`,`header` FROM `course` WHERE `uuid`=?",[$uuid]);
        if($check===false) $uuid=null;
        else {
            $select = $database->fetchAll($db,"SELECT `uuid`,`status`,`time` FROM `{$uuid}_users` WHERE `status`=? AND `sub_uuid`=?",['accept',$potok_uuid]);
            
            $select = array_reverse($select);
        }
    }
?>
<? if($uuid!==null) { ?>
<div class="mt-5 block_animation">
    <h1>Потокқа қабылданған студенттер</h1>
    <p class="mt-5">Курс таңдалды: <b class="badge bg-body-secondary fs-6 text-black"><?=$check['header'];?></b></p>
    <table class="table table-striped mt-5">
        <thead>
            <tr>
                <th>Аты және байланыс</th>
                <th>Іс-қимыл</th>
            </tr>
        </thead>
        <tbody>
            <? foreach($select as $row): 
                $user = $database->fetch($db, "SELECT `name`,`surname`,`phone` FROM `users` WHERE `uuid`=?", [$row['uuid']]);    
            ?>
            <tr>
                <td><?=$user['name'];?> <?=$user['surname'];?> <b>(<?=$user['phone'];?>)</b></td>
                <td class="d-flex gap-2">
                    <form data-form method="POST" action="api/declineRequestToPotok.php">
                        <input type="hidden" name="course-uuid" value="<?=$uuid;?>">
                        <input type="hidden" name="sub-uuid" value="<?=$potok_uuid;?>">
                        <input type="hidden" name="user-uuid" value="<?=$row['uuid'];?>">
                        <button title="Жою" class="ms-2 btn btn-danger" type="submit" name="submit"><i class="bi bi-person-fill-dash"></i></button>
                    </form>
                </td>
            </tr>
            <? endforeach; ?>
            
        </tbody>
    </table>
</div>
<? } else { ?>
    <div class="mt-4">
        <h1>Not found</h1>
    </div>
<? } ?>
