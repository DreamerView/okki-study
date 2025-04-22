<? 
    require_once("db.php");
    $db = $database->connect($mainConnection);
    $select = $database->fetchAll($db,"SELECT `header`,`uuid`,`price`,`type`,`content`,`media` FROM `course`");
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
?>
<div class="mt-5 block_animation">
    <h1>Курстар</h1>
    <div id="carouselExampleCaptions" class="carousel slide mt-5" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner rounded-3">
            <? foreach($select as $key=>$row): 
                $type = "";
                switch($row['type']) {
                    case "potok": $type = "Потоктық"; break;
                    case "always": $type = "Постоянный"; break;
                    default: $type = ""; break;
                }    
            ?>
                <div class="carousel-item position-relative <?=$key===0?"active":""?>">
                    <div class="d-block w-100 rounded-4 position-absolute" style="bottom:0;z-index:2;height:250px;background-image: linear-gradient(180deg, hsla(0, 0%, 39%, 0) 0, #555555 95%);"></div>
                    <? if($row['media']!=='empty') { ?>
                        <img src="source/uploads/<?=$row['media'];?>/original/<?=$row['media'];?>" style="z-index:1;height:350px;object-fit:cover;" class="d-block w-100 rounded-4 bg-body-secondary" alt="..." loading="lazy">
                    <? } else { ?>
                        <img src="source/images/600x600.svg" style="z-index:1;height:350px;object-fit:cover;" class="d-block w-100 rounded-4 bg-body-secondary" alt="..." loading="lazy">
                    <? } ?>
                    <div class="carousel-caption d-md-block" style="z-index:5">
                        <h1><?=truncate_text($row['header'],50);?></h1>
                        <p><?=truncate_text(nl2br($row['content']));?></p>
                        <a data-page href="?location=course_list_<?=$row['type'];?>&&uuid=<?=$row['uuid'];?>" class="btn btn-primary rounded-3">Толығырақ</a>
                    </div>
                </div>
            <? endforeach; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="prev" style="z-index:5;">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="next" style="z-index:5;">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <h2 class="mt-5">Барлық курстар</h2>
    <div class="row py-5" style="">
        <!--  -->
        <? foreach($select as $row): 
                $type = "";
                switch($row['type']) {
                    case "potok": $type = "Потоктық"; break;
                    case "always": $type = "Постоянный"; break;
                    default: $type = ""; break;
                }
                ?>
        <div class="col-6 col-md-4 col-lg-3">
        <div class="border-0 mb-5">
            <? if($row['media']!=='empty') { ?>
                <img src="source/uploads/<?=$row['media'];?>/600/<?=$row['media'];?>" class="bg-body-secondary custom-promo rounded-4" alt="..." loading="lazy">
            <? } else {?> 
                <img src="source/images/600x600.svg" class="bg-body-secondary custom-promo rounded-4" alt="..." loading="lazy">
            <? } ?>
            <div class="mt-4">
                <h5 class=""><?=truncate_text($row['header'],50);?></h5>
                <p class="text-secondary fs-7"><?=truncate_text(nl2br($row['content']));?></p>
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