$(function(){
  var params = {
    url:'user',
    tokenFlag:true,
    sCallback:function(res) {
      InitTable(res);
    }
  };

  // 获取数据
  window.base.getData(params)

  // 初始化表格
  var table = document.querySelector('table');
  function InitTable(data) {
    table.GM({
      gridManagerName: 'admin_user',
      height: '100%',
      ajaxData: data,
      supportDrag: false,
      columnData: [{
        key: 'app_id',
        remind: '管理员名称',
        width: '100px',
        text: '用户名',
        sorting: 'DESC'
      }, {
        key: 'app_description',
        remind: '用户描述',
        text: '描述说明',
        sorting: ''
      }, {
        key: 'update_time',
        remind: 'the lastDate',
        text: '最后修改时间',
        template: function (lastDate, rowObject) {
          return new Date(lastDate).format('YYYY-MM-DD HH:mm:ss');
        }
      }, {
        key: 'action',
        text: '操作',
        // 渲染按钮
        template: function (action, rowObject) {
          return '<span class="action-btn modify" data-id="'+rowObject.id+'">编辑</span><span class="action-btn del" data-id="'+rowObject.id+'">删除</span>'
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

  // 用jquery的点击事件调用
  $(document).on('click','action-btn.modify',function(){
    var $this=$(this);
    var id = $this.attr('data-id')
    console.log(id)
  })

  $(document).on('click','action-btn.del',function(){
    var $this=$(this);
    var id = $this.attr('data-id');
    var params = {
      url:'user',
      type:'delete',
      data:{id:id},
      tokenFlag:true,
      sCallback:function(res) {
        //2出现在首位
        if(res.code.toString().indexOf('2')==0){
          // 查询，重新渲染
          RefreshTable();
          window.alert("操作成功");
        }
      },
      eCallback:function(){
        window.alert("操作失败");
      }
    };
    window.base.getData(params);
  })

  // 查询，渲染
  function RefreshTable(){
    params.sCallback = function (res){
      GM.setAjaxData('admin_user', res)
    }
    window.base.getData(params)
  }

  $(document).on('click','.new-action', function (){
    console.log("新增元素")
  })
})