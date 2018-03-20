<?php
require_once('./LINEBotTiny.php');
require_once __DIR__ . '/../scr/LINEBot.php';
require_once __DIR__ . '/../scr/LINEBot/Response.php';
require_once __DIR__ . '/../scr/LINEBot/Constant/Meta.php';
require_once __DIR__ . '/../scr/LINEBot/HTTPClient.php';
require_once __DIR__ . '/../scr/LINEBot/HTTPClient/Curl.php';
require_once __DIR__ . '/../scr/LINEBot/Constant/MessageType.php';
require_once __DIR__ . '/../scr/LINEBot/MessageBuilder.php';
require_once __DIR__ . '/../scr/LINEBot/HTTPClient/CurlHTTPClient.php';
require_once __DIR__ . '/../scr/LINEBot/MessageBuilder/TextMessageBuilder.php';
USE fu7wm9fyq2nkgeuk;
$channelAccessToken = getenv('LINE_CHANNEL_ACCESSTOKEN');
$channelSecret = getenv('LINE_CHANNEL_SECRET');
$client = new LINEBotTiny($channelAccessToken, $channelSecret);
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($channelAccessToken);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);
foreach ($client->parseEvents() as $event) {
    switch ($event['type']) {
        case 'message':
            $message = $event['message'];
            switch ($message['type']) {
                case 'text':
                    $replyToken=$event['replyToken'];
                	$m_message = $message['text']; $source=$event['source']; $idtype = $source['type'];  $id=$source['userId'];
                    $roomid=$source['roomId']; $groupid=$source['groupId'];
                    $pictureUrl=$message['pictureUrl'];$res = $bot->getProfile($id);$profile = $res->getJSONDecodedBody();
                    $displayName = $profile['displayName'];
                    date_default_timezone_set('Asia/Taipei');
                    $debugmsg='123456';
                    $mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy", "fu7wm9fyq2nkgeuk","3306");
                    $cool=mysqli_query($mysqli,"select Q from test");
			        if(mysqli_connect_errno()){ 
                        $debugmsg='資料庫連線失敗';
                    }
                    else{
					    $mysqli->close();
				    }
                    if($m_message=="安安"){
                       $client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                                'type' => 'text',
				                'text' => $cool
                            )	
                        )));
		    }
                    break;
            }
            break;
        default:
            error_log("Unsupporeted event type: " . $event['type']);
            break;
    }
}
