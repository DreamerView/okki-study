window.addEventListener('load', () => {
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('service-worker.js')
            .then(registration => {
                console.log('Service Worker registered:', registration);
            })
            .catch(error => {
                console.error('Service Worker registration failed:', error);
            });
    }

    const resources = [
        'source/styles/bootstrap.min.css',
        'source/styles/animation.css',
        'source/styles/custom.css',
        'https://cdnjs.cloudflare.com/ajax/libs/plyr/3.7.8/plyr.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css',
        'source/scripts/jquery.min.js',
        'source/scripts/bootstrap.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/plyr/3.7.8/plyr.min.js',
        'source/scripts/router.js',
    ];

    let resourceCount = 0;

    // Функция загрузки ресурса по его URL-адресу
    const loadResource = (url, callback) => {
        const extension = url.split('.').pop();
        let element;

        if (extension === 'css') {
            element = document.createElement('link');
            element.rel = 'stylesheet';
            element.type = 'text/css';
        } else if (extension === 'js') {
            element = document.createElement('script');
            element.type = 'text/javascript';
            element.async = true; // Скрипты загружаются асинхронно
        } else {
            console.error('Unsupported resource type:', extension);
            return;
        }

        element.addEventListener('load', () => {
            resourceCount++;
            checkLoad();
            if (callback) {
                callback();
            }
        });

        element.addEventListener('error', () => {
            console.error('Failed to load resource:', url);
            resourceCount++; // Даже если ресурс не загрузился, мы должны увеличить счетчик, чтобы избежать блокировки загрузки других ресурсов
            checkLoad();
        });

        if (extension === 'css') {
            element.href = url;
            document.head.appendChild(element);
        } else if (extension === 'js') {
            // Для скриптов устанавливаем src после добавления в DOM
            element.src = url;
            document.body.appendChild(element);
        }
    };

    // Функция проверки загрузки всех ресурсов
    const checkLoad = () => {
        // Проверяем, загружены ли все ресурсы
        if (resourceCount === resources.length) {
            // Все ресурсы загружены, можно выключить прелоадер
            const preloader = document.getElementById('preloader');
            if (preloader) {
                preloader.style.display = 'none';
                document.body.style.cssText = "opacity: 1"
            }
        }
    };

    // Загрузка ресурсов поэтапно
    const loadResourcesSequentially = (urls, index) => {
        if (index < urls.length) {
            loadResource(urls[index], () => {
                loadResourcesSequentially(urls, index + 1);
            });
        }
    };

    // Запуск загрузки ресурсов
    loadResourcesSequentially(resources, 0);
});

