## TP6学习

### init project

### TP6开启调试和显示错误信息

### TP6采取多应用并添加api应用下的路由定义

* 多应用的识别需要删除app/controller目录
* TP6相对TP5，路由定义需要在当前应用下
* TP6的路由域名后边是不能去掉应用名称的，确实需要去掉的话在domain_bind替换
* 定义好的路由地址为：http://192.168.243.3/api/v1/banner/{id}

### 强制路由，不需要PATHINFO

* 无法访问：http://192.168.243.3/api/v1.banner/getbanner?id={id}
* 但同时发现可以访问：http://192.168.243.3/api/v1/banner/getbanner/{id}

### 自定义验证器验证（统一校验）

* 使用基类校验统一api控制器下的校验规则
* 获取http请求参数：用Request的静态方法Request::param()。
* 各种子类validate面向的是接口需要调用的校验入口，定义校验规则、信息、场景。
* 基类Validate是所有校验的方法的集合，调用think.Validate的check()方法具体校验。

### 自定义异常处理（统一异常处理）

* 举例通过banner的goCheck()检查参数，然后测试异常
* 把全局的异常都作为BaseException的子类（没开启APP_DEBUG的运维环境下）
* 通过ExceptionHandle把处理方式都统一下来
* 测试地址：http://192.168.243.3/api/v1/banner/{id}

### 测试参数的批量校验，并返回对应异常信息

* 测试地址：http://192.168.243.3/api/v1/banner/{id}?num={num}

### Revert上一次commit，不对num进行校验

* 返回的exception可以自定义message，我们可以把校验的错误信息
* 作为exception的message。

### 添加model层，负责controller和数据库交互

* 同时加入自定义banner异常

### BannerModal使用原生sql语句查询数据库

* 数据库：PostgreSQL 12.11
* 连接数据库需要php-fpm安装pgsql，pdo_pgsql这两个扩展并添加。
* 并执行规定的pgsql.sql文件
* 添加连接配置
* 然后使用facade/Db类库初步进行数据库的原生sql语句查询。

### 使用构造器执行sql语句

* 使用构造器能更方便地使用框架语言对不同数据库完成相同地操作
* ->select(); 返回所有查询结果结合
* ->find(); 返回查询结果数组，1个
* 构造器在没有执行select(),update()这些CRUD链式操作前，都不会去执行sql语句。
* 执行完sql语句之后query构造器会清空链式操作的值。
* 查询方式：原生sql，构造器
* 构造器where条件：表达式，闭包

### sql、error日志单独生成

### 使用模型来对表进行查询

* find、select获取数据。https://www.kancloud.cn/manual/think-orm/1258048
* 模型需要继承Model，默认的类名对应表名，如果自定义，新增table属性
* 新建一个BannerItemModal:
* > php think make:model api@BannerItem
* 模型的使用还是要通过Db层。

### 关联模型查询

* 使用关联模型对banner、banner_item表查询
* 请求：http://192.168.243.3/api/v1/banner/1

### 嵌套关联查询

* banner_item跟image表是一对一关联，可以调用：hasOne或者belongsTo对模型关联。
* 这样的关联属于banner和banner_item之间再嵌套一层image

### 利用框架模型隐藏不必要的字段给客户端

### 利用修改器对查询到的图片URL判断修改

* 新增一个自定义本地服务器的img_prefix配置
* 本例的服务器是：192.168.243.3

### 添加静态图片资源

* 地址：http://192.168.243.3/images/XX.jpg

### 使用模型基类识别所有模型的共性

### 路由自定义版本号

* 代码的迭代遵循：相扩展开发，向修改封闭

### 对theme表信息初步开发接口

* 地址：http://192.168.243.3/api/v1/theme?ids={id1,id2}
* theme表的topic_img（主题栏展示的图片）跟image的一个元组形成1对1，联系属性在theme表。
* theme表的head_img（点击主题图后展示的头图）跟image的一个元组形成1对1，联系属性在theme表。

### 添加theme跟product之间的查询联系接口

