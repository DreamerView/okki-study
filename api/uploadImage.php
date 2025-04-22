<?php
$root = $_SERVER['DOCUMENT_ROOT'];
// Функция для создания директории
function createDirectory($path) {
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
}

// Функция для сжатия изображения до указанной ширины
function compressImage($source, $destination, $width) {
    // Получаем информацию о типе изображения
    $imageInfo = getimagesize($source);
    $mimeType = $imageInfo['mime'];

    // Создаем изображение в зависимости от типа файла
    switch ($mimeType) {
        case 'image/jpeg':
        case 'image/pjpeg': // Дополнительный MIME-тип для JPEG
            $image = imagecreatefromjpeg($source);
            break;
        case 'image/png':
            $image = imagecreatefrompng($source);
            break;
        case 'image/gif':
            $image = imagecreatefromgif($source);
            break;
        case 'image/webp':
            $image = imagecreatefromwebp($source);
            break;
        case 'image/bmp':
            $image = imagecreatefrombmp($source);
            break;
        default:
            echo 'Неподдерживаемый формат изображения.';
            return;
    }
    

    $originalWidth = imagesx($image);
    $originalHeight = imagesy($image);

    if ($originalWidth > $width) {
        $newHeight = ($width / $originalWidth) * $originalHeight;
        $newImage = imagecreatetruecolor($width, $newHeight);
        imagecopyresampled($newImage, $image, 0, 0, 0, 0, $width, $newHeight, $originalWidth, $originalHeight);
        
        // Сохраняем изображение в формате WebP
        imagewebp($newImage, $destination, 80);
    } else {
        copy($source, $destination);
    }

    imagedestroy($image);
}

// Путь для сохранения файлов
$uploadDirectory = "{$root}/source/uploads/";

// Проверяем, был ли загружен файл
if (isset($_FILES['image'])) {
    // Получаем информацию о загруженном файле
    $fileInfo = $_FILES['image'];

    // Генерируем UUID

    // Получаем расширение файла
    $extension = pathinfo($fileInfo['name'], PATHINFO_EXTENSION);

    // Формируем новое имя файла с UUID
    $newFilename = $uuid . '_' . $fileInfo['name'];
    
    // Создаем директорию для загруженного файла
    $filename = $uploadDirectory . $newFilename;
    createDirectory($filename);

    // Создаем вложенные директории
    createDirectory($filename . '/original');
    createDirectory($filename . '/300');
    createDirectory($filename . '/600');
    createDirectory($filename . '/900');

    // Сохраняем файл в указанную директорию
    move_uploaded_file($fileInfo['tmp_name'], $filename . '/' . $newFilename);

    // Сжатие изображения до указанных размеров
    $sizes = array(300, 600, 900);
    foreach ($sizes as $size) {
        compressImage($filename . '/' . $newFilename, $filename . '/' . $size . '/' . $newFilename, $size);
    }

    // Сжатие оригинального изображения до ширины 1000px
    compressImage($filename . '/' . $newFilename, $filename . '/original/' . $newFilename, 1000);

    // echo 'Изображение успешно загружено и обработано.';
} else {
    // echo 'Ошибка: Файл изображения не был загружен.';
}

?>
