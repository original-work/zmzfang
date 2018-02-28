(function(r) {
	
	//获取需求列表成功后的处理方法，新建li元素
	r.getSpecificRequirementListSuccess = function (data,isIndex)
	{
		
		var new_requirementUl=document.createElement('requirementUl');
		var firstFrag = document.createDocumentFragment();
		var func;
		if(isIndex){
			func = 'fillRequirementListLiForIndex'
		}else{
			func = 'fillRequirementListLi';
		}
		for(var i in data)
		{
			var id=data[i].id;
			console.log('\n id:'+id);
			firstFrag.appendChild(window[func](data[i]));
		}
		
		new_requirementUl.appendChild(firstFrag);
		
		var child_dom = document.getElementById('pullrefresh_sub').contentWindow;
		console.log(child_dom);

		var requirementUl=child_dom.document.getElementById('requirementUl');
		requirementUl.innerHTML = "";

		requirementUl.appendChild(new_requirementUl);
	}


	//获取需求列表成功后的处理方法，新建li元素
	r.getRequirementListSuccess = function (data,isIndex)
	{
		
		var requirementUl=document.getElementById('requirementUl');
		//var requirementUl=$("requirementUl:last");
		var firstFrag = document.createDocumentFragment();
		var func;
		if(isIndex){
			func = 'fillRequirementListLiForIndex';
		}else{
			func = 'fillRequirementListLi';
		}
		for(var i in data)
		{
			var id=data[i].id;
			console.log('\n id:'+id);
			firstFrag.appendChild(window[func](data[i]));
		}
		
		//requirementUl.innerHTML = "";
		requirementUl.appendChild(firstFrag);
	}


	
	

})(window);