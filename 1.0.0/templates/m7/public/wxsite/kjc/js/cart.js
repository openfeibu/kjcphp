
//刷新购物车

function freshcart($payflag){
    var paytype = $('input[name="paytype"]').val();
    if(paytype == null || paytype == undefined || paytype == ''){
        url = siteurl+'/index.php?ctrl=wxsite&action=cart&shopid='+shopid+'&datatype=json&random=@random@';
    }else{
        url = siteurl+'/index.php?ctrl=wxsite&action=cart&shopid='+shopid+'&paytype='+paytype+'&datatype=json&random=@random@';
    }
	url = url.replace('@random@', 1+Math.round(Math.random()*1000));
	var bk = ajaxback(url,'');
	if($('#shocart').html() == undefined){
        console.log('bk:'+bk);
        initshop(bk);
        // initshop1(bk);
	}else{
	    freshcartdata(bk,$payflag);
	}
}

function freshcartdata(datas,$payflag){
    $('#foodslist').html('');
    var juancost = Number($("#juancost").val());//优惠券
    $.each(datas.content.list, function(i,val){
        var htmls = template.render('cartlist', {list:val});
        htmls = '<div class="orderDetail_pro">'+htmls + "</div>"
        $('#foodslist').append(htmls);
    });
    if(datas.content.bagcost != 0){
        temp_htmls = '<div class="orderDetail_item">'
                    +'<p>餐盒费</p>'
                    +'<span>￥'+datas.content.bagcost+'</span>'
                    +'</div>';
        $('#foodslist').append(temp_htmls);
    }
    /*==================追加配送费信息===================*/
    if(datas.content.pscost != 0){
        $('input[name="pscost"]').val(datas.content.pscost);
        temp_htmls = '<div class="orderDetail_item"><p>配送费</p><span>￥' +datas.content.pscost+'</span></div>';
        $('#foodslist').append(temp_htmls);
    }else{
        temp_htmls = '<div class="orderDetail_item"><p>配送费</p><span>￥' +0+'</span></div>';
        $('#foodslist').append(temp_htmls);
    }
    /*==============遍历追加优惠活动信息===============*/

    if (datas.content.cxdet !== null && datas.content.cxdet !== undefined && datas.content.cxdet !== ''){
        $.each(datas.content.cxdet, function(i,val){
            var htmls = template.render('cxlist', {list:val});
            $('#addressprice').after(htmls);
        });
    }
    cartbagcost = datas.content.bagcost;
    cxcost =  datas.content.downcost;
    cartsum = datas.content.sum;
    cartpscost = datas.content.pscost;
    surecost = datas.content.surecost-juancost;

    var allcost1 = (Number(datas.content.sum)+Number(datas.content.bagcost)-Number(juancost)-Number(datas.content.downcost)).toFixed(2);
    var allcost = allcost1>0?allcost1:0;
    $('.surecost').text('￥'+allcost);
}

function uponeproduct(gid,tshopid,num){
    $F.loading();
	var url= siteurl+'/index.php?ctrl=site&action=addcart&goods_id='+gid+'&shopid='+tshopid+'&num=1&gdtype=2&datatype=json&random=@random@';
    url = url.replace('@random@', 1+Math.round(Math.random()*1000));
     fbajaxback(url, '',function(backmessage){
        if(backmessage.flag == false){
            $F.closeLoading();
            freshcart();
            return true;
        }else{
            $.toast(backmessage.content,'text');
            return false;
        }

     })

}
function removeoneproduct(gid,tshopid,num){
    $F.loading();
    url = siteurl+'/index.php?ctrl=site&action=downcart&goods_id='+gid+'&shopid='+tshopid+'&num=1&gdtype=2&datatype=json&random=@random@';
    url = url.replace('@random@', 1+Math.round(Math.random()*1000));
     fbajaxback(url, '',function(backmessage){
        if(backmessage.flag == false){
            $F.closeLoading();
            freshcart();
            return true;
        }else{
            $.toast(backmessage.content,'text');
            return false;
        }

     })
    // var bk = ajaxback(url,'');
    // if(bk.flag == false){
    //     freshcart();
    // }else{
    //     $.toast(bk.content,'text');
    // }
}
function addonedish(gid,tshopid,num,obj){
    $F.loading();
    var url= siteurl+'/index.php?ctrl=site&action=addcart&goods_id='+gid+'&shopid='+tshopid+'&num=1&datatype=json&random=@random@';
    url = url.replace('@random@', 1+Math.round(Math.random()*1000));
    fbajaxback(url, '',function(backmessage){
       if(backmessage.flag == false){
        // if($('#total_money').html() != undefined){
        //     //cartimg($('#gid_'+gid),gid);
        // }else{
        //     // $('#loading').hide();
            $F.closeLoading();
            freshcart();
            return true;
        //}
    }else{
        $.toast(backmessage.content,'text');
        return false;
    }
    });
}
function removeonedish(gid,tshopid,num){
    // .toFixed(2)
    // $('#loading').show();
    url = siteurl+'/index.php?ctrl=site&action=downcart&goods_id='+gid+'&shopid='+tshopid+'&num=1&datatype=json&random=@random@';
    url = url.replace('@random@', 1+Math.round(Math.random()*1000));
    $F.loading();
    fbajaxback(url, '',function(backmessage){
        if(backmessage.flag == false){
             $F.closeLoading();
            freshcart();

            return true;
        }else{
            $.toast(backmessage.content,'text');
            return false;
        }
    // $('#loading').hide();
     })

}
function delshopcart(){
     $F.loading();
    var url= siteurl+'/index.php?ctrl=site&action=clearcart&shopid='+shopid+'&num=1&datatype=json&random=@random@';
    url = url.replace('@random@', 1+Math.round(Math.random()*1000));
    fbajaxback(url, '',function(backmessage){
        if(backmessage.flag == false){
             $F.closeLoading();
            freshcart();
            return true;
        }else{
            $.toast(backmessage.content,'text');
            return false;
        }
     })

}
function doselectjuan1(){

    if(checknext ==  false){
        checknext = true;
        $('input[name="fanhui"]').val(1);
        var oldjuanid = Number($('#juanid').val());
        if(juanlist.length > 0){
            var htmle = '';
            var checkcost = Number(cartsum)+Number(cartbagcost);

        }

        setTimeout("myyanchi()", 500 );
    }
}


function myyanchi(){
    checknext = false;
}
/*================获取优惠券信息===================*/
function getjuaninfo(){

    var oldjuanid = Number($('#juanid').val());
    if(  typeof(juanlist) != "undefined" ){

        if(juanlist.length > 0){
            var juancount = 0;
            var checkcost = Number(cartsum)+Number(cartbagcost);

            $.each(juanlist,function(i,field){
                var juancost = Number(field.limitcost);
                if(checkcost >= juancost){
                    juancount = juancount + 1;
                    discountids.push(field.cost+','+field.id);
                    discountvalues.push('满'+field.limitcost+'元-'+field.cost+'元');
                }
            });
            console.log('juancount:'+juancount);
            if(juancount > 0){
                $('.checkDiscount').html('<p>优惠券</p><span>'+juancount+'张可用</span>');
            }else{
                $('.checkDiscount').html('<p>优惠券</p><span>暂无可用</span>');
            }
            console.log('discountids:'+discountids);
            console.log('discountvalues:'+discountvalues);
        }else{
            //$('#juanshuoming').text('暂无可用');
        }
    }
}
