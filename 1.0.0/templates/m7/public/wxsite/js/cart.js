﻿$(function(){ 
	$('body').append('<div id="addload" style="position: absolute; z-index: 1000; left: 30%; top: 30%; opacity: 1; display: none; height: 15px;width: 15px;border-radius: 15px;line-height: 12px;overflow:hidden; background: #ea5413;"></div>'); 	    
});
 var click_button = false;
 
function getdate(time){
	var date =  new Date(time*1000);
    var y = 1900+date.getYear();
    var m = "0"+(date.getMonth()+1);
    var d = "0"+date.getDate();
    return y+"-"+m.substring(m.length-2,m.length)+"-"+d.substring(d.length-2,d.length) ;
} 
function doubleclick(){
	click_button = false;
}
function lockclick(){
	 if(click_button == false){
			click_button = true;
			setTimeout("doubleclick()", 400); 
			return true;
	 }else{
		 return false;
	 }
}

//加购物车动画
function cartimg(obj,gid){
	     $("#addload").show(); 
        var pos =$(obj).offset();
       var topval = pos.top;
       $("#addload").css("top", topval + "px"); 
       $("#addload").css("left", pos.left + "px");
        $("#addload").css({'width':'15px','height':'15px'}); 
       var target_ob = $('#total_count').offset();
       var target_top = Number(target_ob.top);
       var target_left = Number(target_ob.left);
       $("#addload").animate({top:target_top,left:target_left, 'width':'0px','height':'0px'});   
       $('#total_count').text(Number($('#total_count').text())+1);
	   
	   
	    	$('#total_money').text(Number($('#total_money').text())+Number($(obj).attr('data-price'))); 
	    	
	    	if(Number($('#total_money').text()) > Number(shoplimitcost)){
	          		 $('#showlimit').text('');
	          	}else{
	          	        var checkcost = Number(shoplimitcost)-Number($('#total_money').text());
	          	        $('#showlimit').text('差'+checkcost+'起送');
	          	        
	          	}
	    	
	    	
	    	$('#gidli_'+gid).find('.righ_l_b_btn_moren').hide();
	    	$('#gidli_'+gid).find('.righ_l_b_btn_hover').show();
	 
	      $('#gidli_'+gid).addClass('onselect');
	      $('#gshu_'+gid).text(Number($('#gshu_'+gid).text())+1); 
		  $('#gshu_'+gid).show();
		  $('#total_count').show();
	    
} 

