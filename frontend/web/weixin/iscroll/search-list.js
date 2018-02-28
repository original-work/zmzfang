$(function()
{
  

  $(document).on('touchmove', function(event)
  {
    event.preventDefault();
  })
  .on('MSPointerMove', function(event)
  {
    event.preventDefault();
  })
  .on('ajaxStart', function()
  {
    $ajax.show();
  })
  .on('ajaxStop', function()
  {
    $ajax.hide();
  });
	// ajax 加载状态动画
  var $ajax = $('#ajax');
  var isAndroid = /Android /.test(window.navigator.appVersion);
  var isWechat = /micromessenger/ig.test(window.navigator.userAgent);

  var itemPlaceholderHtml = $('#tmpl-result-item').html();
  var $list = $('#result-list');
  var itemHeight = 250/2;
  var $listItems = $list.children();
  var params = getQueryString();
  var infinitePaddingTop = 0;
  var index = + location.hash.slice(1);
  if (isNaN(index)) {
    index = 0;
  }

  function getQueryString()
  {
    var result = {}, queryString = location.search.slice(1), re = /([^&=]+)=([^&]*)/g, m;

    while (m = re.exec(queryString)) {
      if (m[1] === 'code') {
        continue;
      }
      result[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
    }

    return result;
  }

  

//生成返回地址
  function updateLocation()
  {
    var query = '?' + $.param(params) + '#' + index;
    // console.info('update location', query);
    history.replaceState(null, null, query);
  }

  // 生成占位列表
  var itemCount = Math.ceil($(window).height() / itemHeight) + 1;
  for (var i = 0; i < itemCount; i ++) {
    $(itemPlaceholderHtml).appendTo($list);
  }

  var $imgs = $list.find('img');

  // 初始化 iScroll
  var iScroll = new IScroll('#result-list-wrapper', {
    bindToWrapper          : true,
    bounce                 : true, // 旧设备设为false，拉到边界时的弹性效果
    momentum               : true, // 旧设备设为false，惯性滑动
    probeType              : 3,
    useTransition          : false,
    preventDefaultException: {
      tagName: /^(P|LI|IMG)$/
    },
    //    infiniteElements: '#result-list li',
    dataset                : requestData,
    dataFiller             : updateContent,
    infiniteLimit          : 9999,
    cacheSize              : 20
  });

  function loadImage()
  {
    $imgs.each(function()
    {
      var $this = $(this);
      var src = $this.data('src');
      if (src) {
        // console.log('load image', src);
        // $this.removeData('src');
        $this.attr('src', src);
      }
    });
  }

  var timer;
  var delayLoadImage = function(cancel)
  {
    if (timer) {
      clearTimeout(timer);
      // console.log('load cancel', timer);
      timer = null;
      if (cancel) {
        return;
      }
    }

    timer = setTimeout(loadImage, 300);
    // console.log('load delay', timer);
  };

  function offset2index(y)
  {
    y += infinitePaddingTop;
    var index = Math.max(0, Math.ceil(- y / itemHeight));
    // console.info('calculate index', y, index);
    return index;
  }

  function index2offset(index)
  {
    var y = - index * itemHeight;
    y -= infinitePaddingTop;
    // console.info('calculate offset', index, y);
    return y;
  }

  iScroll.on('scrollStart', function()
  {
    // console.group('scroll event');
    delayLoadImage(true);
  });

  iScroll.on('scrollEnd', function()
  {
    var y = this.y;
    // // console.log('directionY', this.directionY, y, - infinitePaddingTop);
    index = offset2index(y);

    updateLocation();
    delayLoadImage();
    // console.groupEnd('scroll event');
  });

  iScroll.disable();

  function isBadXiaoMi()
  {
    var ua = navigator.userAgent;
    // console.log('bad xiao mi', /Android 4\.1/.test(ua), /\bMI [123]\D/.test(ua));
    return /Android 4\.1/.test(ua) && /\bMI [123]\D/.test(ua);
  }

  function ready()
  {
    // console.log('ready', index);
    iScroll.disable();
    iScroll.scrollTo(0, (index ? 0 : infinitePaddingTop) + index2offset(index));
    iScroll.options.infinitePaddingTop = infinitePaddingTop;
    if (isAndroid) {
      iScroll.options.infiniteUseTransform = false;
    }
    iScroll.options.infiniteElements = '#result-list li';
    iScroll._initInfinite();
    iScroll.refresh();
    iScroll._execEvent('refresh');
    iScroll.enable();
    // $list.hide();
  }

  

  function requestData(start, count)
  {
    var data={}
    data.start = start;
    var url = 'http://www.zmzfang.com/?r=search/searcht&requirementCount=20';
    $.getJSON(url, data,function(json) {
      iScroll.updateCache(start, json);
      var done = function()
      {
        iScroll.reorderInfinite();
        iScroll._execEvent('scrollEnd'); // 触发加载图片
      };

      if (isAndroid) {
        // console.info('in android');
        setTimeout(done, 100);
      } else {
        done();
      }
    });
  }

  function updateContent(el, data)
  {
    var $el = $(el);
    // console.log('update', arguments);
    // $el.toggle(data);
    if (! data) {
      return;
    }
    $el.attr('data-id', data.requirementid);
    $el.find('.requirement-subject').html(data.subject);
    $el.find('.nickname').html(data.nickname);
    $el.find('.description').html(data.detail);
    $el.find('.circle-img').attr('src', './img/favicon.ico').attr('data-src', data.picture);
  }

  // 点击事件
  $list.on('tap', 'li', function()
  {
    location.href = '/house/' + $(this).attr('data-id') + '/';
  });
  setTimeout(ready, isAndroid ? 100 : 0);

});