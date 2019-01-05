<?php
//$portCheck='111.111.111.111';
//$usernameCheck='aaaa';
//$passwordCheck='aaaaaa1231';
//$hostnameCheck='aaaaaaa12312';
//$protocolCheck='sdfssf2131';

$flag=0;

$xml=simplexml_load_file("noauth-config.xml") or die("Error: Cannot create object");
foreach($xml->children() as $data) { 
   //echo '<pre>';
   //print_r($data);
   //echo '</pre>';
 

	echo $mainmenu=$data->name[0]; 
	echo '<br>';
	echo $password=$data->menuname[0]; 
	echo '<br>';
	echo $username=$data->link[0]; 
        echo '<br>';
 if($portCheck==$port && $usernameCheck==$username && $passwordCheck==$password)
     {  	
	echo '<br><br>';
	$flag=1;
	break;
 }
} 

/*$file = 'noauth-config.xml';
if($flag==0){

$fullxml=file_get_contents($file);	
$splitvals=explode('</configs>',$fullxml);
$current=$splitvals[0];
$now='<config name="vnc-server" protocol="'.$protocolCheck.'">
<param name="hostname" value="'.$hostnameCheck.'"/>
<param name="port" value="'.$portCheck.'"/>
<param name="password">'.$passwordCheck.'</param>
<param name="username">'.$usernameCheck.'</param>
</config></configs>';

file_put_contents($file,$current.$now);
}*/

/*
$check=xml2array($xml);

   echo '<pre>';
   print_r($check);
   echo '</pre>';*/
?>