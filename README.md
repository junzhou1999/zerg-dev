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
