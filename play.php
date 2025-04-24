<?php
$id = $_GET["id"] ?? die("Invalid ID.");
?>
<html>
<head>
    <title>CricHD | <?php echo $id; ?></title>
    <link rel="stylesheet" type="text/css" href="clap.css">
    <script src="//cdn.jsdelivr.net/npm/clappr@latest/dist/clappr.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/gh/clappr/clappr-level-selector-plugin@latest/dist/level-selector.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@clappr/hlsjs-playback@1.2.0/dist/hlsjs-playback.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@c3voc/clappr-audio-track-selector@0.2.4/dist/audio-track-selector.min.js"></script>
    <script disable-devtool-auto src='https://cdn.jsdelivr.net/npm/disable-devtool@latest'></script>
</head>
<body>
    <div id="player" style="height: 100%; width: 100%;"></div>
    <script>
        var player = new Clappr.Player({
            watermark: '#',
            position: 'top-left',
            hide: true,
            source: 'stream.php?id=<?php echo $id; ?>',
            width: '100%',
            height: '100%',
            autoPlay: true,
            plugins: [HlsjsPlayback, LevelSelector, AudioTrackSelector],
            mimeType: "application/x-mpegURL",
            mediacontrol: { seekbar: "#ff0000", buttons: "#eee" },
            parentId: "#player",
        });
    </script>
</body>
</html>
