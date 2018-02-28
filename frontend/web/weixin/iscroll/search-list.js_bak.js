$(function()
{
  var startx,endx,starty,endy;
  var startxs,endxs,startys,endys;
  FastClick.attach(document.body);

  // ajax 加载状态动画
  var $ajax = $('#ajax');

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

  var isAndroid = /Android /.test(window.navigator.appVersion);
  var isWechat = /micromessenger/ig.test(window.navigator.userAgent);
  var infinitePaddingTop = 115;
  // if(cur_city == 'sz'){
  //   infinitePaddingTop = 146;
  // }
  // if(!isWechat){
  //   infinitePaddingTop = 145;
  // }
  var itemPlaceholderHtml = $('#tmpl-result-item').html();
  var $list = $('#result-list');
  var itemHeight = 194/2;
  var itemPerPage = 15;

  var $pager = $('#pager');
  var $page = $pager.find('.page');
  var $totalPage = $pager.find('.total');

  // 初始化搜索数据
  var index = + location.hash.slice(1);
  var page = 1;
  var maxPage = 0;
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

  var params = getQueryString();
  // console.info('location', params, index);

  function updateLocation()
  {
    var query = '?' + $.param(params) + '#' + index;
    // console.info('update location', query);
    history.replaceState(null, null, query);
  }

  // 生成占位列表
  $list.empty();

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

  function updateParams(field, path)
  {
    if (field === 'key') {
      value = path;
    } else {
      var data = getDataByPath(path),//根据路径获取当前更新数据
      value,
      name;
      if (data.length) {
        params[data[1].field] = data[1].data;
        value = data[0].data;
        name = data[1].name
      } else {
        params['bid'] = '';
        value = data.data;
        name = data.name
      }
    }
    console.log('change param', field, value);
    params[field] = value;
    index = 0;
    if (parseInt(path.split('-')[0]) === 4) {

    } else {
      iScroll.disable();
      iScroll.reload();
      iScroll.scrollTo(0, 0);
      iScroll.enable();
      updateLocation();
      filterP.removeClass('half');
      $search.addClass('collapsed');
      //将已选项名称更新到菜单
      if (name) {
        category.find('.selected').html(name);
        /*       if (name.length > 4) {
         category.css('fontSize', '16px');
         }*/
      }
      category.find('.selected').removeClass('selected');
    }
    //修改已选项路径
    selectPath[field] = path;
  }

  //根据路径获取数据
  function getDataByPath(path)
  {
    var data = filterData, isMulti = false, isAres = false, tmp;
    path = path.split('-');
    for (var i = 0; i < path.length; i ++) {
      if (i === 0) {//一级为菜单
        data = data[parseInt(path[i])];
        if (parseInt(path[i]) === 4) {
          isMulti = true;
        }
        if (parseInt(path[i]) === 0) {
          isAres = true;
        }
      } else if (path[i] === '') {//如果选择不限
        if (i === 1 || isMulti) {//如果选择的是2级菜单中的不限，则清空数据
          data = {
            name: data.name,
            data: ''
          }
        }
      } else {
        if (isAres && i === 2) {
          tmp = [
            {
              field: 'did',
              data : data.data,
              name : data.name
            }, {
              field: 'bid',
              data : data.child[parseInt(path[i])].data,
              name : data.child[parseInt(path[i])].name
            }
          ];
          data = tmp;
        } else {
          data = data.child[parseInt(path[i])];
        }
      }
    }
    return data
  }

  var form = $("#form-filters"),//过滤面板
  category = form.find('.category ul'),//类别
  filterP = form.find('.filter-detail'),//过滤详细项
  firstF = form.find('.first-filter'),
  firstFUl = firstF.find('ul'),
  secondF = form.find('.second-filter'),
  secondFUl = secondF.find('ul'),
  paddingTop = false,
  selectPath,
  filterData;
  var scrollDom = $('.filter-detail');
  var firstS = new IScroll('#first_filter', {
    bindToWrapper          : true,
    bounce                 : true, // 旧设备设为false，拉到边界时的弹性效果
    momentum               : true, // 旧设备设为false，惯性滑动
    useTransition          : false,
    preventDefaultException: {
      tagName: /^(P|LI|IMG)$/
    }
  });
  var secondS = new IScroll('#second_filter', {
    bindToWrapper          : true,
    bounce                 : true, // 旧设备设为false，拉到边界时的弹性效果
    momentum               : true, // 旧设备设为false，惯性滑动
    useTransition          : false,
    preventDefaultException: {
      tagName: /^(P|LI|IMG)$/
    }
  });

  //初始化筛选分类
  function filterInit(data)
  {
    var params = {};
    filterData = data;
    selectPath = getSelectPath(data);
    if (data && data.length >= 5) {
      category.html(buildList(data));
      initCategoryMenuName();

    } else {
      form.hide();
    }
  }

  function initCategoryMenuName()
  {
    var data, path, tmp;
    for (var i = 0; i < filterData.length; i ++) {
      data = filterData[i];
      if (selectPath[data.data]) {
        tmp = filterData;
        path = selectPath[data.data].split('-');
        for (var j = 0; j < path.length; j ++) {
          if (j === 0) {
            tmp = tmp[parseInt(path[j])];
          } else {
            tmp = tmp.child[parseInt(path[j])];
          }
        }
        category.find('li').eq(i).html(tmp.name);
        /*  if (tmp.name.length > 4) {
         category.css('fontSize', '16px');
         }*/
      }
    }
  }

  //筛选项点击事件
  function filterClick(e)
  {
    e.stopPropagation();
    e.preventDefault();
    endx = e.originalEvent.changedTouches[0].clientX;
    endy = e.originalEvent.changedTouches[0].clientY;
    if(!(Math.abs(endx - startx) < 30 && Math.abs(endy - starty) <30)){
      return;
    }
    var cIndex = category.data('value'),
    curData = filterData[cIndex],
    field = curData.data;
    //更多
    if (curData.type === 'multi') {
      var selectDom = $(e.target), path;
      if (e.target.tagName === 'A') {
        selectDom.parent().find('.selected').removeClass('selected');
        selectDom.addClass('selected');
        path = selectDom.data('path');
        field = curData.child[parseInt(path.split('-')[1])].data;
        updateParams(field, selectDom.data('path'));
      } else if (e.target.tagName == 'BUTTON') {
        iScroll.disable();
        iScroll.reload();
        iScroll.scrollTo(0, 0);
        iScroll.enable();
        updateLocation();
        filterP.removeClass('half');
        $search.addClass('collapsed');
        category.find('.selected').removeClass('selected');
      }
    } else {//区域金额等
      path = $(this).data('path').toString().split('-');
      var parentDom = $(this).parent().parent().parent(),
      fIndex = parseInt(path[path.length - 1]),
      selData = curData;
      for (var i = 1; i < path.length; i ++) {
        if (path[i] && path[i] !== '') {
          selData = selData.child[path[i]];
        }
      }
      $(this).parent().find('.selected').removeClass('selected');
      $(this).addClass('selected');
      if (parentDom.hasClass('first-filter')) {
        if (! isNaN(fIndex) && curData.child[fIndex].child) {
          secondFUl.html(buildList(selData.child, {
            path   : path.join('-'),
            field  : filterData[cIndex].data,
            showAny: true
          }));
          filterP.addClass('half');
          secondS.refresh();
        } else {
          updateParams(field, path.join('-'));
        }

      } else {
        updateParams(field, path.join('-'));
      }
    }
  }

  //分类点击事件
  function categoryClick()
  {
    if (! $(this).hasClass('selected')) {
      var path = $(this).data('path').toString().split('-'),
      index = parseInt(path[path.length - 1]),
      shawAny = false;
      if (! paddingTop) {
        paddingTop = $search.height();
      }
      if (! filterData[index].type) {
        shawAny = true;
      }
      filterP.removeClass('half');
      firstFUl.html(buildList(filterData[index].child, {
        path   : path.join('-'),
        field  : filterData[index].data,
        showAny: shawAny,
        type   : filterData[index].type
      }));
      $(this).parent().find('.selected').removeClass('selected');
      $(this).addClass('selected');
      category.data('value', index);
      $search.removeClass('collapsed');
      scrollDom.css("height", ($search.height() - paddingTop) + 'px');
      firstS.refresh();
      secondS.refresh();
    } else {
      $search.addClass('collapsed');
      category.find('.selected').removeClass('selected');
    }
  }

  //渲染列表
  function buildList(datas, config)
  {
    var html = [], data, selectClass = '', path = '', thisPath, multiData = [], tmp = [], field;
    //判断是否有配置项（类别项无配置项）
    if (config) {
      if (config.path) {
        path = config.path + '-';
      }
    }
    for (var i = 0; i < datas.length; i ++) {
      data = datas[i];
      thisPath = path + i;
      selectClass = '';
      if (config && config.type && config.type === 'multi') {
        field = data.data;
        tmp = [];
        for (var j = 0; j < data.child.length; j ++) {
          selectClass = '';
          if (field && selectPath[field] && selectPath[field].search([thisPath, '-', j].join('')) === 0) {
            selectClass = 'selected';
          }
          if (j === 0) {
            tmp.push(['<a data-path="', thisPath, '-">不限</a>'].join(''));
          }
          tmp.push([
            '<a class="', selectClass, '" data-path="', thisPath, '-', j, '">', data.child[j].name, '</a>'
          ].join(''));
        }
        html.push(['<li class="multi">', '<span>', data.name, ':</span>', tmp.join(''), '</li>'].join(''));
        if (i === datas.length - 1) {
          html.push(['<li class="multi btn"><button>确定</button></li>'])
        }
      } else {
        //判断是否为已选项
        if (config && selectPath[config.field] && selectPath[config.field].search(thisPath) === 0) {
          selectClass = 'selected';
          //如果已选项有子集则渲染出来
          if (data.child) {
            secondFUl.html(buildList(data.child, {
              path   : thisPath,
              field  : filterData[parseInt(path.split('-')[0])].data,
              showAny: true
            }));
            filterP.addClass('half');
          }
        }
        //判断是否显示不限选项（当前只有更多分类无不限选项）
        if (config && config.showAny && i === 0) {
          html.push(['<li data-path="', path, '">', '不限', '</li>'].join(''))
        }
        html.push(['<li class="', selectClass, '" data-path="', path, i, '">', data.name, '</li>'].join(''))
      }

    }
    return html.join('');
  }

  //获取已选项路径
  function getSelectPath(datas)
  {
    var data, path = {}, cPath = '';
    for (var i = 0; i < datas.length; i ++) {
      data = datas[i];
      if (data.type === 'multi') {
        for (var j = 0; j < data.child.length; j ++) {
          if (! data.child[j].type && params[data.child[j].data] && params[data.child[j].data] !== '') {
            path[data.child[j].data] = i + '-' + j + '-' + getChildPath(data.child[j].child,
            params[data.child[j].data]);
          }
        }
      } else if (! data.type && params[data.data] && params[data.data] !== '') {
        cPath = getChildPath(data.child, params[data.data]);
        path[data.data] = i + '-' + cPath;
        if (data.data == 'did' && params['bid'] && params['bid'] !== '') {
          path[data.data] = path[data.data] + '-' + getChildPath(data.child[parseInt(cPath)].child, params['bid']);
        }
      }
    }
    return path;
  }

  function getChildPath(datas, value)
  {
    var data, path = false, tmp;
    for (var i = 0; i < datas.length; i ++) {
      data = datas[i];
      if (data.data.toString() === value.toString()) {
        path = i;
        break;
      } else if (data.child) {
        tmp = getChildPath(data.child, value);
        if (tmp !== false) {
          path = i + '-' + tmp;
          break;
        }
      }
    }
    return path;
  }

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
    // console.log('directionY', this.directionY, y, - infinitePaddingTop);
    if (this.directionY < 0 || y === 0) {
      $search.show();
    } else if (y < - infinitePaddingTop && maxPage) {
      $search.hide();
    }
    index = offset2index(y);

    var lastVisiableIndex = index + itemCount - 1;
    page = Math.ceil(lastVisiableIndex / itemPerPage);
    // console.log('page', page, lastVisiableIndex, itemPerPage, index);
    $page.html(page);
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
    $list.hide();
  }

  var lastQuery;
  var lastTotal = 0;
  var $listItems = $list.children();

  function requestData(start, count)
  {
    //console.log('request data', start, start + count);
    var data = $.extend({}, params);
    data.start = start;
    var query = $.param(data);
    if (lastQuery === query) {
      return;
    }
    lastQuery = query;
    var url = '/search/json';
    if (window.cur_city) {
      url = '/' + cur_city + url;
    }
    $.getJSON(url, data,function(json) {
      //console.log(json);
      var total = json.total_found;
      if (total !== lastTotal) {
        lastTotal = total;
        if (total) {
          $list.show();
          if (total < itemCount) {
            //console.log('hide some item');
            $listItems.slice(0, total).show();
            $listItems.slice(total).hide();
          } else {
            //console.log('show item');
            $listItems.show();
          }
        } else {
          //console.log('hide list');
          $list.hide();
        }
      }
      iScroll.updateCache(start, json.matches || [], total);

      var done = function()
      {
        maxPage = Math.ceil(total / itemPerPage);
        $totalPage.html(maxPage);
        //        iScroll.refresh();
        iScroll.reorderInfinite();
        iScroll._execEvent('scrollEnd'); // 触发加载图片

        if (! total) {
          alert('没有合适的房源，请修改搜索条件。');
        }
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
    var $el = $(el),tags=[];
    // console.log('update', arguments);
    $el.toggle(data);
    if (! data) {
      return;
    }
    $el.data('id', data.id);
    $el.find('.text').html(data.name);
    $el.find('.price').html(data.price/10000+'万');
    $el.find('.brief').html(data.rooms+'室'+data.halls+'厅'+data.washrooms+'卫');
    $el.find('.description').html(data.des);


    if(data.v){
      tags.push('<span>精品</span>')
    }
    /*if(data.xer){
     tags.push('<span>小二服务</span>')
     }*/
    if(data.vr){
      tags.push('<span>全景</span>')
    }
    if(data.agent_code){
      tags.push('<span>委托</span>')
    }
    if(data.is_prospect){
      tags.push('<span>实勘</span>')
    }
    $el.find('.tags').html(tags.join(''));

    var img = '/a/mobile/img/default-new.png';
    if (data.cover) {
      img = data.cover;
    }
    if(data.sell_status == 1){
      $el.find('.price').html(data.deal.price/10000+'万');
      $el.find('.brief').html(data.brief.replace(/\d+㎡/,data.deal.area+'㎡'));
      // $el.find('.text').html(data.name+'<span class="sold">已售出</span>');
      $el.find('.tags').html('')
      $el.find('.sell-mask').addClass('show')
    }else{
      $el.find('.sell-mask').removeClass('show')
    }
    $el.find('.thumb').attr('src', '/a/mobile/img/default-new.png').data('src', img);
  }

  // ui交互
  $list.on('click', 'li', function()
  {
    location.href = '/' + cur_city + '/house/' + $(this).data('id') + '/';
  });
  var $search = $('#search');

  var $keyword = $('#keyword');
  /*  var $keyword = $('#keyword').focus(function()
   {
   $search.removeClass('collapsed');
   });*/
  if (params.key) {
    $keyword.val(params.key);
  }
  $keyword.on('change',function () {
    // console.log($keyword.val());
  });
  $('#form-keyword').on('submit', function(e)
  {
    e.preventDefault();
    updateParams('key', $keyword.val());
    $search.addClass('collapsed');
  });

  category.on('touchstart', 'li', categoryClick);
  filterP.on('touchstart', 'li', function (e) {
    startx = e.originalEvent.changedTouches[0].clientX;
    starty = e.originalEvent.changedTouches[0].clientY;
  });
  filterP.on('touchend', 'li', filterClick);

  // 快速翻页
  var $pagination = $('#pagination');
  var $paginationItems = $pagination.find('li');

  $pager.on('click', function()
  {
    if (maxPage) {
      $pagination.triggerHandler('show');
    }
  });
  $pagination.on('show', function()
  {
    $paginationItems.each(function(i)
    {
      if (i < maxPage) {
        // console.log('show', i, this);
        $(this).show();
        return;
      }
      $(this).hide();
      // console.log('hide', i, this);
    });
    $pagination.show();
    var pageScroll = new IScroll('#page-list-wrapper', {
      bindToWrapper        : true,
      moveThreshold        : 1,
      bounce               : true, // 旧设备设为false，拉到边界时的弹性效果
      momentum             : true, // 旧设备设为false，惯性滑动
      infiniteElements     : '#page-list-wrapper li',
      dataset              : function(start, count)
      {
        var data = [];
        count = Math.min(count, maxPage - start);
        for (var i = 0; i < count; i ++) {
          data[i] = start + i + 1;
        }
        // console.info('data', start, count);
        var self = this;
        setTimeout(function()
        {
          // console.log('data done', start, count);
          self.updateCache(start, data);
          self.reorderInfinite()
        })
      },
      dataFiller           : function(el, data)
      {
        if (data) {
          var $el = $(el);
          // console.log(arguments);
          $el.html('第' + data + '页').show();
        }
      },
      infiniteLimit        : maxPage,
      infinitePaddingTop   : 112,
      infinitePaddingBottom: 120,
      snap                 : true,
      snapStepY            : 40,
      cacheSize            : 100
    });

    $pagination.data('scroll', pageScroll);
    pageScroll.goToPage(0, page - 1, 0);

  }).on('hide', function()
  {
    $pagination.hide();
    $pagination.data('scroll').destroy();
  }).on('click', '.enter', function()
  {
    var snap = $pagination.data('scroll').snap;
    if (snap) {
      page = 1 - snap.pageY;
    }
    // console.log(snap, page);
    iScroll.scrollTo(0, itemPerPage * itemHeight * (1 - page));
    iScroll._execEvent('scrollEnd');
    $pagination.triggerHandler('hide');
  }).on('click', '.cancel', function()
  {
    $pagination.triggerHandler('hide');
  });

  setTimeout(ready, isAndroid ? 100 : 0);
  filterInit(window.filter_config);
  $(document).on('touchstart',function () {
    $('.swiper-container').hide();
  });
  $('#keyword').autocompleter({
    source:"/"+currentCity+"/ajax/getCommunity",
    highlightMatches:true,
    ajaxType:'post',
    empty:false,
    delay:300,
    offset:'data',
    cacheExpires: 1800,
    customLabel:'name',
    template:'<a title="{{ name }} - {{ address }}"><i>{{ label }}</i> <em>{{ address }}</em> </a>',
    customValue:'name',
    callback: function (value, index) {
      // console.log(value);
    }
  });
  var closeIcoDom = $('.closeIco');
  $('.searchIco').on('touchstart',function (e) {
    e.stopPropagation();
    e.preventDefault();
    var key = $('#keyword').val();
    if(key.length == 0){
      alert('请输入小区关键词');
      return;
    }
    updateParams('key', key);
    var keywordDom = $('#keyword')
    keywordDom.blur();
    $('.swiper-container').hide();
    closeIcoDom.show();
  });
  if(params['key'] && params['key'].length>0 ){
    closeIcoDom.show()
  }
  closeIcoDom.on('touchstart',function (e) {
    e.stopPropagation();
    e.preventDefault();
    updateParams('key', '');
    var keywordDom = $('#keyword');
    keywordDom.val('');
    keywordDom.blur();
    $('.swiper-container').hide();
    closeIcoDom.hide();
  });
  var clickAuto = false;
  $('.swiper-wrapper').on('touchstart','li',function (e) {
    e.stopPropagation();
    e.preventDefault();
    startxs = e.originalEvent.changedTouches[0].clientX;
    startys = e.originalEvent.changedTouches[0].clientY;
  });
  $('.swiper-wrapper').on('touchend','li',function (e) {
    e.stopPropagation();
    e.preventDefault();
    endxs = e.originalEvent.changedTouches[0].clientX;
    endys = e.originalEvent.changedTouches[0].clientY;
    if(!(Math.abs(endxs - startxs) < 30 && Math.abs(endys - startys) <30)){
      return;
    }
    var _this = $(this);
    var name = _this.attr('data-label'),keywordDom = $('#keyword'),val;
    keywordDom.val(name);
    if (params.key) {
      val = params.key;
    }
    val = name;
    lastTotal = 0;
    updateParams('key', val);
    keywordDom.blur();
    $('.swiper-container').hide();
    closeIcoDom.show();
  })
});