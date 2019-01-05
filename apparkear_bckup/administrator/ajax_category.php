<?php
ob_start();
session_start();
include('includes/config.php');


if(isset($_REQUEST['action']) == 'cat')
    {
        $catid = $_REQUEST['id'];
       
        $sql_city = mysql_query("SELECT * FROM `estejmam_subcategory` WHERE `cat_id` = '".$catid."'");
        while($row_city = mysql_fetch_array($sql_city))
        {
?>
    <option value="<?php echo $row_city['id'] ?>"><?php echo $row_city['name'] ?></option>
<?php
        }
        
    }
    
    
    
?>

    
    
   