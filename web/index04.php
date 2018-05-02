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
					$key=rand(1000,9999);
			    		$time=date("Y-m-d H:i:s");
					$mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy", "fu7wm9fyq2nkgeuk","3306");
			            $sql="select numbercode from code where userid='$userId'";
				$result = $mysqli->query($sql);
						while($row = $result->fetch_array(MYSQLI_BOTH)) {
							$numbercode = $row['numbercode'];
						}
					if($m_message =="進" && $m_message!=$numbercode){
						$mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy", "fu7wm9fyq2nkgeuk","3306");
			            $sql="INSERT INTO code (numbercode,userid) VALUES ('$key','$userId')";
			            $result = $mysqli->query($sql);
						$msg = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($key);
                        $bot->replyMessage($replyToken,$msg);
			}$standard_A = "/^([0-9]+)$/"; 
			if ($m_message== $numbercode ) {
				$sql="INSERT INTO code (msg) VALUES ('ok')";
							$result = $mysqli->query($sql);
				$msg = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("驗證成功");
                        $bot->replyMessage($replyToken,$msg);
							$sql="delete from code where numbercode='$m_message'";
							$result = $mysqli->query($sql);	
					
					}else if (checkString($m_message, $standard_A)){
				$msg = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("驗證失敗");
                        $bot->replyMessage($replyToken,$msg);
			}
			    		break;
			}
			break;
		default:
			error_log("Unsupporeted event type: " . $event['type']);  
			break; 
	}
}
