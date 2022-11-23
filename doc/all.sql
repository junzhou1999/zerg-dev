create database db_zergdev encoding 'UTF-8';

drop table if exists banner;
create table banner
(
    "id"          serial not null,
    "name"        varchar(50)  default null,
    "description" varchar(255) default null,
    "delete_time" int          default null,
    "update_time" int          default null,
    primary key ("id")
);
comment on column banner.name is 'banner名称，通常作为标识';
comment on column banner.description is 'banner描述';
comment on table banner is 'banner管理表';

insert into banner
values ('1', '首页置顶', '首页轮播图', null, null);

drop table if exists banner_item;
create table banner_item
(
    "id"          serial       not null,
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


drop table if exists image;
create table image
(
    "id"          serial       not null,
    "url"         varchar(255) not null,
    "from"        boolean      not null default '1',
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
drop table if exists theme;
create table theme
(
    "id"           serial      not null,
    "name"         varchar(50) not null,
    "description"  varchar(255) default null,
    "topic_img_id" int         not null,
    "delete_time"  int          default null,
    "head_img_id"  int         not null,
    "update_time"  int          default null,
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


-- 产品信息表
drop table if exists product;
create table product
(
    "id"           serial        not null,
    "name"         varchar(80)   not null,
    "price"        decimal(6, 2) not null,
    "stock"        int           not null default '0',
    "delete_time"  int                    default null,
    "category_id"  int                    default null,
    "main_img_url" varchar(255)           default null,
    "from"         boolean       not null default '1',
    "create_time"  int                    default null,
    "update_time"  int                    default null,
    "summary"      varchar(50)            default null,
    "img_id"       int                    default null,
    primary key ("id")
);
comment on column product.name is '商品名称';
comment on column product.price is '价格,单位：分';
comment on column product.stock is '库存量';
comment on column product.main_img_url is '主图ID号，这是一个反范式设计，有一定的冗余';
comment on column product.from is '图片来自 1 本地 ，2公网';
comment on column product.create_time is '创建时间';
comment on column product.summary is '摘要';
comment on column product.img_id is '图片外键';
comment on table product is '产品信息表';

insert into "product"
values ('1', '芹菜 半斤', '0.01', '998', null, '3', '/product-vg@1.png', '1', null, null, null, '13');
insert into "product"
values ('2', '梨花带雨 3个', '0.01', '984', null, '2', '/product-dryfruit@1.png', '1', null, null, null, '10');
insert into "product"
values ('3', '素米 327克', '0.01', '996', null, '7', '/product-rice@1.png', '1', null, null, null, '31');
insert into "product"
values ('4', '红袖枸杞 6克*3袋', '0.01', '998', null, '6', '/product-tea@1.png', '1', null, null, null, '32');
insert into "product"
values ('5', '春生龙眼 500克', '0.01', '995', null, '2', '/product-dryfruit@2.png', '1', null, null, null, '33');
insert into "product"
values ('6', '小红的猪耳朵 120克', '0.01', '997', null, '5', '/product-cake@2.png', '1', null, null, null, '53');
insert into "product"
values ('7', '泥蒿 半斤', '0.01', '998', null, '3', '/product-vg@2.png', '1', null, null, null, '68');
insert into "product"
values ('8', '夏日芒果 3个', '0.01', '995', null, '2', '/product-dryfruit@3.png', '1', null, null, null, '36');
insert into "product"
values ('9', '冬木红枣 500克', '0.01', '996', null, '2', '/product-dryfruit@4.png', '1', null, null, null, '37');
insert into "product"
values ('10', '万紫千凤梨 300克', '0.01', '996', null, '2', '/product-dryfruit@5.png', '1', null, null, null, '38');
insert into "product"
values ('11', '贵妃笑 100克', '0.01', '994', null, '2', '/product-dryfruit-a@6.png', '1', null, null, null, '39');
insert into "product"
values ('12', '珍奇异果 3个', '0.01', '999', null, '2', '/product-dryfruit@7.png', '1', null, null, null, '40');
insert into "product"
values ('13', '绿豆 125克', '0.01', '999', null, '7', '/product-rice@2.png', '1', null, null, null, '41');
insert into "product"
values ('14', '芝麻 50克', '0.01', '999', null, '7', '/product-rice@3.png', '1', null, null, null, '42');
insert into "product"
values ('15', '猴头菇 370克', '0.01', '999', null, '7', '/product-rice@4.png', '1', null, null, null, '43');
insert into "product"
values ('16', '西红柿 1斤', '0.01', '999', null, '3', '/product-vg@3.png', '1', null, null, null, '69');
insert into "product"
values ('17', '油炸花生 300克', '0.01', '999', null, '4', '/product-fry@1.png', '1', null, null, null, '44');
insert into "product"
values ('18', '春泥西瓜子 128克', '0.01', '997', null, '4', '/product-fry@2.png', '1', null, null, null, '45');
insert into "product"
values ('19', '碧水葵花籽 128克', '0.01', '999', null, '4', '/product-fry@3.png', '1', null, null, null, '46');
insert into "product"
values ('20', '碧螺春 12克*3袋', '0.01', '999', null, '6', '/product-tea@2.png', '1', null, null, null, '47');
insert into "product"
values ('21', '西湖龙井 8克*3袋', '0.01', '998', null, '6', '/product-tea@3.png', '1', null, null, null, '48');
insert into "product"
values ('22', '梅兰清花糕 1个', '0.01', '997', null, '5', '/product-cake-a@3.png', '1', null, null, null, '54');
insert into "product"
values ('23', '清凉薄荷糕 1个', '0.01', '998', null, '5', '/product-cake-a@4.png', '1', null, null, null, '55');
insert into "product"
values ('25', '小明的妙脆角 120克', '0.01', '999', null, '5', '/product-cake@1.png', '1', null, null, null, '52');
insert into "product"
values ('26', '红衣青瓜 混搭160克', '0.01', '999', null, '2', '/product-dryfruit@8.png', '1', null, null, null, '56');
insert into "product"
values ('27', '锈色瓜子 100克', '0.01', '998', null, '4', '/product-fry@4.png', '1', null, null, null, '57');
insert into "product"
values ('28', '春泥花生 200克', '0.01', '999', null, '4', '/product-fry@5.png', '1', null, null, null, '58');
insert into "product"
values ('29', '冰心鸡蛋 2个', '0.01', '999', null, '7', '/product-rice@5.png', '1', null, null, null, '59');
insert into "product"
values ('30', '八宝莲子 200克', '0.01', '999', null, '7', '/product-rice@6.png', '1', null, null, null, '14');
insert into "product"
values ('31', '深涧木耳 78克', '0.01', '999', null, '7', '/product-rice@7.png', '1', null, null, null, '60');
insert into "product"
values ('32', '土豆 半斤', '0.01', '999', null, '3', '/product-vg@4.png', '1', null, null, null, '66');
insert into "product"
values ('33', '青椒 半斤', '0.01', '999', null, '3', '/product-vg@5.png', '1', null, null, null, '67');

drop table if exists theme_product;
create table theme_product
(
    "theme_id"   int not null,
    "product_id" int not null,
    primary key ("theme_id", "product_id")
);
comment on column theme_product.theme_id is '主题外键';
comment on column theme_product.product_id is '商品外键';
comment on table theme_product is '主题所包含的商品';

insert into "theme_product"
values ('1', '2');
insert into "theme_product"
values ('1', '5');
insert into "theme_product"
values ('1', '8');
insert into "theme_product"
values ('1', '10');
insert into "theme_product"
values ('1', '12');
insert into "theme_product"
values ('2', '1');
insert into "theme_product"
values ('2', '2');
insert into "theme_product"
values ('2', '3');
insert into "theme_product"
values ('2', '5');
insert into "theme_product"
values ('2', '6');
insert into "theme_product"
values ('2', '16');
insert into "theme_product"
values ('2', '33');
insert into "theme_product"
values ('3', '15');
insert into "theme_product"
values ('3', '18');
insert into "theme_product"
values ('3', '19');
insert into "theme_product"
values ('3', '27');
insert into "theme_product"
values ('3', '30');
insert into "theme_product"
values ('3', '31');
