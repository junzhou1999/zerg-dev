$(function(){
  var params = {
    url:'/user',
    // data:{},
    tokenFlag:true,
    sCallback:function(res) {
      $('table').GM({
        gridManagerName: 'admin_user',
        height: '100%',

        ajaxData : res,
        columnData: [{
          key: 'app_id',
          remind: '管理员名称',
          width: '100px',
          text: '用户名',
          sorting: 'DESC'
        },{
          key: 'app_description',
          remind: '用户描述',
          text: '描述说明',
          sorting: ''
        },{
          key: 'update_time',
          remind: 'the lastDate',
          text: '最后修改时间',
          template: function(lastDate, rowObject){
            return new Date(lastDate).format('YYYY-MM-DD HH:mm:ss');
          }
        }]
      });
    }
  };
  window.base.getData(params),


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
})