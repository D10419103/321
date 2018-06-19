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
          				$key=rand(1000,9999);
					$mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy", "fu7wm9fyq2nkgeuk","3306");
					$join=false;
					$unjoin=false;
					$untest=true;
					$sql = "SELECT inside from ininin";
					$result = $mysqli->query($sql);
					
					if($userId=="U1bfd8c42263e43bc3f34a6d0c4e1ecb2"){
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
					$sql="select test from untest";
					$result = $mysqli->query($sql);
						while($row = $result->fetch_array(MYSQLI_BOTH)) {
							$test = $row['test'];
							if(preg_match("/$test/i","$m_message")){
								$untest=false;
							}
						}
					
				if($untest)	{
					if($join && $m_message!=$numbercode){
            $mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy", "fu7wm9fyq2nkgeuk","3306");
			            $sql="INSERT INTO code (numbercode,msg,userid) VALUES ('$key','進','$userId')";
			            $result = $mysqli->query($sql);
						$sql = "select number from ex";
							$result = $mysqli->query($sql);
					    		while($row = $result->fetch_array(MYSQLI_BOTH)) {
						    		$a = $row['number'] ;
					    		}
					    		$a+=1;
						$sql="INSERT INTO ex (number,name,userid,msg,worktime) VALUES ('$a','$displayname','$userId','$m_message','$time')";
					    		$result = $mysqli->query($sql);
            $client->replyMessage(array(
						    		'replyToken' => $event['replyToken'],
						    		'messages' => array(
							    		array(
								    		'type' => 'text',
										'text' => "歡迎你的到來!!" . "\n" . "祝你使用愉快!!"
									),
									array(
								    		'type' => 'text',
								    		'text' => "請輸入驗證碼!!"
									),
						    		),
					    		));
						$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($displayname."的驗證碼是".$key);
		    					$response = $bot->pushMessage($userId, $textMessageBuilder);
					sleep(5);
						$mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy", "fu7wm9fyq2nkgeuk","3306");
					  $sql="select * from code where userid='$userId'";
				$result = $mysqli->query($sql);
						while($row = $result->fetch_array(MYSQLI_BOTH)) {
							$msg2 = $row['msg'];
						}
						
						if($msg2 == "進"){
							$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("驗證逾時");
							$response = $bot->pushMessage($userId, $textMessageBuilder);
							$sql="delete from code where numbercode='$key' and userid='$userId'";
							$result = $mysqli->query($sql);
							$sql="UPDATE ex SET worktype='逾時' where worktype='' and vcode='' and userid='$userId';";
							$result = $mysqli->query($sql);
						}
					}else if($unjoin && $m_message!=$numbercode){
			            $sql="INSERT INTO code (numbercode,msg,userid) VALUES ('$key','出','$userId')";
			            $result = $mysqli->query($sql);
						$sql = "select number from ex";
							$result = $mysqli->query($sql);
					    		while($row = $result->fetch_array(MYSQLI_BOTH)) {
						    		$a = $row['number'] ;
					    		}
					    		$a+=1;
						$sql="INSERT INTO ex (number,name,userid,msg,worktime) VALUES ('$a','$displayname','$userId','$m_message','$time')";
					    		$result = $mysqli->query($sql);
							$client->replyMessage(array(
								'replyToken' => $event['replyToken'],
								'messages' => array(
									array(
										'type' => 'text',
										'text' => "謝謝你的使用!!" . "\n" . "歡迎下次再來!!"
									),
									array(
								    		'type' => 'text',
								    		'text' => "請輸入驗證碼!!"
							    		),
						    		),
					    		));
						$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($displayname."的驗證碼是".$key);
		    					$response = $bot->pushMessage($userId, $textMessageBuilder);
						sleep(5);
						$mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy", "fu7wm9fyq2nkgeuk","3306");
					  $sql="select * from code where userid='$userId'";
				$result = $mysqli->query($sql);
						while($row = $result->fetch_array(MYSQLI_BOTH)) {
							$msg2 = $row['msg'];
						}
						if($msg2 == "出"){
							$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("驗證逾時");
							$response = $bot->pushMessage($userId, $textMessageBuilder);
							$sql="delete from code where numbercode='$key' and userid='$userId'";
							$result = $mysqli->query($sql);
							$sql="UPDATE ex SET worktype='逾時' where worktype='' and vcode='' and userid='$userId';";
							$result = $mysqli->query($sql);
						}
						
			    		}
				}
					$mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy", "fu7wm9fyq2nkgeuk","3306");
					  $sql="select numbercode,msg from code where userid='$userId'";
				$result = $mysqli->query($sql);
						while($row = $result->fetch_array(MYSQLI_BOTH)) {
							$numbercode = $row['numbercode'];
							$msg = $row['msg'];
						}
          if ($m_message== $numbercode) {
		              $mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy", "fu7wm9fyq2nkgeuk","3306");
		$sql = "UPDATE ex SET worktype='$msg',vcode='$numbercode' where worktype='' and vcode='' and userid='$userId';";		
							$result = $mysqli->query($sql);
				$msg = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("驗證成功");
                        $bot->replyMessage($replyToken,$msg);
							$sql="delete from code where numbercode='$m_message' and userid='$userId'";
							$result = $mysqli->query($sql);	
					
					}else if(preg_match("/^([0-9]+)$/","$m_message")){
				$msg = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("驗證失敗");
                        $bot->replyMessage($replyToken,$msg);
			}else{
			  $msg = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("安安");
                        $bot->replyMessage($replyToken,$msg);
	  }
					}
          break;
			}
			break;
		default:
			error_log("Unsupporeted event type: " . $event['type']);  
			break; 
	}
}
