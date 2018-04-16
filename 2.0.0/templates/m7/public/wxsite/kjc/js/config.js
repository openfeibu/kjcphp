
//计算rem  100px = 1rem
;(function (doc, win,fs) {
  var docEl = doc.documentElement,
  resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize';
  function recalc() {
    var clientWidth = docEl.clientWidth;
    !clientWidth ? '' :  clientWidth>750 ? docEl.style.fontSize = 100 + 'px' : clientWidth<=750 ? docEl.style.fontSize = (clientWidth / 7.5) + 'px' : '';
  };
  if (!doc.addEventListener) return;
  win.addEventListener(resizeEvt, recalc, false);
  doc.addEventListener('DOMContentLoaded', recalc, false);
})(document, window);

$(function(){
    var u = navigator.userAgent;
    var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
    var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
    if(isAndroid){
        $(".mine_header,.shopList .weui-navbar").css("background","#393a3f");
    }
})


var config = {
   apiUrl : "http://txhapi.feibu.info/"
}

// window.addEventListener('pageshow', function(e) {
//     // 通过persisted属性判断是否存在 BF Cache
//     if (e.persisted) {
//         location.reload();
//     }
// });
