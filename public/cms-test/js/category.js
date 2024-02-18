$(function(){
  var common = window.base;

  InitTable();
  var recordData = [];   // 当前页面表格的数据

  // 初始化表格
  function InitTable() {
    var table = document.querySelector('table');
    table.GM({
      gridManagerName: 'category',
      height: '100%',
      ajaxData: function () {
        return common.g_restUrl+'category/paginate';
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
        key: 'img',
        text: '缩略图',
        width: '130px',
        align: 'center',
        template: function(cell, row){
          var picNode = document.createElement('a');
          picNode.setAttribute('href', row.img.url);
          picNode.setAttribute('target', '_blank');
          picNode.style.display = 'block';
          picNode.style.height = '58.5px';

          var imgNode = document.createElement('img');
          imgNode.style.width = '100%';
          imgNode.style.height = '100%';
          imgNode.style.margin = '0 auto';
          imgNode.src = row.img.url;

          picNode.appendChild(imgNode);
          return picNode;
        }
        }, {
        key: 'name',
        text: '分类名称',
      },{
        key: 'description',
        text: '描述',
        width: '120px'
      },{
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
  $(document).on('click','.action-btn.modify',function(){
    var $this=$(this);
    var id = $this.attr('data-id')

  })

})