/*****12-15新增代码****/
function addproduct(gid,tshopid,num,obj){//调用选择规格界面
	 

	 var objccc = $(obj).parents('.goodsli');
    $('#product_one').show();  
	$('#product_one').css({'width':$(objccc).width(),'left':$(objccc).offset().left,'top':$(obj).offset().top});
	$('#product_one .productloding').show();
	$('#product_one .cart_products_content_area').hide();
	var url= siteurl+'/index.php?ctrl=site&action=selectproduct&goods_id='+gid+'&shopid='+tshopid+'&random=@random@';
	  url = url.replace('@random@', 1+Math.round(Math.random()*1000)); 
	  /*****  *****/
	  
	  
	  $('#product_one .cart_products_content_area').eq(0).load(url, function() {
			//alert("Load was performed.");//siteurl 
			$('#product_one .productloding').hide();
			$('#product_one .cart_products_content_area').show(); 
			bindclcikattr();
		});  
}
function bindclcikattr(){
	$('.productggli li').bind("click", function() { 
	   if($(this).hasClass('disable') == true){
			diaerror('商品无库存或者库存不足');
	   }else{
			var obj = $('#product_one .productggli');
			var tarray= new Array();
			var liarray = new Array();
			$.each(obj, function(i, newobj){   
				 if($(newobj).find('.checked').eq(0).html() != undefined){
					 
					 tarray.push($(newobj).find('.checked').eq(0).attr('childid'));
				 }else{
					 liarray.push($(newobj).attr('data'));
				 }
			});
			if(tarray.length == $(obj).length){//已全则还需要 重置查询条件
				$('#product_one .checked').removeClass('checked');
			}
		
		
		
			$(this).addClass('checked').siblings().removeClass('checked');
			freshproduct();
	   }
         	
    });
}
function producttocart(){
 
	if($('#producttocart').hasClass('disable') == true){
		
	}else{
		uponeproduct($('input[name="selectproductid"]').val(),$('input[name="product_shopid"]').val(),1);
		closeproductdiv();		
	}
}
function freshproduct(){
	var obj = $('#product_one .productggli');
	var tarray= new Array();
	var liarray = new Array();
	$.each(obj, function(i, newobj){   
		 if($(newobj).find('.checked').eq(0).html() != undefined){
			 
			 tarray.push($(newobj).find('.checked').eq(0).attr('childid'));
		 }else{
			 
			 liarray.push($(newobj).attr('data'));
		 }
	});
	var shopid = $('input[name="product_shopid"]').val();
	var goodsid = $('input[name="product_goodsid"]').val();
	var ggdetids = tarray.join(',');
 
	if(tarray.length == $(obj).length){ 
		var url= siteurl+'/index.php?ctrl=site&action=doselectproduct&goods_id='+goodsid+'&shopid='+shopid+'&ggdetids='+ggdetids+'&type=1&datatype=json&random=@random@';
        url = url.replace('@random@', 1+Math.round(Math.random()*1000)); 
    	var bk = ajaxback(url,'');
		 
	    if(bk.flag == false){ //需获取出当前商品的productid 并获取相关库存 已在购物中的数量
		     var productinfo = bk.content;
          	
             if(productinfo.stock < 1){
				  $('#producttocart').addClass('disable');
				  diaerror('商品库存不足');
			 }else{
				 
				 $('input[name="selectproductid"]').val(productinfo.id);
				 $('#producttocart').removeClass('disable');
				 $('#product_s_cost').text("￥"+productinfo.cost+"元");
			 }
	    }else{
			$('input[name="selectproductid"]').val('');
			$('#producttocart').addClass('disable');
			 
	    	diaerror(bk.content);
			
	    } 
	}else{
		//构造未选择完刷新提交数据
		$('#producttocart').addClass('disable');
		$('input[name="selectproductid"]').val('');
		var url= siteurl+'/index.php?ctrl=site&action=doselectproduct&goods_id='+goodsid+'&shopid='+shopid+'&ggdetids='+ggdetids+'&datatype=json&random=@random@';
        url = url.replace('@random@', 1+Math.round(Math.random()*1000)); 
    	var bk = ajaxback(url,'');
	    if(bk.flag == false){ 
		     var tempids = bk.content;
		     var checkarray = tempids.split(','); 
			 for(var i=0;i<liarray.length;i++){
				 var tempobj = $('#productggli_'+liarray[i]);
				 var liboj = $(tempobj).find('li');
				  $.each(liboj, function(j, newobj){  
                      if($.inArray( $(newobj).attr('pid'), checkarray ) >=0){ 
					      $(newobj).removeClass('disable');
					  }else{
						  $(newobj).addClass('disable');
					  }    				  
				  });
			 }
			 
			 
	 
	    }else{
	    	diaerror(bk.content);
	    } 
    }		
	
}
function closeproductdiv(){
	 $('#product_one').hide(); 
}
function uponeproduct(gid,tshopid,num){  
	var url= siteurl+'/index.php?ctrl=site&action=addcart&goods_id='+gid+'&shopid='+tshopid+'&num=1&gdtype=2&datatype=json&random=@random@';
      url = url.replace('@random@', 1+Math.round(Math.random()*1000)); 
    	var bk = ajaxback(url,'');
	    if(bk.flag == false){ 
	       freshcart();
	    }else{
	    	Tmsg(bk.content);
	    }
	
}
function removeoneproduct(gid,tshopid,num){ 
	 
	 
	 url = siteurl+'/index.php?ctrl=site&action=downcart&goods_id='+gid+'&shopid='+tshopid+'&num=1&gdtype=2&datatype=json&random=@random@';
	  	 url = url.replace('@random@', 1+Math.round(Math.random()*1000));
	var bk = ajaxback(url,'');
	    if(bk.flag == false){ 
	       freshcart();
	    }else{
	    	Tmsg(bk.content);
	    }
	  
}
function delproduct(gid,tshopid){  //删除某规格
  
	url = siteurl+'/index.php?ctrl=site&action=delcartgoods&goods_id='+gid+'&shopid='+tshopid+'&num=1&gdtype=2&datatype=json&random=@random@';
	url = url.replace('@random@', 1+Math.round(Math.random()*1000));
	var bk = ajaxback(url,'');
	    if(bk.flag == false){ 
	       freshcart();
	    }else{
	    	Tmsg(bk.content);
	    }
	
}

/*****12-15新增代码结束****/
function addonedish(gid,tshopid,num,obj){   
	    $('#loading').show();
    	var url= siteurl+'/index.php?ctrl=site&action=addcart&goods_id='+gid+'&shopid='+tshopid+'&num=1&datatype=json&random=@random@';
      url = url.replace('@random@', 1+Math.round(Math.random()*1000)); 
    	var bk = ajaxback(url,'');
	    if(bk.flag == false){  
	       if($('#total_money').html() != undefined){
	         
	   	 	   cartimg($('#gid_'+gid),gid);  
	   	 	   
	   	   }else{// $('#loading').hide();
	   	   	
	   	    	  freshcart();
	   	   }
	    }else{
	    	 Tmsg(bk.content);  
	    } 
	    $('#loading').hide();
}
function uponedish(gid,tshopid,num){ 
	var url= siteurl+'/index.php?ctrl=site&action=addcart&goods_id='+gid+'&shopid='+tshopid+'&num=1&datatype=json&random=@random@';
      url = url.replace('@random@', 1+Math.round(Math.random()*1000)); 
    	var bk = ajaxback(url,'');
	    if(bk.flag == false){ 
	       freshcart();
	    }else{
	    	Tmsg(bk.content);  
	    }
}
	
function delshopcart(){
	if(confirm('确认清空购物车')){
	var url= siteurl+'/index.php?ctrl=site&action=clearcart&shopid='+shopid+'&num=1&datatype=json&random=@random@';
      url = url.replace('@random@', 1+Math.round(Math.random()*1000)); 
	var bk = ajaxback(url,'');
	    if(bk.flag == false){ 
	       freshcart();
	    }else{
	    	Tmsg(bk.content);
	    }
  }
  return false;
}
function delbackshop(nowlinke){
	var url= siteurl+'/index.php?ctrl=site&action=clearcart&shopid='+shopid+'&num=1&datatype=json&random=@random@';
      url = url.replace('@random@', 1+Math.round(Math.random()*1000)); 
	var bk = ajaxback(url,'');
	    if(bk.flag == false){ 
	      window.location.href= nowlinke;// freshcart();
	    }else{
	    	Tmsg(bk.content);
	    }
   
}

