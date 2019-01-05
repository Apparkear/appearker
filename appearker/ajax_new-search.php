<?php 
header('Content-Type: application/json');
ob_start();
session_start();

include "administrator/includes/config.php";
include dirname(__FILE__)."/class/class.paginator.php";
ini_set('display_errors', 0);

$distance=1;

$data           = curencyrateAndSymbol();
$convertionRate = $data['rate'];
$symbol         = $data['symbol'];

$current_page = ((isset($_POST['page']))?$_POST['page']:1);
$current_page = (intval($current_page)>99999)?1:intval($current_page);
// $current_page = $current_page+1;
$lat=strip_tags($_POST['lat']);
$lng=strip_tags($_POST['lng']);
$start_date=$_POST['startDateR'];
$end_date=$_POST['startDateR'];
$distance=(intval($_POST['distance'])!=0)?intval($_POST['distance']):1;
$distance=($distance>1)?$distance-1:$distance;
if(isset($_REQUEST['location']) && $_REQUEST['location']!="")
{
	$place=strip_tags($_REQUEST['location']);
	$prepAddr=str_replace(" ", "+",$_REQUEST['location']);
	$geocode   = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false&libraries=places');
	$output    = json_decode($geocode);
	if($lat=="" || $lng==""){
		$lat  = $output->results[0]->geometry->location->lat;
		$lng = $output->results[0]->geometry->location->lng;
	}
}

if($lat=="51.5073509" && $lng=="-0.12775829999998223")
{
	unset($lat);
	unset($lng);
}
$lng=round($lng,6);

if(isset($_POST['filters']) AND is_array($_POST['filters']))
{
	foreach ($_POST['filters'] as $filter_id => $filter) {
		$filter['value']=trim(strip_tags(strtolower($filter['value'])));
		$filter['value']=str_replace("'", "", $filter['value']);
		
		if($filter['value']=="")continue;
		switch ($filter['name']) {
			case 'bed':
				$filter_query['bed'][]="mp.bed_type='{$filter['value']}'";
			break;
			case 'features':
				$filter['value']=intval($filter['value']);

				$query[]="mp.amenities regexp '[[:<:]]{$filter['value']}[[:>:]]'";
			break;

			case 'bills':
				$filter['value']=intval($filter['value']);
				$query[]="mp.bills_include_id regexp '[[:<:]]{$filter['value']}[[:>:]]'";
			break;
			case 'adults':
				// $filter_query['adults'][]="mp.bed_type='{$filter['value']}'";
			break;
			case 'gender':
				$filter_query['gender'][]="mp.preferred_gender='{$filter['value']}'";
			break;
			
			default:
				break;
		}
	}
	foreach ($filter_query as $qfilter) {
		$query[]="(".implode(" OR ", $qfilter).")";
	}

}
if($_POST['priceF'] && $_POST['priceT']){
	$priceF=intval($_POST['priceF']);
	$priceT=intval($_POST['priceT']);
	if($priceF!=0 && $priceT!=0)
	{
		$query[]="mp.price BETWEEN '$priceF' AND '$priceT'";
	}
}

if($query)$ad_query=" AND ".implode(" AND ",$query);
// die($ad_query);
$query="";

// `start_date`>='" . $start_date . "' and `end_date`<='" . $end_date . "' and
if($lng!="" && $lat!="")
{
	$num['count']= mysql_num_rows(mysql_query("SELECT mp.lng as lng,( 3959 * acos( cos( radians(" . $lat . ") ) * cos( radians(lat) ) * cos( radians(lng) - radians(" . $lng . ") ) + sin( radians(" . $lat . ") ) * sin(radians(lat)) ) ) AS distance FROM `estejmam_main_property` mp where `status`=1 AND mp.id not in (select prop_id from `estejmam_booking` where `status`=1) $ad_query HAVING distance < " . $distance . " OR distance is NULL"));
	// echo("SELECT mp.lng as lng,( 3959 * acos( cos( radians(" . $lat . ") ) * cos( radians(lat) ) * cos( radians(lng) - radians(" . $lng . ") ) + sin( radians(" . $lat . ") ) * sin(radians(lat)) ) ) AS distance FROM `estejmam_main_property` mp where `status`=1 AND mp.id not in (select * from `estejmam_booking` where  `status`=1) HAVING distance < " . $distance . " OR distance is NULL");

}else{
	// 
	$num=mysql_fetch_array(mysql_query("SELECT count(*) as count FROM estejmam_main_property mp where `status`='1' AND mp.id not in (select prop_id from `estejmam_booking` where `status`=1) $ad_query"));
}
$PHP_SELF=SITE_URL."search-listing/";
$perpage=26;
$pagination = new Pagination($current_page,$perpage);
$pages = $pagination->CreatePages($num['count'],"simple",5);
$start = $pagination->_start;
$json=array();
// TMP CONFIG 
$all= $pagination->_arrayPages;
$json['paginate_links'] = $pagination->_indexes;
$last = $pagination->_totalPages;
$json['prevpage'] =  $pagination->_previousPage;
$json['nextpage'] =  $pagination->_nextPage;
$json['distance'] =  $distance;

