<?php
ob_start();
session_start();
include('administrator/includes/config.php');

    
    
    if($_REQUEST['action']=='deleteImg')
    {
     $details=array();
    $id=$_REQUEST['id'];
    $query="Select * FROM estejmam_moreimage where id=".$id."";
    $res=mysql_query($query);
    $row=mysql_fetch_assoc($res);
    
    if($row['image']!="")
    {
    unlink("upload/product/".$row['image']);
    
    
    }
    
   $sql=" DELETE FROM estejmam_moreimage where id=".$id."";
    $res=mysql_query($sql);
    if($res)
    {
    $details['ack']=1;
    
    }
    else
    {
     $details['ack']=0;
    }
    
    
    
    
    echo json_encode($details);
    
    }
    
    
        
    if($_REQUEST['action']=='deleteImgClassified')
    {
     $details=array();
    $id=$_REQUEST['id'];
    $query="Select * FROM estejmam_moreimage_classified where id=".$id."";
    $res=mysql_query($query);
    $row=mysql_fetch_assoc($res);
    
    if($row['image']!="")
    {
    unlink("upload/classified/".$row['image']);
    
    
    }
    
   $sql=" DELETE FROM estejmam_moreimage where id=".$id."";
    $res=mysql_query($sql);
    if($res)
    {
    $details['ack']=1;
    
    }
    else
    {
     $details['ack']=0;
    }
    
    
    
    
    echo json_encode($details);
    
    }
    
    
    
?>
