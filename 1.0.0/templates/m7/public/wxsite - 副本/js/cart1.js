$(function(){ 
	$('body').append('<div id="addload" style="position: absolute; z-index: 1000; left: 30%; top: 30%; opacity: 1; display: none; height: 15px;width: 15px;border-radius: 15px;line-height: 12px;overflow:hidden; background: #ea5413;"></div>'); 
});
 var click_button = false;
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
	  //    var typeid = $(obj).attr('typeid');
	  //    $('#typelist'+typeid).show();
	 //     $('#typelist'+typeid).text(Number($('#typelist'+typeid).text())+1);
	      $('#gidli_'+gid).addClass('onselect');
	      $('#gshu_'+gid).text(Number($('#gshu_'+gid).text())+1); 
		  $('#gshu_'+gid).show();
		  $('#total_count').show();
	    	//if($(valse).is(':checked') == true)
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
	// alert(tarray.join(','));
	 
	 
	var shopid = $('input[name="product_shopid"]').val();
	var goodsid = $('input[name="product_goodsid"]').val();
	var ggdetids = tarray.join(',');
 
	if(tarray.length == $(obj).length){ 
		var url= siteurl+'/index.php?ctrl=site&action=doselectproduct&goods_id='+goodsid+'&shopid='+shopid+'&ggdetids='+ggdetids+'&type=1&datatype=json&random=@random@';
        url = url.replace('@random@', 1+Math.round(Math.random()*1000)); 
    	var bk = ajaxback(url,'');
		 
	    if(bk.flag == false){ //需获取出当前商品的productid 并获取相关库存 已在购物中的数量
		     var productinfo = bk.content;
             //alert(productinfo.id);		
            // uponeproduct(productinfo.id,shopid,1);	
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
			 
			 
			  // if($.inArray( $(this).attr('data'), temparray ) >=0){ 
		// }else{
		     // temparray.push($(this).attr('data'));
		// } 	
			 
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
    var paytype = $("#payway ul li").find(".onpay").attr('data');
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
	if(newpscost && newpscost != datas.content.pscost && $payflag !=1){
		newTmsg("由于配送地址变化，配送费更改为"+newpscost+"元"); 
	}
	datas.content.pscost = newpscost;
 	 $('#shocart').html(''); 
 	 $('#nextshocart').html(''); 
	  if(datas.flag == false){
    	var temp_htmls = '';
           $('#shocart').append(temp_htmls);
    	 	  $.each(datas.content.list, function(i,val){    
    	 	 	  var htmls = template.render('cartlist', {list:val});
    	 	 	  $('#shocart').append(htmls);
    	    });

		  var morepscost = Number($("#morepscost").text());

		  var morepscost = Number($("#morepscost").text());//附加配送费
		  var juancost = Number($("#juancost").val());//代金券
		  var jifen = Number($("#jifen").val());//积分抵扣


     	    $('#cartnum').text(datas.content.sumcount);
		  var noyouhuiallcost = Number(datas.content.sum);//+Number(datas.content.pscost)+Number//(datas.content.bagcost);
		  var allcost = (Number(datas.content.sum)+Number(datas.content.pscost)+Number(datas.content.bagcost)+Number(morepscost)-Number(datas.content.downcost)-Number(juancost)-Number(jifen)).toFixed(2);
			//alert(allcost);
    	    $('#cartcost').text(allcost);

    	 //   $('#cart_total').text(datas.content.sum);
    	 //   $('#bagcost').text(datas.content.bagcost);
    	 //   $('#cxcost').text(datas.content.downcost);
    	    
    	    /*
    	     
       	  	   	  */
		 if(datas.content.bagcost != 0){
       	  	  temp_htmls = '     <li><span class="shopdetalistL">打包费</span><span class="shopdetalistC">&nbsp;</span><span class="shopdetalistR">￥'+datas.content.bagcost+'</span></li>    ';
			  $('#shocart').append(temp_htmls); 
		 }
		if(datas.content.pscost != 0){
       	  	  temp_htmls = '     <li><span class="shopdetalistL">配送费</span><span class="shopdetalistC">&nbsp;</span><span class="shopdetalistR">￥'+datas.content.pscost+'</span></li>    ';
			  $('#shocart').append(temp_htmls); 
		 }
			 temp_htmls = '        <li><span class="shopdetalistL" style="width:49.8823%;">&nbsp;</span><span class="shopdetalistC shpdetb">合计：</span><span class="shopdetalistR">￥'+noyouhuiallcost+'</span></li> <input type="hidden" value="'+noyouhuiallcost+'" id="total_num"/>';
			  $('#shocart').append(temp_htmls);

		  if(morepscost>0){
			  temp_htmls = '     <li><span class="shopdetalistL">附加配送费</span><span class="shopdetalistC">&nbsp;</span><span class="shopdetalistR">￥'+morepscost+'</span></li>    ';
			  $('#shocart').append(temp_htmls);
		  }

	  if(datas.content.downcost != 0 ){
			temp_htmls = ' <li><span class="shopdetalistL">优惠立减</span><span class="shopdetalistC">&nbsp;</span><span class="shopdetalistR">-￥'+datas.content.downcost+'</span></li>	<input type="hidden" value="'+datas.content.downcost+'" id="downcost"/>';
			$('#nextshocart').append(temp_htmls);
	  }

		  if(juancost > 0 ){
			  temp_htmls = ' <li><span class="shopdetalistL" style="width:49.8823%;">&nbsp;</span><span class="shopdetalistC shpdetb">代金券抵扣：</span><span class="shopdetalistR">-￥'+juancost+'</span></li>	';
			  $('#nextshocart').append(temp_htmls);
		  }
		  if(jifen > 0 ){
			  temp_htmls = ' <li><span class="shopdetalistL" style="width:49.8823%;">&nbsp;</span><span class="shopdetalistC shpdetb">积分抵扣：</span><span class="shopdetalistR">-￥'+jifen+'</span></li>	';
			  $('#nextshocart').append(temp_htmls);
		  }


			temp_htmls = ' <li><span class="shopdetalistL" style="width:49.8823%;">&nbsp;</span><span class="shopdetalistC" style=" width:28.5%; ">订单总计：</span><span class="shopdetalistR shpdetredb">￥'+allcost+'</span></li>	';  
    	    $('#nextshocart').append(temp_htmls);

    	    $("#jifenshuoming").html('选择抵扣金额<i class="fa fa-angle-right"></i>');
    	    $("#jifen").val(0);
    	    cartbagcost = datas.content.bagcost;
    	    cxcost =  datas.content.downcost;
          cartsum = datas.content.sum;
          cartpscost = datas.content.pscost; 
          surecost = datas.content.surecost;
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
  		   
      	//	$('.listcontent').remove();
      	//	$('.colgreen').remove();//移除促销
      		cartbagcost =0;
          cartpscost = 0;
           cartsum = 0;
          cxcost = 0;
          //    carttj();
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
function doselectjifen(bili,myscore){
	if(checknext ==  false){ 
    	checknext = true;
	  var oldjifen = Number($('#jifen').val());
	  var myjifen = myscore;
		var jifenbili =bili;
		var rslt = Number(myjifen)/Number(jifenbili); //闄� 
	  var canduihuan = rslt - Math.floor(rslt) > 0?Math.floor(rslt):Math.floor(rslt);//鎬婚〉闈㈡暟閲�
	  var shopcost = surecost;
	  var cancost = Math.ceil(shopcost) > canduihuan ? canduihuan:Math.ceil(shopcost);
	  var htmlbottom = '';
	  if(jifenbili > 0){ 
	      for(var i=1;i<=cancost;i++){
	      	 var temp_pre = '';
	      	if(oldjifen == i){
	      		temp_pre = 'on';
	      	}
	      	 var jifenall = Number(i)*jifenbili;
	      	 htmlbottom += '<li class="'+temp_pre+' asdas" onclick="selectjifen(\''+i+'\',\'使用'+jifenall+'抵扣'+i+'元\');">抵扣'+i+'元</li>';
	      }
	      if(htmlbottom != ''){
	      	  htmlbottom = '<li class="" onclick="selectjifen(0,\'不使用积分抵扣\');">不使用积分抵扣</li>'+htmlbottom;
	      	  myScroll.scrollToElement('#jifenposition',100); 
	      //	 myScroll.scrollTo(0,Number(defaultheight)*-1,200,false); 
  	     // myScroll.refresh();
  	         setTimeout(function(){
	             	loadhtml(htmlbottom,'#jifenposition');
	           }, 100);
	      }else{
	      	 Tmsg('积分不超过'+bili+'，不能抵扣');
	      }
	      
	      
	      
	  }else{
	    Tmsg('积分不超过'+bili+'，不能抵扣');
	  } 
	    setTimeout("myyanchi()", 500 );
  }
}
function loadhtml(htmlbottom,elmid){
	myScroll.destroy();
	htmlbottom = '<div class="jifenshow" id="outdivshow"><ul>'+htmlbottom+'</ul></div>  ';
	      	 $('#popcontent').html(htmlbottom);
	  	 	  $('#mask1').show();
	        $('#popup1').show();
	        var allheight = $(window).height();
	          // var bottom = $("#jifenposition").offset().bottom;//元素相当于窗口的左边的偏移量
             var top = $(elmid).offset().top;//元素相对于窗口的上边的偏移量 
               allheight = Number(allheight)-100;  
			 //  alert(0);
             top = Number(top)+40;
			   var  kuangheight = allheight/1.5;
				var kheight  =(allheight/1.5)/2;
	           $('#popup1').css({'top':'50%'});
	           $('#popup1').css({'marginTop':-kheight});
	       //    $('#outdivshow').css({'height':allheight});
	           $('#outdivshow').css({'height':kuangheight});
	          myScroll = new iScroll('outdivshow', {hScrollbar:false, vScrollbar:true,bounce:false});
}
function selectjifen(dikoujin,names){
	if(checknext ==  false){ 
    	checknext = true;
        //var money=$("#total_num").val();
        //var juancost=$("#juancost").val();
        //if(document.getElementById('downcost')){
        //    var downcost=$("#downcost").val();
        //}else{
        //    var downcost=0;
        //}
        //if(dikoujin !=0){
        //    var num=money-dikoujin-Number(juancost)-Number(downcost);
        //    if(document.getElementById("shopjf")){
        //        $("#jfnum").html("-￥"+dikoujin+"");
        //        $(".shpdetredb").html("￥"+num+"");
        //    }else{
        //        var temp_htmls = ' <li id="shopjf"><span class="shopdetalistL" style="width:49.8823%;">&nbsp;</span><span class="shopdetalistC shpdetb">积分抵扣：</span><span id="jfnum" class="shopdetalistR">-￥'+dikoujin+'</span></li>	';
        //        $('#nextshocart li').eq(-1).before(temp_htmls);//将积分抵扣追加在倒数第二位
        //        $(".shpdetredb").html("￥"+num+"");
        //    }
        //}else{
        //
        //	var num=money-dikoujin-Number(juancost)-Number(downcost);
        //
        //
        //	$("#jifen").val(0);
        //    $("#shopjf").remove();
        //    $(".shpdetredb").html("￥"+num+"");
        //}



  $('#jifen').val(dikoujin);
  $('#jifenshuoming').text(names);
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
	  myScroll.refresh();
  }
}
function maketime(){
	if(timelist.length > 0){
		if(timelist[0].cost > 0){
			$('#DeliveryTimesm').html(timelist[0].name+'附加配送费￥<font color=red  id="morepscost">'+timelist[0].cost+'</font>');
		}else{
			$('#DeliveryTimesm').html(timelist[0].name);
	   }
	  $('#DeliveryTime').val(timelist[0].value);
	}else{
		$('#DeliveryTimesm').text('店铺不在营业时间');
	}
}
function doselectTime(){
	if(checknext ==  false){ 
    	checknext = true;
	if(timelist.length > 0){
		var htmlbottom = ""; 
	   $.each(timelist,function(i,field){    	   
			 htmlbottom += '<li class="" onclick="selectTime(\''+field.value+'\',\''+field.name+'\',\''+field.cost+'\');">'+field.name+'</li>'; 
		});
	      //	  myScroll.scrollToElement('#Timeposition',100); 
	      //	 myScroll.scrollTo(0,Number(defaultheight)*-1,200,false); 
  	    //  myScroll.refresh();
  	         setTimeout(function () {
	             	loadhtml(htmlbottom,'#Timeposition');
	           }, 100);
		
		
	}else{
		Tmsg('店铺不在营业时间');
	}
	setTimeout("myyanchi()", 500 );
  }
}
//doselectpeople
function doselectpeople(personcount){
	if(checknext ==  false){ 
    	checknext = true;
	 var htmlbottom = "";
		for(var i=1;i<=personcount;i++){ 
	      	 htmlbottom += '<li class="" onclick="selectPeople(\''+i+'\');">'+i+'人</li>';
	  }  
	   
	      //	  myScroll.scrollToElement('#peopleposition',100); 
	      //	 myScroll.scrollTo(0,Number(defaultheight)*-1,200,false); 
  	    //  myScroll.refresh();
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
	 $('#DeliveryTimesm').html(timetitle+'附加配送费￥<font color=red  id="morepscost">'+cost+'</font>');
 }else{
	$('#DeliveryTimesm').html(timetitle);
 }
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
		freshcart(1);
	setTimeout("myyanchi()", 500 );
 }
}
function selectjuan(juanid,juancost,juanname,juanpaytype){
	if(checknext ==  false){ 
	var curpaytype = $("#payway ul li").find(".onpay").attr('data');
  	//if( curpaytype == 0 && juanpaytype !=0 ){
	//	if(  juanpaytype.indexOf(1) > -1  ){
 	//	}else{
	//		Tmsg('此代金券不支持货到付款');
	//		return false;
	//	}
	//}
    //
	//if( curpaytype == 1 && juanpaytype !=0  ){
	//	if(  juanpaytype.indexOf(2) > -1  ){
 	//	}else{
	//		Tmsg('此代金券不支持在线支付');
	//		return false;
	//	}
	//}

    	checknext = true;
        //var money=$("#total_num").val();
        //var jifen=$("#jifen").val();
        //if(document.getElementById('downcost')){
        //    var downcost=$("#downcost").val();
        //}else{
        //    var downcost=0;
        //}
        //if(juancost > 0){
        //    var num=money-juancost-Number(jifen)-Number(downcost);
        //    if(document.getElementById("shopyhj")){
        //        $("#yhjnum").html("-￥"+juancost+"");
        //        $(".shpdetredb").html("￥"+num+"");
        //    }else{
        //        var temp_htmls = ' <li id="shopyhj"><span class="shopdetalistL" style="width:49.8823%;">&nbsp;</span><span class="shopdetalistC shpdetb">优惠劵抵扣：</span><span id="yhjnum" class="shopdetalistR">-￥'+juancost+'</span></li>	';
        //        $('#nextshocart li').eq(-1).before(temp_htmls);//将优惠劵抵扣追加在倒数第二位
        //        $(".shpdetredb").html("￥"+num+"");
        //    }
        //}else{
			//var num=money-jifen-Number(juancost)-Number(downcost);
        //    $("#shopyhj").remove();
        //    $(".shpdetredb").html("￥"+num+"");
        //}

 $('#juanid').val(juanid);
 $('#juancost').val(juancost);
 $('#juanshuoming').text(juanname);
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
function doselectjuan(){
	if(checknext ==  false){ 
    	checknext = true;
	 var oldjuanid = Number($('#juanid').val());
	if(juanlist.length > 0){
		var htmle = '';
		var checkcost = Number(surecost);
 		$.each(juanlist,function(i,field){  
			var juancost = Number(field.limitcost);
			
			   if(checkcost >= juancost){
			   	   var temp_pre = oldjuanid == field.id ?'on':'';
			      	htmle +='<li class="'+temp_pre+'" onclick="selectjuan(\''+field.id+'\',\''+field.cost+'\',\''+field.name+'\',\''+field.paytype+'\');">'+field.name+'</li>';
			   	
			   }
		});
		if(htmle == ''){
		  Tmsg('无满足条件的代金券');
		}else{
			 htmle = '<li class="" onclick="selectjuan(\'0\',\'0\',\'不使用代金券\',\'0\');">不使用代金券</li>'+htmle;
		//	  htmle = '<div class="juanshow" id="outdivshow"><ul>'+htmle+'</ul></div>  <div style="clear:both;height:20px;"></div>';
	       
		  myScroll.scrollToElement('#yhjposition',100); 
	      //	 myScroll.scrollTo(0,Number(defaultheight)*-1,200,false); 
  	    //  myScroll.refresh();
  	         setTimeout(function () {
	             	loadhtml(htmle,'#yhjposition');
	           }, 100);
	           /*
			
	         
	          myScroll.destroy();
	          myScroll = new iScroll('outdivshow', {hScrollbar:false, vScrollbar:false,bounce:false});    */
		} 
		
	}else{
	  Tmsg('您未绑定代金券');
	  $('#mask1').hide();
	  $('#popup1').hide();
	}
	setTimeout("myyanchi()", 500 );
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
	var payway = $("#payway ul li").find(".onpay").attr('data');
	if( payway == 'undefined'){
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
                 data:{shopid:shopid,'remark':$('input[name="remark"]').val(),'minit':$("#DeliveryTime").val(),'dikou':$('#jifen').val(),'juanid':$('#juanid').val(),'paytype':payway,'buyerlng':buyerlng,'buyerlat':buyerlat},
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
	var payway = $("#payway ul li").find(".onpay").attr('data');
	 
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

