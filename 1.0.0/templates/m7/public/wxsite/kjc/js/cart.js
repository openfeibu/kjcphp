
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
    $.each(datas.content.list, function(i,val){
        var htmls = template.render('cartlist', {list:val});
        $('#foodslist').html(htmls);
    });
    if(datas.content.bagcost != 0){
        temp_htmls = '<div class="orderDetail_item">'
                    +'<p>餐盒费</p>'
                    +'<span>￥'+datas.content.bagcost+'</span>'
                    +'</div>';
        $('#foodslist').after(temp_htmls);
    }
    /*==================追加配送费信息===================*/
    if(datas.content.pscost != 0){
        $('input[name="pscost"]').val(datas.content.pscost);
        temp_htmls = '￥'+datas.content.pscost;
        $('#addressprice').find('span').html(temp_htmls);
    }else{
        temp_htmls = '￥0';
        $('#addressprice').find('span').html(temp_htmls);
    }
    /*==============遍历追加优惠活动信息===============*/

    if (datas.content.cxdet !== null && datas.content.cxdet !== undefined && datas.content.cxdet !== ''){
        $.each(datas.content.cxdet, function(i,val){
            var htmls = template.render('cxlist', {list:val});
            $('#addressprice').after(htmls);
        });
    }
    var allcost1 = (Number(datas.content.sum)+Number(datas.content.bagcost)-Number(datas.content.downcost)).toFixed(2);
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
    var url= siteurl+'/index.php?ctrl=site&action=clearcart&shopid='+shopid+'&num=1&datatype=json&random=@random@';
    url = url.replace('@random@', 1+Math.round(Math.random()*1000));
    var bk = ajaxback(url,'');
    if(bk.flag == false){
        freshcart();
    }else{
        $.toast(bk.content,'text');
    }

    return false;
}
function doselectjuan1(){

    if(checknext ==  false){
        checknext = true;
        $('input[name="fanhui"]').val(1);
        var oldjuanid = Number($('#juanid').val());
        if(juanlist.length > 0){
            var htmle = '';
            var checkcost = Number(cartsum)+Number(cartbagcost);
            /*
            $.each(juanlist,function(i,field){  //可用优惠券
                var juancost = Number(field.limitcost);
                var jpaytype = $('input[name="paytype"]').val();
                jpaytype = Number(jpaytype)+1;
                if(field.paytype == '' || field.paytype == 'undefined' || field.paytype == null){
                    var paytypearr = '1,2';
                }else{
                    var paytypearr = field.paytype.split(",");
                }
                if(checkcost >= juancost && contains(paytypearr,jpaytype)){
                    var can = 'yes';

                    var temp_pre = oldjuanid == field.id ?'on':'';
                    htmle +='<div class="discoupon"   style="background-color: #fff; border-radius:0">';
                    htmle +='<div style="padding-bottom: 5px;">';
                    if(checkcost >= juancost && contains(paytypearr,jpaytype)){
                        htmle +='<div class="checkjuan c_'+field.id+'"  onclick="selectjuan(\''+field.id+'\',\''+field.cost+'\',\''+field.limitcost+'\',\''+field.name+'\',\''+field.paytype+'\')"></div>';
                    }
                    htmle +='<div style="display:inline-block;text-align:center;width:30%;margin-top: 10px;">';
                    htmle +='<p class="'+can+'"><font style="color:red">￥</font><font style="color:red;font-size: 30px;font-weight: bold;">'+field.cost+'</font></p>';
                    htmle +='<p><div id="'+can+'" style="text-align:center;font-size:11px;background-color: #FFE4E1;border-radius: 25px;height: 22px;margin-left: 5px;">满'+field.limitcost+'元可用</div></p>';
                    htmle +='</div><div style="display:inline-block;text-align:center"><ul class="'+can+'">';
                    htmle +='<li  style="font-size: 14px; font-weight:bold;text-align:left">'+field.name+'</li>';
                    htmle +='<li  style="font-size: 11px;">有效期：'+getdate(field.creattime)+'至'+getdate(field.endtime)+'</li></ul></div></div>	';

                }
                htmle +='</div>';

            });

            htmle +='<div style="height:40px"></div>';
            if(htmle == ''){
                Tmsg('无满足条件的优惠券');
            }else{
                var juanid = $('#juanid').val();
                var isck = $('#juanid').attr('data');
                if(juanid > 0 || isck == 1){

                }else{
                    $('#yhjlist').append(htmle);
                    $('#yhjlist').append('<div class="discoupon notusejuan" onclick="notusejuan();" >不使用优惠券</div>');
                }
                $('#gdcart').hide();
                $('#orderaddress').hide();
                $('.wmr_title_center').text('选择优惠券');
                $('#yhjlist').show();
            }
            */
        }

        setTimeout("myyanchi()", 500 );
    }
}

function  orderSubmit(){
    var buyerlng = $('input[name="addresslng"]').val();
    var buyerlat = $('input[name="addresslat"]').val();
    if(checknext ==  false){
        checknext = true;
        url = siteurl+'/index.php?ctrl=wxsite&action=makeorder&datatype=json&random=@random@';
        url = url.replace('@random@', 1+Math.round(Math.random()*1000));
        $.ajax({         //script定义
            url: url.replace('@random@', 1+Math.round(Math.random()*1000)),
            dataType: "json",
            async:true,
            data:{shopid:shopid,'juanid':$('#juanid').val(),'buyerlng':buyerlng,'buyerlat':buyerlat},
            success:function(content) {
                if(content.error ==  false){
                    window.location.href=  siteurl+'/index.php?ctrl=wxsite&action=subshow&orderid='+content.msg ;//.html?orderid='+datas.data;
                }else{
                    $.toast(content.msg,'text');
                    return false;
                }
            },
            error:function(){

            }
        });
         setTimeout("myyanchi()", 500 );
    }
}
function myyanchi(){
    checknext = false;
}
