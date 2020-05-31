//index.js
Page({
  data: {
  },
  onLoad: function () {
    this.setData({
      logs: (wx.getStorageSync('logs') || []).map(log => {
        return util.formatTime(new Date(log))
      })
    })
  },
  MT:function(){
    
    var that = this
    wx.request({
      url: `https://www.finance-data.keytoheart.top/data-daliy.php`,//你的后台url地址
      data:{
        day: '20200424'
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