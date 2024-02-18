$(function(){
  var common = window.base;
  InitTable();

  // 初始化表格
  function InitTable() {
    var table = document.querySelector('table');
    table.GM({
      gridManagerName: 'order',
      height: '100%',
      ajaxData: function () {
        return common.g_restUrl+'order/paginate';
      },
      ajaxHeaders: {'token': common.getLocalStorage('token')},
      supportDrag: false,
      supportCheckbox: false,
      supportAjaxPage: true,
      currentPageKey: 'page',
      pageSizeKey: 'size',
      isCombSorting: false,  // 排序参数作为传输参数
      columnData: [{
        key: 'order_no',
        text: '订单编号',
      }, {
        key: 'snap_name',
        remind: '订单包含的商品',
        text: '商品名称',
      },{
        key: 'total_count',
        remind: '订单商品数量',
        text: '总数量',
      },{
        key: 'total_price',
        remind: '',
        text: '总价格',
      },{
        key: 'status',
        remind: '1:未支付；2：已支付；3：已发货；4: 已支付，但库存不足',
        text: '订单状态',
        sorting: 'ASC',
        template: function(action, rowObject) {
          var arr=[{
            cName:'unpay',
            txt:'未付款'
          },{
            cName:'payed',
            txt:'已付款'
          },{
            cName:'done',
            txt:'已发货'
          },{
            cName:'unstock',
            txt:'缺货'
          }];
          return '<span class="order-status-txt '+arr[rowObject.status-1].cName+'">'+arr[rowObject.status-1].txt+'</span>'
        }
      }, {
        key: 'create_time',
        text: '下单时间',
        sorting: 'DESC',
        template: function (lastDate, rowObject) {
          return new Date(lastDate).format('YYYY-MM-DD HH:mm:ss');
        },
      }, {
        key: 'action',
        text: '操作',
        // 渲染按钮
        template: function (action, rowObject) {
          var arr=[{
            cName:'payed',
            txt:'发货'
          },{
            cName:'done',
            txt:''
          },{
            cName:'unstock',
            txt:'缺货'
          }];
          var index=0;
          // 渲染已经支付的情况，未支付的不显示
          if (rowObject.status==1)  return '';
          if (rowObject.status==3)  index=1;
          if (rowObject.status==4)  index=2;
          // 已经支付
          return '<span class="action-btn ' + arr[index].cName + '" data-id=' + rowObject.id + '>' + arr[index].txt + '</span>';
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

  // 发货操作
  $(document).on('click','.action-btn.payed',function(){
    // 弹出模态框
    // 显示收获地址
    // 填写物流信息
    var $this=$(this);
    var id = $this.attr('data-id')
    console.log(id)
  })

})