<?php
require_once('./LINEBotTiny.php');
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../scr/LINEBot/HTTPClient.php';
require_once __DIR__ . '/../scr/LINEBot/Constant/Meta.php';
require_once __DIR__ . '/../scr/LINEBot.php';
require_once __DIR__ . '/../scr/LINEBot/HTTPClient/CurlHTTPClient.php';
require_once __DIR__ . '/../scr/LINEBot/HTTPClient/Curl.php';
require_once __DIR__ . '/../scr/LINEBot/Response.php';
require_once __DIR__ . '/../scr/LINEBot/Constant/MessageType.php';
require_once __DIR__ . '/../scr/LINEBot/MessageBuilder.php';
require_once __DIR__ . '/../scr/LINEBot/MessageBuilder/TextMessageBuilder.php';
require_once __DIR__ . '/../scr/LINEBot/MessageBuilder/StickerMessageBuilder.php';
require_once __DIR__ . '/../scr/LINEBot/MessageBuilder/LocationMessageBuilder.php';
require_once __DIR__ . '/../scr/LINEBot/MessageBuilder/MultiMessageBuilder.php';
require_once __DIR__ . '/../scr/LINEBot/TemplateActionBuilder.php';
require_once __DIR__ . '/../scr/LINEBot/Constant/ActionType.php';
require_once __DIR__ . '/../scr/LINEBot/TemplateActionBuilder/PostbackTemplateActionBuilder.php';
require_once __DIR__ . '/../scr/LINEBot/MessageBuilder/TemplateBuilder.php';
require_once __DIR__ . '/../scr/LINEBot/Constant/TemplateType.php';
require_once __DIR__ . '/../scr/LINEBot/MessageBuilder/TemplateBuilder/ConfirmTemplateBuilder.php';
require_once __DIR__ . '/../scr/LINEBot/MessageBuilder/TemplateMessageBuilder.php';
$channelAccessToken = getenv('LINE_CHANNEL_ACCESSTOKEN');
$channelSecret = getenv('LINE_CHANNEL_SECRET');
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($channelAccessToken);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret ]);
$client = new LINEBotTiny($channelAccessToken, $channelSecret);
foreach ($client->parseEvents() as $event) {
	switch ($event['type']) {
		case 'message':
			$message = $event['message'];		
			switch ($message['type']) {
				case 'text':
					$m_message = $message['text'];
					$type = $message['type'];
			    		$source=$event['source'];     	   
			    		$userId=$source['userId'];			
			    		$roomid=$source['roomId'];
			    		$groupid=$source['groupId'];
			    		$replyToken=$event['replyToken'];
			    		$type2=$event['type'];
			    		$timestamp=$event['timestamp'];
			    		$response = $bot->getProfile($userId);
			    		$profile = $response->getJSONDecodedBody();
					$displayname=$profile['displayName'];
			    		date_default_timezone_set('Asia/Taipei');	   
			    		$time=date("Y-m-d H:i:s");
					$mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy", "fu7wm9fyq2nkgeuk","3306");
					$join=false;
					$unjoin=false;
					$sql = "SELECT inside from ininin";
					$result = $mysqli->query($sql);
					while($row = $result->fetch_array(MYSQLI_BOTH)){
						$inside = $row['inside'] ;
						if(preg_match("/$inside/i","$m_message")){
  							$join=true;
						}
					}
					$sql = "SELECT outside from ininin";
					$result = $mysqli->query($sql);
					while($row = $result->fetch_array(MYSQLI_BOTH)){
						$outside = $row['outside'] ;
						if(preg_match("/$outside/i","$m_message")){
							$unjoin=true;
						}
					}
					
				if($join && strlen($m_message)<"15"){
					$sql = "select number from 304ex";
							$result = $mysqli->query($sql);
					    		while($row = $result->fetch_array(MYSQLI_BOTH)) {
						    		$a = $row['number'] ;
					    		}
					    		$a+=1;
					$sql="INSERT INTO 304ex (number,name,userid,msg,worktype,worktime) VALUES ('$a','$displayname','$userId','$m_message','進','$time')";
					$result = $mysqli->query($sql);
				}else if($unjoin && strlen($m_message)<"15"){
					$sql = "select number from 304ex";
							$result = $mysqli->query($sql);
					    		while($row = $result->fetch_array(MYSQLI_BOTH)) {
						    		$a = $row['number'] ;
					    		}
					    		$a+=1;
					$sql="INSERT INTO 304ex (number,name,userid,msg,worktype,worktime) VALUES ('$a','$displayname','$userId','$m_message','出','$time')";
					$result = $mysqli->query($sql);
				}else{
					$sql = "select number from 304ex";
							$result = $mysqli->query($sql);
					    		while($row = $result->fetch_array(MYSQLI_BOTH)) {
						    		$a = $row['number'] ;
					    		}
					    		$a+=1;
				$sql="INSERT INTO 304ex (number,name,userid,msg,worktype,worktime) VALUES ('$a','$displayname','$userId','$m_message','無','$time')";
				$result = $mysqli->query($sql);
			}
			    		break;
			}
			break;
		default:
			error_log("Unsupporeted event type: " . $event['type']);  
			break; 
	}
}
