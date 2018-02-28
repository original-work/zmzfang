var expressionHtml = '<div class="mui-slider"><div class="mui-slider-group">';
for (var i = 1; i <= 5; i++) {
    expressionHtml += '<div class="mui-slider-item">';
    for(var j = 1; j <= 20; j++){
        var n = 20*(i-1)+j;
        expressionHtml += '<span class="express" index="'+ n +'" alt="[em_'+ n +']"><img src="face/'+n+'.gif" /></span>';
    }
    expressionHtml += '<span class="express" index="-1" alt="">删除</span></div>';
}
expressionHtml += '</div></div>';

$("#slider").append(expressionHtml);

var curFocus = {
    fid: 'content',
    start: 0,
    end: 0
};

$('#content').blur(function() {
    curFocus.fid = 'content';
    curFocus.start = $(this).get(0).selectionStart;
    curFocus.end = $(this).get(0).selectionEnd;
});

// 点击表情
$('.express').on('click ', function() {
    // 获取表情对应code
    var imgCode = $(this).attr('alt');
    // 获取编号判断是否为删除按钮
    var index = $(this).attr('index');
    var ta = document.querySelector('textarea');
    // 删除操作
    if(index == -1){
        if ($('#' + curFocus.fid).length) {
            var text = $('#' + curFocus.fid).val();
            // 获取光标之前的字符串
            var changedText = text.substr(0, curFocus.start);
            var len = changedText.length;
            var reg=/\[em_([0-9]*)\]$/g;
            // 删除表情code块或最后一个字符
            if(reg.test(changedText)){
                changedText=changedText.replace(reg,"");
            }else{
                changedText=changedText.substring(0,changedText.length-1);
            }
            var resText = changedText + text.substr(curFocus.end, text.length);
            $('#' + curFocus.fid).val(resText);
            // 调整光标位置
            curFocus.start = curFocus.end = curFocus.end - (len - changedText.length);
        }
    // 添加操作
    }else if ($('#' + curFocus.fid).length) {
        var text = $('#' + curFocus.fid).val();
        // 添加表情code块到光标位置
        var resText = text.substr(0, curFocus.start) + imgCode + text.substr(curFocus.end, text.length);
        $('#' + curFocus.fid).val(resText);
        curFocus.start = curFocus.end = curFocus.end + imgCode.length;
    }
});