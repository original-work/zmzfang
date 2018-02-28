function getArea(r1,r2,r3,type){
			
			r1 = pad(r1.toString(),2);
			r2 = pad(r2.toString(),2);
			r3 = pad(r3.toString(),2);
			$id = r1+r2+r3;
			var type = type ? type : 'name';
			if(r3 != "00"){
				type = 'name';
			}
			console.log(type);
			console.log($id);
			switch($id){
				case "110000":
				if(type=='list'){
					return areaData3[0]['children'];
				}else{
					return areaData3[0]['text'];
				}
				break;
				case "120000":
				if(type=='list'){
					return areaData3[1]['children'];
				}else{
					return areaData3[1]['text'];
				}
				break;
				case "130000":
				if(type=='list'){
					return areaData3[2]['children'];
				}else{
					return areaData3[2]['text'];
				}
				break;
			}
			// console.log(r1);
			switch (r1) {
				case "11":
				var $conf = areaData3[0]['children'];
				break;
				case "12":
				var $conf = areaData3[1]['children'];
				break;
				case "13":
				var $conf = areaData3[2]['children'];
				break;
			}
			// console.log($conf);
			var $father;
			for (var $i=0;$i<$conf.length;$i++) {
				if($id == $conf[$i]['value']){
					if(type == 'list'){
						return $conf[$i]['children'];
					}else{
						return $conf[$i]['text'];
					}
				}
				for (var $j=0;$j<$conf[$i]['children'].length;$j++) {
						if($id == $conf[$i]['children'][$j]['value']){
							$father = getArea(r1,r2,'00');
							$conf[$i]['children'][$j]['father'] = $father;
							return $conf[$i]['children'][$j];
						}
					}
			}

	}
	function pad(num, n) {  
		    var len = num.toString().length;  
		    while(len < n) {  
		        num = "0" + num;  
		        len++;  
		    }  
		    return num; 
	}  