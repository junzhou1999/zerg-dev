$(function(){
  var common = window.base;
  InitTable();

  // 初始化表格
  function InitTable() {
    var table = document.querySelector('table');
    table.GM({
      gridManagerName: 'media',
      height: '100%',
      lineHeight: '130px',
      ajaxData: function () {
        return common.g_restUrl+'media/paginate';
      },
      ajaxHeaders: {'token': common.getLocalStorage('token')},
      supportDrag: false,
      supportCheckbox: false,
      supportAjaxPage: true,
      currentPageKey: 'page',
      pageSizeKey: 'size',
      pageSize: 10,
      columnData: [{
        key: 'url',
        text: '缩略图',
        width: '130px',
        align: 'center',
        template: function(pic, rowObject){
          var picNode = document.createElement('a');
          picNode.setAttribute('href', rowObject.url);
          picNode.setAttribute('target', '_blank');
          picNode.style.display = 'block';
          picNode.style.height = '58.5px';

          var imgNode = document.createElement('img');
          imgNode.style.width = '100%';
          imgNode.style.height = '100%',
          imgNode.style.margin = '0 auto';
          imgNode.src = rowObject.url;

          picNode.appendChild(imgNode);
          return picNode;
        }
      }, {
        key: 'from',
        remind: '1：来自本地服务器；2-来自公网',
        text: '来源',
        template: function(action, rowObject){
          if(rowObject.from=='1')  return '本地';
          return '公网';
        }
      },{
        key: 'type',
        text: '文件类型',
        template:function(){
          return '图片';
        }
      }]
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

  $(document).on('click','.new-action', function (){
    console.log("新增元素")
  })
})