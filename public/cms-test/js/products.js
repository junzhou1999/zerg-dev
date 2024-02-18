$(function(){
  var common = window.base;

  InitTable();
  var modal = new bootstrap.Modal(document.getElementById('myModal'));
  var recordData = [];   // 当前页面表格的数据

  // 初始化表格
  function InitTable() {
    var table = document.querySelector('table');
    table.GM({
      gridManagerName: 'product',
      height: '100%',
      ajaxData: function () {
        return common.g_restUrl+'product/paginate';
      },
      ajaxHeaders: {'token': common.getLocalStorage('token')},
      supportDrag: false,
      supportCheckbox: false,
      supportAjaxPage: true,
      currentPageKey: 'page',
      pageSizeKey: 'size',
      pageSize: 10,
      columnData: [{
        key: 'id',
        isShow: false,
        template: function(cell, row) {
          recordData.push(row);   // 渲染当前页面的表格就记录好数据
        }
        }, {
        key: 'main_img_url',
        text: '缩略图',
        width: '130px',
        align: 'center',
        template: function(pic, rowObject){
          var picNode = document.createElement('a');
          picNode.setAttribute('href', rowObject.main_img_url);
          picNode.setAttribute('target', '_blank');
          picNode.style.display = 'block';
          picNode.style.height = '58.5px';

          var imgNode = document.createElement('img');
          imgNode.style.width = '100%';
          imgNode.style.height = '100%';
          imgNode.style.margin = '0 auto';
          imgNode.src = rowObject.main_img_url;

          picNode.appendChild(imgNode);
          return picNode;
        }
        }, {
        key: 'name',
        text: '商品名称',
      },{
        key: 'price',
        text: '价格（单价）',
        width: '120px'
      },{
        key: 'stock',
        text: '库存量',
        width: '120px'
      }, {
        key: 'category',
        text: '所属分类',
        template:function (action, rowObject){
          return rowObject.category.name;
        }
      },{
        key: 'property',
        text: '商品属性',
        template:function (cell, row){
          return '<span class="property-btn enter" data-id="'+row.id+'">查看</span>'
        }
      },{
        key: 'create_time',
        text: '创建时间',
        sorting: 'DESC',
        template: function (lastDate, rowObject) {
          return new Date(lastDate).format('YYYY-MM-DD HH:mm:ss');
        },
      }, {
        key: 'action',
        text: '操作',
        // 渲染按钮
        template: function (action, rowObject) {
          return '<span class="action-btn modify" data-id="'+rowObject.id+'">编辑</span><span class="action-btn del" data-id="'+rowObject.id+'">删除</span>'
        }
      },],
      pagingBefore: function(){
        recordData = [];   // 渲染数据前清空记录数据
      },
    });
  }

  // 日期格式化,不是插件的代码,只用于处理时间格式化
  Date.prototype.format = function(fmt){
    var o = {
      "M+": this.getMonth() + 1, //月份
      "D+": this.getDate(), //日
      "d+": this.getDate(), //日
      "H+": this.getHours(), //小时
      "h+": this.getHours(), //小时
      "m+": this.getMinutes(), //分
      "s+": this.getSeconds(), //秒
      "q+": Math.floor((this.getMonth() + 3) / 3), //季度
      "S": this.getMilliseconds() //毫秒
    };
    if (/([Y,y]+)/.test(fmt)){
      fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    }
    for (var k in o){
      if(new RegExp("(" + k + ")").test(fmt)){
        fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
      }
    }
    return fmt;
  }

  // 查看商品属性
  $(document).on('click','.property-btn.enter',function(){
    var $this=$(this);
    var id = $this.attr('data-id')

    console.log(recordData);
    // 获取对象

    var modalTitle = document.querySelector('.modal-title');

    // 设置变量，js不能像php那样的kv数组
    modalTitle.textContent = recordData.find(item => item.id == id).name+' 的属性';
    modal.show();
  })

})