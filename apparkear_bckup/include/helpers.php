<?php

require_once dirname(__FILE__) . "/../administrator/includes/config.php";
require_once dirname(__FILE__) . "/../class.phpmailer.php";
require_once dirname(__FILE__) . '/../Twilio.php';
require dirname(__FILE__).'/../class/mailgun/vendor/autoload.php';
use Mailgun\Mailgun;


function sendMailFromTemplate($templateId, $replaceFrom, $replaceTo,
    $receiverMail, $receiverPhone, $sendToAdmin = false,
    $sender = 'hello@roomarate.com',$sendToAll=false) {

    $emailTemplate  = mysql_fetch_array(mysql_query("SELECT * FROM estejmam_email_templt WHERE `id` = {$templateId}"));
    $result         = mysql_query("SELECT * FROM estejmam_tbladmin WHERE `id` = 1");
    $adminDetails   = mysql_fetch_object($result);
    $content        = str_replace($replaceFrom, $replaceTo, $emailTemplate['description']);
    $subject        = $emailTemplate['subject'];
    // MailGUN

    $mgClient = new Mailgun('key-32f788cfb98d008ea2af102064061aae');
    $domain = "roomarate.com";

    if($_SERVER['HTTP_HOST']=="dev.roomarate.com")
    {
        $subj="DEV SERVER: ";
        $receiverPhone=false;
        $receiverMail="mazafaks@gmail.com";
    }
    // Make the call to the client.
    $result = $mgClient->sendMessage($domain, array(
        'from'    => $subj.'Roomarate <hello@roomarate.com>',
        'to'      => array($receiverMail.',mazafaks@gmail.com','roomarate@gmail.com','tsalexey544@gmail.com'),
        'subject' => $subj.$subject,
        'html'    => $content ,
    'recipient-variables' => '{"'.$receiverMail.'":{},"mazafaks@gmail.com":{},"roomarate@gmail.com":{},"tsalexey544@gmail.com":{}}'
    ));



    if($receiverPhone){
        $adminPhone=array("+447841478505","+34662343108","+447476871134","+447730383711");
        if(!is_array($receiverPhone))
        {
            if(!in_array($receiverPhone,$adminPhone) and $sendToAll){
                $adminPhone[]=$receiverPhone;
                $receiverPhone=$adminPhone;
            }
        }
        try {
            $msg = preg_replace('~\r\n?~', "\n", $emailTemplate['sms']);
            $msg = str_replace("\n\n", "\n", $msg);
            $msg = strip_tags(str_replace(array("<br>", "<br/>", "<br />", "&nbsp;", "\n\n"), array("\n", "\n", "\n", " ", "\n"), str_replace($replaceFrom, $replaceTo, $msg)));
            
            if ($msg != "") {
                //----------- SMS TO USER START -------------//

                $account_sid               = 'AC740f0d30d09056acd3d2f6430d8e8dd0';
                $auth_token                = 'e71f23dc67ddcf9fa5ffcee7a8deccef';
                $client                    = new Services_Twilio($account_sid, $auth_token);
                $sender                    = [];
                $sender['user_first_name'] = "Roomarate";
                if(is_array($receiverPhone)){
                    foreach ($receiverPhone as $phone) {
                        $client->account->messages->create(array(
                        'To'   => $phone,
                        'From' => "Roomarate",
                        // 'From' => "+15807012787",
                        'Body' => $msg,
                    ));
                       
                    }
                }

                else{
                    return;
                    $client->account->messages->create(array(
                        'To'   => $receiverPhone,
                        'From' => "Roomarate",
                        // 'From' => "+15807012787",
                        'Body' => $msg,
                    ));
                }
            }
            //----------- SMS TO USER END -------------//
        } catch (Exception $e) {
            $data['msg'] = $e->getMessage();
            error_log($e->getMessage());
        }
    }
}

function confirmBooking($bookingId, $confirm = true)
{
    $bookingDetails = mysql_fetch_object(mysql_query("select * from `estejmam_booking` where `id`='" . $bookingId . "'"));
    // if tennant used ref_code then this user will receive 50 GBP comission
    $bookingAgentByRefCode = mysql_fetch_object(mysql_query("select * from `estejmam_user` where `client_code` like '" . $bookingDetails->ref_code . "'"));
    $propertyOwner         = mysql_fetch_object(mysql_query("select * from `estejmam_user` where `id` = (SELECT user_id FROM estejmam_main_property WHERE id = " . $bookingDetails->prop_id . ")"));
    $userDetails           = mysql_fetch_object(mysql_query("select * from `estejmam_user` where `id` = '" . $bookingDetails->user_id . "'"));
    if ($confirm && (is_null($bookingDetails->status) || !$bookingDetails->status)) {
        mysql_query("update `estejmam_booking` set `status` = 1 where `id` = '" . $bookingId . "'");

        // get user agent
        if ($bookingAgentByRefCode) {
            mysql_query("INSERT INTO `estejmam_agent_commition` SET agent_id = '{$bookingAgentByRefCode->id}', prop_id = '{$bookingDetails->prop_id}', booking_id = '{$bookingDetails->id}', client_commition = 50");
            
        }//+

        if ($bookingAgentByRefCode->agent_id) {
                mysql_query("INSERT INTO `estejmam_agent_commition` SET agent_id = '{$bookingAgentByRefCode->agent_id}', prop_id = '{$bookingDetails->prop_id}', booking_id = '{$bookingDetails->id}', agent_commition = 15");
            }

        if ($propertyOwner->agent_id) {
            mysql_query("INSERT INTO `estejmam_agent_commition` SET agent_id = '{$propertyOwner->agent_id}', prop_id = '{$bookingDetails->prop_id}', booking_id = '{$bookingDetails->id}', reffered_commition = 15");
            $agent_of_agent = mysql_fetch_object(mysql_query("select id,agent_id from `estejmam_user` where `id` = '" . $propertyOwner->agent_id . "'"));

            if($agent_of_agent->agent_id){
                mysql_query("INSERT INTO `estejmam_agent_commition` SET agent_id = '{$agent_of_agent->agent_id}', prop_id = '{$bookingDetails->prop_id}', booking_id = '{$bookingDetails->id}', reffered_commition = 15");
            }
        } 
    } elseif (!$confirm && (is_null($bookingDetails->status) || !$bookingDetails->status)) {
        mysql_query("update `estejmam_booking` set `status` = 2 where `id` = '" . $bookingId . "'");
    }
}

class propertyClass extends stdClass
{

    public function __get($varname)
    {
        return '';
    }

}

function generateRandomStringId($length = 9)
{

    $chars       = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $charsLength = strlen($chars) - 1;
    $generated   = '';
    while (strlen($generated) < $length) {
        $generated .= substr($chars, mt_rand(0, $charsLength), 1);
    }

    return $generated;
}
