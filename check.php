<?php
// Пример URL прямого эфира YouTube
$url = 'https://www.youtube.com/watch?v=ON7d4DCBBlk';

// Функция для извлечения идентификатора видео из URL
// Функция для извлечения идентификатора видео из URL
function getYouTubeVideoID($url) {
    $parsed_url = parse_url($url);
    if (isset($parsed_url['query'])) {
        parse_str($parsed_url['query'], $query);
        if (isset($query['v'])) {
            return $query['v'];
        }
    }
    // Вернуть false, если не удается извлечь идентификатор видео
    return false;
}

// Получить идентификатор видео из URL
$video_id = getYouTubeVideoID($url);

// Создать iframe с использованием полученного идентификатора видео
if ($video_id) {
    $iframe_code = '<iframe width="640" height="360" src="source/images/youtube.png" data-src="https://www.youtube.com/embed/' . $video_id . '" frameborder="0" allowfullscreen  loading="lazy"></iframe>';
} else {
    echo 'Не удалось извлечь идентификатор видео из URL.';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lazy Loading YouTube Video with Placeholder</title>
</head>
<body>

<!-- iframe с via.placeholder в качестве placeholder src и data-src для реальной ссылки на видео YouTube -->
<?=$iframe_code;?>
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Получаем все элементы iframe
  var iframes = document.querySelectorAll('iframe');

  // Проходимся по всем iframe
  iframes.forEach(function(iframe) {
    // Получаем значение data-src из атрибута data-src
    var videoSrc = iframe.getAttribute('data-src');

    // Загружаем данные из data-src
    setTimeout(()=>{
        iframe.src = videoSrc;
    },[500])
  });
});

</script>

</body>
</html>

