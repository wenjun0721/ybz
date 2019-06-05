const app = getApp().globalData;
// pages/index/index.js
Page({
  data: {
    bannerLists:[{
      adId:1,
      adFile:"../../upload/banner/timg.jpg",
      adTypeStr:"String",
      adURLType:"String",
      adURL:"#",
    },
    {
        adId: 2,
        adFile: "../../upload/banner/timg.jpg",
        adTypeStr: "String",
        adURLType: "String",
        adURL: "#",
      }],
    bannerLists2: [{
      adId: 1,
      adFile: "../../upload/banner/timg.jpg",
      adTypeStr: "String",
      adURLType: "String",
      adURL: "#",
    },
    {
      adId: 2,
      adFile: "../../upload/banner/timg.jpg",
      adTypeStr: "String",
      adURLType: "String",
      adURL: "#",
    }],
    caselist:[{
      url:1,
      img:"../../upload/goods/good1.png",
      title:"案例1"
    }, 
    {
      url: 2,
      img: "../../upload/goods/good2.png",
      title: "案例2"
    }],
    newlist:[{
        url: 1,
        img: "../../upload/goods/good1.png",
      title: "案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1案例1",
        time:"2019-1-1"
      },
      {
        url: 1,
        img: "../../upload/goods/good3.png",
        title: "案例2",
        time: "2019-1-1"
      }]
  },

  // onLoad: function (options) {//页面开始加载
  //   this.getbanner();
  //   this.getgoods();
  // },
  // onReachBottom: function () {
  //   this.getgoods(true)//true:加载下一页goods
  // },
  //首页获取产品
  getgoods(page = false) {
    let that = this;
    app.util.request(app.api.indexgetgoods, 'POST', this.data.goodspage).then((res) => {//获取goods
      console.log(res.data.length);
      if (res.status && res.status == 1) {
        let goods = [];
        if (!page) {
          goods = res.data
        } else {
          //当滚到到底部添加goods
          goods = that.data.goodslist.concat(res.data);//concat:复制整个数组到前面的数组
        }
        that.setData({
          goodslist: goods,
        })
      } else {
        wx.showToast({
          title: res.msg,
          icon: 'none',
          duration: 2000
        })
        that.setData({
          sharerList: [],
        })
      }
    }).catch((error) => {
      console.log(error)
    })
  },
  //获取广告
  getbanner() {
    let that = this;
    app.util.request(app.api.indexgetbanner, 'POST').then((res) => {//获取banner
      if (res.status && res.status == 1) {
        that.setData({
          bannerLists: res.data,
        })
      } else {
        wx.showToast({
          title: res.msg,
          icon: 'none',
          duration: 2000
        })
        that.setData({
          sharerList: [],
        })
      }
    }).catch((error) => {
      console.log(error)
    })
  },
  /* 
   *  跳转到我的消息页面
   */
  
  morecase: function (e) {
    wx.navigateTo({
      url: 'case/case'
    })
  },
  morenews: function (e) {
    wx.navigateTo({
      url: 'news/news'
    })
  },
  Tomap:function(e){
    wx.navigateTo({
      url: 'map/map'
    })
  }

})