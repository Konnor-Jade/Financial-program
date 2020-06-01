//index.js
const app = getApp()
const util=require('../../utils/util.js')
Page({
  data: {
  },
  onLoad: function () {
    this.setData({
      logs: (wx.getStorageSync('logs') || []).map(log => {
        return util.formatTime(new Date(log))
      })
    })
    var time = util.formatTime(new Date());
    // 再通过setData更改Page()里面的data，动态更新页面的数据
    this.setData({
      time: time
    });
  },
  MT:function(){

    var that = this
    var today = this.data.time
    console.log(today);
    wx.request({
      url: `https://www.finance-data.keytoheart.top/data-daliy.php`,//你的后台url地址
      data:{
        day: today
      },
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      method: "GET",
      success(result) {
        console.log(result);
        that.setData({
          demo: result.data
        })
      },
      fail(error) {
        util.showModel('请求失败', error);
        console.log('request fail', error);
      }
    })
  },
})