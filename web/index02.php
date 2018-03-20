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
	$channel_id = "{1537195749}";
	$channel_secret = "{f09490cd01d030f3bed923ab84c529cd}";
	$channel_access_token = "{d94WAvqAJBWRXZ3pmnlejuQ7S/Glp8CDK0FHSSLEWlypMdpiPerBs23gk/xsbQjT31RHVd1iq4YVMqqLbYiRRA0AnDPQohV2zFBBwMBK5JchWjB47muK5uiHL2l/JvkepuraSTviQNaPxMjKM7z/jwdB04t89/1O/w1cDnyilFU=}";
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
    global $header, $from, $receive;
	 	
		$url = "https://api.line.me/v2/bot/message/push";
		
		$data = ["to" => $from, "messages" => array(["type" => "text", "text" => $message])];
		
		switch($content_type) {
		
			case "text" :
				$content_type = "文字訊息";
				$data = ["to" => $from, "messages" => array(["type" => "text", "text" => $message])];
				break;
       $context = stream_context_create(array(
		"http" => array("method" => "POST", "header" => implode(PHP_EOL, $header), "content" => json_encode($data), "ignore_errors" => true)
		));
		file_get_contents($url, false, $context);
	}
	function getObjContent($filenameExtension){
		
	global $channel_access_token, $receive;
	
	$objID = $receive->events[0]->message->id;
	$url = 'https://api.line.me/v2/bot/message/'.$objID.'/content';
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Authorization: Bearer {' . $channel_access_token . '}',
	));
	
	$json_content = curl_exec($ch);
	curl_close($ch);

	if (!$json_content) {
		return false;
	}
	
	$fileURL = './update/'.$objID.'.'.$filenameExtension;
	$fp = fopen($fileURL, 'w');
	fwrite($fp, $json_content);
	fclose($fp);
		
	if ($filenameExtension=="mp3"){
	    //使用getID3套件分析mp3資訊
		require_once("getID3/getid3/getid3.php");
		$getID3 = new getID3;
		$fileData = $getID3->analyze($fileURL);
		//$audioInfo = var_dump($fileData);
		$playSec = floor($fileData["playtime_seconds"]);
		$re = array($myURL.$objID.'.'.$filenameExtension, $playSec*1000);
		return $re;
	}
	return $myURL.$objID.'.'.$filenameExtension;
}
}