function removeonedish(gid,tshopid,num){ 

	   $('#loading').show();
	   url = siteurl+'/index.php?ctrl=site&action=downcart&goods_id='+gid+'&shopid='+tshopid+'&num=1&datatype=json&random=@random@';
	  	 url = url.replace('@random@', 1+Math.round(Math.random()*1000));
    	var bk = ajaxback(url,'');
	    if(bk.flag == false){ 
	       if($('#total_money').html() != undefined){
	         /*操作分类*/
	         var typeid = $('#gidli_'+gid).attr('typeid'); 
	         var notypenum = Number($('#typelist'+typeid).text()) -1; 
	          $('#typelist'+typeid).text(notypenum);
	         if(notypenum < 1){
	             $('#typelist'+typeid).text(0);
	             $('#typelist'+typeid).hide();
	         } 
	         notypenum = Number($('#total_count').text())-1;
	         $('#total_count').text(notypenum);
	         if(notypenum < 1){
	         	  $('#total_count').text(0);
	         }
	         notypenum = Number($('#total_money').text())-Number($('#gidli_'+gid).attr('data-price')); 
	          $('#total_money').text(notypenum);
	         if(notypenum < 0){
	         	$('#total_money').text(0);
	         }
	         	if(Number($('#total_money').text()) > Number(shoplimitcost)){
	          		 $('#showlimit').text('');
	          	}else{
	          	        var checkcost = Number(shoplimitcost)-Number($('#total_money').text());
	          	        $('#showlimit').text('差'+checkcost+'起送');
	          	        
	          	}
	         notypenum = Number($('#gshu_'+gid).text()) -1;
	          $('#gshu_'+gid).text(notypenum);
	         if(notypenum < 1){
	         	$('#gshu_'+gid).text(0);
	         	$('#gidli_'+gid).removeClass('onselect');
	         	$('#gidli_'+gid).find('.righ_l_b_btn_hover').hide(); 
	         	$('#gidli_'+gid).find('.righ_l_b_btn_moren').show();
				$('#gshu_'+gid).hide();
				//$('#total_count').hide();
	         	
	         } 
	   	   }else{ 
	   	    	  freshcart();
	   	   }
	    }else{
	    	Tmsg(bk.content);
	    }
	  $('#loading').hide();
}
 
