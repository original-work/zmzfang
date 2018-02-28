<html>
<title>test</title>
<?php
header("Content-Type:text/html;charset=utf-8");
$name=$_REQUEST['name'];
$url=$_REQUEST['url'];
$params=$_REQUEST['params'];
$paramarray=[];
if(!empty($params)){
$paramarray=explode(',',$params);
}
?>
<head>
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript" src="sendajax.js"></script>
<script type="text/javascript">
$(function() {
	  <!--*******************************************************************************-->
		$("#requestinterface").click(function() {
		var url = "/index.php?r=<?=$url?>";
		var paramstr ='';
		<?php 
			$paramcnt=0;
			foreach ($paramarray as $param){ 
				   $paramcnt++;
				   if($paramcnt==1){
		?>
  				 			paramstr =paramstr+'{"<?=$param?>":"'+$("#<?=$param?>").val();
  	<?php
					 } else {
		?>
  							paramstr =paramstr+'","<?=$param?>":"'+$("#<?=$param?>").val();
  	<?php
  					}
			} 
		  if($paramcnt>0){
		?>
		  		paramstr =paramstr+'"}' ;
		<?php
  		}
		?>
		//alert(paramstr);
		$("#jsonparams").val(paramstr);
		sendajax(url,paramstr);
		});
		
		$("#requestuseparam").click(function() {
				var url = "/index.php?r=<?=$url?>";
				var paramstr =$("#jsonparams").val();
				sendajax(url,paramstr);
		});
		<!--******************************************************************************-->
});
</script>
</head>
<body>
	<!-- 
<p><label for="name">phonenumber:</label>
<input id="phonenumber" name="phonenumber" type="text" />
</p>
-->
<?php 
   foreach($paramarray as $param){ 
?>
   <p><?=$param?>:<input id="<?=$param?>" name="<?=$param?>" type="text" />
<?php
	} 
?>
</p>
<p>
<input id="requestinterface" type="button" value="<?=$name?>"/>
</p>
<span>params:</span>
<textarea id="jsonparams" type="text" style="width:100%;"></textarea>
</p>
<input id="requestuseparam" type="button" value="<?=$name?>[useparams]"/>

<p><span>URL:</span><span id="requesturl">/index.php?r=<?=$url?></span></p>
<p><span id="retcontent"></span></p>
</body>
</html>
