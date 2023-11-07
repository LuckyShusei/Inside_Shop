var player = false;
var current_type;
var ended = false;

if (!$('#video_area .vimeo_player').length) {
    $('#video_area').append('<div class="vimeo_player"></div><div id="remain_time"></div>');
    var options = {
        url: live_url,
        portrait: false, // 左上のVimeoのマークを表示するかどうか設定
        byline: false, // 投稿者の部分を表示するかどうか設定
        loop: false, // ループするかどうか設定
        title: false, // タイトルを表示するかどうか設定
        controls: false, // コントロールを表示するかどうか設定
        width: $('.ec-grid2__cell2').width()
    };
    player = new Vimeo.Player($('.vimeo_player'), options);
    console.log(player);
    player.play();
}
$('#video_area').show();
$('#image_area').hide();