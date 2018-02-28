<?php
namespace  common\helpers;


class Area{
	static $area = ["value"=>"130000","text"=>"板块","children"=>[
					["value"=>"130100","text"=>"青浦区","children"=>
					  [
						["value"=>"130101","text"=>"青浦城区"],
						["value"=>"130102","text"=>"赵巷"],
						["value"=>"130103","text"=>"徐泾"],
						["value"=>"130104","text"=>"华新"],
						["value"=>"130105","text"=>"重固"],
						["value"=>"130106","text"=>"白鹤"],
						["value"=>"130107","text"=>"朱家角"],
						["value"=>"130108","text"=>"练塘"],
						["value"=>"130109","text"=>"金泽"]
					  ]
					],
					["value"=>"130200","text"=>"松江区","children"=>
					  [
					  	["value"=>"130201","text"=>"松江新城"],
					  	["value"=>"130202","text"=>"松江老城"],
					  	["value"=>"130203","text"=>"松江大学城"],
					  	["value"=>"130204","text"=>"莘闵"],
					  	["value"=>"130205","text"=>"小昆山"],
					  	["value"=>"130206","text"=>"叶榭"],
					  	["value"=>"130207","text"=>"石湖荡"],
					  	["value"=>"130208","text"=>"新浜"],
					  	["value"=>"130209","text"=>"车墩"],
					  	["value"=>"130210","text"=>"新桥"],
					  	["value"=>"130211","text"=>"佘山"],
					  	["value"=>"130212","text"=>"洞泾"],
					  	["value"=>"130213","text"=>"泗泾"],
					  	["value"=>"130214","text"=>"九亭"],
					  	["value"=>"130215","text"=>"泖港"]
					  ]
					],
					["value"=>"130300","text"=>"嘉定区","children"=>
					  [
					  	["value"=>"130301","text"=>"嘉定城区"],
					  	["value"=>"130302","text"=>"丰庄"],
					  	["value"=>"130303","text"=>"嘉定新城"],
					  	["value"=>"130304","text"=>"华亭"],
					  	["value"=>"130305","text"=>"安亭"],
					  	["value"=>"130306","text"=>"南翔"],
					  	["value"=>"130307","text"=>"马陆"],
					  	["value"=>"130308","text"=>"江桥"],
					  	["value"=>"130309","text"=>"外冈"],
					  	["value"=>"130310","text"=>"徐行"],
					  	["value"=>"130311","text"=>"真新"]
					  ]
					],
					["value"=>"130400","text"=>"闵行区","children"=>
					  [
					  	["value"=>"130401","text"=>"江川"],
					  	["value"=>"130402","text"=>"龙柏"],
					  	["value"=>"130403","text"=>"航华"],
					  	["value"=>"130404","text"=>"古美"],
					  	["value"=>"130405","text"=>"罗阳"],
					  	["value"=>"130406","text"=>"春申"],
					  	["value"=>"130407","text"=>"莘庄"],
					  	["value"=>"130408","text"=>"七宝"],
					  	["value"=>"130409","text"=>"浦江"],
					  	["value"=>"130410","text"=>"梅陇"],
					  	["value"=>"130411","text"=>"虹桥"],
					  	["value"=>"130412","text"=>"马桥"],
					  	["value"=>"130413","text"=>"吴泾"],
					  	["value"=>"130414","text"=>"华漕"],
					  	["value"=>"130415","text"=>"颛桥"],
					  	["value"=>"130416","text"=>"金汇"],
					  	["value"=>"130417","text"=>"静安新城"]
					  ]
					],
					["value"=>"130500","text"=>"宝山区","children"=>
					  [
					  	["value"=>"130501","text"=>"上大"],
					  	["value"=>"130502","text"=>"大华"],
					  	["value"=>"130503","text"=>"大场"],
					  	["value"=>"130504","text"=>"高境"],
					  	["value"=>"130505","text"=>"顾村"],
					  	["value"=>"130506","text"=>"共康"],
					  	["value"=>"130507","text"=>"共富"],
					  	["value"=>"130508","text"=>"通河"],
					  	["value"=>"130509","text"=>"张庙"],
					  	["value"=>"130510","text"=>"月浦"],
					  	["value"=>"130511","text"=>"杨行"],
					  	["value"=>"130512","text"=>"淞南"],
					  	["value"=>"130513","text"=>"淞宝"],
					  	["value"=>"130514","text"=>"罗店"],
					  	["value"=>"130515","text"=>"罗泾"],
					  	["value"=>"130516","text"=>"庙行"]
					  ]
					],
					["value"=>"130600","text"=>"金山区","children"=>
					  [
					  	["value"=>"130601","text"=>"金山新城"],
					  	["value"=>"130602","text"=>"朱泾"],
					  	["value"=>"130603","text"=>"石化"],
					  	["value"=>"130604","text"=>"亭林"],
					  	["value"=>"130605","text"=>"枫泾"],
					  	["value"=>"130606","text"=>"金山其他"]
					  ]
					],
					["value"=>"130700","text"=>"长宁区","children"=>
					  [
					  	["value"=>"130701","text"=>"北新泾"],
					  	["value"=>"130702","text"=>"古北"],
					  	["value"=>"130703","text"=>"虹桥"],
					  	["value"=>"130704","text"=>"天山"],
					  	["value"=>"130705","text"=>"西郊"],
					  	["value"=>"130706","text"=>"仙霞"],
					  	["value"=>"130707","text"=>"新华路"],
					  	["value"=>"130708","text"=>"镇宁路"],
					  	["value"=>"130709","text"=>"中山公园"]
					  ]
					],
					["value"=>"130800","text"=>"普陀区","children"=>
					  [
					  	["value"=>"130801","text"=>"曹杨"],
					  	["value"=>"130802","text"=>"长风"],
					  	["value"=>"130803","text"=>"长寿路"],
					  	["value"=>"130804","text"=>"长征"],
					  	["value"=>"130805","text"=>"甘泉宜川"],
					  	["value"=>"130806","text"=>"桃浦"],
					  	["value"=>"130807","text"=>"万里"],
					  	["value"=>"130808","text"=>"武宁"],
					  	["value"=>"130809","text"=>"光新"],
					  	["value"=>"130810","text"=>"真如"],
					  	["value"=>"130811","text"=>"真光"],
					  	["value"=>"130812","text"=>"中远两湾城"]
					  ]
					],
					["value"=>"130900","text"=>"杨浦区","children"=>
					  [
					  	["value"=>"130901","text"=>"鞍山"],
					  	["value"=>"130902","text"=>"东外滩"],
					  	["value"=>"130903","text"=>"黄兴公园"],
					  	["value"=>"130904","text"=>"控江路"],
					  	["value"=>"130905","text"=>"五角场"],
					  	["value"=>"130906","text"=>"周家嘴路"],
					  	["value"=>"130907","text"=>"中原"],
					  	["value"=>"130908","text"=>"杨浦大桥"],
					  	["value"=>"130909","text"=>"新江湾城"]
					  ]
					],
					["value"=>"131000","text"=>"虹口区","children"=>
					  [
					  	["value"=>"131001","text"=>"北外滩"],
					  	["value"=>"131002","text"=>"江湾镇"],
					  	["value"=>"131003","text"=>"凉城"],
					  	["value"=>"131004","text"=>"临平路"],
					  	["value"=>"131005","text"=>"鲁迅公园"],
					  	["value"=>"131006","text"=>"曲阳"],
					  	["value"=>"131007","text"=>"四川北路"]
					  ]
					],
					["value"=>"131100","text"=>"黄浦区","children"=>
					  [
					  	["value"=>"131101","text"=>"蓬莱公园"],
					  	["value"=>"131102","text"=>"人民广场"],
					  	["value"=>"131103","text"=>"豫园"],
					  	["value"=>"131104","text"=>"董家渡"],
					  	["value"=>"131105","text"=>"黄浦滨江"],
					  	["value"=>"131106","text"=>"南京东路"],
					  	["value"=>"131107","text"=>"打浦桥"],
					  	["value"=>"131108","text"=>"淮海中路"],
					  	["value"=>"131109","text"=>"世博滨江"],
					  	["value"=>"131110","text"=>"五里桥"],
					  	["value"=>"131111","text"=>"新天地"],
					  	["value"=>"131112","text"=>"老西门"]

					  ]
					],
					["value"=>"131200","text"=>"静安区","children"=>
					  [
					  	["value"=>"131201","text"=>"曹家渡"],
					  	["value"=>"131202","text"=>"江宁路"],
					  	["value"=>"131203","text"=>"静安寺"],
					  	["value"=>"131204","text"=>"南京西路"]
					  ]
					],
					["value"=>"131300","text"=>"奉贤区","children"=>
					  [
					  	["value"=>"131301","text"=>"奉城"],
					  	["value"=>"131302","text"=>"西渡"],
					  	["value"=>"131303","text"=>"南桥"],
					  	["value"=>"131304","text"=>"拓林"],
					  	["value"=>"131305","text"=>"庄行"],
					  	["value"=>"131306","text"=>"金汇"],
					  	["value"=>"131307","text"=>"海湾"],
					  	["value"=>"131308","text"=>"奉贤其他"]
					  ]
					],
					["value"=>"131400","text"=>"徐汇区","children"=>
					  [
					  	["value"=>"131401","text"=>"漕河泾"],
					  	["value"=>"131402","text"=>"长桥"],
					  	["value"=>"131403","text"=>"衡山路"],
					  	["value"=>"131404","text"=>"华东理工"],
					  	["value"=>"131405","text"=>"华泾"],
					  	["value"=>"131406","text"=>"建国西路"],
					  	["value"=>"131407","text"=>"康健"],
					  	["value"=>"131408","text"=>"龙华"],
					  	["value"=>"131409","text"=>"上海南站"],
					  	["value"=>"131410","text"=>"田林"],
					  	["value"=>"131411","text"=>"万体馆"],
					  	["value"=>"131412","text"=>"斜土路"],
					  	["value"=>"131413","text"=>"徐汇滨江"],
					  	["value"=>"131414","text"=>"徐家汇"],
					  	["value"=>"131415","text"=>"植物园"]
					  ]
					],
					["value"=>"131500","text"=>"闸北区","children"=>
					  [
					  	["value"=>"131501","text"=>"不夜城"],
					  	["value"=>"131502","text"=>"大宁"],
					  	["value"=>"131503","text"=>"彭浦"],
					  	["value"=>"131504","text"=>"西藏北路"],
					  	["value"=>"131505","text"=>"闸北公园"],
					  	["value"=>"131506","text"=>"阳城"],
					  	["value"=>"131507","text"=>"永和"]
					  ]
					],
					["value"=>"131600","text"=>"浦东新区","children"=>
					  [
					  	["value"=>"131601","text"=>"曹路"],
					  	["value"=>"131602","text"=>"高行"],
					  	["value"=>"131603","text"=>"航头"],
					  	["value"=>"131604","text"=>"碧云"],
					  	["value"=>"131605","text"=>"金杨"],
					  	["value"=>"131606","text"=>"康桥"],
					  	["value"=>"131607","text"=>"联洋"],
					  	["value"=>"131608","text"=>"潍坊"],
					  	["value"=>"131609","text"=>"新场"],
					  	["value"=>"131610","text"=>"杨东"],
					  	["value"=>"131611","text"=>"祝桥"],
					  	["value"=>"131612","text"=>"源深"],
					  	["value"=>"131613","text"=>"洋泾"],
					  	["value"=>"131614","text"=>"塘桥"],
					  	["value"=>"131615","text"=>"唐镇"],
					  	["value"=>"131616","text"=>"北蔡"],
					  	["value"=>"131617","text"=>"川沙"],
					  	["value"=>"131618","text"=>"三林"],
					  	["value"=>"131619","text"=>"世博"],
					  	["value"=>"131620","text"=>"世纪公园"],
					  	["value"=>"131621","text"=>"惠南"],
					  	["value"=>"131622","text"=>"花木"],
					  	["value"=>"131623","text"=>"金桥"],
					  	["value"=>"131624","text"=>"外高桥"],
					  	["value"=>"131625","text"=>"张江"],
					  	["value"=>"131626","text"=>"周浦"],
					  	["value"=>"131627","text"=>"临港新城"],
					  	["value"=>"131628","text"=>"陆家嘴"],
					  	["value"=>"131629","text"=>"南码头"]
					  ]
					],
					["value"=>"131700","text"=>"崇明县","children"=>
					  [
					  	["value"=>"131701","text"=>"崇明"]
					  ]
					],
					["value"=>"131800","text"=>"上海周边","children"=>
					  [
					  	["value"=>"131801","text"=>"花桥"],
					  	["value"=>"131802","text"=>"嘉兴"],
					  	["value"=>"131803","text"=>"嘉善"],
					  	["value"=>"131804","text"=>"千灯"],
					  	["value"=>"131899","text"=>"其他"]
					  ]
					]
				  ]
				]; 
	static $metro =["value"=>"110000","text"=>"地铁","children"=>[
					['value'=>'110100',
					 'text'=>'1号线',
					 'children'=>[
						['value'=>'110101',
						 'text'=>'富锦路',
						 'longitude'=>'121.431023',
						 'latitude'=>'31.39867'
						],
						['value'=>'110102',
						 'text'=>'友谊西路',
						 'longitude'=>'121.434336',
						 'latitude'=>'31.38774'
						],
						['value'=>'110103',
						 'text'=>'宝安公路',
						 'longitude'=>'121.437378',
						 'latitude'=>'31.376139'
						],
						['value'=>'110104',
						 'text'=>'共富新村',
						 'longitude'=>'121.440529',
						 'latitude'=>'31.361502'
						],
						['value'=>'110105',
						 'text'=>'呼兰路',
						 'longitude'=>'121.444185',
						 'latitude'=>'31.345991'
						],
						['value'=>'110106',
						 'text'=>'通河新村',
						 'longitude'=>'121.447817',
						 'latitude'=>'31.337798'
						],
						['value'=>'110107',
						 'text'=>'共康路',
						 'longitude'=>'121.453464',
						 'latitude'=>'31.325355'
						],
						['value'=>'110108',
						 'text'=>'彭浦新村',
						 'longitude'=>'121.455097',
						 'latitude'=>'31.312943'
						],
						['value'=>'110109',
						 'text'=>'汶水路',
						 'longitude'=>'121.45656',
						 'latitude'=>'31.298815'
						],
						['value'=>'110110',
						 'text'=>'上海马戏城',
						 'longitude'=>'121.458503',
						 'latitude'=>'31.285845'
						],
						['value'=>'110111',
						 'text'=>'延长路',
						 'longitude'=>'121.461893',
						 'latitude'=>'31.27806'
						],
						['value'=>'110112',
						 'text'=>'中山北路',
						 'longitude'=>'121.465616',
						 'latitude'=>'31.265275'
						],
						['value'=>'110113',
						 'text'=>'上海火车站',
						 'longitude'=>'121.462367',
						 'latitude'=>'31.253614'
						],
						['value'=>'110114',
						 'text'=>'汉中路',
						 'longitude'=>'121.464994',
						 'latitude'=>'31.247814'
						],
						['value'=>'110115',
						 'text'=>'新闸路',
						 'longitude'=>'121.474802',
						 'latitude'=>'31.244699'
						],
						['value'=>'110116',
						 'text'=>'人民广场',
						 'longitude'=>'121.481689',
						 'latitude'=>'31.238907'
						],
						['value'=>'110117',
						 'text'=>'黄陂南路',
						 'longitude'=>'121.479798',
						 'latitude'=>'31.228753'
						],
						['value'=>'110118',
						 'text'=>'陕西南路',
						 'longitude'=>'121.46667',
						 'latitude'=>'31.223499'
						],
						['value'=>'110119',
						 'text'=>'常熟路',
						 'longitude'=>'121.457727',
						 'latitude'=>'31.219932'
						],
						['value'=>'110120',
						 'text'=>'衡山路',
						 'longitude'=>'121.45316',
						 'latitude'=>'31.211335'
						],
						['value'=>'110121',
						 'text'=>'徐家汇',
						 'longitude'=>'121.444742',
						 'latitude'=>'31.19915'
						],
						['value'=>'110122',
						 'text'=>'上海体育馆',
						 'longitude'=>'121.442834',
						 'latitude'=>'31.188361'
						],
						['value'=>'110123',
						 'text'=>'漕宝路',
						 'longitude'=>'121.441499',
						 'latitude'=>'31.174521'
						],
						['value'=>'110124',
						 'text'=>'上海南站',
						 'longitude'=>'121.436267',
						 'latitude'=>'31.161165'
						],
						['value'=>'110125',
						 'text'=>'锦江乐园',
						 'longitude'=>'121.42068',
						 'latitude'=>'31.148312'
						],
						['value'=>'110126',
						 'text'=>'莲花路',
						 'longitude'=>'121.409334',
						 'latitude'=>'31.136734'
						],
						['value'=>'110127',
						 'text'=>'外环路',
						 'longitude'=>'121.399814',
						 'latitude'=>'31.126929'
						],
						['value'=>'110128',
						 'text'=>'莘庄',
						 'longitude'=>'121.391623',
						 'latitude'=>'31.116581'
						],
					 ]
					],
					['value'=>'110200',
					 'text'=>'2号线',
					 'children'=>[
					 	['value'=>'110201',
					 	 'text'=>'徐泾东',
					 	 'longitude'=>'121.307524',
					 	 'latitude'=>'31.195431'
					 	],
					 	['value'=>'110202',
					 	 'text'=>'虹桥火车站',
					 	 'longitude'=>'121.327907',
					 	 'latitude'=>'31.200316'
					 	],
					 	['value'=>'110203',
					 	 'text'=>'虹桥2号航站楼',
					 	 'longitude'=>'121.333274',
					 	 'latitude'=>'31.20056'
					 	],
					 	['value'=>'110204',
					 	 'text'=>'淞虹路',
					 	 'longitude'=>'121.365797',
					 	 'latitude'=>'31.223998'
					 	],
					 	['value'=>'110205',
					 	 'text'=>'北新泾',
					 	 'longitude'=>'121.38064',
					 	 'latitude'=>'31.222104'
					 	],
					 	['value'=>'110206',
					 	 'text'=>'威宁路',
					 	 'longitude'=>'121.393671',
					 	 'latitude'=>'31.220485'
					 	],
					 	['value'=>'110207',
					 	 'text'=>'娄山关路',
					 	 'longitude'=>'121.410818',
					 	 'latitude'=>'31.216959'
					 	],
					 	['value'=>'110208',
					 	 'text'=>'中山公园',
					 	 'longitude'=>'121.424455',
					 	 'latitude'=>'31.224627'
					 	],
					 	['value'=>'110209',
					 	 'text'=>'江苏路',
					 	 'longitude'=>'121.438949',
					 	 'latitude'=>'31.226175'
					 	],
					 	['value'=>'110210',
					 	 'text'=>'静安寺',
					 	 'longitude'=>'121.452707',
					 	 'latitude'=>'31.229552'
					 	],
					 	['value'=>'110211',
					 	 'text'=>'南京西路',
					 	 'longitude'=>'121.46677',
					 	 'latitude'=>'31.236137'
					 	],
					 	['value'=>'110212',
					 	 'text'=>'人民广场',
					 	 'longitude'=>'121.479265',
					 	 'latitude'=>'31.238796'
					 	],
					 	['value'=>'110213',
					 	 'text'=>'南京东路',
					 	 'longitude'=>'121.490308',
					 	 'latitude'=>'31.242916'
					 	],
					 	['value'=>'110214',
					 	 'text'=>'陆家嘴',
					 	 'longitude'=>'121.508824',
					 	 'latitude'=>'31.243637'
					 	],
					 	['value'=>'110215',
					 	 'text'=>'东昌路',
					 	 'longitude'=>'121.521998',
					 	 'latitude'=>'31.239079'
					 	],
					 	['value'=>'110216',
					 	 'text'=>'世纪大道',
					 	 'longitude'=>'121.533435',
					 	 'latitude'=>'31.23485'
					 	],
					 	['value'=>'110217',
					 	 'text'=>'上海科技馆',
					 	 'longitude'=>'121.550621',
					 	 'latitude'=>'31.22552'
					 	],
					 	['value'=>'110218',
					 	 'text'=>'世纪公园',
					 	 'longitude'=>'121.557176',
					 	 'latitude'=>'31.215933'
					 	],
					 	['value'=>'110219',
					 	 'text'=>'龙阳路',
					 	 'longitude'=>'121.563814',
					 	 'latitude'=>'31.209427'
					 	],
					 	['value'=>'110220',
					 	 'text'=>'张江高科',
					 	 'longitude'=>'121.594061',
					 	 'latitude'=>'31.207879'
					 	],
					 	['value'=>'110221',
					 	 'text'=>'金科路',
					 	 'longitude'=>'121.608557',
					 	 'latitude'=>'31.209932'
					 	],
					 	['value'=>'110222',
					 	 'text'=>'广兰路',
					 	 'longitude'=>'121.627183',
					 	 'latitude'=>'31.216662'
					 	],
					 	['value'=>'110223',
					 	 'text'=>'唐镇',
					 	 'longitude'=>'121.662625',
					 	 'latitude'=>'31.219828'
					 	],
					 	['value'=>'110224',
					 	 'text'=>'创新中路',
					 	 'longitude'=>'121.680337',
					 	 'latitude'=>'31.219751'
					 	],
					 	['value'=>'110225',
					 	 'text'=>'华夏东路',
					 	 'longitude'=>'121.687295',
					 	 'latitude'=>'31.203168'
					 	],
					 	['value'=>'110226',
					 	 'text'=>'川沙',
					 	 'longitude'=>'121.704499',
					 	 'latitude'=>'31.192886'
					 	],
					 	['value'=>'110227',
					 	 'text'=>'凌空路',
					 	 'longitude'=>'121.730308',
					 	 'latitude'=>'31.198595'
					 	],
					 	['value'=>'110228',
					 	 'text'=>'远东大道',
					 	 'longitude'=>'121.76216',
					 	 'latitude'=>'31.205201'
					 	],
					 	['value'=>'110229',
					 	 'text'=>'海天三路',
					 	 'longitude'=>'121.803224',
					 	 'latitude'=>'31.174953'
					 	],
					 	['value'=>'110230',
					 	 'text'=>'浦东国际机场',
					 	 'longitude'=>'121.813381',
					 	 'latitude'=>'31.155041'
					 	],
					 ]
					],
					['value'=>'110300',
					 'text'=>'3号线',
					 'children'=>[
					 	['value'=>'110301',
					 	 'text'=>'江杨北路',
					 	 'longitude'=>'121.446217',
					 	 'latitude'=>'31.414218'
					 	],
					 	['value'=>'110302',
					 	 'text'=>'铁力路',
					 	 'longitude'=>'121.467851',
					 	 'latitude'=>'31.414261'
					 	],
					 	['value'=>'110303',
					 	 'text'=>'友谊路',
					 	 'longitude'=>'121.48254',
					 	 'latitude'=>'31.40993'
					 	],
					 	['value'=>'110304',
					 	 'text'=>'宝杨路',
					 	 'longitude'=>'121.486126',
					 	 'latitude'=>'31.401287'
					 	],
					 	['value'=>'110305',
					 	 'text'=>'水产路',
					 	 'longitude'=>'121.494718',
					 	 'latitude'=>'31.387101'
					 	],
					 	['value'=>'110306',
					 	 'text'=>'淞滨路',
					 	 'longitude'=>'121.499387',
					 	 'latitude'=>'31.376563'
					 	],
					 	['value'=>'110307',
					 	 'text'=>'张华浜',
					 	 'longitude'=>'121.505406',
					 	 'latitude'=>'31.363662'
					 	],
					 	['value'=>'110308',
					 	 'text'=>'淞发路',
					 	 'longitude'=>'121.50714',
					 	 'latitude'=>'31.350804'
					 	],
					 	['value'=>'110309',
					 	 'text'=>'长江南路',
					 	 'longitude'=>'121.498185',
					 	 'latitude'=>'31.337669'
					 	],
					 	['value'=>'110310',
					 	 'text'=>'殷高西路',
					 	 'longitude'=>'121.491418',
					 	 'latitude'=>'31.325557'
					 	],
					 	['value'=>'110311',
					 	 'text'=>'江湾镇',
					 	 'longitude'=>'121.491636',
					 	 'latitude'=>'31.311153'
					 	],
					 	['value'=>'110312',
					 	 'text'=>'大柏树',
					 	 'longitude'=>'121.489614',
					 	 'latitude'=>'31.295096'
					 	],
					 	['value'=>'110313',
					 	 'text'=>'赤峰路',
					 	 'longitude'=>'121.48899',
					 	 'latitude'=>'31.287038'
					 	],
					 	['value'=>'110314',
					 	 'text'=>'虹口足球场',
					 	 'longitude'=>'121.485641',
					 	 'latitude'=>'31.27748'
					 	],
					 	['value'=>'110315',
					 	 'text'=>'东宝兴路',
					 	 'longitude'=>'121.486639',
					 	 'latitude'=>'31.265746'
					 	],
					 	['value'=>'110316',
					 	 'text'=>'宝山路',
					 	 'longitude'=>'121.483032',
					 	 'latitude'=>'31.257464'
					 	],
					 	['value'=>'110317',
					 	 'text'=>'上海火车站',
					 	 'longitude'=>'121.464742',
					 	 'latitude'=>'31.255931'
					 	],
					 	['value'=>'110318',
					 	 'text'=>'中潭路',
					 	 'longitude'=>'121.447452',
					 	 'latitude'=>'31.261022'
					 	],
					 	['value'=>'110319',
					 	 'text'=>'镇坪路',
					 	 'longitude'=>'121.436225',
					 	 'latitude'=>'31.252825'
					 	],
					 	['value'=>'110320',
					 	 'text'=>'曹杨路',
					 	 'longitude'=>'121.424264',
					 	 'latitude'=>'31.245572'
					 	],
					 	['value'=>'110321',
					 	 'text'=>'金沙江路',
					 	 'longitude'=>'121.419507',
					 	 'latitude'=>'31.237991'
					 	],
					 	['value'=>'110322',
					 	 'text'=>'中山公园',
					 	 'longitude'=>'121.422241',
					 	 'latitude'=>'31.223936'
					 	],
					 	['value'=>'110323',
					 	 'text'=>'延安西路',
					 	 'longitude'=>'121.423584',
					 	 'latitude'=>'31.215865'
					 	],
					 	['value'=>'110324',
					 	 'text'=>'虹桥路',
					 	 'longitude'=>'121.427312',
					 	 'latitude'=>'31.203495'
					 	],
					 	['value'=>'110325',
					 	 'text'=>'宜山路',
					 	 'longitude'=>'121.427303',
					 	 'latitude'=>'31.203495'
					 	],
					 	['value'=>'110326',
					 	 'text'=>'漕溪路',
					 	 'longitude'=>'121.444739',
					 	 'latitude'=>'31.182978'
					 	],
					 	['value'=>'110327',
					 	 'text'=>'龙漕路',
					 	 'longitude'=>'121.450794',
					 	 'latitude'=>'31.175727'
					 	],
					 	['value'=>'110328',
					 	 'text'=>'石龙路',
					 	 'longitude'=>'121.44963',
					 	 'latitude'=>'31.164304'
					 	],
					 	['value'=>'110329',
					 	 'text'=>'上海南站',
					 	 'longitude'=>'121.437139',
					 	 'latitude'=>'31.159659'
					 	],
					 ]
					],
					['value'=>'110400',
					 'text'=>'4号线',
					 'children'=>[
					 	['value'=>'110401',
					 	 'text'=>'宜山路',
					 	 'longitude'=>'121.433856',
					 	 'latitude'=>'31.193066'
					 	],
					 	['value'=>'110402',
					 	 'text'=>'虹桥路',
					 	 'longitude'=>'121.427312',
					 	 'latitude'=>'31.203495'
					 	],
					 	['value'=>'110403',
					 	 'text'=>'延安西路',
					 	 'longitude'=>'121.423584',
					 	 'latitude'=>'31.215865'
					 	],
					 	['value'=>'110404',
					 	 'text'=>'中山公园',
					 	 'longitude'=>'121.422241',
					 	 'latitude'=>'31.223936'
					 	],
					 	['value'=>'110405',
					 	 'text'=>'金沙江路',
					 	 'longitude'=>'121.419762',
					 	 'latitude'=>'31.238375'
					 	],
					 	['value'=>'110406',
					 	 'text'=>'曹杨路',
					 	 'longitude'=>'121.424255',
					 	 'latitude'=>'31.245568'
					 	],
					 	['value'=>'110407',
					 	 'text'=>'镇坪路',
					 	 'longitude'=>'121.436238',
					 	 'latitude'=>'31.252819'
					 	],
					 	['value'=>'110408',
					 	 'text'=>'中潭路',
					 	 'longitude'=>'121.447452',
					 	 'latitude'=>'31.261022'
					 	],
					 	['value'=>'110409',
					 	 'text'=>'上海火车站',
					 	 'longitude'=>'121.464741',
					 	 'latitude'=>'31.25593'
					 	],
					 	['value'=>'110410',
					 	 'text'=>'宝山路',
					 	 'longitude'=>'121.483032',
					 	 'latitude'=>'31.257464'
					 	],
					 	['value'=>'110411',
					 	 'text'=>'海伦路',
					 	 'longitude'=>'121.496106',
					 	 'latitude'=>'31.264137'
					 	],
					 	['value'=>'110412',
					 	 'text'=>'临平路',
					 	 'longitude'=>'121.507604',
					 	 'latitude'=>'31.26658'
					 	],
					 	['value'=>'110413',
					 	 'text'=>'大连路',
					 	 'longitude'=>'121.519576',
					 	 'latitude'=>'31.263723'
					 	],
					 	['value'=>'110414',
					 	 'text'=>'杨树浦路',
					 	 'longitude'=>'121.523944',
					 	 'latitude'=>'31.257681'
					 	],
					 	['value'=>'110415',
					 	 'text'=>'浦东大道',
					 	 'longitude'=>'121.526013',
					 	 'latitude'=>'31.245796'
					 	],
					 	['value'=>'110416',
					 	 'text'=>'世纪大道',
					 	 'longitude'=>'121.533435',
					 	 'latitude'=>'31.23485'
					 	],
					 	['value'=>'110417',
					 	 'text'=>'浦电路',
					 	 'longitude'=>'121.538513',
					 	 'latitude'=>'31.229007'
					 	],
					 	['value'=>'110418',
					 	 'text'=>'蓝村路',
					 	 'longitude'=>'121.534381',
					 	 'latitude'=>'31.217627'
					 	],
					 	['value'=>'110419',
					 	 'text'=>'塘桥',
					 	 'longitude'=>'121.525353',
					 	 'latitude'=>'31.215407'
					 	],
					 	['value'=>'110420',
					 	 'text'=>'南浦大桥',
					 	 'longitude'=>'121.506336',
					 	 'latitude'=>'31.214285'
					 	],
					 	['value'=>'110421',
					 	 'text'=>'西藏南路',
					 	 'longitude'=>'121.496122',
					 	 'latitude'=>'31.207672'
					 	],
					 	['value'=>'110422',
					 	 'text'=>'鲁班路',
					 	 'longitude'=>'121.480988',
					 	 'latitude'=>'31.20494'
					 	],
					 	['value'=>'110423',
					 	 'text'=>'大木桥路',
					 	 'longitude'=>'121.470103',
					 	 'latitude'=>'31.200369'
					 	],
					 	['value'=>'110424',
					 	 'text'=>'东安路',
					 	 'longitude'=>'121.461376',
					 	 'latitude'=>'31.197041'
					 	],
					 	['value'=>'110425',
					 	 'text'=>'上海体育场',
					 	 'longitude'=>'121.450248',
					 	 'latitude'=>'31.19218'
					 	],
					 	['value'=>'110426',
					 	 'text'=>'上海体育馆',
					 	 'longitude'=>'121.443979',
					 	 'latitude'=>'31.189284'
					 	],
					 ]
					],
					['value'=>'110500',
					 'text'=>'5号线',
					 'children'=>[
					 	['value' => '110501',
					 	 'text' => '莘庄',
					 	 'longitude' => '121.391623',
					 	 'latitude' => '31.116581'
					 	],
					 	['value' => '110502',
					 	 'text' => '春申路',
					 	 'longitude' => '121.392332',
					 	 'latitude' => '31.103958'
					 	],
					 	['value' => '110503',
					 	 'text' => '银都路',
					 	 'longitude' => '121.396872',
					 	 'latitude' => '31.095083'
					 	],
					 	['value' => '110504',
					 	 'text' => '颛桥',
					 	 'longitude' => '121.408435',
					 	 'latitude' => '31.072842'
					 	],
					 	['value' => '110505',
					 	 'text' => '北桥',
					 	 'longitude' => '121.416485',
					 	 'latitude' => '31.051134'
					 	],
					 	['value' => '110506',
					 	 'text' => '剑川路',
					 	 'longitude' => '121.422973',
					 	 'latitude' => '31.032572'
					 	],
					 	['value' => '110507',
					 	 'text' => '东川路',
					 	 'longitude' => '121.426326',
					 	 'latitude' => '31.024468'
					 	],
					 	['value' => '110508',
					 	 'text' => '金平路',
					 	 'longitude' => '121.416554',
					 	 'latitude' => '31.017141'
					 	],
					 	['value' => '110509',
					 	 'text' => '华宁路',
					 	 'longitude' => '121.401635',
					 	 'latitude' => '31.013066'
					 	],
					 	['value' => '110510',
					 	 'text' => '文井路',
					 	 'longitude' => '121.387319',
					 	 'latitude' => '31.009198'
					 	],
					 	['value' => '110511',
					 	 'text' => '闵行开发区',
					 	 'longitude' => '121.376495',
					 	 'latitude' => '31.006315'
					 	],
					 ]
					],
					['value'=>'110600',
					 'text'=>'6号线',
					 'children'=>[
					 	['value' => '110601',
					 	 'text' => '港城路',
					 	 'longitude' => '121.581148',
					 	 'latitude' => '31.359297'
					 	],
					 	['value' => '110602',
					 	 'text' => '外高桥保税区北',
					 	 'longitude' => '121.593445',
					 	 'latitude' => '31.353883'
					 	],
					 	['value' => '110603',
					 	 'text' => '航津路',
					 	 'longitude' => '121.600539',
					 	 'latitude' => '31.341305'
					 	],
					 	['value' => '110604',
					 	 'text' => '外高桥保税区南',
					 	 'longitude' => '121.608663',
					 	 'latitude' => '31.327228'
					 	],
					 	['value' => '110605',
					 	 'text' => '洲海路',
					 	 'longitude' => '121.595922',
					 	 'latitude' => '31.318355'
					 	],
					 	['value' => '110606',
					 	 'text' => '五洲大道',
					 	 'longitude' => '121.595846',
					 	 'latitude' => '31.308625'
					 	],
					 	['value' => '110607',
					 	 'text' => '东靖路',
					 	 'longitude' => '121.595327',
					 	 'latitude' => '31.296804'
					 	],
					 	['value' => '110608',
					 	 'text' => '巨峰路',
					 	 'longitude' => '121.594981',
					 	 'latitude' => '31.286714'
					 	],
					 	['value' => '110609',
					 	 'text' => '五莲路',
					 	 'longitude' => '121.59454',
					 	 'latitude' => '31.278007'
					 	],
					 	['value' => '110610',
					 	 'text' => '博兴路',
					 	 'longitude' => '121.593414',
					 	 'latitude' => '31.270058'
					 	],
					 	['value' => '110611',
					 	 'text' => '金桥路',
					 	 'longitude' => '121.588374',
					 	 'latitude' => '31.263292'
					 	],
					 	['value' => '110612',
					 	 'text' => '云山路',
					 	 'longitude' => '121.579314',
					 	 'latitude' => '31.256659'
					 	],
					 	['value' => '110613',
					 	 'text' => '德平路',
					 	 'longitude' => '121.570573',
					 	 'latitude' => '31.251659'
					 	],
					 	['value' => '110614',
					 	 'text' => '北洋泾路',
					 	 'longitude' => '121.559229',
					 	 'latitude' => '31.245588'
					 	],
					 	['value' => '110615',
					 	 'text' => '民生路',
					 	 'longitude' => '121.549926',
					 	 'latitude' => '31.242115'
					 	],
					 	['value' => '110616',
					 	 'text' => '源深体育中心',
					 	 'longitude' => '121.540892',
					 	 'latitude' => '31.239044'
					 	],
					 	['value' => '110617',
					 	 'text' => '世纪大道',
					 	 'longitude' => '121.533435',
					 	 'latitude' => '31.23485'
					 	],
					 	['value' => '110618',
					 	 'text' => '浦电路',
					 	 'longitude' => '121.535457',
					 	 'latitude' => '31.22605'
					 	],
					 	['value' => '110619',
					 	 'text' => '蓝村路',
					 	 'longitude' => '121.534381',
					 	 'latitude' => '31.217627'
					 	],
					 	['value' => '110620',
					 	 'text' => '上海儿童医学中心',
					 	 'longitude' => '121.52979',
					 	 'latitude' => '31.209399'
					 	],
					 	['value' => '110621',
					 	 'text' => '临沂新村',
					 	 'longitude' => '121.52308',
					 	 'latitude' => '31.198949'
					 	],
					 	['value' => '110622',
					 	 'text' => '高科西路',
					 	 'longitude' => '121.516396',
					 	 'latitude' => '31.191286'
					 	],
					 	['value' => '110623',
					 	 'text' => '东明路',
					 	 'longitude' => '121.517488',
					 	 'latitude' => '31.17825'
					 	],
					 	['value' => '110624',
					 	 'text' => '高青路',
					 	 'longitude' => '121.52227',
					 	 'latitude' => '31.165247'
					 	],
					 	['value' => '110625',
					 	 'text' => '华夏西路',
					 	 'longitude' => '121.521145',
					 	 'latitude' => '31.15557'
					 	],
					 	['value' => '110626',
					 	 'text' => '上南路',
					 	 'longitude' => '121.512956',
					 	 'latitude' => '31.154788'
					 	],
					 	['value' => '110627',
					 	 'text' => '灵岩南路',
					 	 'longitude' => '121.50168',
					 	 'latitude' => '31.154367'
					 	],
					 	['value' => '110628',
					 	 'text' => '东方体育中心',
					 	 'longitude' => '121.487012',
					 	 'latitude' => '31.159351'
					 	],
					 ]
					],
					['value'=>'110700',
					 'text'=>'7号线',
					 'children'=>[
					 	['value' => '110701',
					 	 'text' => '美兰湖',
					 	 'longitude' => '121.356426',
					 	 'latitude' => '31.407854'
					 	],
					 	['value' => '110702',
					 	 'text' => '罗南新村',
					 	 'longitude' => '121.364185',
					 	 'latitude' => '31.394383'
					 	],
					 	['value' => '110703',
					 	 'text' => '潘广路',
					 	 'longitude' => '121.362293',
					 	 'latitude' => '31.370197'
					 	],
					 	['value' => '110704',
					 	 'text' => '刘行',
					 	 'longitude' => '121.368889',
					 	 'latitude' => '31.363427'
					 	],
					 	['value' => '110705',
					 	 'text' => '顾村公园',
					 	 'longitude' => '121.379313',
					 	 'latitude' => '31.350576'
					 	],
					 	['value' => '110706',
					 	 'text' => '祁华路',
					 	 'longitude' => '121.38016',
					 	 'latitude' => '31.328108'
					 	],
					 	['value' => '110707',
					 	 'text' => '上海大学',
					 	 'longitude' => '121.395296',
					 	 'latitude' => '31.326259'
					 	],
					 	['value' => '110708',
					 	 'text' => '南陈路',
					 	 'longitude' => '121.405224',
					 	 'latitude' => '31.327225'
					 	],
					 	['value' => '110709',
					 	 'text' => '上大路',
					 	 'longitude' => '121.414775',
					 	 'latitude' => '31.321458'
					 	],
					 	['value' => '110710',
					 	 'text' => '场中路',
					 	 'longitude' => '121.420162',
					 	 'latitude' => '31.309963'
					 	],
					 	['value' => '110711',
					 	 'text' => '大场镇',
					 	 'longitude' => '121.422947',
					 	 'latitude' => '31.29971'
					 	],
					 	['value' => '110712',
					 	 'text' => '行知路',
					 	 'longitude' => '121.428059',
					 	 'latitude' => '31.291225'
					 	],
					 	['value' => '110713',
					 	 'text' => '大华三路',
					 	 'longitude' => '121.429488',
					 	 'latitude' => '31.280186'
					 	],
					 	['value' => '110714',
					 	 'text' => '新村路',
					 	 'longitude' => '121.429033',
					 	 'latitude' => '31.270157'
					 	],
					 	['value' => '110715',
					 	 'text' => '岚皋路',
					 	 'longitude' => '121.428339',
					 	 'latitude' => '31.262583'
					 	],
					 	['value' => '110716',
					 	 'text' => '镇坪路',
					 	 'longitude' => '121.437948',
					 	 'latitude' => '31.253378'
					 	],
					 	['value' => '110717',
					 	 'text' => '长寿路',
					 	 'longitude' => '121.444728',
					 	 'latitude' => '31.246285'
					 	],
					 	['value' => '110718',
					 	 'text' => '昌平路',
					 	 'longitude' => '121.448746',
					 	 'latitude' => '31.240476'
					 	],
					 	['value' => '110719',
					 	 'text' => '静安寺',
					 	 'longitude' => '121.455077',
					 	 'latitude' => '31.229262'
					 	],
					 	['value' => '110720',
					 	 'text' => '常熟路',
					 	 'longitude' => '121.455508',
					 	 'latitude' => '31.21999'
					 	],
					 	['value' => '110721',
					 	 'text' => '肇嘉浜路',
					 	 'longitude' => '121.45668',
					 	 'latitude' => '31.205027'
					 	],
					 	['value' => '110722',
					 	 'text' => '东安路',
					 	 'longitude' => '121.460929',
					 	 'latitude' => '31.197571'
					 	],
					 	['value' => '110723',
					 	 'text' => '龙华中路',
					 	 'longitude' => '121.463377',
					 	 'latitude' => '31.19132'
					 	],
					 	['value' => '110724',
					 	 'text' => '后滩',
					 	 'longitude' => '121.480035',
					 	 'latitude' => '31.177884'
					 	],
					 	['value' => '110725',
					 	 'text' => '长清路',
					 	 'longitude' => '121.492645',
					 	 'latitude' => '31.18033'
					 	],
					 	['value' => '110726',
					 	 'text' => '耀华路',
					 	 'longitude' => '121.501124',
					 	 'latitude' => '31.184085'
					 	],
					 	['value' => '110727',
					 	 'text' => '云台路',
					 	 'longitude' => '121.507267',
					 	 'latitude' => '31.187762'
					 	],
					 	['value' => '110728',
					 	 'text' => '高科西路',
					 	 'longitude' => '121.516396',
					 	 'latitude' => '31.191286'
					 	],
					 	['value' => '110729',
					 	 'text' => '杨高南路',
					 	 'longitude' => '121.531652',
					 	 'latitude' => '31.193453'
					 	],
					 	['value' => '110730',
					 	 'text' => '锦绣路',
					 	 'longitude' => '121.546398',
					 	 'latitude' => '31.193767'
					 	],
					 	['value' => '110731',
					 	 'text' => '芳华路',
					 	 'longitude' => '121.556478',
					 	 'latitude' => '31.199531'
					 	],
					 	['value' => '110732',
					 	 'text' => '龙阳路',
					 	 'longitude' => '121.564023',
					 	 'latitude' => '31.209949'
					 	],
					 	['value' => '110733',
					 	 'text' => '花木路',
					 	 'longitude' => '121.569227',
					 	 'latitude' => '31.21757'
					 	],
					 ]
					],
					['value'=>'110800',
					 'text'=>'8号线',
					 'children'=>[
					 	['value' => '110801',
					 	 'text' => '市光路',
					 	 'longitude' => '121.538527',
					 	 'latitude' => '31.328516'
					 	],
					 	['value' => '110802',
					 	 'text' => '嫩江路',
					 	 'longitude' => '121.538559',
					 	 'latitude' => '31.320923'
					 	],
					 	['value' => '110803',
					 	 'text' => '翔殷路',
					 	 'longitude' => '121.538559',
					 	 'latitude' => '31.320923'
					 	],
					 	['value' => '110804',
					 	 'text' => '黄兴公园',
					 	 'longitude' => '121.538472',
					 	 'latitude' => '31.311024'
					 	],
					 	['value' => '110805',
					 	 'text' => '延吉中路',
					 	 'longitude' => '121.541405',
					 	 'latitude' => '31.294724'
					 	],
					 	['value' => '110806',
					 	 'text' => '黄兴路',
					 	 'longitude' => '121.534441',
					 	 'latitude' => '31.284573'
					 	],
					 	['value' => '110807',
					 	 'text' => '江浦路',
					 	 'longitude' => '121.524804',
					 	 'latitude' => '31.280818'
					 	],
					 	['value' => '110808',
					 	 'text' => '鞍山新村',
					 	 'longitude' => '121.516066',
					 	 'latitude' => '31.278923'
					 	],
					 	['value' => '110809',
					 	 'text' => '四平路',
					 	 'longitude' => '121.507816',
					 	 'latitude' => '31.280576'
					 	],
					 	['value' => '110810',
					 	 'text' => '曲阳路',
					 	 'longitude' => '121.497039',
					 	 'latitude' => '31.282122'
					 	],
					 	['value' => '110811',
					 	 'text' => '虹口足球场',
					 	 'longitude' => '121.485963',
					 	 'latitude' => '31.27579'
					 	],
					 	['value' => '110812',
					 	 'text' => '西藏北路',
					 	 'longitude' => '121.47525',
					 	 'latitude' => '31.2694'
					 	],
					 	['value' => '110813',
					 	 'text' => '中兴路',
					 	 'longitude' => '121.475411',
					 	 'latitude' => '31.259035'
					 	],
					 	['value' => '110814',
					 	 'text' => '曲阜路',
					 	 'longitude' => '121.478011',
					 	 'latitude' => '31.248303'
					 	],
					 	['value' => '110815',
					 	 'text' => '人民广场',
					 	 'longitude' => '121.482132',
					 	 'latitude' => '31.238724'
					 	],
					 	['value' => '110816',
					 	 'text' => '大世界',
					 	 'longitude' => '121.485885',
					 	 'latitude' => '31.233127'
					 	],
					 	['value' => '110817',
					 	 'text' => '老西门',
					 	 'longitude' => '121.489485',
					 	 'latitude' => '31.224674'
					 	],
					 	['value' => '110818',
					 	 'text' => '陆家浜路',
					 	 'longitude' => '121.492716',
					 	 'latitude' => '31.217413'
					 	],
					 	['value' => '110819',
					 	 'text' => '西藏南路',
					 	 'longitude' => '121.496122',
					 	 'latitude' => '31.207672'
					 	],
					 	['value' => '110820',
					 	 'text' => '中华艺术宫',
					 	 'longitude' => '121.500749',
					 	 'latitude' => '31.19134'
					 	],
					 	['value' => '110821',
					 	 'text' => '耀华路',
					 	 'longitude' => '121.501124',
					 	 'latitude' => '31.184085'
					 	],
					 	['value' => '110822',
					 	 'text' => '成山路',
					 	 'longitude' => '121.50273',
					 	 'latitude' => '31.176478'
					 	],
					 	['value' => '110823',
					 	 'text' => '杨思',
					 	 'longitude' => '121.50029',
					 	 'latitude' => '31.16671'
					 	],
					 	['value' => '110824',
					 	 'text' => '东方体育中心',
					 	 'longitude' => '121.487012',
					 	 'latitude' => '31.159351'
					 	],
					 	['value' => '110825',
					 	 'text' => '凌兆新村',
					 	 'longitude' => '121.496279',
					 	 'latitude' => '31.146696'
					 	],
					 	['value' => '110826',
					 	 'text' => '芦恒路',
					 	 'longitude' => '121.504377',
					 	 'latitude' => '31.124907'
					 	],
					 	['value' => '110827',
					 	 'text' => '浦江镇',
					 	 'longitude' => '121.512891',
					 	 'latitude' => '31.102197'
					 	],
					 	['value' => '110828',
					 	 'text' => '江月路',
					 	 'longitude' => '121.515133',
					 	 'latitude' => '31.089988'
					 	],
					 	['value' => '110829',
					 	 'text' => '联航路',
					 	 'longitude' => '121.51713',
					 	 'latitude' => '31.079655'
					 	],
					 	['value' => '110830',
					 	 'text' => '沈杜公路',
					 	 'longitude' => '121.518803',
					 	 'latitude' => '31.06706'
					 	],
					 	['value' => '110831',
					 	 'text' => '三鲁公路',
					 	 'longitude' => '121.53011',
					 	 'latitude' => '31.061103'
					 	],
					 	['value' => '110832',
					 	 'text' => '闵瑞路',
					 	 'longitude' => '121.537126',
					 	 'latitude' => '31.054892'
					 	],
					 	['value' => '110833',
					 	 'text' => '浦航路',
					 	 'longitude' => '121.537449',
					 	 'latitude' => '31.047112'
					 	],
					 	['value' => '110834',
					 	 'text' => '东方一路',
					 	 'longitude' => '121.539093',
					 	 'latitude' => '31.035664'
					 	],
					 	['value' => '110835',
					 	 'text' => '汇臻路',
					 	 'longitude' => '121.530137',
					 	 'latitude' => '31.02604'
					 	],
					 ]
					],
					['value'=>'110900',
					 'text'=>'9号线',
					 'children'=>[
					 	['value'=>'110901',
					 	 'text'=>'曹路',
					 	 'longitude'=>'121.689437',
					 	 'latitude'=>'31.277561'
					 	],
					 	['value'=>'110902',
					 	 'text'=>'民雷路',
					 	 'longitude'=>'121.674597',
					 	 'latitude'=>'31.27466'
					 	],
					 	['value'=>'110903',
					 	 'text'=>'顾戴路',
					 	 'longitude'=>'121.662991',
					 	 'latitude'=>'31.272198'
					 	],
					 	['value'=>'110904',
					 	 'text'=>'金海路',
					 	 'longitude'=>'121.645771',
					 	 'latitude'=>'31.269937'
					 	],
					 	['value'=>'110905',
					 	 'text'=>'申江路',
					 	 'longitude'=>'121.633608',
					 	 'latitude'=>'31.269945'
					 	],
					 	['value'=>'110906',
					 	 'text'=>'金桥',
					 	 'longitude'=>'121.619055',
					 	 'latitude'=>'31.266897'
					 	],
					 	['value'=>'110907',
					 	 'text'=>'平度路',
					 	 'longitude'=>'121.602535',
					 	 'latitude'=>'31.257745'
					 	],
					 	['value'=>'110908',
					 	 'text'=>'碧云路',
					 	 'longitude'=>'121.584371',
					 	 'latitude'=>'31.247171'
					 	],
					 	['value'=>'110909',
					 	 'text'=>'芳甸路',
					 	 'longitude'=>'121.564061',
					 	 'latitude'=>'31.237732'
					 	],
					 	['value'=>'110910',
					 	 'text'=>'杨高中路',
					 	 'longitude'=>'121.555022',
					 	 'latitude'=>'31.233791'
					 	],
					 	['value'=>'110911',
					 	 'text'=>'世纪大道',
					 	 'longitude'=>'121.533435',
					 	 'latitude'=>'31.23485'
					 	],
					 	['value'=>'110912',
					 	 'text'=>'商城路',
					 	 'longitude'=>'121.52289',
					 	 'latitude'=>'31.236125'
					 	],
					 	['value'=>'110913',
					 	 'text'=>'小南门',
					 	 'longitude'=>'121.504895',
					 	 'latitude'=>'31.222656'
					 	],
					 	['value'=>'110914',
					 	 'text'=>'陆家浜路',
					 	 'longitude'=>'121.492716',
					 	 'latitude'=>'31.217413'
					 	],
					 	['value'=>'110915',
					 	 'text'=>'马当路',
					 	 'longitude'=>'121.483699',
					 	 'latitude'=>'31.215202'
					 	],
					 	['value'=>'110916',
					 	 'text'=>'打浦桥',
					 	 'longitude'=>'121.475402',
					 	 'latitude'=>'31.212073'
					 	],
					 	['value'=>'110917',
					 	 'text'=>'嘉善路',
					 	 'longitude'=>'121.467263',
					 	 'latitude'=>'31.209004'
					 	],
					 	['value'=>'110918',
					 	 'text'=>'肇嘉浜路',
					 	 'longitude'=>'121.456237',
					 	 'latitude'=>'31.205765'
					 	],
					 	['value'=>'110919',
					 	 'text'=>'徐家汇',
					 	 'longitude'=>'121.443364',
					 	 'latitude'=>'31.202058'
					 	],
					 	['value'=>'110920',
					 	 'text'=>'宜山路',
					 	 'longitude'=>'121.434103',
					 	 'latitude'=>'31.191181'
					 	],
					 	['value'=>'110921',
					 	 'text'=>'桂林路',
					 	 'longitude'=>'121.424982',
					 	 'latitude'=>'31.181001'
					 	],
					 	['value'=>'110922',
					 	 'text'=>'漕河泾开发区',
					 	 'longitude'=>'121.404164',
					 	 'latitude'=>'31.17622'
					 	],
					 	['value'=>'110923',
					 	 'text'=>'合川路',
					 	 'longitude'=>'121.391169',
					 	 'latitude'=>'31.172226'
					 	],
					 	['value'=>'110924',
					 	 'text'=>'星中路',
					 	 'longitude'=>'121.375571',
					 	 'latitude'=>'31.163862'
					 	],
					 	['value'=>'110925',
					 	 'text'=>'七宝',
					 	 'longitude'=>'121.356049',
					 	 'latitude'=>'31.161393'
					 	],
					 	['value'=>'110926',
					 	 'text'=>'中春路',
					 	 'longitude'=>'121.344742',
					 	 'latitude'=>'31.155955'
					 	],
					 	['value'=>'110927',
					 	 'text'=>'九亭',
					 	 'longitude'=>'121.325378',
					 	 'latitude'=>'31.143844'
					 	],
					 	['value'=>'110928',
					 	 'text'=>'泗泾',
					 	 'longitude'=>'121.267259',
					 	 'latitude'=>'31.123976'
					 	],
					 	['value'=>'110929',
					 	 'text'=>'佘山',
					 	 'longitude'=>'121.236257',
					 	 'latitude'=>'31.110609'
					 	],
					 	['value'=>'110930',
					 	 'text'=>'洞泾',
					 	 'longitude'=>'121.237014',
					 	 'latitude'=>'31.090393'
					 	],
					 	['value'=>'110931',
					 	 'text'=>'松江大学城',
					 	 'longitude'=>'121.239201',
					 	 'latitude'=>'31.060041'
					 	],
					 	['value'=>'110932',
					 	 'text'=>'松江新城',
					 	 'longitude'=>'121.237259',
					 	 'latitude'=>'31.036209'
					 	],
					 	['value'=>'110933',
					 	 'text'=>'松江体育中心',
					 	 'longitude'=>'121.237126',
					 	 'latitude'=>'31.022049'
					 	],
					 	['value'=>'110934',
					 	 'text'=>'醉白池',
					 	 'longitude'=>'121.235829',
					 	 'latitude'=>'31.006987'
					 	],
					 	['value'=>'110935',
					 	 'text'=>'松江南站',
					 	 'longitude'=>'121.237677',
					 	 'latitude'=>'30.990955'
					 	],
					 ]
					],
					['value'=>'111000',
					 'text'=>'10号线',
					 'children'=>[
					 	['value'=>'111001',
					 	 'text'=>'新江湾城',
					 	 'longitude'=>'121.513188',
					 	 'latitude'=>'31.334451'
					 	],
					 	['value'=>'111002',
					 	 'text'=>'殷高东路',
					 	 'longitude'=>'121.513177',
					 	 'latitude'=>'31.327743'
					 	],
					 	['value'=>'111003',
					 	 'text'=>'三门路',
					 	 'longitude'=>'121.514701',
					 	 'latitude'=>'31.318613'
					 	],
					 	['value'=>'111004',
					 	 'text'=>'江湾体育场',
					 	 'longitude'=>'121.520633',
					 	 'latitude'=>'31.308746'
					 	],
					 	['value'=>'111005',
					 	 'text'=>'五角场',
					 	 'longitude'=>'121.521191',
					 	 'latitude'=>'31.303805'
					 	],
					 	['value'=>'111006',
					 	 'text'=>'国权路',
					 	 'longitude'=>'121.516743',
					 	 'latitude'=>'31.295352'
					 	],
					 	['value'=>'111007',
					 	 'text'=>'同济大学',
					 	 'longitude'=>'121.51305',
					 	 'latitude'=>'31.288214'
					 	],
					 	['value'=>'111008',
					 	 'text'=>'四平路',
					 	 'longitude'=>'121.50817',
					 	 'latitude'=>'31.280779'
					 	],
					 	['value'=>'111009',
					 	 'text'=>'邮电新村',
					 	 'longitude'=>'121.500859',
					 	 'latitude'=>'31.274187'
					 	],
					 	['value'=>'111010',
					 	 'text'=>'海伦路',
					 	 'longitude'=>'121.495107',
					 	 'latitude'=>'31.264913'
					 	],
					 	['value'=>'111011',
					 	 'text'=>'四川北路',
					 	 'longitude'=>'121.490774',
					 	 'latitude'=>'31.257732'
					 	],
					 	['value'=>'111012',
					 	 'text'=>'天潼路',
					 	 'longitude'=>'121.488783',
					 	 'latitude'=>'31.250088'
					 	],
					 	['value'=>'111013',
					 	 'text'=>'南京东路',
					 	 'longitude'=>'121.49113',
					 	 'latitude'=>'31.244166'
					 	],
					 	['value'=>'111014',
					 	 'text'=>'豫园',
					 	 'longitude'=>'121.4939',
					 	 'latitude'=>'31.234005'
					 	],
					 	['value'=>'111015',
					 	 'text'=>'老西门',
					 	 'longitude'=>'121.489485',
					 	 'latitude'=>'31.224674'
					 	],
					 	['value'=>'111016',
					 	 'text'=>'新天地',
					 	 'longitude'=>'121.481697',
					 	 'latitude'=>'31.222209'
					 	],
					 	['value'=>'111017',
					 	 'text'=>'陕西南路',
					 	 'longitude'=>'121.46449',
					 	 'latitude'=>'31.220989'
					 	],
					 	['value'=>'111018',
					 	 'text'=>'上海图书馆',
					 	 'longitude'=>'121.450771',
					 	 'latitude'=>'31.214439'
					 	],
					 	['value'=>'111019',
					 	 'text'=>'交通大学',
					 	 'longitude'=>'121.440988',
					 	 'latitude'=>'31.208431'
					 	],
					 	['value'=>'111020',
					 	 'text'=>'虹桥路',
					 	 'longitude'=>'121.428753',
					 	 'latitude'=>'31.202856'
					 	],
					 	['value'=>'111021',
					 	 'text'=>'宋园路',
					 	 'longitude'=>'121.418434',
					 	 'latitude'=>'31.202693'
					 	],
					 ]
					],
					['value'=>'111100',
					 'text'=>'11号线',
					 'children'=>[
					 	['value'=>'111101',
					 	 'text'=>'花桥',
					 	 'longitude'=>'121.110706',
					 	 'latitude'=>'31.304845'
					 	],
					 	['value'=>'111102',
					 	 'text'=>'光明路',
					 	 'longitude'=>'121.123995',
					 	 'latitude'=>'31.302118'
					 	],
					 	['value'=>'111103',
					 	 'text'=>'兆丰路',
					 	 'longitude'=>'121.156828',
					 	 'latitude'=>'31.294652'
					 	],
					 	['value'=>'111104',
					 	 'text'=>'安亭',
					 	 'longitude'=>'121.168602',
					 	 'latitude'=>'31.294335'
					 	],
					 	['value'=>'111105',
					 	 'text'=>'上海汽车城',
					 	 'longitude'=>'121.18725',
					 	 'latitude'=>'31.291581'
					 	],
					 	['value'=>'111106',
					 	 'text'=>'昌吉东路',
					 	 'longitude'=>'121.206771',
					 	 'latitude'=>'31.29994'
					 	],
					 	['value'=>'111107',
					 	 'text'=>'上海赛车场',
					 	 'longitude'=>'121.232625',
					 	 'latitude'=>'31.337944'
					 	],
					 	['value'=>'111108',
					 	 'text'=>'嘉定北',
					 	 'longitude'=>'121.24401',
					 	 'latitude'=>'31.397409'
					 	],
					 	['value'=>'111109',
					 	 'text'=>'嘉定西',
					 	 'longitude'=>'121.234404',
					 	 'latitude'=>'31.383236'
					 	],
					 	['value'=>'111110',
					 	 'text'=>'白银路',
					 	 'longitude'=>'121.251801',
					 	 'latitude'=>'31.351371'
					 	],
					 	['value'=>'111111',
					 	 'text'=>'嘉定新城',
					 	 'longitude'=>'121.26104',
					 	 'latitude'=>'31.335744'
					 	],
					 	['value'=>'111112',
					 	 'text'=>'马陆',
					 	 'longitude'=>'121.28343',
					 	 'latitude'=>'31.325402'
					 	],
					 	['value'=>'111113',
					 	 'text'=>'南翔',
					 	 'longitude'=>'121.329748',
					 	 'latitude'=>'31.303357'
					 	],
					 	['value'=>'111114',
					 	 'text'=>'桃浦新村',
					 	 'longitude'=>'121.355937',
					 	 'latitude'=>'31.287647'
					 	],
					 	['value'=>'111115',
					 	 'text'=>'武威路',
					 	 'longitude'=>'121.371318',
					 	 'latitude'=>'31.282825'
					 	],
					 	['value'=>'111116',
					 	 'text'=>'祁连山路',
					 	 'longitude'=>'121.382499',
					 	 'latitude'=>'31.277205'
					 	],
					 	['value'=>'111117',
					 	 'text'=>'李子园',
					 	 'longitude'=>'121.396533',
					 	 'latitude'=>'31.274628'
					 	],
					 	['value'=>'111118',
					 	 'text'=>'上海西站',
					 	 'longitude'=>'121.40794',
					 	 'latitude'=>'31.268542'
					 	],
					 	['value'=>'111119',
					 	 'text'=>'真如',
					 	 'longitude'=>'121.413834',
					 	 'latitude'=>'31.256497'
					 	],
					 	['value'=>'111120',
					 	 'text'=>'枫桥路',
					 	 'longitude'=>'121.41754',
					 	 'latitude'=>'31.248068'
					 	],
					 	['value'=>'111121',
					 	 'text'=>'曹杨路',
					 	 'longitude'=>'121.4241',
					 	 'latitude'=>'31.244107'
					 	],
					 	['value'=>'111122',
					 	 'text'=>'隆德路',
					 	 'longitude'=>'121.430091',
					 	 'latitude'=>'31.236727'
					 	],
					 	['value'=>'111123',
					 	 'text'=>'江苏路',
					 	 'longitude'=>'121.4371',
					 	 'latitude'=>'31.226732'
					 	],
					 	['value'=>'111124',
					 	 'text'=>'交通大学',
					 	 'longitude'=>'121.441394',
					 	 'latitude'=>'31.208906'
					 	],
					 	['value'=>'111125',
					 	 'text'=>'徐家汇',
					 	 'longitude'=>'121.442314',
					 	 'latitude'=>'31.201202'
					 	],
					 	['value'=>'111126',
					 	 'text'=>'上海游泳馆',
					 	 'longitude'=>'121.448026',
					 	 'latitude'=>'31.185365'
					 	],
					 	['value'=>'111127',
					 	 'text'=>'龙华',
					 	 'longitude'=>'121.459229',
					 	 'latitude'=>'31.179259'
					 	],
					 	['value'=>'111128',
					 	 'text'=>'云锦路',
					 	 'longitude'=>'121.464914',
					 	 'latitude'=>'31.17265'
					 	],
					 	['value'=>'111129',
					 	 'text'=>'龙耀路',
					 	 'longitude'=>'121.466',
					 	 'latitude'=>'31.166117'
					 	],
					 	['value'=>'111130',
					 	 'text'=>'东方体育中心',
					 	 'longitude'=>'121.487012',
					 	 'latitude'=>'31.159351'
					 	],
					 	['value'=>'111131',
					 	 'text'=>'三林',
					 	 'longitude'=>'121.517556',
					 	 'latitude'=>'31.148688'
					 	],
					 	['value'=>'111132',
					 	 'text'=>'三林东',
					 	 'longitude'=>'121.529691',
					 	 'latitude'=>'31.152393'
					 	],
					 	['value'=>'111133',
					 	 'text'=>'浦三路',
					 	 'longitude'=>'121.54554',
					 	 'latitude'=>'31.157148'
					 	],
					 	['value'=>'111134',
					 	 'text'=>'御桥',
					 	 'longitude'=>'121.577365',
					 	 'latitude'=>'31.164663'
					 	],
					 	['value'=>'111135',
					 	 'text'=>'罗山路',
					 	 'longitude'=>'121.599723',
					 	 'latitude'=>'31.159221'
					 	],
					 	['value'=>'111136',
					 	 'text'=>'秀沿路',
					 	 'longitude'=>'121.605344',
					 	 'latitude'=>'31.143615'
					 	],
					 	['value'=>'111137',
					 	 'text'=>'康新公路',
					 	 'longitude'=>'121.62383',
					 	 'latitude'=>'31.136033'
					 	],
					 	['value'=>'111138',
					 	 'text'=>'迪士尼',
					 	 'longitude'=>'114.056704',
					 	 'latitude'=>'22.318356'
					 	],
					 ]
					],
					['value'=>'111200',
					 'text'=>'12号线',
					 'children'=>[
					 	['value'=>'111201',
					 	 'text'=>'金海路',
					 	 'longitude'=>'121.645202',
					 	 'latitude'=>'31.268949'
					 	],
					 	['value'=>'111202',
					 	 'text'=>'申江路',
					 	 'longitude'=>'121.633793',
					 	 'latitude'=>'31.285856'
					 	],
					 	['value'=>'111203',
					 	 'text'=>'金京路',
					 	 'longitude'=>'121.622205',
					 	 'latitude'=>'31.285413'
					 	],
					 	['value'=>'111204',
					 	 'text'=>'杨高北路',
					 	 'longitude'=>'121.609423',
					 	 'latitude'=>'31.285852'
					 	],
					 	['value'=>'111205',
					 	 'text'=>'巨峰路',
					 	 'longitude'=>'121.596078',
					 	 'latitude'=>'31.286166'
					 	],
					 	['value'=>'111206',
					 	 'text'=>'东陆路',
					 	 'longitude'=>'121.585248',
					 	 'latitude'=>'31.288712'
					 	],
					 	['value'=>'111207',
					 	 'text'=>'复兴岛',
					 	 'longitude'=>'121.567831',
					 	 'latitude'=>'31.287214'
					 	],
					 	['value'=>'111208',
					 	 'text'=>'爱国路',
					 	 'longitude'=>'121.559427',
					 	 'latitude'=>'31.286351'
					 	],
					 	['value'=>'111209',
					 	 'text'=>'隆昌路',
					 	 'longitude'=>'121.550831',
					 	 'latitude'=>'31.281347'
					 	],
					 	['value'=>'111210',
					 	 'text'=>'宁国路',
					 	 'longitude'=>'121.539069',
					 	 'latitude'=>'31.274769'
					 	],
					 	['value'=>'111211',
					 	 'text'=>'江浦公园',
					 	 'longitude'=>'121.530286',
					 	 'latitude'=>'31.270507'
					 	],
					 	['value'=>'111212',
					 	 'text'=>'大连路',
					 	 'longitude'=>'121.519576',
					 	 'latitude'=>'31.263723'
					 	],
					 	['value'=>'111213',
					 	 'text'=>'提篮桥',
					 	 'longitude'=>'121.51328',
					 	 'latitude'=>'31.259141'
					 	],
					 	['value'=>'111214',
					 	 'text'=>'国际客运中心',
					 	 'longitude'=>'121.504856',
					 	 'latitude'=>'31.255835'
					 	],
					 	['value'=>'111215',
					 	 'text'=>'天潼路',
					 	 'longitude'=>'121.48887',
					 	 'latitude'=>'31.249668'
					 	],
					 	['value'=>'111216',
					 	 'text'=>'曲阜路',
					 	 'longitude'=>'121.478011',
					 	 'latitude'=>'31.248303'
					 	],
					 	['value'=>'111217',
					 	 'text'=>'汉中路',
					 	 'longitude'=>'121.465348',
					 	 'latitude'=>'31.246839'
					 	],
					 	['value'=>'111218',
					 	 'text'=>'南京西路',
					 	 'longitude'=>'121.465932',
					 	 'latitude'=>'31.234138'
					 	],
					 	['value'=>'111219',
					 	 'text'=>'陕西南路',
					 	 'longitude'=>'121.465735',
					 	 'latitude'=>'31.22213'
					 	],
					 	['value'=>'111220',
					 	 'text'=>'嘉善路',
					 	 'longitude'=>'121.467263',
					 	 'latitude'=>'31.209004'
					 	],
					 	['value'=>'111221',
					 	 'text'=>'大木桥路',
					 	 'longitude'=>'121.470103',
					 	 'latitude'=>'31.200369'
					 	],
					 	['value'=>'111222',
					 	 'text'=>'龙华中路',
					 	 'longitude'=>'121.463605',
					 	 'latitude'=>'31.191322'
					 	],
					 	['value'=>'111223',
					 	 'text'=>'龙华',
					 	 'longitude'=>'121.459149',
					 	 'latitude'=>'31.180118'
					 	],
					 	['value'=>'111224',
					 	 'text'=>'龙漕路',
					 	 'longitude'=>'121.450404',
					 	 'latitude'=>'31.176843'
					 	],
					 	['value'=>'111225',
					 	 'text'=>'桂林公园',
					 	 'longitude'=>'121.425093',
					 	 'latitude'=>'31.173038'
					 	],
					 	['value'=>'111226',
					 	 'text'=>'虹漕路',
					 	 'longitude'=>'121.41697',
					 	 'latitude'=>'31.170066'
					 	],
					 	['value'=>'111227',
					 	 'text'=>'虹梅路',
					 	 'longitude'=>'121.403996',
					 	 'latitude'=>'31.165961'
					 	],
					 	['value'=>'111228',
					 	 'text'=>'东兰路',
					 	 'longitude'=>'121.398733',
					 	 'latitude'=>'31.160908'
					 	],
					 	['value'=>'111229',
					 	 'text'=>'顾戴路',
					 	 'longitude'=>'121.398948',
					 	 'latitude'=>'31.14667'
					 	],
					 	['value'=>'111230',
					 	 'text'=>'虹莘路',
					 	 'longitude'=>'121.38597',
					 	 'latitude'=>'31.142943'
					 	],
					 	['value'=>'111231',
					 	 'text'=>'七莘路',
					 	 'longitude'=>'121.369818',
					 	 'latitude'=>'31.137797'
					 	],
					 ]
					],
					['value'=>'111300',
					 'text'=>'13号线',
					 'children'=>[
					 	['value'=>'111301',
					 	 'text'=>'张江路',
					 	 'longitude'=>'121.635791',
					 	 'latitude'=>'31.194911'
					 	],
					 	['value'=>'111302',
					 	 'text'=>'哥白尼路',
					 	 'longitude'=>'121.619105',
					 	 'latitude'=>'31.187779'
					 	],
					 	['value'=>'111303',
					 	 'text'=>'中科路',
					 	 'longitude'=>'121.5998',
					 	 'latitude'=>'31.184284'
					 	],
					 	['value'=>'111304',
					 	 'text'=>'华夏中路',
					 	 'longitude'=>'121.589838',
					 	 'latitude'=>'31.179152'
					 	],
					 	['value'=>'111305',
					 	 'text'=>'莲溪路',
					 	 'longitude'=>'121.572523',
					 	 'latitude'=>'31.175309'
					 	],
					 	['value'=>'111306',
					 	 'text'=>'绿川新村',
					 	 'longitude'=>'121.564919',
					 	 'latitude'=>'31.17892'
					 	],
					 	['value'=>'111307',
					 	 'text'=>'北蔡',
					 	 'longitude'=>'121.559502',
					 	 'latitude'=>'31.186509'
					 	],
					 	['value'=>'111308',
					 	 'text'=>'下南路',
					 	 'longitude'=>'121.544375',
					 	 'latitude'=>'31.184906'
					 	],
					 	['value'=>'111309',
					 	 'text'=>'六里',
					 	 'longitude'=>'121.528978',
					 	 'latitude'=>'31.180917'
					 	],
					 	['value'=>'111310',
					 	 'text'=>'东明路',
					 	 'longitude'=>'121.517785',
					 	 'latitude'=>'31.178511'
					 	],
					 	['value'=>'111311',
					 	 'text'=>'成山路',
					 	 'longitude'=>'121.502644',
					 	 'latitude'=>'31.17707'
					 	],
					 	['value'=>'111312',
					 	 'text'=>'长清路',
					 	 'longitude'=>'121.495175',
					 	 'latitude'=>'31.179623'
					 	],
					 	['value'=>'111313',
					 	 'text'=>'世博大道',
					 	 'longitude'=>'121.490937',
					 	 'latitude'=>'31.18823'
					 	],
					 	['value'=>'111314',
					 	 'text'=>'世博会博物馆',
					 	 'longitude'=>'121.488515',
					 	 'latitude'=>'31.202606'
					 	],
					 	['value'=>'111315',
					 	 'text'=>'马当路',
					 	 'longitude'=>'121.48331',
					 	 'latitude'=>'31.215357'
					 	],
					 	['value'=>'111316',
					 	 'text'=>'新天地',
					 	 'longitude'=>'121.481686',
					 	 'latitude'=>'31.221998'
					 	],
					 	['value'=>'111317',
					 	 'text'=>'淮海中路',
					 	 'longitude'=>'121.470677',
					 	 'latitude'=>'31.226198'
					 	],
					 	['value'=>'111318',
					 	 'text'=>'南京西路',
					 	 'longitude'=>'121.468867',
					 	 'latitude'=>'31.234689'
					 	],
					 	['value'=>'111319',
					 	 'text'=>'自然博物馆',
					 	 'longitude'=>'121.469279',
					 	 'latitude'=>'31.241917'
					 	],
					 	['value'=>'111320',
					 	 'text'=>'汉中路',
					 	 'longitude'=>'121.465326',
					 	 'latitude'=>'31.246847'
					 	],
					 	['value'=>'111321',
					 	 'text'=>'江宁路',
					 	 'longitude'=>'121.450568',
					 	 'latitude'=>'31.250553'
					 	],
					 	['value'=>'111322',
					 	 'text'=>'长寿路',
					 	 'longitude'=>'121.444755',
					 	 'latitude'=>'31.247169'
					 	],
					 	['value'=>'111323',
					 	 'text'=>'武宁路',
					 	 'longitude'=>'121.436675',
					 	 'latitude'=>'31.240291'
					 	],
					 	['value'=>'111324',
					 	 'text'=>'隆德路',
					 	 'longitude'=>'121.429975',
					 	 'latitude'=>'31.236718'
					 	],
					 	['value'=>'111325',
					 	 'text'=>'金沙江路',
					 	 'longitude'=>'121.419507',
					 	 'latitude'=>'31.237991'
					 	],
					 	['value'=>'111326',
					 	 'text'=>'大渡河路',
					 	 'longitude'=>'121.401707',
					 	 'latitude'=>'31.237536'
					 	],
					 	['value'=>'111327',
					 	 'text'=>'真北路',
					 	 'longitude'=>'121.388887',
					 	 'latitude'=>'31.237862'
					 	],
					 	['value'=>'111328',
					 	 'text'=>'祁连山南路',
					 	 'longitude'=>'121.374143',
					 	 'latitude'=>'31.243169'
					 	],
					 	['value'=>'111329',
					 	 'text'=>'丰庄',
					 	 'longitude'=>'121.362183',
					 	 'latitude'=>'31.248367'
					 	],
					 	['value'=>'111330',
					 	 'text'=>'金沙江西路',
					 	 'longitude'=>'121.34169',
					 	 'latitude'=>'31.2474'
					 	],
					 	['value'=>'111331',
					 	 'text'=>'金运路',
					 	 'longitude'=>'121.326035',
					 	 'latitude'=>'31.247368'
					 	],
					 ]
					],
					['value'=>'111400',
					 'text'=>'14号线',
					 'children'=>[
					 	['value'=>'111401',
					 	 'text'=>'封浜',
					 	 'longitude'=>'121.303167',
					 	 'latitude'=>'31.273635'
					 	],
					 	['value'=>'111402',
					 	 'text'=>'金园五路',
					 	 'longitude'=>'121.320091',
					 	 'latitude'=>'31.271598'
					 	],
					 	['value'=>'111403',
					 	 'text'=>'临洮路',
					 	 'longitude'=>'121.337455',
					 	 'latitude'=>'31.269384'
					 	],
					 	['value'=>'111404',
					 	 'text'=>'嘉怡路',
					 	 'longitude'=>'121.352915',
					 	 'latitude'=>'31.265016'
					 	],
					 	['value'=>'111405',
					 	 'text'=>'曹安公路',
					 	 'longitude'=>'121.367521',
					 	 'latitude'=>'31.26223'
					 	],
					 	['value'=>'111406',
					 	 'text'=>'真新新村',
					 	 'longitude'=>'121.380241',
					 	 'latitude'=>'31.260687'
					 	],
					 	['value'=>'111407',
					 	 'text'=>'真光路',
					 	 'longitude'=>'121.390608',
					 	 'latitude'=>'31.258997'
					 	],
					 	['value'=>'111408',
					 	 'text'=>'铜川路',
					 	 'longitude'=>'121.403579',
					 	 'latitude'=>'31.256589'
					 	],
					 	['value'=>'111409',
					 	 'text'=>'真如',
					 	 'longitude'=>'121.412985',
					 	 'latitude'=>'31.256666'
					 	],
					 	['value'=>'111410',
					 	 'text'=>'中宁路',
					 	 'longitude'=>'121.419399',
					 	 'latitude'=>'31.252144'
					 	],
					 	['value'=>'111411',
					 	 'text'=>'东新路',
					 	 'longitude'=>'121.427861',
					 	 'latitude'=>'31.246286'
					 	],
					 	['value'=>'111412',
					 	 'text'=>'武宁路',
					 	 'longitude'=>'121.436925',
					 	 'latitude'=>'31.239547'
					 	],
					 	['value'=>'111413',
					 	 'text'=>'武定路',
					 	 'longitude'=>'121.442988',
					 	 'latitude'=>'31.233349'
					 	],
					 	['value'=>'111414',
					 	 'text'=>'静安寺',
					 	 'longitude'=>'121.451845',
					 	 'latitude'=>'31.228432'
					 	],
					 	['value'=>'111415',
					 	 'text'=>'黄陂南路',
					 	 'longitude'=>'121.479504',
					 	 'latitude'=>'31.229929'
					 	],
					 	['value'=>'111416',
					 	 'text'=>'大世界',
					 	 'longitude'=>'121.486722',
					 	 'latitude'=>'31.232646'
					 	],
					 	['value'=>'111417',
					 	 'text'=>'豫园',
					 	 'longitude'=>'121.494838',
					 	 'latitude'=>'31.235202'
					 	],
					 	['value'=>'111418',
					 	 'text'=>'陆家嘴',
					 	 'longitude'=>'121.509413',
					 	 'latitude'=>'31.241056'
					 	],
					 	['value'=>'111419',
					 	 'text'=>'浦东南路',
					 	 'longitude'=>'121.518369',
					 	 'latitude'=>'31.244163'
					 	],
					 	['value'=>'111420',
					 	 'text'=>'浦东大道',
					 	 'longitude'=>'121.525277',
					 	 'latitude'=>'31.245992'
					 	],
					 	['value'=>'111421',
					 	 'text'=>'源深路',
					 	 'longitude'=>'121.536488',
					 	 'latitude'=>'31.247042'
					 	],
					 	['value'=>'111422',
					 	 'text'=>'巨野路',
					 	 'longitude'=>'121.547448',
					 	 'latitude'=>'31.250507'
					 	],
					 	['value'=>'111423',
					 	 'text'=>'歇浦路',
					 	 'longitude'=>'121.557536',
					 	 'latitude'=>'31.256682'
					 	],
					 	['value'=>'111424',
					 	 'text'=>'龙居路',
					 	 'longitude'=>'121.565198',
					 	 'latitude'=>'31.263527'
					 	],
					 	['value'=>'111425',
					 	 'text'=>'云山路',
					 	 'longitude'=>'121.577765',
					 	 'latitude'=>'31.256998'
					 	],
					 	['value'=>'111426',
					 	 'text'=>'碧云路',
					 	 'longitude'=>'121.584799',
					 	 'latitude'=>'31.246679'
					 	],
					 	['value'=>'111427',
					 	 'text'=>'黄杨路',
					 	 'longitude'=>'121.597357',
					 	 'latitude'=>'31.240196'
					 	],
					 	['value'=>'111428',
					 	 'text'=>'红枫路',
					 	 'longitude'=>'121.60626',
					 	 'latitude'=>'31.242843'
					 	],
					 	['value'=>'111429',
					 	 'text'=>'金港路',
					 	 'longitude'=>'121.621234',
					 	 'latitude'=>'31.247158'
					 	],
					 	['value'=>'111430',
					 	 'text'=>'金粤路',
					 	 'longitude'=>'121.634637',
					 	 'latitude'=>'31.247652'
					 	],
					 	['value'=>'111431',
					 	 'text'=>'金穗路',
					 	 'longitude'=>'121.641473',
					 	 'latitude'=>'31.258665'
					 	],
					 ]
					],
					['value'=>'111500',
					 'text'=>'15号线',
					 'children'=>[
					 	['value'=>'',
						 'text'=>'',
						 'longitude'=>'',
						 'latitude'=>''
						],
					 ]
					],
					['value'=>'111600',
					 'text'=>'16号线',
					 'children'=>[
					 	['value'=>'111601',
					 	 'text'=>'龙阳路',
					 	 'longitude'=>'121.56412',
					 	 'latitude'=>'31.208354'
					 	],
					 	['value'=>'111602',
					 	 'text'=>'华夏中路',
					 	 'longitude'=>'121.589873',
					 	 'latitude'=>'31.18115'
					 	],
					 	['value'=>'111603',
					 	 'text'=>'罗山路',
					 	 'longitude'=>'121.599723',
					 	 'latitude'=>'31.159221'
					 	],
					 	['value'=>'111604',
					 	 'text'=>'周浦东',
					 	 'longitude'=>'121.613533',
					 	 'latitude'=>'31.1158'
					 	],
					 	['value'=>'111605',
					 	 'text'=>'鹤沙航城',
					 	 'longitude'=>'121.617792',
					 	 'latitude'=>'31.083402'
					 	],
					 	['value'=>'111606',
					 	 'text'=>'航头东',
					 	 'longitude'=>'121.624049',
					 	 'latitude'=>'31.060692'
					 	],
					 	['value'=>'111607',
					 	 'text'=>'新场',
					 	 'longitude'=>'121.655259',
					 	 'latitude'=>'31.051489'
					 	],
					 	['value'=>'111608',
					 	 'text'=>'野生动物园',
					 	 'longitude'=>'121.706186',
					 	 'latitude'=>'31.056408'
					 	],
					 	['value'=>'111609',
					 	 'text'=>'惠南',
					 	 'longitude'=>'121.768452',
					 	 'latitude'=>'31.059659'
					 	],
					 	['value'=>'111610',
					 	 'text'=>'惠南东',
					 	 'longitude'=>'121.799711',
					 	 'latitude'=>'31.032764'
					 	],
					 	['value'=>'111611',
					 	 'text'=>'书院',
					 	 'longitude'=>'121.85722',
					 	 'latitude'=>'30.965002'
					 	],
					 	['value'=>'111612',
					 	 'text'=>'临港大道',
					 	 'longitude'=>'121.916746',
					 	 'latitude'=>'30.930354'
					 	],
					 	['value'=>'111613',
					 	 'text'=>'滴水湖',
					 	 'longitude'=>'121.935987',
					 	 'latitude'=>'30.913401'
					 	],
					 ]
					],
					['value'=>'111700',
					 'text'=>'17号线',
					 'children'=>[
					 	['value'=>'111701',
					 	 'text'=>'东方绿洲',
					 	 'longitude'=>'121.016473',
					 	 'latitude'=>'31.10381'
					 	],
					 	['value'=>'111702',
					 	 'text'=>'朱家角',
					 	 'longitude'=>'121.056501',
					 	 'latitude'=>'31.107334'
					 	],
					 	['value'=>'111703',
					 	 'text'=>'淀山湖大道',
					 	 'longitude'=>'121.091571',
					 	 'latitude'=>'31.143132'
					 	],
					 	['value'=>'111704',
					 	 'text'=>'漕盈路',
					 	 'longitude'=>'121.102495',
					 	 'latitude'=>'31.166927'
					 	],
					 	['value'=>'111705',
					 	 'text'=>'青浦',
					 	 'longitude'=>'121.13169',
					 	 'latitude'=>'31.164563'
					 	],
					 	['value'=>'111706',
					 	 'text'=>'汇金路',
					 	 'longitude'=>'121.15898',
					 	 'latitude'=>'31.167004'
					 	],
					 	['value'=>'111707',
					 	 'text'=>'赵巷站',
					 	 'longitude'=>'121.195954',
					 	 'latitude'=>'31.166958'
					 	],
					 	['value'=>'111708',
					 	 'text'=>'嘉松中路',
					 	 'longitude'=>'121.231294',
					 	 'latitude'=>'31.170063'
					 	],
					 	['value'=>'111709',
					 	 'text'=>'徐泾北城',
					 	 'longitude'=>'121.251829',
					 	 'latitude'=>'31.182391'
					 	],
					 	['value'=>'111710',
					 	 'text'=>'徐盈路',
					 	 'longitude'=>'121.26118',
					 	 'latitude'=>'31.184345'
					 	],
					 	['value'=>'111711',
					 	 'text'=>'蟠龙路',
					 	 'longitude'=>'121.285991',
					 	 'latitude'=>'31.192879'
					 	],
					 	['value'=>'111712',
					 	 'text'=>'中国博览会北',
					 	 'longitude'=>'121.300257',
					 	 'latitude'=>'31.19847'
					 	],
					 	['value'=>'111713',
					 	 'text'=>'虹桥火车站',
					 	 'longitude'=>'121.326891',
					 	 'latitude'=>'31.200377'
					 	],
					 ]
					],

				]
			];


	static function getArea($r1,$r2,$r3){
		if (strlen($r1)!=2 || strlen($r2)!=2 || strlen($r3)!=2) {
			return ['value'=>0,'text'=>'error'];
		}
		$id = $r1.$r2.$r3;
		switch ($r1) {
			case 11:
				$conf = static::$metro['children'];
				break;
			case 13:
				$conf = static::$area['children'];
		}
		foreach ($conf as  $child) {
			if($id == $child['value']){
				return $child['text'];
			}
			foreach ($child['children'] as $Grand) {
				if($id == $Grand['value']){
					$father = static::getArea($r1,$r2,'00');
					$Grand['father'] = $father;
					return $Grand;
				}
			}

		}
	}

	static function returnSchoolArea(){
		foreach (static::$area['children'] as $val){
			$res[substr($val['value'],2,2)] = $val['text'];
		}
		return $res;
	}
}