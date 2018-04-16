function dolink(url) {
    window.location.href = url;
}

function ajaxback(url, info) {
    var backmessage = {
        'flag': true,
        'content': ''
    };
    $.ajax({
        type: 'POST',
        async: false,
        url: url.replace('@random@', 1 + Math.round(Math.random() * 1000)),
        data: info,
        dataType: 'json',
        success: function(content) {
            if (content.error == false) {
                backmessage['flag'] = false;
                backmessage['content'] = content.msg;
            } else {
                if (content.error == true) {
                    backmessage['content'] = content.msg;
                } else {
                    backmessage['content'] = content;
                }
            }
        },
        error: function(content) {
            backmessage['content'] = '提交数据失败';
        }
    });
    return backmessage;
}

function fbajaxback(url, info,sunfun) {
    var backmessage = {
        'flag': true,
        'content': ''
    };

    $.ajax({
        type: 'POST',
        async: true,
        url: url.replace('@random@', 1 + Math.round(Math.random() * 1000)),
        data: info,
        dataType: 'json',
        success: function(content) {
            $F.closeLoading();
            if (content.error == false) {
                backmessage['flag'] = false;
                backmessage['content'] = content.msg;

            } else {
                if (content.error == true) {
                    backmessage['content'] = content.msg;
                } else {
                    backmessage['content'] = content;
                }
            }
            sunfun(backmessage);
        },
        error: function(content) {
            backmessage['content'] = '提交数据失败';
        }
    });
    // return backmessage;
}