//删除商品
function removesupplierdish(gid,tshopid){
 
	url = siteurl+'/index.php?ctrl=site&action=delcartgoods&goods_id='+gid+'&shopid='+tshopid+'&num=1&datatype=json&random=@random@';
	url = url.replace('@random@', 1+Math.round(Math.random()*1000));
	var bk = ajaxback(url,'');
	    if(bk.flag == false){ 
	       freshcart();
	    }else{
	    	Tmsg(bk.content);
	    }
}
//修改购物车数量
function modifycart(gid,oldnum,tshopid){  
	var nowgscount = 	$('#cart_count'+gid).val();
	url = siteurl+'/index.php?ctrl=site&action=modifycart&goods_id='+gid+'&shopid='+tshopid+'&num='+nowgscount+'&datatype=json&random=@random@';
	url = url.replace('@random@', 1+Math.round(Math.random()*1000));
	var bk = ajaxback(url,'');
	    if(bk.flag == false){ 
	       freshcart();
	    }else{
	    	$('#cart_count'+gid).val(oldnum);
	    	Tmsg(bk.content);
	    }
} 
function freshcart($payflag){	 
    var paytype = $('input[name="paytype"]').val();
    if(paytype == null || paytype == undefined || paytype == ''){
        url = siteurl+'/index.php?ctrl=wxsite&action=cart&shopid='+shopid+'&datatype=json&random=@random@';
    }else{
        url = siteurl+'/index.php?ctrl=wxsite&action=cart&shopid='+shopid+'&paytype='+paytype+'&datatype=json&random=@random@';
    }
	//url = siteurl+'/index.php?ctrl=wxsite&action=cart&shopid='+shopid+'&datatype=json&random=@random@';
	url = url.replace('@random@', 1+Math.round(Math.random()*1000));
	var bk = ajaxback(url,'');

	if($('#shocart').html() == undefined){
		initshop(bk);
	}else{
	    freshcartdata(bk,$payflag);
	}
}
function showpsts(){
	$("#tspschange").hide();//显示你的DIV
}
function freshcartdata(datas,$payflag){
	var newpscost = $('input[name="adrpscost"]').val();
    if( newpscost != '' ){
        if(datas.content.canps!=1){
            if(newpscost && newpscost != datas.content.pscost && $payflag !=1 && datas.content.nops == 0){
                newTmsg("由于配送地址变化，配送费更改为"+newpscost+"元");
            }
            datas.content.pscost = newpscost;
        }
    }
	 
	datas.content.pscost = newpscost;
	if(datas.content.nops == 1){
		$('input[name="surepscost"]').val(0);
	}else{
		$('input[name="surepscost"]').val(datas.content.pscost);
	}
 	 $('#foodslist').html(''); 
 	 $('#nextshocart').html(''); 
	
	  if(datas.flag == false){
		var morepscost = Number($("#morepscost").text());//附加配送费
		var juancost = Number($("#juancost").val());//优惠券
		var jifen = Number($("#jfcost").val());//积分抵扣
    	var temp_htmls = '';
           $('#foodslist').append(temp_htmls);
		/*======遍历追加商品详情、数量、价格信息=========*/   
    	 	  $.each(datas.content.list, function(i,val){    
    	 	 	  var htmls = template.render('cartlist', {list:val});   
				  $('#foodslist').append(htmls);
    	    }); 
		/*==================追加打包费信息=================*/ 
		 if(datas.content.bagcost != 0){
       	  	  temp_htmls = '<li><div class="wmr_subord_info_l">餐盒费</div><div class="wmr_subord_info_c"></div><div class="wmr_subord_info_r">&yen;'+datas.content.bagcost+'</div></li>';
			  $('#foodslist').append(temp_htmls); 
		 }
		 /*==================追加配送费信息===================*/ 
		if(datas.content.pscost != 0){
			  $('input[name="pscost"]').val(datas.content.pscost);
       	  	  temp_htmls = '<li><div class="wmr_subord_info_l">配送费</div><div class="wmr_subord_info_c"></div><div class="wmr_subord_info_r">&yen;'+datas.content.pscost+'</div></li>';
			  $('#foodslist').append(temp_htmls); 
		 }
		 /*=================追加附加配送费信息=================*/ 
       if(morepscost>0){ 
			  $('input[name="addpscost"]').val(morepscost);
       	  	  temp_htmls = '<li><div class="wmr_subord_info_l">附加配送费</div><div class="wmr_subord_info_c"></div><div class="wmr_subord_info_r">&yen;'+morepscost+'</div></li>';
			  $('#foodslist').append(temp_htmls); 
		 }
		 /*==============遍历追加优惠活动信息===============*/ 
			  
			 if (datas.content.cxdet !== null && datas.content.cxdet !== undefined && datas.content.cxdet !== ''){				  				  
				  $.each(datas.content.cxdet, function(i,val){    
    	 	 	  var htmls = template.render('cxlist', {list:val});  
				  $('#foodslist').append(htmls);
    	          });
			  }		   	   		 
		    $("div[data='']").text('-￥'+datas.content.pscost);   
     	    $('#cartnum').text(datas.content.sumcount);
			var noyouhuiallcost = Number(datas.content.sum);//+Number(datas.content.pscost)+Number//(datas.content.bagcost);
		    var allcost1 = (Number(datas.content.sum)+Number($('input[name="surepscost"]').val())+Number(datas.content.bagcost)+Number(morepscost)-Number(datas.content.downcost)-Number(juancost)-Number(jifen)).toFixed(2);
			var allcost = allcost1>0?allcost1:0;
			$('#allcost').text(allcost);
			$('.surecost').text('￥'+allcost);
			var yhjcost = $('input[name="yhjcost"]').val();
			if(datas.content.nops == 1){
				var alldowncost = Number(yhjcost)+Number(datas.content.downcost)+Number(datas.content.pscost);
			}else{
				var alldowncost = Number(yhjcost)+Number(datas.content.downcost);
			}
			if(alldowncost != 0){
				$('.downcost').text('已优惠'+alldowncost+'元');
			}else{
				$('.downcost').text('');
			}
			
    	    $('#cartcost').text(allcost);
    	    cartbagcost = datas.content.bagcost;
    	    cxcost =  datas.content.downcost;
            cartsum = datas.content.sum;
            cartpscost = datas.content.pscost; 
            surecost = datas.content.surecost-jifen-juancost;
           $('.addbtn').bind("click", function() {   
      	    	if(checknext ==  false){ 
      	    		checknext = true;
					var checkhavedet = $(this).attr('have_det');
					 
					if(checkhavedet == 1){
					 
						 uponeproduct($(this).attr('product_id'),$(this).attr('data-shopid'),1);
					}else{
						addonedish($(this).attr('data-id'),$(this).attr('data-shopid'),1,this);
				   }
				  
      	     	   setTimeout("myyanchi()", 500 );
           	  }
      	 	
          }); 
           $('.downdbtn').bind("click", function() {   
           	  if(checknext ==  false){ 
           	  		checknext = true;
					var checkhavedet = $(this).attr('have_det');
					if(checkhavedet == 1){
						 removeoneproduct($(this).attr('product_id'),$(this).attr('data-shopid'),1);
					}else{
						removeonedish($(this).attr('data-id'),$(this).attr('data-shopid'),1,this);
				   }
				  
      	     	   setTimeout("myyanchi()", 500 );
           	  }
      	 	
          });

    }else{ 
      	cartbagcost =0;
        cartpscost = 0;
        cartsum = 0;
        cxcost = 0;
        $('#cartnum').text(0);
    	$('#cartcost').text(0);
        $('#nonecart').show();
        $('#cartlist').hide();
        $('#showdet').hide();  
    }
}
function doordershow(){
	var checkid = $('#shocart').find('li').length;
	if(checkid > 0){
		$('#cartcontent').hide();
		$('#makecontent').show();
		$('#jifen').val(0);
		$('#juanid').val(0);
		$('#juancost').val(0);
	}else{
	   Tmsg('购物车无商品');
	}
   
}

