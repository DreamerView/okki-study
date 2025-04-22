<? $url = $_GET['url']; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/source/styles/plyr.css">
    <script src="/source/scripts/plyr.js"></script>
    <style>
        * {
            margin:0;
            padding:0;
        }
        .container {
            position: relative;
            display: inline-block; /* Чтобы контейнер подстраивался по размерам изображения */
            pointer-events:none;
        }
        
        iframe#youtubePlayer {
            width:100vw;
            aspect-ratio: 16/9;
            pointer-events: none!important;
            overflow: hidden;
            pointer-events: none;
            z-index:0;
        }
        .youtubePlayerRelative {
            width:100vw;
            aspect-ratio: 16/2;
            position:absolute;
            z-index:5555555;
        }
    </style>
</head>
<body style="opacity:0;">
    <div>
        <div class="youtubePlayerRelative"></div>
        <div id="player" data-plyr-provider="youtube" data-plyr-embed-id="<?=$url;?>"></div>
    </div>
    <!-- <div class="plyr__video-embed" id="player">
        <div class="youtubePlayerRelative"></div>
        <iframe style='pointer-events: none;' id="youtubePlayer" class="custom-player rounded-4 bg-body-secondary" src="https://www.youtube-nocookie.com/embed/<?=$url;?>?autoplay=1&&rel=0&&color=white&&hl=ko&&iv_load_policy=3&&modestbranding=1&&showinfo=0"></iframe>
    </div> -->
    <script type="module">
        const filesToLoad = [
            {path:"/source/styles/plyr.css", type:"link"},
            {path:"/source/scripts/plyr.js", type:"script"},
            {path:"/source/scripts/plyrPlayer.js", type:"script"}
        ];
        const loadResource = (filePath, type) => new Promise((resolve, reject) => {
            const element = document.createElement(type);
            if (type === 'script') {
                element.src = filePath;
                element.onload = resolve;
                element.onerror = reject;
                element.defer = true;
                document.body.appendChild(element);
            } else if (type === 'link') {
                element.href = filePath;
                element.rel = 'stylesheet';
                element.onload = resolve;
                element.onerror = reject;
                document.head.appendChild(element);
            }
        });


        const loadResourcesSequentially = async (resources) => {
            for (const { path, type } of resources) {
                try { await loadResource(path, type); }
                catch (error) { console.error(`Ошибка загрузки ${path}:`, error); }
            }
            console.log('Все ресурсы загружены.');
        };
        document.addEventListener("DOMContentLoaded", ()=> {
            loadResourcesSequentially(filesToLoad)
                .then(() => {document.body.style.cssText = "opacity: 1"})
                .catch((error) => console.log('Произошла ошибка при загрузке ресурсов:', error))
        });
    </script>
</body>
</html>