drop TABLE if exists p39_brand;
CREATE TABLE p39_brand
(
	id mediumint unsigned not null auto_increment comment 'id',
	brand_name varchar(30) not null comment '品牌名称',
	site_url varchar(150) not null default '' comment '官网',
	logo varchar(150) not null default '' comment 'LOGO图片',
	primary key (id)
)engine=InnoDB default charset=utf8 comment '品牌';