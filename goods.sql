CREATE database php39;

use php39;

set names utf8;

CREATE TABLE p39_goods
(
	id mediumint unsigned not null auto_increment comment 'ID',
	goods_name varchar(50) not null comment '商品名称',
	market_price decimal(10,2) not null comment '市场价格',
	shop_price decimal(10,2) not null comment '本店价格',
	goods_desc longtext comment '商品描述',
	is_on_sale enum('是','否') not null default '是' comment '是否上架',
	is_delete enum('是','否') not null default '否' comment '是否放到回收站',
	addtime datetime not null comment '添加时间',
	logo varchar(150) not null comment '原始图片',
	sm_logo varchar(150) not null comment '最小图',
	mid_logo varchar(150) not null comment '稍大图',
	big_logo varchar(150) not null comment '大图',
	mbig_logo varchar(150) not null comment '最大图',
	brand_id mediumint unsigned not null default '0' comment '品牌ID',
	primary key (id),
	key shop_price(shop_price),
	key addtime(addtime),
	key is_on_sale(is_on_sale),
	key brand_id(brand_id)
)engine=InnoDB default charset=utf8 comment '商品';

ALTER TABLE p39_goods ADD logo varchar(150) not null comment '原始图片';
ALTER TABLE p39_goods ADD sm_logo varchar(150) not null comment '最小图';
ALTER TABLE p39_goods ADD mid_logo varchar(150) not null comment '稍大图';
ALTER TABLE p39_goods ADD big_logo varchar(150) not null comment '大图';
ALTER TABLE p39_goods ADD mbig_logo varchar(150) not null comment '最大图';
alter table p39_goods add index(brand_id);

drop TABLE if exists p39_brand;
CREATE TABLE p39_brand
(
	id mediumint unsigned not null auto_increment comment 'id',
	brand_name varchar(30) not null comment '品牌名称',
	site_url varchar(150) not null default '' comment '官网',
	logo varchar(150) not null default '' comment 'LOGO图片',
	primary key (id)
)engine=InnoDB default charset=utf8 comment '品牌';

drop TABLE if exists p39_member_level;
CREATE TABLE p39_member_level
(
	id mediumint unsigned not null auto_increment comment 'id',
	level_name varchar(30) not null comment '级别名称',
	jifen_bottom mediumint unsigned not null comment '最小积分',
	jifen_top mediumint unsigned not null comment '最大积分',
	primary key (id)
)engine=InnoDB default charset=utf8 comment '会员级别';

drop table if exists p39_member_price;
CREATE table p39_member_price
(
	price decimal(10,2) not null comment '会员价格',
	level_id mediumint unsigned not null comment '级别ID',
	goods_id mediumint unsigned not null comment '商品ID',
	key level_id(level_id),
	key goods_id(goods_id)
)engine=InnoDB default charset=utf8 comment '会员价格';

