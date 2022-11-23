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


drop sequence if exists image;
drop table if exists SEQ_IMAGE;

create sequence SEQ_IMAGE as bigint
    start 70;
create table image
(
    "id"          bigint       not null default nextval('SEQ_IMAGE'),
    "url"         varchar(255) not null,
    "from"        int          not null default '1',
    "delete_time" int                   default null,
    "update_time" int                   default null,
    primary key ("id")
);
comment on column image.url is '图片路径';
comment on column image.from is '1 来自本地，2 来自公网';
comment on table image is '图片总表';

insert into "image"
values ('1', '/banner-1a.png', '1', null, null);
insert into "image"
values ('2', '/banner-2a.png', '1', null, null);
insert into "image"
values ('3', '/banner-3a.png', '1', null, null);
insert into "image"
values ('4', '/category-cake.png', '1', null, null);
insert into "image"
values ('5', '/category-vg.png', '1', null, null);
insert into "image"
values ('6', '/category-dryfruit.png', '1', null, null);
insert into "image"
values ('7', '/category-fry-a.png', '1', null, null);
insert into "image"
values ('8', '/category-tea.png', '1', null, null);
insert into "image"
values ('9', '/category-rice.png', '1', null, null);
insert into "image"
values ('10', '/product-dryfruit@1.png', '1', null, null);
insert into "image"
values ('13', '/product-vg@1.png', '1', null, null);
insert into "image"
values ('14', '/product-rice@6.png', '1', null, null);
insert into "image"
values ('16', '/1@theme.png', '1', null, null);
insert into "image"
values ('17', '/2@theme.png', '1', null, null);
insert into "image"
values ('18', '/3@theme.png', '1', null, null);
insert into "image"
values ('19', '/detail-1@1-dryfruit.png', '1', null, null);
insert into "image"
values ('20', '/detail-2@1-dryfruit.png', '1', null, null);
insert into "image"
values ('21', '/detail-3@1-dryfruit.png', '1', null, null);
insert into "image"
values ('22', '/detail-4@1-dryfruit.png', '1', null, null);
insert into "image"
values ('23', '/detail-5@1-dryfruit.png', '1', null, null);
insert into "image"
values ('24', '/detail-6@1-dryfruit.png', '1', null, null);
insert into "image"
values ('25', '/detail-7@1-dryfruit.png', '1', null, null);
insert into "image"
values ('26', '/detail-8@1-dryfruit.png', '1', null, null);
insert into "image"
values ('27', '/detail-9@1-dryfruit.png', '1', null, null);
insert into "image"
values ('28', '/detail-11@1-dryfruit.png', '1', null, null);
insert into "image"
values ('29', '/detail-10@1-dryfruit.png', '1', null, null);
insert into "image"
values ('31', '/product-rice@1.png', '1', null, null);
insert into "image"
values ('32', '/product-tea@1.png', '1', null, null);
insert into "image"
values ('33', '/product-dryfruit@2.png', '1', null, null);
insert into "image"
values ('36', '/product-dryfruit@3.png', '1', null, null);
insert into "image"
values ('37', '/product-dryfruit@4.png', '1', null, null);
insert into "image"
values ('38', '/product-dryfruit@5.png', '1', null, null);
insert into "image"
values ('39', '/product-dryfruit-a@6.png', '1', null, null);
insert into "image"
values ('40', '/product-dryfruit@7.png', '1', null, null);
insert into "image"
values ('41', '/product-rice@2.png', '1', null, null);
insert into "image"
values ('42', '/product-rice@3.png', '1', null, null);
insert into "image"
values ('43', '/product-rice@4.png', '1', null, null);
insert into "image"
values ('44', '/product-fry@1.png', '1', null, null);
insert into "image"
values ('45', '/product-fry@2.png', '1', null, null);
insert into "image"
values ('46', '/product-fry@3.png', '1', null, null);
insert into "image"
values ('47', '/product-tea@2.png', '1', null, null);
insert into "image"
values ('48', '/product-tea@3.png', '1', null, null);
insert into "image"
values ('49', '/1@theme-head.png', '1', null, null);
insert into "image"
values ('50', '/2@theme-head.png', '1', null, null);
insert into "image"
values ('51', '/3@theme-head.png', '1', null, null);
insert into "image"
values ('52', '/product-cake@1.png', '1', null, null);
insert into "image"
values ('53', '/product-cake@2.png', '1', null, null);
insert into "image"
values ('54', '/product-cake-a@3.png', '1', null, null);
insert into "image"
values ('55', '/product-cake-a@4.png', '1', null, null);
insert into "image"
values ('56', '/product-dryfruit@8.png', '1', null, null);
insert into "image"
values ('57', '/product-fry@4.png', '1', null, null);
insert into "image"
values ('58', '/product-fry@5.png', '1', null, null);
insert into "image"
values ('59', '/product-rice@5.png', '1', null, null);
insert into "image"
values ('60', '/product-rice@7.png', '1', null, null);
insert into "image"
values ('62', '/detail-12@1-dryfruit.png', '1', null, null);
insert into "image"
values ('63', '/detail-13@1-dryfruit.png', '1', null, null);
insert into "image"
values ('65', '/banner-4a.png', '1', null, null);
insert into "image"
values ('66', '/product-vg@4.png', '1', null, null);
insert into "image"
values ('67', '/product-vg@5.png', '1', null, null);
insert into "image"
values ('68', '/product-vg@2.png', '1', null, null);
insert into "image"
values ('69', '/product-vg@3.png', '1', null, null);


-- Theme表
drop sequence if exists SEQ_THEME;
drop table if exists theme;

create sequence SEQ_THEME as bigint
    start 4;
create table "theme"
(
    "id"           bigint      not null default nextval('SEQ_THEME'),
    "name"         varchar(50) not null,
    "description"  varchar(255)         default null,
    "topic_img_id" int         not null,
    "delete_time"  int                  default null,
    "head_img_id"  int         not null,
    "update_time"  int                  default null,
    primary key ("id")
);
comment on column theme.name is '专题名称';
comment on column theme.description is '专题描述';
comment on column theme.topic_img_id is '主题图';
comment on column theme.head_img_id is '专题列表页，头图';
comment on table theme is '主题信息表';

insert into "theme"
values ('1', '专题栏位一', '美味水果世界', '16', null, '49', null);
insert into "theme"
values ('2', '专题栏位二', '新品推荐', '17', null, '50', null);
insert into "theme"
values ('3', '专题栏位三', '做个干物女', '18', null, '18', null);
