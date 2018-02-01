<?php
 
header("Content-Type:text/html;charset=utf-8"); 
define('hopedir', dirname(__FILE__).DIRECTORY_SEPARATOR);  
$config = hopedir."config/hopeconfig.php";   
$cfg = include($config); 
 
$lnk = mysqli_connect($cfg['dbhost'], $cfg['dbuser'], $cfg['dbpw']) or die ('Not connected : ' . mysql_error()); 
$version = mysqli_get_server_info(); 
if($version > '4.1' && $cfg['dbcharset']) {
				mysqli_query("SET NAMES '".$cfg['dbcharset']."'");
} 
if($version > '5.0') {
				mysqli_query("SET sql_mode=''");
}
												
if(!@mysqli_select_db($cfg['dbname'])){ 
				if(@mysqli_error()) {
					echo '数据库连接失败';exit;
				} else {
					mysqli_select_db($cfg['dbname']);
				}
}

/* mysql_query("
CREATE TABLE IF NOT EXISTS `xiaozu_jscompute` (
  `id` int(2) NOT NULL , 
  `type` text(50)  COMMENT '公式类型',
  `pscost` int(2) DEFAULT '0' COMMENT '是否加配送费',
  `bagcost` int(2) DEFAULT '0' COMMENT '是否加打包费',
  `shopdowncost` int(2) DEFAULT '0'  COMMENT '是否减促销中商家承担的部分',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
 ");
$checktable = mysql_query("SELECT psstatus FROM   `".$cfg['tablepre']."order`  ");
if(mysql_error()){
    mysql_query("ALTER TABLE  `".$cfg['tablepre']."order` ADD  `psstatus` int(2)  ; ");
}
$checktable = mysql_query("SELECT picktime FROM   `".$cfg['tablepre']."order`  ");
if(mysql_error()){
    mysql_query("ALTER TABLE  `".$cfg['tablepre']."order` ADD  `picktime` int(12)  ; ");
}

   mysql_query(" 
INSERT INTO `xiaozu_jscompute` VALUES ('1', '平台配送佣金', '1', '1', '1');
");  
  mysql_query(" 
INSERT INTO `xiaozu_jscompute` VALUES ('2', '商家配送佣金', '1', '1', '1');
");   
mysql_query(" 
INSERT INTO `xiaozu_jscompute` VALUES ('3', '平台配送结算', '1', '1', '1');
"); 
  mysql_query(" 
INSERT INTO `xiaozu_jscompute` VALUES ('4', '商家配送结算', '1', '1', '1');
"); 

 
	
	
	 

	 mysql_query(' DROP TRIGGER IF EXISTS `orderJs` ');
	 
	 mysql_query("
	
	CREATE TRIGGER `orderJs` AFTER UPDATE ON `".$cfg['tablepre']."order`
 FOR EACH ROW begin
 
  
 
 if old.paystatus = 0 && new.paystatus = 1 then
	if old.pstype = 0 && old.is_goshop =0 && old.shoptype != 100 &&  old.is_make = 1 then 
  		  insert into `".$cfg['tablepre']."orderps`(`orderid`,`shopid`,`psuid`,`psusername`,`psemail`,`status`,`dno`,`addtime`,`pstime`,`psycost`,`picktime`,`dotype`)
               		  values(old.id,new.shopid,0,'','',0,new.dno,unix_timestamp(),new.posttime,0,0,1);  
	end if; 
end if;
#当商家确认制作后执行
if old.is_make = 0 && new.is_make = 1 then
	if old.pstype = 0 && old.is_goshop =0 && old.shoptype != 100  then 
	 
  		  insert into `xiaozu_orderps`(`orderid`,`shopid`,`psuid`,`psusername`,`psemail`,`status`,`dno`,`addtime`,`pstime`,`psycost`,`picktime`,`dotype`)
               		  values(old.id,new.shopid,0,'','',0,new.dno,unix_timestamp(),new.posttime,0,0,1);  
	end if;
 
end if;
 
 
set @dotime = unix_timestamp();
 
IF old.status <> 3 && new.status = 3 && old.shoptype <> 100 then
select id into @cf_id from xiaozu_shopjs where orderid=old.id;
    IF @cf_id is null then 

            select id,shoptype,yjin,uid into @cf_shopid,@cf_shoptype,@cf_yjin,@cf_uid from xiaozu_shop where id=old.shopid;
            IF @cf_shoptype = 1 then
                    select sendtype into @cf_sendtype from xiaozu_shopmarket where shopid=@cf_shopid;
                    
            ELSE         
                    select sendtype into @cf_sendtype from xiaozu_shopfast where shopid=@cf_shopid;
            END IF;
            
            IF old.paytype =1 then 
            	set @onlinecost = old.allcost;
                set @onlinecount = 1;
                set @unlinecost = 0;
                set @unlinecount = 0;
				
            ELSE
            	set @onlinecost = 0;
                set @onlinecount = 0;
                set @unlinecost = old.allcost;
                set @unlinecount = 1;
            END IF;
            
            IF @cf_sendtype = 1 then
			    set @sjyjnum = old.shopcost;
			    select pscost,bagcost,shopdowncost into @cf_pscost,@cf_bagcost,@cf_shopdowncost from xiaozu_jscompute where id=2;
				if @cf_pscost = 1 then  
				    set @sjyjnum = @sjyjnum + old.shopps;  
				end if;  	
				if @cf_bagcost = 1 then  
				    set @sjyjnum = @sjyjnum + old.bagcost;  
				end if;  
				if @cf_shopdowncost = 1 then  
				    set @sjyjnum = @sjyjnum - (old.cxcost-old.shopdowncost);  
				end if;  
            	set @yjcost = @sjyjnum*(@cf_yjin*0.01);
				
				set @sjjsnum = old.shopcost;
			    select pscost,bagcost,shopdowncost into @cf_pscost,@cf_bagcost,@cf_shopdowncost from xiaozu_jscompute where id=4;
				if @cf_pscost = 1 then  
				    set @sjjsnum = @sjjsnum + old.shopps;  				 
				end if;  
				if @cf_bagcost = 1 then  
				    set @sjjsnum = @sjjsnum + old.bagcost;  
				end if;  
				if @cf_shopdowncost = 1 then  
				    set @sjjsnum = @sjjsnum - (old.cxcost-old.shopdowncost);   
				end if;  
				
				if old.paytype = 0 then
				    set @acountcost =  - @yjcost;
				else
				    set @acountcost = @sjjsnum - @yjcost;
				end if;
            ELSE
				set @ptyjnum = old.shopcost;
			    select pscost,bagcost,shopdowncost into @cf_pscost,@cf_bagcost,@cf_shopdowncost from xiaozu_jscompute where id=1;
				if @cf_pscost = 1 then  
				    set @ptyjnum = @ptyjnum + old.shopps;  				 
				end if; 
				if @cf_bagcost = 1 then  
				    set @ptyjnum = @ptyjnum + old.bagcost;  
				end if; 
				if @cf_shopdowncost = 1 then  
				    set @ptyjnum = @ptyjnum - (old.cxcost-old.shopdowncost);  
				end if;  
            	set @yjcost = @ptyjnum*(@cf_yjin*0.01);
			
            	set @ptjsnum = old.shopcost;
			    select pscost,bagcost,shopdowncost into @cf_pscost,@cf_bagcost,@cf_shopdowncost from xiaozu_jscompute where id=3;
				if @cf_pscost = 1 then  
				    set @ptjsnum = @ptjsnum + old.shopps;  				 
				end if; 
				if @cf_bagcost = 1 then  
				    set @ptjsnum = @ptjsnum + old.bagcost;  
				end if; 
				if @cf_shopdowncost = 1 then  
				    set @ptjsnum = @ptjsnum - (old.cxcost-old.shopdowncost);  
				end if;  
 				set @acountcost = @ptjsnum - @yjcost;
            END IF;
    	    select max(id) into @n from `xiaozu_shopjs`;
			
			if @n is null  then
				set @n=1;
			else
				set @n=@n+1;
			end if;
            
			insert into xiaozu_shopjs(onlinecount,onlinecost,unlinecount,unlinecost,yjb,acountcost,yjcost,pstype,shopid,shopuid,addtime,jstime,orderid) values (@onlinecount,@onlinecost,@unlinecount,@unlinecost,@cf_yjin,@acountcost,@yjcost,@cf_shoptype,@cf_shopid,@cf_uid,@dotime,@dotime,old.id);  
     
			select shopcost into @cf_shopcost from xiaozu_member where uid=@cf_uid;
			set @add_cost = @cf_shopcost+@acountcost;
			
			if @acountcost > 0 then
			    insert into xiaozu_shoptx(cost,type,status,addtime,shopid,shopuid,name,yue,jsid) values (@acountcost,3,2,@dotime,@cf_shopid,@cf_uid,'订单结算转入余额',@add_cost,@n);
			else
			    insert into xiaozu_shoptx(cost,type,status,addtime,shopid,shopuid,name,yue,jsid) values (@acountcost,3,2,@dotime,@cf_shopid,@cf_uid,'订单结算扣除佣金',@add_cost,@n);
			end if;
			
			UPDATE  `xiaozu_member` SET `shopcost` = `shopcost`+@acountcost  WHERE `uid`=@cf_uid;  
        
	 
     END IF;
     ELSEIF old.is_reback = 1 && new.is_reback = 2 then
		IF  old.status = 3   then  
			select id,onlinecost,onlinecount,unlinecount,unlinecost,yjb,yjcost,pstype,shopid,shopuid,acountcost,jsid,orderid into @cf_id,@cf_onlinecost,@cf_onlinecount,@cf_unlinecount,@cf_unlinecost,@cf_yjb,@cf_yjcost,@cf_pstype,@cf_shopid,@cf_shopuid,@cf_acountcost,@cf_jsid,@cf_orderid from xiaozu_shopjs where orderid=old.id;
			IF @cf_id is null then 
				set @X = 1;
			ELSE			 
				select shopcost into @cf_shopcost from xiaozu_member where uid=@cf_shopuid;
				set @jian_cost = @cf_shopcost-@cf_acountcost;
				insert into xiaozu_shoptx(cost,type,status,addtime,shopid,shopuid,name,yue,jsid) values (@cf_acountcost,3,2,@dotime,@cf_shopid,@cf_shopuid,'订单退款扣款',@jian_cost,@cf_id);
				
				UPDATE  `xiaozu_member` SET `cost` = `cost`-@cf_acountcost  WHERE `uid`=@cf_shopuid;
			
			END IF;
		END IF;
ELSE	 
	 set @X = 1;
END IF;
end;
	
	 ");

*/
	 // alter table 表名称 modify 字段名称 字段类型 [是否允许非空];

//	 mysql_query("alter table `xiaozu_order` modify `allcost` decimal(8,2)");
mysqli_query(" INSERT INTO `xiaozu_ztymode`(`id`,`type`,`cityid`) VALUES(7,1,450100) ");
//mysqli_query(" UPDATE `xiaozu_ztymode` set `cityid`= 450100 where `cityid`=110000 ");
echo mysqli_error();
mysqli_close($lnk);		 
echo 'ok';
exit;		
?>