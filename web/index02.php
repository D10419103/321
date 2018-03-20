<?php
//require_once('./LINEBotTiny.php');
require('../vendor/autoload.php');
require_once __DIR__ . '/../scr/LINEBot.php';
require_once __DIR__ . '/../scr/LINEBot/Response.php';
require_once __DIR__ . '/../scr/LINEBot/Constant/Meta.php';
require_once __DIR__ . '/../scr/LINEBot/HTTPClient.php';
require_once __DIR__ . '/../scr/LINEBot/HTTPClient/Curl.php';
require_once __DIR__ . '/../scr/LINEBot/Constant/MessageType.php';
require_once __DIR__ . '/../scr/LINEBot/MessageBuilder.php';
require_once __DIR__ . '/../scr/LINEBot/HTTPClient/CurlHTTPClient.php';
require_once __DIR__ . '/../scr/LINEBot/MessageBuilder/TextMessageBuilder.php';

/*$channelAccessToken = getenv('LINE_CHANNEL_ACCESSTOKEN');
$channelSecret = getenv('LINE_CHANNEL_SECRET');
*/
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($channelAccessToken);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret ]);
//$client = new LINEBotTiny($channelAccessToken, $channelSecret);

$receive = json_decode(file_get_contents("php://input"));
	
	// 讀取收到的訊息內容
	$text = $receive->events[0]->message->text;
	
	// 讀取訊息來源的類型 	[user, group, room]
	$type = $receive->events[0]->source->type;
	
	// 由於新版的Messaging Api可以讓Bot帳號加入多人聊天和群組當中
	// 所以在這裡先判斷訊息的來源
	if ($type == "room")
	{
		// 多人聊天 讀取房間id
		$from = $receive->events[0]->source->roomId;
	} 
	else if ($type == "group")
	{
		// 群組 讀取群組id
		$from = $receive->events[0]->source->groupId;
	}
	else
	{
		// 一對一聊天 讀取使用者id
		$from = $receive->events[0]->source->userId;
	}
	
	// 讀取訊息的型態 [Text, Image, Video, Audio, Location, Sticker]
	$content_type = $receive->events[0]->message->type;
	
	// 準備Post回Line伺服器的資料 
	$header = ["Content-Type: application/json", "Authorization: Bearer {" . $channel_access_token . "}"];
	
	// 回覆訊息
	reply($content_type, $text);

function reply($content_type, $message) {
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
                    $cool=mysqli_query($mysqli,"select Q from test where cool=456");
			        if(mysqli_connect_errno()){ 
                        $debugmsg='資料庫連線失敗';
                    }
                    else{
					    $mysqli->close();
				    }
                    if($m_message=="安安"){
                       $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($cool);
$response = $bot->replyMessage($replyToken, $textMessageBuilder);
		    }
                    break;
            }
            break;
        default:
            error_log("Unsupporeted event type: " . $event['type']);
            break;
    }
}
