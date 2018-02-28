			var dom=
				'<div class="search">'
					+'<span id="search" class="mui-icon mui-icon-search" style="position: absolute;left: 12px;top:5px;"></span>'
					+'<div id="segmentedControl" class="mui-segmented-control mui-segmented-control-inverted">'
						+'<a id="gcLink" class="mui-control-item">'
							+'广场'
						+'</a>'
						+'<a id="anonymousLink" class="mui-control-item">'
							+'小道'
						+'</a>'
						+'<a id="dynamicLink" class="mui-control-item">'
							+'转介'
						+'</a>'
					+'</div>'
					+'<span id="publish" class="mui-icon mui-icon-plus" style="position: absolute;right: 12px;top:5px;"></span>'
				+'</div>'
				+'<div id="searchContent" class="content mui-table-view">'
					+'<p class="mui-text-center" style="margin-bottom: 0px;">在这里可以搜到</p>'
					+'<ul class="mui-table-view mui-grid-view mui-grid-9">'
						+'<li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3">'
							+'<a id="searchAgentLink">'
								+'<svg  class="icon" aria-hidden="true" style="color:#d6da3d;font-size:32px"><use xlink:href="#icon-mine"></use></svg>'
								+'<div class="mui-media-body">找人</div>'
							+'</a>'
						+'</li>'
						
						+'<li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3">'
							+'<a id="searchRequirementLink">'
								+'<svg  class="icon" aria-hidden="true" style="color:#95c14f;font-size:32px"><use xlink:href="#icon-house-search"></use></svg>'
								+'<div class="mui-media-body">需求</div>'
							+'</a>'
						+'</li>'
						
						+'<li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3 mui-hidden">'
							+'<a id="searchTopicLink">'
								+'<span class="mui-icon mui-icon-chatbubble"></span>'
								+'<div class="mui-media-body">话题</div>'
							+'</a>'
						+'</li>'
						
						+'<li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3 mui-hidden">'
							+'<a id="searchAnonymousLink">'
								+'<span class="mui-icon mui-icon-location"></span>'
								+'<div class="mui-media-body">匿名动态</div>'
							+'</a>'
						+'</li>'
						
						+'<li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3 mui-hidden">'
							+'<a id="searchRecruitLink">'
								+'<span class="mui-icon mui-icon-search"></span>'
								+'<div class="mui-media-body">职位</div>'
							+'</a>'
						+'</li>'
						
						+'<li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3 mui-hidden">'
							+'<a id="searchEventsLink">'
								+'<span class="mui-icon mui-icon-phone"></span>'
								+'<div class="mui-media-body">活动</div>'
							+'</a>'
						+'</li>'
					+'</ul> '
				+'</div>'
				
				+'<div id="publishContent" class="content mui-table-view">'
					+'<ul class="mui-table-view mui-grid-view mui-grid-9">'
						+'<li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3">'
							+'<a id="publishAnonymousLink">'
								+'<svg  class="icon" aria-hidden="true" style="color:#eca414;font-size:32px"><use xlink:href="#icon-anonymous"></use></svg>'
								+'<div class="mui-media-body">匿名发布</div>'
							+'</a>'
						+'</li>'
						
						+'<li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3">'
							+'<a id="publishHelpLink">'
								+'<svg  class="icon" aria-hidden="true" style="color:#19b953;font-size:32px"><use xlink:href="#icon-forhelp"></use></svg>'
								+'<div class="mui-media-body">求助发布</div>'
							+'</a>'
						+'</li>'
						
						+'<li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3">'
							+'<a id="publishRequirementLink">'
								+'<svg  class="icon" aria-hidden="true" style="color:#d6da3d;font-size:32px"><use xlink:href="#icon-house-sale"></use></svg>'
								+'<div class="mui-media-body">购房需求</div>'
							+'</a>'
						+'</li>'
						
						+'<li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3">'
							+'<a id="publishRentRequirementLink">'
								+'<svg  class="icon" aria-hidden="true" style="color:#f7b04d;font-size:32px"><use xlink:href="#icon-house-rent"></use></svg>'
								+'<div class="mui-media-body">租房需求</div>'
							+'</a>'
						+'</li>'
						
						+'<li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3">'
							+'<a id="publishHouseLink">'
								+'<svg  class="icon" aria-hidden="true" style="color:#95c14f;font-size:32px"><use xlink:href="#icon-edit"></use></svg>'
								+'<div class="mui-media-body">房源发布</div>'
							+'</a>'
						+'</li>'
						
						+'<li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3">'
							+'<a id="publishRecruitLink">'
								+'<svg  class="icon" aria-hidden="true" style="color:#f7b04d;font-size:32px"><use xlink:href="#icon-position"></use></svg>'
								+'<div class="mui-media-body">招聘发布</div>'
							+'</a>'
						+'</li>'
						
						+'<li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3">'
							+'<a id="publishActivityLink">'
								+'<svg  class="icon" aria-hidden="true" style="color:#d6da3d;font-size:32px"><use xlink:href="#icon-huodong"></use></svg>'
								+'<div class="mui-media-body">活动发布</div>'
							+'</a>'
						+'</li>'
						
						+'<li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3">'
							+'<a id="publishYdHouseLink">'
								+'<svg  class="icon" aria-hidden="true" style="color:#95c14f;font-size:32px"><use xlink:href="#icon-yidi"></use></svg>'
								+'<div class="mui-media-body">转介需求</div>'
							+'</a>'
						+'</li>'
					+'</ul> '
				+'</div>';
			$('.mui-content').prepend(dom);
			if(isTopic()){
				$('#anonymousLink').addClass('mui-active');
			}else{
				if(isGc())
				{
					$('#gcLink').addClass('mui-active');
				}
				else
				{
					$('#dynamicLink').addClass('mui-active');
				}
				
				$('#publishAnonymousLink').parent().hide();
			}
			function initLinkEvent()
			{
				
				var dstUrl = '';
				document.querySelector('#dynamicLink').addEventListener('tap', function() {
					dstUrl = '../HomePage/zj_index.html';
					mui.openWindow({
						url:dstUrl,
						id:'DynamicIndex'
					})
				}, false);
				
				document.querySelector('#anonymousLink').addEventListener('tap', function() {
					dstUrl = '../Topic/shuoshuo.html';
					mui.openWindow({
						url:dstUrl,
						id:'shuoshuo'
					})
				}, false);
				
				document.querySelector('#gcLink').addEventListener('tap', function() {
					dstUrl = '../HomePage/index.html';
					mui.openWindow({
						url:dstUrl,
						id:'shuoshuo'
					})
				}, false);

				
			}
			
			function initSearchEvent()
			{
				var dstUrl = '../HomePage/search.html?type=1';
				document.querySelector('#searchAgentLink').addEventListener('tap', function() {
					dstUrl = '../HomePage/searchAgent.html';
					mui.openWindow({
						url:dstUrl,
						id:'search'
					})
				}, false);
				
				document.querySelector('#searchRequirementLink').addEventListener('tap', function() {
					
					mui.openWindow({
						url:'../HomePage/searchIndex.html?type=1',
						id:'search'
					})
				}, false);
				
				document.querySelector('#searchTopicLink').addEventListener('tap', function() {
					
					mui.openWindow({
						url:dstUrl,
						id:'search'
					})
				}, false);
				
				document.querySelector('#searchAnonymousLink').addEventListener('tap', function() {
					
					mui.openWindow({
						url:dstUrl,
						id:'search'
					})
				}, false);
				
				document.querySelector('#searchRecruitLink').addEventListener('tap', function() {
					
					mui.openWindow({
						url:dstUrl,
						id:'search'
					})
				}, false);
				
				document.querySelector('#searchEventsLink').addEventListener('tap', function() {
					
					mui.openWindow({
						url:dstUrl,
						id:'search'
					})
				}, false);
				
			}
			function isTopic(){
				if(location.pathname.split('/')[2] == 'Topic'){
					return true;
				}
				return false
			}
			
			//是否是广场
			function isGc(){
				if(location.pathname.split('/')[3] == 'index.html' && location.pathname.split('/')[2] == 'HomePage'){
					return true;
				}
				return false
			}
			
			function initPublishEvent()
			{
				var dstUrl = '';
				$('#publishAnonymousLink').on('tap',function(){
					if(isTopic()){
						$('#popup').addClass('active');
						mui.scrollTo(0,50,function(){$('#content').focus();$('#content').trigger('tap');});
						document.body.style.overflow='hidden';
					}else{
						dstUrl = '../Topic/shuoshuo.html';
						//alert(dstUrl);
						mui.openWindow({
							url:dstUrl,
							id:'shuoshuo'
						})
					}
				});
				$('#publishHelpLink').on('tap',function(){
					if(!$.wechated()){
						mask.close();
			    		$('.mui-content').hide();$('#authMessage').show();$('.need-wechat').show();
			    	}else{
						dstUrl = '../Expert/Mine/HelpPublish1.html';
						
						mui.openWindow({
							url:dstUrl,
							id:'HelpPublish1'
						})
					}
				});
				$('#publishRequirementLink').on('tap',function(){
					if(!$.wechated()){
						mask.close();
			    		$('.mui-content').hide();$('#authMessage').show();$('.need-wechat').show();
			    	}else{
						dstUrl = '../Publish/RequirementPublish1.html';
						
						mui.openWindow({
							url:dstUrl,
							id:'RequirementPublish1'
						})
					}
				});
				$('#publishRentRequirementLink').on('tap',function(){
					if(!$.wechated()){
						mask.close();
			    		$('.mui-content').hide();$('#authMessage').show();$('.need-wechat').show();
			    	}else{
						dstUrl = '../Publish/RentPublish1.html';
						mui.openWindow({
							url:dstUrl,
							id:'RentPublish1'
						})
					}
				});
				$('#publishHouseLink').on('tap',function(){
					if(!$.wechated()){
						mask.close();
			    		$('.mui-content').hide();$('#authMessage').show();$('.need-wechat').show();
			    	}else{
						dstUrl = '../Publish/HousePublish1.html';
						mui.openWindow({
							url:dstUrl,
							id:'HousePublish1'
						})
					}
				});
				$('#publishHouseLink').on('tap',function(){
					if(!$.wechated()){
						mask.close();
			    		$('.mui-content').hide();$('#authMessage').show();$('.need-wechat').show();
			    	}else{
						dstUrl = '../Publish/HousePublish1.html';
						mui.openWindow({
							url:dstUrl,
							id:'RecruitPublish'
						})
					}
				});
				
				$('#publishRecruitLink').on('tap',function(){
					if(!$.wechated()){
						mask.close();
			    		$('.mui-content').hide();$('#authMessage').show();$('.need-wechat').show();
			    	}else{
			    		
			    		if($.agented())
			    		{
			    			dstUrl = '../Recruit/PositionMgr/PublishPostion.html';
							mui.openWindow({
								url:dstUrl,
								id:'RecruitPublish'
							})
			    		}
						else
						{
							mui.toast('经纪人才可以发布招聘信息');
						}
					}
				});
				
				
				
				$('#publishActivityLink').on('tap',function(){
					if(!$.wechated()){
						mask.close();
			    		$('.mui-content').hide();$('#authMessage').show();$('.need-wechat').show();
			    	}else{
						dstUrl = '../Activity/Mine/Activity.html?type=1';
						mui.openWindow({
							url:dstUrl
						})
					}
				});
				
				$('#publishYdHouseLink').on('tap',function(){
					if(!$.wechated()){
						mask.close();
			    		$('.mui-content').hide();$('#authMessage').show();$('.need-wechat').show();
			    	}else{
						dstUrl = '../Referral/HousePublish1.html';
						mui.openWindow({
							url:dstUrl
						})
					}
				});
				
			}

						$('#search').on('tap',function(){
					if($(this).hasClass('active')){
						$(this).removeClass('active');
						$('#searchContent').removeClass('active');
						mask.close();
					}else{
						$(this).addClass('active');
						document.body.style.overflow='hidden';
						$('#searchContent').addClass('active');
						mask.show();//显示遮罩
					}
			});
			
			$('#publish').on('tap',function(){
					if($(this).hasClass('active')){
						$(this).removeClass('active');
						$('#publishContent').removeClass('active');

						mask.close();

					}else{
						$(this).addClass('active');
						document.body.style.overflow='hidden';
						$('#publishContent').addClass('active');
						mask.show();//显示遮罩
					}
			});