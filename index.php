<? 
    require_once("pages/db.php");
    $db = $database->connect($mainConnection);
    $authExist = false;
    if(isset($_COOKIE['auth'])) {
        $auth = $_COOKIE['auth'];
        $authExist = $database->fetch($db, "SELECT `uuid` FROM `users` WHERE `last`=? AND (`status`=? OR `status`=?)", [$auth, 'admin', 'author']);
    }
    unset($db);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Zaru Academy</title>
    <!-- <link rel="manifest" href="manifest.json"> -->
    <style>
        #preloader {
            font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Open Sans, Helvetica Neue, sans-serif;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #fff;
            /* Цвет фона вашего прелоадера */
            display: flex;
            flex-direction: column;
            gap: 32px;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            /* Высокий z-index, чтобы прелоадер был наверху других элементов */
        }

        .spinner {
            border: 6px solid #f3f3f3;
            /* Цвет бордюра */
            border-top: 6px solid hsl(1, 49%, 40%);
            /* Цвет верхнего бордюра, создающего эффект вращения */
            border-radius: 50%;
            /* Для создания круглой формы */
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            /* Анимация вращения */
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Добавьте стили для вашего прелоадера, например, анимацию загрузки */
    </style>
</head>

<body>
    <!-- <div id="preloader">
        <img src="source/system-images/logo.webp" alt="">
        <div class="spinner"></div>
    </div> -->
    <? file_exists("etc/components/nav.php") && require_once("etc/components/nav.php");?>
    <div class="">
        <div class="container">
            <div class="row">
                <main id="renderHTML" class="container col-12 ms-sm-auto col-lg-12">
                    <h1 class="d-none" id="preloaderHTML">Loading</h1>
                    <div class="d-flex gap-3 mt-4 flex-wrap">
                        <button data-page-back class="btn bg-body-secondary rounded-3"><i class="bi bi-arrow-left"></i>
                            Артқа</button>
                        <button data-page-reload class="btn bg-body-secondary rounded-3">Бетті жаңарту <i
                                class="bi bi-arrow-clockwise"></i></button>
                        <? if($authExist!==false): ?>
                        <a data-page href="?location=admin_all" class="btn btn-danger rounded-3 fs-6">Редактор режимі <i class="bi bi-boxes"></i></a>
                        <? endif;?>
                    </div>
                    <div id="root">
                        <? 
                        $location = isset($_GET['location'])?$_GET['location']:"";
                        switch(true) {
                            case ($location==='auth'): file_exists("pages/auth.php") && require_once("pages/auth.php"); break;
                            case ($location==='my_courses'): file_exists("pages/my_courses.php") && require_once("pages/my_courses.php"); break;
                            case ($location==='register'): file_exists("pages/register.php") && require_once("pages/register.php"); break;
                            case ($location==='admin_potok'): file_exists("pages/admin_potok.php") && require_once("pages/admin_potok.php"); break;
                            case ($location==='admin_potok_add'): file_exists("pages/admin_potok_add.php") && require_once("pages/admin_potok_add.php"); break;
                            case ($location==='admin_potok_remove'): file_exists("pages/admin_potok_remove.php") && require_once("pages/admin_potok_remove.php"); break;
                            case ($location==='admin_all'): file_exists("pages/admin_all.php") && require_once("pages/admin_all.php"); break;
                            case ($location==='admin_list_lesson_always'): file_exists("pages/admin_list_always.php") && require_once("pages/admin_list_lesson_always.php"); break;
                            case ($location==='admin_list_lesson_potok'): file_exists("pages/admin_list_lesson_potok.php") && require_once("pages/admin_list_lesson_potok.php"); break;
                            case ($location==='course_list_potok'): file_exists("pages/course_list_potok.php") && require_once("pages/course_list_potok.php"); break;
                            case ($location==='course_list_lesson_potok'): file_exists("pages/course_list_lesson_potok.php") && require_once("pages/course_list_lesson_potok.php"); break;
                            case ($location==='course_list_lesson_potok_select'): file_exists("pages/course_list_lesson_potok_select.php") && require_once("pages/course_list_lesson_potok_select.php"); break;
                            default: file_exists("pages/all.php") && require_once("pages/all.php");
                        }
                    ?>
                    </div>
                    <? file_exists("etc/components/modal.php") && require_once("etc/components/modal.php");?>
                </main>
            </div>
        </div>
    </div>
    <script src="source/scripts/main.js" defer></script>
</body>

</html>