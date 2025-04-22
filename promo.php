<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Zaru Academy</title>
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

<body class="d-flex h-100 text-center text-bg-dark">
    <div id="preloader">
        <!-- Ваш прелоадер может содержать, например, анимацию загрузки -->
        <!-- Здесь можно использовать изображение, SVG или другие элементы -->
        <img src="source/system-images/logo.webp" alt="">
        <div class="spinner"></div>
    </div>
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
  <header class="mb-auto">
    <div>
      <h3 class="float-md-start mb-0">Cover</h3>
      <nav class="nav nav-masthead justify-content-center float-md-end">
        <a class="nav-link fw-bold py-1 px-0 active" aria-current="page" href="#">Home</a>
        <a class="nav-link fw-bold py-1 px-0" href="#">Features</a>
        <a class="nav-link fw-bold py-1 px-0" href="#">Contact</a>
      </nav>
    </div>
  </header>

  <main class="px-3">
    <h1>Cover your page.</h1>
    <p class="lead">Cover is a one-page template for building simple and beautiful home pages. Download, edit the text, and add your own fullscreen background photo to make it your own.</p>
    <p class="lead">
      <a href="#" class="btn btn-lg btn-light fw-bold border-white bg-white">Learn more</a>
    </p>
  </main>

  <footer class="mt-auto text-white-50">
    <p>Cover template for <a href="https://getbootstrap.com/" class="text-white">Bootstrap</a>, by <a href="https://twitter.com/mdo" class="text-white">@mdo</a>.</p>
  </footer>
</div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function loadCSS(url) {
                var link = document.createElement('link');
                link.rel = 'stylesheet';
                link.type = 'text/css';
                link.href = url;
                document.head.appendChild(link);
            }

            // Ленивая загрузка CSS-файла после загрузки контента страницы
            loadCSS('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
            loadCSS(
                'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css'
            );
            setTimeout(() => {
                const preloader = document.getElementById('preloader');
                preloader.style.display = 'none';
            }, [1000]);

            function makeHtmlRequest(url, successCallback, errorCallback) {
                var xhr = new XMLHttpRequest();

                xhr.open('GET', url, true);

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        if (xhr.status >= 200 && xhr.status < 300) {
                            successCallback(xhr.responseText);
                        } else {
                            errorCallback(xhr.statusText);
                        }
                    }
                };

                xhr.onerror = function () {
                    errorCallback('Произошла ошибка при отправке запроса');
                };

                xhr.send();
            }
            document.getElementById('loadDataLink').addEventListener('click', function(event) {
                document.querySelector("h1#preloaderHTML").style.display="block";
                makeHtmlRequest('courses/lazy.php',
                    function (data) {
                        document.querySelector('main#renderHTML').innerHTML = data;
                        document.querySelector("h1#preloaderHTML").style.display="none";
                    },
                    function (error) {
                        console.error('Ошибка при загрузке данных:', error);
                        // Ваш код обработки ошибки
                    }
                );
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous" defer></script>
</body>

</html>