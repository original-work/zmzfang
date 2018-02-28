var regionData=[{
		value: '130000',
		text: '上海所有区域'
	},{
		value: '130100', 
		text: '青浦区'
	},{
		value: '130200',
		text: '松江区'
	}, {
		value: '130300',
		text: '嘉定区'
	}, {
		value: '130400',
		text: '闵行区'
	}, {
		value: '130500',
		text: '宝山区'
	}, {
		value: '130600',
		text: '金山区'
	}, {
		value: '130700',
		text: '长宁区'
	}, {
		value: '130800',
		text: '普陀区'
	}, {
		value: '130900',
		text: '杨浦区'
	}, {
		value: '131000', 
		text: '虹口区'
	}, {
		value: '131100', 
		text: '黄浦区'
	}, {
		value: '131200', 
		text: '静安区'
	}, {
		value: '131300', 
		text: '奉贤区'
	}, {
		value: '131400', 
		text: '徐汇区'
	}, {
		value: '131500', 
		text: '闸北区'
	}, {
		value: '131600', 
		text: '浦东新区'
	}, {
		value: '131700', 
		text: '崇明区'
	}];

function getRegionStr(regionid)
{
	var str = '';
	switch(regionid)
	{
		case '130000':
			str = regionData[0].text;
			break;
		case '130100':
			str = regionData[1].text;
			break;
		case '130200':
			str = regionData[2].text;
			break;
		case '130300':
			str = regionData[3].text;
			break;
		case '130400':
			str = regionData[4].text;
			break;
		case '130500':
			str = regionData[5].text;
			break;
		case '130600':
			str = regionData[6].text;
			break;
		case '130700':
			str = regionData[7].text;
			break;
		case '130800':
			str = regionData[8].text;
			break;
		case '130900':
			str = regionData[9].text;
			break;
		case '131000':
			str = regionData[10].text;
			break;
		case '131100':
			str = regionData[11].text;
			break;
		case '131200':
			str = regionData[12].text;
			break;
		case '131300':
			str = regionData[13].text;
			break;
		case '131400':
			str = regionData[14].text;
			break;
		case '131500':
			str = regionData[15].text;
			break;
		case '131600':
			str = regionData[16].text;
			break;
		case '131700':
			str = regionData[17].text;
			break;
		default:
			break;
	}
	return str;
}

var domainData=[{
		value: '1',
		text: '政策'
	},{
		value: '2',
		text: '贷款'
	},{
		value: '3',
		text: '交易税费'
	},{
		value: '4',
		text: '法律纠纷'
	}
	];
	
function getDomainStrNew(domain)
{
	var str = '';
	
	switch(domain)
	{
		case '0':
			str = domainData[0].text;
			break;
		case '1':
			str = domainData[1].text;
			break;
		case '2':
			str = domainData[2].text;
			break;
		case '3':
			str = domainData[3].text;
			break;
		case '4':
			str = domainData[4].text;
			break;
		case '5':
			str = domainData[5].text;
			break;
		default:
			break;
	}
	return str;
}