<html>
<head>
   <link href="https://vjs.zencdn.net/7.19.2/video-js.css" rel="stylesheet" />
</head>
<body>
   <video
      id="my-video"
      class="video-js vjs-big-play-centered vjs-theme-sea"
      controls
      preload="auto"
      fluid="true"
      data-setup='{
         "techOrder": ["youtube"],
         "sources": [{ "type": "video/youtube", "src":
         "https://www.youtube-nocookie.com/embed/-vmvXVeKHo8"}] },
         "youtube": {
            "ytControls": 2,
            "customVars": { "wmode": "transparent"}
         }'
      >
   </video>
      <script src="https://vjs.zencdn.net/7.17.0/video.min.js">
      </script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-youtube/2.6.1/Youtube.min.js"></script>
      <script>
         var player = videojs('my-video');
      </script>
</body>
</html>