* theme在原来两个img的基础上添加跟products的多对多联系
* 地址：http://192.168.243.3/api/v1/theme/{id}
* 开启路由完全匹配
* 添加themeController下的路由分组，避免要把复杂的路由定义在前，简单的路由定义在后的麻烦

### product表的合理数据冗余

* 查询product信息之后经常要用到img_url字段
* 需要查询product信息的数量是不可控的

### 添加最近新品接口

* 地址：http://192.168.243.3/api/v1/product/recent?count={count}
* Postgres数据库order by desc会把null值放前面

### 添加访问所有分类的接口

* 地址：http://192.168.243.3/api/v1/category/all

### 添加根据分类id获取商品信息的接口

* 地址：http://192.168.243.3/api/v1/product/by-category?id={id}
* REST基于资源跟模型，那么选择基于product模型来获取分类下的商品

### 创建用于获取小程序用户登录的openid接口

* common.php：定义全局的方法调用
* 用户向服务器发送code，服务器调用微信登录服务器获取用户对应的openid
* code用post的body的raw方式传输
* json_decode：对JSON格式的字符串进行解码
* empty()：它用于确定变量是否存在，并且变量的值没有评估为false。

### 完善登录令牌的获取

* 从小程序正确获取到openid后，整合wxresult, openid, uid存在redis缓存中

### 编写商品详情接口

* 地址：http://192.168.243.3/api/v1/product/{id}
* 返回商品详细信息以及介绍图片
* 使用闭包在商品信息下的product_img再对其与image表的一对一关系进行处理获取图片URL
* "order"、"user"在postgres里面是关键字

### 用户携带token更新或新增收货地址

* 地址：http://192.168.243.3/api/v1/address (header:"token")
* 客户端携带（头部的token）发送修改或申请的地址
  * 服务器根据校验token并获得uid而非从用户的body中获得（重要）
  * 数据库有uid的情况下，判断是否存在uid对应的userAddress（模型关系），且简单地认为一个用户只有一个收货地址
* 需要过滤掉客户端发来的多余的字段避免更新或插入错误的数据
* 一对一关系，没有属性的一方使用hasOne关联
* 有关联属性（有外键）的一方使用belongsTo关联

### 枚举确定权限作用域，前置中间件做权限校验

### 开发用户下单的接口

* 地址：http://192.168.243.3/api/v1/order
* 继续添加前置中间件，对用户下单的接口只允许带有用户token（符合scope权限的条件下）来访问

### 编写订单的商品校验器

* 检验订单的商品列表和各个的商品信息
* 在列表的校验中又嵌套了各个的商品信息的校验

### 编写下订单流程1

* 根据订单信息（二维）在数据库中查找相应产品信息（一维）
* 数据库的读操作会比写操作慢得多

### 生成订单前实现订单快照的存储

### 编写下订单流程2

* 前置验证权限，验证token，获取uid
* 根据客户端订单信息(product_id, count)查询数据库对应的商品信息
* 遍历数据库对应的商品信息判断下单的商品是否存在，计算对应的商品数量、订单（商品）总价格
* 根据订单status生成快照表
* 在生成快照表的基础上往数据库插入product和order之间多对一的一方，以及它们的联系属性（每个商品的count）
* 需要注意两个数据表的更新操作，如果是比较严谨的业务，应该要加上事务

### 调整数据库连接配置

### 新增根据产品名称获取产品信息的接口

### 新增地址表的获取和删除(Restful API)

### 新增token验证接口

### 迁移到另外的服务器，更新底层
* composer update topthink/framework

### 迁移到MYSQL5.7数据库
* 修正一些错误查询

### 修正用户地址获取
* 注意迁移到新环境中要配置appid,app_secret(config/wx.php)以便wx.login调用
* 还要配置好数据库，缓存（config/cache.php）数据库（config/database.php）
* 这次的commit纯属自己玩

### 修正like查询

### 添加服务端配置文件

### 添加cms端

### 添加cms端配置文件
* 访问地址：ip:port/pages/index.html

### 开发cms登录接口
* 校验
* 接口->service->model检查数据库->service存进缓存

### 服务端全局允许跨域