// var_dump($last);

if($lng!="" && $lat!="")
{
	
	$proplistSql = "SELECT tm.station_name, tm.distance as tubedistance, tm.logo,GROUP_CONCAT(img.image SEPARATOR '||') as imgs,mp.*,mp.lat as lat,mp.lng as lng,( 3959 * acos( cos( radians(" . $lat . ") ) * cos( radians(lat) ) * cos( radians(lng) - radians(" . $lng . ") ) + sin( radians(" . $lat . ") ) * sin(radians(lat)) ) ) AS distance FROM `estejmam_main_property` mp left join estejmam_tubemap tm on tm.prop_id=mp.id left join estejmam_image img on img.prop_id=mp.id  where `status`=1 $ad_query GROUP by mp.id HAVING distance < " . $distance . " OR distance is NULL ORDER by distance  Limit $start,$perpage";
}else{
	$proplistSql="SELECT tm.station_name, tm.distance, tm.logo,mp.*,GROUP_CONCAT(img.image SEPARATOR '||') as imgs FROM estejmam_main_property mp left join estejmam_tubemap tm on tm.prop_id=mp.id left join estejmam_image img on img.prop_id=mp.id where mp.status='1' AND mp.id not in (select prop_id from `estejmam_booking` where `status`=1) $ad_query GROUP BY mp.id Limit $start,$perpage";	
}
// echo $proplistSql;
// die();
// echo $proplistSql;
$query=mysql_query($proplistSql);
// ALL estejmam_amenities
$amenities_query=mysql_query("SELECT id,name,img,type FROM estejmam_amenities order by id");
while ($amenitie = mysql_fetch_array($amenities_query)) {
	$amenities[$amenitie['id']]['name']=stripslashes($amenitie['name']);
	$amenities[$amenitie['id']]['img']=stripslashes($amenitie['img']);
	$amenities[$amenitie['id']]['type']=stripslashes($amenitie['type']);		
}

while ($row=mysql_fetch_array($query)) {
	$data=array();
	$i++;
	$prop_amenities=explode(",",$row['amenities']);
	$amenitiesv=array();
	$img_url=array();
	foreach ($prop_amenities as $key) {
		if($amenities[$key]['name'])
		{
			$amenitiesv[]="<li><img class=\"c-property-card__amenities-icon\" src=\"/newdes/img/icons/Amenities/{$amenities[$key]['img']}\"/>{$amenities[$key]['name']}</li>";
		}
	}
	$images=explode("||",$row['imgs']);

	foreach ($images as $image) {
		if($image)$img_url[]="/upload/property/".$image;
	}
	$data['name']=stripslashes($row['name']);
	$data['price']="$symbol".round($row['price'],0);
	$data['slide']=$img_url;
	// $data['url']=SITE_URL."details/".$row['unique_prop_id'];;
	$data['url']=SITE_URL."london/".UrlGen($row['neighborhood'])."/room-rent/".UrlGen($row['name'])."-".$row['id']."/";
	$data['uid']=$row['id'];
	$data['tubetype']=$row['logo'];
	$data['transpotation']=strip_tags($row['station_name']. " (".$row['tubedistance']." Distance)");
	$data['amenities']=implode("",$amenitiesv);
	$geo[$row['id']]['latitude']=$row['lat'];
	$geo[$row['id']]['longitude']=$row['lng'];
	$geo[$row['id']]['uid']=$row['id'];
	$rand=rand(1,10);
	if($rand%2)
	{
		$data['randdata']=intval(rand(2,10))." people are looking right now";
	}
	 // $data['randdata']=$rand%2;
	$data['addinfo']="somebody will book it!";
	// $result[]=json_encode($data);
	$json['room'][]=($data);
	// $geoJS[]=json_encode($geo);
}
$json['geo']=array_values($geo);
// $json['geo']=json_decode($geoJS);
// $data['more']=true;
$pages="";

if($current_page!=1){

	$pages.="<li><a href=\"$PHP_SELF?page=$prev\" aria-label=\"Previous\"><span aria-hidden=\"true\">«</span></a></li>";
}


if($last!=$current_page) {

	$pages.="<li><a href=\"$PHP_SELF?page=$next\" aria-label=\"Next\"><span aria-hidden=\"true\">»</span></a></li>";
}

$total=$num['count'];
$pages=json_encode($pagea);

$json['total']=$total;
$json['total_pages']=count($all);
$json['currpage']=$current_page;

echo json_encode($json);

?>