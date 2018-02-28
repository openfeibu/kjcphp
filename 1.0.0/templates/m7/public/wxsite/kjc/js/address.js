$(function(){
    loadaddreslist();
});
function loadaddreslist(){ 	//记载购物车 地址有关信息
	var url= siteurl+'/index.php?ctrl=member&action=address&datatype=json&random=@random@';
	url = url.replace('@random@', 1+Math.round(Math.random()*1000));
	var bk = ajaxback(url,'');
	if(bk.flag == false){
		var addresslist = bk.content.addresslist;
		if(addresslist.length > 0){
            $(".usermap").show();
			$(".noMap").hide();
			var html = '';
			console.log(addresslist)
			$.each(addresslist, function(i, newobj) {
				if(newobj.default == 1){
					//默认地址
					html += '<div class="orderDetail_address_con">';
	                html += '<p><span>'+newobj.contactname+'</span>'+newobj.phone+'</p>';
	                html += '<p>'+newobj.detailadr+'</p>';
	                html += '</div>';
	                return false;
				}
                  

			});
            $('.orderDetail_address').html(html);
		}else{
            $(".usermap").hide();
			$(".noMap").show();
		}
	}else{
	    newTmsg(bk.content);
	}
}
