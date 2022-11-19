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