/*====================点击积分抵扣弹出积分列表======================*/
function doselectjifen(bili,myscore){
	if(checknext ==  false){ 
      checknext = true;	  
	  var myjifen = myscore;
	  var jifenbili =bili;
	  var rslt = Number(myjifen)/Number(jifenbili);  
	  var canduihuan = rslt - Math.floor(rslt) > 0?Math.floor(rslt):Math.floor(rslt); 	  
	  var shopcost = surecost;
	  var cancost = Math.ceil(shopcost) > canduihuan ? canduihuan:Math.ceil(shopcost);
	  var jfhtml = '';
	  if(jifenbili > 0 && rslt > 1){ 
	      for(var i=1;i<=cancost;i++){	      	 
	      	 var jifenall = Number(i)*jifenbili;
			  jfhtml += '<li class="jflist jf_'+i+'"  onclick="selectjifen(\''+i+'\',\''+jifenall+'\',\'使用'+jifenall+'抵扣'+i+'元\');"><div class="wmr_subord_popup_l">使用'+jifenall+'积分</div><div class="wmr_subord_popup_c">抵扣'+i+'元</div><div class="wmr_subord_popup_r"><input type="radio" /></div></li>';		      	
	      }
		  var cjf = $('#jfcost').attr('data'); 
		  if(cjf != 1){
			 $('.wmr_jfsubord_popup_list ul').append(jfhtml);	
		     $('.wmr_jfsubord_popup_list ul').append('<div style="position:fixed;bottom:0;width:100%;" onclick="notusejf()" class="wmr_subord_popup_tit notusejf">不使用积分抵扣</div>'); 
		  }
		  
	      $('.jfmaskbg').show();		   
	  }else{
	    Tmsg('积分不超过'+bili+'，不能抵扣');
	  } 
	    setTimeout("myyanchi()", 500 );
  }
}
function notusejf(){
		$('.wmr_subord_jf').html('<h3>积分抵扣</h3><span>不使用积分<i class="fa fa-angle-right"></i></span>');     
		$('.jfmaskbg').hide(); 
		$('#jfcost').attr('data',1);
        $('.jflist').removeClass('checkonejuan'); 
		$('.jflist').removeClass('navaA'); 
        $('#jifen').val(0);
	    $('input[name="jfcost"]').val(0);		
		freshcart();
	}
function loadhtml(htmlbottom,elmid){
	myScroll.destroy();
	htmlbottom = '<div class="jifenshow" id="outdivshow"><ul>'+htmlbottom+'</ul></div>  ';
	$('#popcontent').html(htmlbottom);
	$('#mask1').show();
	$('#popup1').show();
	var allheight = $(window).height(); 
	var top = $(elmid).offset().top;//元素相对于窗口的上边的偏移量 
	allheight = Number(allheight)-100;  
	top = Number(top)+40;			 
	var  kuangheight = allheight/1.5;
	var kheight  =(allheight/1.5)/2;
	$('#popup1').css({'top':'50%'});
	$('#popup1').css({'marginTop':-kheight});	        
	$('#outdivshow').css({'height':kuangheight}); 
	myScroll = new iScroll('outdivshow', {hScrollbar:false, vScrollbar:true,bounce:false});   	
}

/*====================选择用多少积分抵扣多少金额======================*/
function selectjifen(dikoujin,dikoujf,names){
	 var dikoumax = $('#scoretocostmax').val();	 
	 if((Number(dikoujin) > Number(dikoumax)) && Number(dikoumax) > 0){
		 Tmsg('单次最高抵现'+dikoumax+'元哦~');
		 return false;
	 }
	if(checknext ==  false){ 
       checknext = true;
       $('input[name="jifen"]').val(dikoujf);
	   $('input[name="jfcost"]').val(dikoujin);
	   $('.wmr_subord_jf').html('<h3>积分抵扣</h3><span style="color:#ff6e6e">-￥'+dikoujin+'<i class="fa fa-angle-right"></i></span>');
       $('#jfcost').attr('data',1);
	   $('.jflist').removeClass('navaA'); 
	   $('.jf_'+dikoujin).addClass('navaA'); 
       $('.jfmaskbg').hide();
	   freshcart();
	   myScroll.destroy();
	   myScroll = new iScroll('wrapper', {
	   useTransform: false,
	   bounce:false,
	   onBeforeScrollStart: function (e) {
			var target = e.target;
			while (target.nodeType != 1) target = target.parentNode;
            if (target.tagName != 'SELECT' && target.tagName != 'INPUT' && target.tagName != 'TEXTAREA')
				e.preventDefault();
		}
	}); 
	  setTimeout("myyanchi()", 500 );
  }
}
function maketime(){
	if(timelist.length > 0){
        gettimelist();
		if(timelist[0].cost > 0){
			$('.wmr_subord_top h3').html(timelist[0].name+'(需附加配送费￥<font  color=red  id="morepscost">'+timelist[0].cost+'</font>元)');
			//$('#DeliveryTimesm').html(timelist[0].name+'附加配送费￥<font  color=red  id="morepscost">'+timelist[0].cost+'</font>');
		}else{
			$('#DeliveryTimesm').html(timelist[0].name);
	   }
	  $('#DeliveryTime').val(timelist[0].value);
	}else{
		$('#DeliveryTimesm').text('店铺不在营业时间');
	}
}
/*=================获取配送时间信息列表==================*/
function gettimelist(){	
	 
	$.each(timelist,function(i,field){
		 tmhtml = '';		  
		 var pscost = Number(field.cost)+Number($('input[name="adrpscost"]').val());			 		   
		 tmhtml += '<li class="" id="'+field.value+'" onclick="selectTime(\''+field.value+'\',\''+field.name+'\',\''+field.cost+'\');"><div class="wmr_subord_popup_l">'+field.name+'</div><div class="wmr_subord_popup_c">'+pscost+'元配送费</div><div class="wmr_subord_popup_r"><input type="radio" /></div></li>'				  
		 $('.wmr_subord_popup_list ul').append(tmhtml);		 
    });
	$('.wmr_subord_popup_list ul').append('<div style="position:fixed;bottom:0;width:100%;" class="wmr_subord_popup_tit">取消</div>');
}
/*==================点击选择配送时间====================*/
function doselectTime(){
	if(checknext ==  false){ 
    	checknext = true;
	if(timelist.length > 0){
		$('.maskbg').show();	
	}else{
		Tmsg('店铺不在营业时间');
	}
	setTimeout("myyanchi()", 500 );
  }
}
 
