create database db_zergdev encoding 'UTF-8';

drop table if exists banner;
drop sequence if exists SEQ_BANNER;

create sequence SEQ_BANNER as bigint
    start 2;
create table banner
(
    "id"          bigint not null default nextval('seq_banner'),
    "name"        varchar(50)     default null,
    "description" varchar(255)    default null,
    "delete_time" int             default null,
    "update_time" int             default null,
    primary key ("id")
);
comment on column banner.name is 'banner名称，通常作为标识';
comment on column banner.description is 'banner描述';
comment on table banner is 'banner管理表';
insert into banner
values ('1', '首页置顶', '首页轮播图', null, null);

drop table if exists banner_item;
drop sequence if exists SEQ_BANNER_ITEM;

create sequence SEQ_BANNER_ITEM as bigint
    start 6;
create table banner_item
(
    "id"          bigint       not null default nextval('SEQ_BANNER_ITEM'),
    "img_id"      int          not null,
    "key_word"    varchar(100) not null,
    "type"        int          not null default '1',
    "delete_time" int                   default null,
    "banner_id"   int          not null,
    "update_time" int                   default null,
    primary key ("id")
);
comment on column banner_item.img_id is '外键，关联image表';
comment on column banner_item.key_word is '执行关键字，根据不同的type含义不同';
comment on column banner_item.type is '跳转类型，可能导向商品，可能导向专题，可能导向其他。0，无导向；1：导向商品;2:导向专题';
comment on column banner_item.banner_id is '外键，关联banner表';
comment on table banner is 'banner子项表';

insert into "banner_item"
values ('1', '65', '6', '1', null, '1', null);
insert into "banner_item"
values ('2', '2', '25', '1', null, '1', null);
insert into "banner_item"
values ('3', '3', '11', '1', null, '1', null);
insert into "banner_item"
values ('5', '1', '10', '1', null, '1', null);
