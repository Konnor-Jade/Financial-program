//index.js
Page({
  data: {
    result:'',
    state:'',
    selectShow: true,//控制下拉列表的显示隐藏，false隐藏、true显示
    selectData: ['上证指数','上证50','商业指数','地产指数','沪深300','中证500','深证成指','中小板指','创业板指','深证创新'],//下拉列表的数据
    index: 0,//选择的下拉列表下标
  },

  onLoad: function () {
    this.setData({
      logs: (wx.getStorageSync('logs') || []).map(log => {
        return util.formatTime(new Date(log))
      })
    })
  },
  formSubmit: function (e) {
    var that = this;
    var trade_date = e.detail.value.id; //获取表单所有name=id的值  
    this.setData({
      trade_date: e.detail.value.id
    });
    var selectData=this.data.selectData
    var index = this.data.index
    wx.request({
      url: 'https://www.finance-data.keytoheart.top/data-name.php',
      data: {
        name:selectData[index] 
      },
      header: { 'Content-Type': 'application/json' },
      success: function (res) {
        console.log(res.data)
        that.setData({
          re: res.data,
        })
        wx.showToast({
          title: '已提交',
          icon: 'success',
          duration: 2000
        })
      }
    })
  },
  // 点击下拉显示框
  selectTap() {
    this.setData({
      selectShow: !this.data.selectShow
    });
  },
  // 点击下拉列表
  optionTap(e) {
    let Index = e.currentTarget.dataset.index;//获取点击的下拉列表的下标
    this.setData({
      index: Index,
      selectShow: !this.data.selectShow
    });
  }
})