function doselectpeople(personcount){
	if(checknext ==  false){ 
    	checknext = true;
	 var htmlbottom = "";
		for(var i=1;i<=personcount;i++){ 
	      	 htmlbottom += '<li class="" onclick="selectPeople(\''+i+'\');">'+i+'人</li>';
	  }  
  	         setTimeout(function () {
	             	loadhtml(htmlbottom,'#peopleposition');
	           }, 100);
	setTimeout("myyanchi()", 500 );
  }
}
function selectPeople(renshu){
	if(checknext ==  false){ 
    	checknext = true;
 $('#people').val(renshu);
 $('#peopleshuoming').text(renshu+'人');
  $('#mask1').hide();
	$('#popup1').hide();
	 myScroll.destroy();
	 myScroll = new iScroll('wrapper', {
		useTransform: false,
		bounce:false,
		onBeforeScrollStart: function (e) {
			var target = e.target;
			while (target.nodeType != 1) target = target.parentNode;

			if (target.tagName != 'SELECT' && target.tagName != 'INPUT' && target.tagName != 'TEXTAREA')
				e.preventDefault();
		}
	}); 
	setTimeout("myyanchi()", 500 );
}
	
}
function selectTime(timename,timetitle,cost){ 
	if(checknext ==  false){ 
    	checknext = true;
 $('#DeliveryTime').val(timename);
 if(cost > 0){
	 $('.wmr_subord_top h3').html(timetitle+'(需附加配送费￥<font  color=red  id="morepscost">'+cost+'</font>元)');  
	 $('input[name="addpscost"]').val(cost);
 }else{
	$('.wmr_subord_top h3').html(timetitle);
 }
 $('.wmr_subord_popup_list ul li').removeClass('navaA'); 
 $('#'+timename).addClass('navaA'); 
  $('.maskbg').hide();
  $('#mask1').hide();
	$('#popup1').hide();
	freshcart(1);
	 myScroll.destroy();
	 myScroll = new iScroll('wrapper', {
		useTransform: false,
		bounce:false,
		onBeforeScrollStart: function (e) {
			var target = e.target;
			while (target.nodeType != 1) target = target.parentNode;

			if (target.tagName != 'SELECT' && target.tagName != 'INPUT' && target.tagName != 'TEXTAREA')
				e.preventDefault();
		}
	});


	setTimeout("myyanchi()", 500 );
 }
}
/*==================选择完优惠券后执行函数========================*/
function selectjuan(juanid,juancost,limitcost,juanname,juanpaytype){
	if(checknext ==  false){
	$('.checkjuan').removeClass('checkonejuan');	
    $('.c_'+juanid).addClass('checkonejuan'); 		
	$('#gdcart').show();  
    $('#yhjlist').hide();
	$('.toptitC').html('<h3>购物车下单</h3>')	
	var curpaytype = $('input[name="paytype"]').val();  
    
  	if( curpaytype == 0 && juanpaytype !=0 && Number(juanpaytype) >0 ){
		if(  juanpaytype.indexOf(1) > -1  ){
 		}else{
			Tmsg('此优惠券不支持货到付款');
			return false;
		}
	}
	
	if( curpaytype == 1 && juanpaytype !=0 && Number(juanpaytype) >0 ){
		if(  juanpaytype.indexOf(2) > -1  ){
 		}else{
			Tmsg('此优惠券不支持在线支付');
			return false;
		}
	}
    checknext = true;
    $('#juanid').val(juanid);
    $('#juancost').val(juancost);
	$('input[name="yhjcost"]').val(juancost);
	$('#orderaddress').show();
	$('.wmr_title_center').text('订单配送至');
	$('.wmr_subord_yh').html('<h3>优惠券</h3><span style="color:#ff6e6e">-￥'+juancost+'<i class="fa fa-angle-right"></i></span>');
    $("#juanshuoming b span").text('-￥'+juancost);
    $('#mask1').hide();
	$('#popup1').hide();
	freshcart(1);
    myScroll.refresh();
	myScroll = new iScroll('wrapper', {
		useTransform: false,
		bounce:false,
		onBeforeScrollStart: function (e) {
			var target = e.target;
			while (target.nodeType != 1) target = target.parentNode;
			if (target.tagName != 'SELECT' && target.tagName != 'INPUT' && target.tagName != 'TEXTAREA')
				e.preventDefault();
		}
	}); 
	setTimeout("myyanchi()", 500 );
 }

}
function doselectjuan(){
	if(checknext ==  false){ 
    	checknext = true;
		
	 var oldjuanid = Number($('#juanid').val());
	if(juanlist.length > 0){
		var htmle = '';
		var checkcost = Number(cartsum)+Number(cartbagcost);
 		$.each(juanlist,function(i,field){  
			var juancost = Number(field.limitcost);

			   if(checkcost >= juancost){
			   	   var temp_pre = oldjuanid == field.id ?'on':'';
			      	htmle +='<li class="'+temp_pre+'" onclick="selectjuan(\''+field.id+'\',\''+field.cost+'\',\''+field.limitcost+'\',\''+field.name+'\',\''+field.paytype+'\');">满'+field.limitcost+'减'+field.cost+'</li>';
			   	
			   }
		});
		if(htmle == ''){
		  Tmsg('无满足条件的优惠券');
		}else{
			 htmle = '<li class="" onclick="selectjuan(\'0\',\'0\',\'0\',\'不使用优惠券\',\'0\');">不使用优惠券</li>'+htmle; 
		  myScroll.scrollToElement('#yhjposition',100); 
	      
  	         setTimeout(function () {
	             	loadhtml(htmle,'#yhjposition');
	           }, 100);	            
		} 
		
	}else{
	  Tmsg('您未绑定优惠券');
	  $('#mask1').hide();
	  $('#popup1').hide();
	}
	setTimeout("myyanchi()", 500 );
 }
}  
function contains(arr, obj) {
  var i = arr.length;
  while (i--) {
    if (arr[i] == obj) {
      return true;
    }
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
		$.each(juanlist,function(i,field){   //不可用优惠券
			var juancost = Number(field.limitcost);
			var jpaytype = $('input[name="paytype"]').val();   
			    jpaytype = Number(jpaytype)+1;
				if(field.paytype == '' || field.paytype == 'undefined' || field.paytype == null){
					var paytypearr = '1,2';
				}else{
					var paytypearr = field.paytype.split(","); 
				}				  
            if(!(checkcost >= juancost && contains(paytypearr,jpaytype))){
					 
					var can = 'no';	
					                 	   
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
					 
					htmle +=' <div class="discouponB" style="height:auto;line-height:20px;border-top:1px #F0F0F0 dashed;font-size: 11px;color:red;"><ul>';
					htmle +='<li style="color:red"><img src="'+siteurl+'/upload/images/tip.png" style="height: 17px;margin: 0px 7px -3px -3px;">不可用原因</li>';	
					if(checkcost < juancost){
						htmle +='<li style="color:#999999">&bull;&nbsp;&nbsp;满'+juancost+'元可使用</li>';							
					} if(!contains(paytypearr,jpaytype) && jpaytype == 1){
						htmle +='<li style="color:#999999">&bull;&nbsp;&nbsp;仅限在线支付订单使用</li>';	
					} if(!contains(paytypearr,jpaytype) && jpaytype == 2){
						htmle +='<li style="color:#999999">&bull;&nbsp;&nbsp;仅限货到付款订单使用</li>';	
					}
					htmle +='</ul></div>';	
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
		
	} 
	
	setTimeout("myyanchi()", 500 );
 }
}
function notusejuan(){
	$('#orderaddress').show();
		$('.wmr_title_center').text('订单配送至');
		$('.wmr_subord_yh').html('<h3>优惠券</h3><span>不使用优惠券<i class="fa fa-angle-right"></i></span>');     
		$('#mask1').hide();
		$('#popup1').hide();
		$('#gdcart').show();  
		$('#yhjlist').hide();
		$('#juanid').attr('data',1);
		$('#juanid').val(0);
		$('#juancost').val(0);
		$('input[name="yhjcost"]').val(0);
		$('.checkjuan').removeClass('checkonejuan');
		freshcart();
}
/*================获取优惠券信息===================*/  
function getjuaninfo(){
     freshcart()  
	 var oldjuanid = Number($('#juanid').val());
	
	if(  typeof(juanlist) != "undefined" ){
	 
	if(juanlist.length > 0){	
		var juancount = 0;
		var checkcost = Number(cartsum)+Number(cartbagcost);
		 console.log(juanlist);
 		$.each(juanlist,function(i,field){  
		   var juancost = Number(field.limitcost);
		
			var jpaytype = $('input[name="paytype"]').val();   
			    jpaytype = Number(jpaytype)+1;
				 
				if(field.paytype == '' || field.paytype == 'undefined' || field.paytype == null){
					var paytypearr = '1,2';
					 
				}else{
					var paytypearr = field.paytype.split(","); 
					 
				}	
			 
		   if(checkcost >= juancost && contains(paytypearr,jpaytype)){
			   
				juancount = juancount + 1;
		   }
		});
		   
		if(juancount > 0){
			$('.wmr_subord_yh').html('<h3>优惠券</h3><span style="color:#ff6e6e">'+juancount+'张可用<i class="fa fa-angle-right"></i></span>');
			$('#yhjlist span i').text(juancount);        			 			  
		}else{
			 $('.wmr_subord_yh').html('<h3>优惠券</h3><span>暂无可用<i class="fa fa-angle-right"></i></span>');  
           $('#yhjlist span i').text(0); 			 
		} 
		
	}else{
	    $('#juanshuoming').text('暂无可用');        
	} 
}
}
function closeout(){ 
	  $('#mask1').hide();
	  $('#popup1').hide(); 
}

function carttj(){
	//alert(cartsum);
	$('#packagingFee').text(cartbagcost);
	$('#fixedDeliveryFee').text(cartpscost);
	var totalFee =Number(cartbagcost)+Number(cartpscost)+Number(cartsum)-Number(cxcost);
	$('#totalFee').text(totalFee);
} 

function  orderSubmit(){
	var buyerlng = $('input[name="addresslng"]').val();
	var buyerlat = $('input[name="addresslat"]').val();
	var payway = $('input[name="paytype"]').val();  
    var remark = $('input[name="kouweibz"]').val()+$('input[name="orderbz"]').val();
	var jfcost = $('input[name="jfcost"]').val();
	if( payway == 2){
		Tmsg("未开启任何支付方式，请联系管理员！");	
		return false;
	}
	 if(checknext ==  false){ 
    	 checknext = true;
     	 if($('#DeliveryTime').val() == ''){
     	    Tmsg('请录入联送货时间');
     	   return false;
     	 }
     	$('#loading').show();
     	  url = siteurl+'/index.php?ctrl=wxsite&action=makeorder&datatype=json&random=@random@';
     	  url = url.replace('@random@', 1+Math.round(Math.random()*1000));
        $.ajax({         //script定义
                 url: url.replace('@random@', 1+Math.round(Math.random()*1000)),
                 dataType: "json",
                 async:true,
                 data:{shopid:shopid,'remark':remark,'minit':$("#DeliveryTime").val(),'dikou':jfcost,'juanid':$('#juanid').val(),'paytype':payway,'buyerlng':buyerlng,'buyerlat':buyerlat},
                 success:function(content) {
                 	if(content.error ==  false){
                 	    	window.location.href=  siteurl+'/index.php?ctrl=wxsite&action=subshow&orderid='+content.msg ;//.html?orderid='+datas.data;
                 	}else{
                 		Tmsg(content.msg);
						$('#loading').toggle();
						return false;
                 	}
                  	$('#loading').toggle();
                 
                 },
                 error:function(){
                  $('#loading').toggle();
                 }
        }); 
        setTimeout("myyanchi()", 500 );
   }    
}
function  orderSubmit2(){
	var payway = $('input[name="paytype"]').val();  
	 
	if( payway == 'undefined'){
		Tmsg("未开启任何支付方式，请联系管理员！");	
		return false;
	}
	 if(checknext ==  false){ 
    	 checknext = true;
     	 if($('#DeliveryTime').val() == ''){
     	    Tmsg('请录入消费时间');
     	   return false;
     	 } 
     	$('#loading').show();
     	  url = siteurl+'/index.php?ctrl=wxsite&action=makeorder2&datatype=json&random=@random@';
     	  url = url.replace('@random@', 1+Math.round(Math.random()*1000));
        $.ajax({         //script定义
                 url: url.replace('@random@', 1+Math.round(Math.random()*1000)),
                 dataType: "json",
                 async:true,
                 data:{shopid:shopid,'remark':$('input[name="remark"]').val(),'minit':$("#DeliveryTime").val(),'dikou':'0','juanid':'0','paytype':$('input[name="paytype"]').val(),'subtype':subtype,'personcount':$('input[name="people"]').val(),'paytype':payway},
                 success:function(content) { 
                 	if(content.error ==  false){
                 	    	window.location.href=  siteurl+'/index.php?ctrl=wxsite&action=subshow&orderid='+content.msg ;//.html?orderid='+datas.data;
                 	}else{
                 		Tmsg(content.msg);
                 	}
                  	$('#loading').toggle();
                 
                 },
                 error:function(){
                  $('#loading').toggle();
                 }
        }); 
        setTimeout("myyanchi()", 500 );
   }    
}
function dochangpaytype(obj){
  $(obj).addClass('onpaytype').siblings().removeClass('onpaytype');
   $(obj).removeClass('downpaytype').siblings().addClass('downpaytype');
   $('input[name="paytype"]').val($(obj).attr('data'));
}
function ShowChange(){
	$('body').append('<div id="mask" style="" ></div>'); //创建遮照层
	$('body').append('<div class="popup w580" style="display:none;"><div class="popup-hd"><a id="closex" title="关闭" class="closex closegb" href="javascript:void(0);"><span>关闭</span></a></div><p id="alertbox-msg" class="position02">下单前请添加客户信息</p><div class="bgPray" style="display: -webkit-box;display: -moz-box;display: -o-box;display: box;-webkit-box-align: center;-moz-box-align: center;-o-box-align: center;box-align: center;"><div style="width:50%;"><input id="alertbox-OK" class="inputBtn05 dogozuo" type="button" value="返回店铺"></div><div style="width:50%;"><input id="alertbox-OK" class="inputBtn05 goaddress" type="button" value="添加地址"></div></div></div>');
  $('.popup').slideToggle();
   $('.closegb').bind("click", function() {   
	 $("#mask").hide();
	$(".popup").hide();
});
  $('.dogozuo').bind("click", function() {   
	 window.location.href = backgoshop;
});
$('.goaddress').bind("click", function() {   
	 window.location.href = backadd;
});
}
function changeaddress(){
	 window.location.href = backadd;
}

function ShowChangezuo(){
	$('body').append('<div id="mask" style="" ></div>'); //创建遮照层
	$('body').append('<div class="popup w580" style="display:none;"><div class="popup-hd"><a id="closex" title="关闭" class="closex closegb" href="javascript:void(0);"><span>关闭</span></a></div><p id="alertbox-msg" class="position02">请选择你是直接预订桌位还是点菜预订</p><div class="bgPray" style="display: -webkit-box;display: -moz-box;display: -o-box;display: box;-webkit-box-align: center;-moz-box-align: center;-o-box-align: center;box-align: center;"><div style="width:50%;"><input id="alertbox-OK" class="inputBtn05 dogozuo" type="button" value="预定桌位"></div><div style="width:50%;"><input id="alertbox-OK" class="inputBtn05 closegb" type="button" value="点菜"></div></div></div>');
  $('.popup').slideToggle();
  $('.closegb').bind("click", function() {   
	$("#mask").hide();
	$(".popup").hide();
});
  $('.dogozuo').bind("click", function() {   
	 window.location.href = zuocart;
   });
}

