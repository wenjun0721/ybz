// pages/news/news.js
Page({
  /**
   * 页面的初始数据
   */
  data: {
    newlist: [{
      url: 1,
      img: "../../../upload/goods/good1.png",
      title: "案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1",
      time: "2019-1-1"
    },
    {
      url: 1,
      img: "../../../upload/goods/good3.png",
      title: "案例2",
      time: "2019-1-1"
    }]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    wx.setNavigationBarTitle({
      title: '防水咨询'
    })
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {

  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {

  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {

  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {

  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  }
})