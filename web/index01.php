<?php
require_once('./LINEBotTiny.php');
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/LINEBot/HTTPClient.php';
require_once __DIR__ . '/../src/LINEBot/Constant/Meta.php';
require_once __DIR__ . '/../src/LINEBot.php';
require_once __DIR__ . '/../src/LINEBot/HTTPClient/CurlHTTPClient.php';
require_once __DIR__ . '/../src/LINEBot/HTTPClient/Curl.php';
require_once __DIR__ . '/../src/LINEBot/Response.php';
require_once __DIR__ . '/../src/LINEBot/Constant/MessageType.php';
require_once __DIR__ . '/../src/LINEBot/MessageBuilder.php';
require_once __DIR__ . '/../src/LINEBot/MessageBuilder/TextMessageBuilder.php';
require_once __DIR__ . '/../src/LINEBot/MessageBuilder/StickerMessageBuilder.php';
require_once __DIR__ . '/../src/LINEBot/MessageBuilder/LocationMessageBuilder.php';
require_once __DIR__ . '/../src/LINEBot/MessageBuilder/MultiMessageBuilder.php';
require_once __DIR__ . '/../src/LINEBot/TemplateActionBuilder.php';
require_once __DIR__ . '/../src/LINEBot/Constant/ActionType.php';
require_once __DIR__ . '/../src/LINEBot/TemplateActionBuilder/PostbackTemplateActionBuilder.php';
require_once __DIR__ . '/../src/LINEBot/MessageBuilder/TemplateBuilder.php';
require_once __DIR__ . '/../src/LINEBot/Constant/TemplateType.php';
require_once __DIR__ . '/../src/LINEBot/MessageBuilder/TemplateBuilder/ConfirmTemplateBuilder.php';
require_once __DIR__ . '/../src/LINEBot/MessageBuilder/TemplateMessageBuilder.php';
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
					$join=false;
					$unjoin=false;
					$untest=true;
					$sql = "SELECT inside from ininin";
					$result = $mysqli->query($sql);
					
					if($userId=="U06f44ab74ed972f7a22838ed5e75300e" || $userId=="U8acc7f611c6f853ac53e1a474bd77c92" || $userId=="U3c822c99099ebc65694c3b8401be9707" || $userId=="U0da0177d489bff17a4d77614a0b23257"){
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
						$sql = "select number from 304ex";
							$result = $mysqli->query($sql);
					    		while($row = $result->fetch_array(MYSQLI_BOTH)) {
						    		$a = $row['number'] ;
					    		}
					    		$a+=1;
						$sql="INSERT INTO 304ex (number,name,userid,msg,worktime) VALUES ('$a','$displayname','$userId','$m_message','$time')";
					    		$result = $mysqli->query($sql);
            $client->replyMessage(array(
						    		'replyToken' => $event['replyToken'],
						    		'messages' => array(
									array(
								    		'type' => 'text',
								    		'text' => "請輸入驗證碼!!",
									),
						    		),
					    		));
						$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($displayname."的驗證碼是".$key);
		    					$response = $bot->pushMessage(U3c822c99099ebc65694c3b8401be9707, $textMessageBuilder);
						sleep(20);
						$mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy", "fu7wm9fyq2nkgeuk","3306");
					  $sql="select * from code where userid='$userId'";
				$result = $mysqli->query($sql);
						while($row = $result->fetch_array(MYSQLI_BOTH)) {
							$msg2 = $row['msg'];
						}
						if($msg2 == "進"){
							$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("驗證逾時");
							$response = $bot->pushMessage($groupid, $textMessageBuilder);
							$sql="delete from code where numbercode='$key' and userid='$userId'";
							$result = $mysqli->query($sql);
							$sql="UPDATE 304ex SET worktype='逾時' where worktype='' and vcode='' and userid='$userId';";
							$result = $mysqli->query($sql);
						}
						
					}else if($unjoin && $m_message!=$numbercode){
			            $sql="INSERT INTO code (numbercode,msg,userid) VALUES ('$key','出','$userId')";
			            $result = $mysqli->query($sql);
						$sql = "select number from 304ex";
							$result = $mysqli->query($sql);
					    		while($row = $result->fetch_array(MYSQLI_BOTH)) {
						    		$a = $row['number'] ;
					    		}
					    		$a+=1;
						$sql="INSERT INTO 304ex (number,name,userid,msg,worktime) VALUES ('$a','$displayname','$userId','$m_message','$time')";
					    		$result = $mysqli->query($sql);
							$client->replyMessage(array(
								'replyToken' => $event['replyToken'],
								'messages' => array(
									array(
								    		'type' => 'text',
								    		'text' => "請輸入驗證碼!!",
							    		),
						    		),
					    		));
						$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($displayname."的驗證碼是".$key);
		    					$response = $bot->pushMessage(U3c822c99099ebc65694c3b8401be9707, $textMessageBuilder);
						sleep(10);
						$mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy", "fu7wm9fyq2nkgeuk","3306");
					  $sql="select * from code where userid='$userId'";
				$result = $mysqli->query($sql);
						while($row = $result->fetch_array(MYSQLI_BOTH)) {
							$msg2 = $row['msg'];
						}
						if($msg2 == "出"){
							$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($displayname."驗證逾時");
							$response = $bot->pushMessage($groupid, $textMessageBuilder);
							$sql="delete from code where numbercode='$key' and userid='$userId'";
							$result = $mysqli->query($sql);
							$sql="UPDATE 304ex SET worktype='逾時' where worktype='' and vcode='' and userid='$userId';";
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
		$sql = "UPDATE 304ex SET worktype='$msg',vcode='$numbercode' where worktype='' and vcode='' and userid='$userId';";		
							$result = $mysqli->query($sql);
				$msg = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($displayname."驗證成功");
                        $bot->replyMessage($replyToken,$msg);
							$sql="delete from code where numbercode='$m_message' and userid='$userId'";
							$result = $mysqli->query($sql);	
					
					}else if(preg_match("/^([0-9]+)$/","$m_message")){
				$msg = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($displayname."驗證失敗");
                        $bot->replyMessage($replyToken,$msg);
			}
					}				else{
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
				if($join){
					$sql = "SELECT name from 304ex where userid='$userId'";
					$result = $mysqli->query($sql);
					while($row = $result->fetch_array(MYSQLI_BOTH)) {
					    		$name = $row['name'];
				    		}	
					$sql = "select number from 304ex";
							$result = $mysqli->query($sql);
					    		while($row = $result->fetch_array(MYSQLI_BOTH)) {
						    		$a = $row['number'] ;
					    		}
					    		$a+=1;
					if($displayname!=""){
						$sql="INSERT INTO 304ex (number,name,userid,msg,worktype,worktime) VALUES ('$a','$displayname','$userId','$m_message','進','$time')";
					$result = $mysqli->query($sql);
					}else{
					$sql="INSERT INTO 304ex (number,name,userid,msg,worktype,worktime) VALUES ('$a','$name','$userId','$m_message','進','$time')";
					$result = $mysqli->query($sql);
					}
				}else if($unjoin){
					$sql = "SELECT name from 304ex where userid='$userId'";
					$result = $mysqli->query($sql);
					while($row = $result->fetch_array(MYSQLI_BOTH)) {
					    		$name = $row['name'];
				    		}	
					$sql = "select number from 304ex";
							$result = $mysqli->query($sql);
					    		while($row = $result->fetch_array(MYSQLI_BOTH)) {
						    		$a = $row['number'] ;
					    		}
					    		$a+=1;
					if($displayname!=""){
						$sql="INSERT INTO 304ex (number,name,userid,msg,worktype,worktime) VALUES ('$a','$displayname','$userId','$m_message','出','$time')";
					$result = $mysqli->query($sql);
					}else{
					$sql="INSERT INTO 304ex (number,name,userid,msg,worktype,worktime) VALUES ('$a','$name','$userId','$m_message','出','$time')";
					$result = $mysqli->query($sql);
					}
					}else{
					$sql = "SELECT name from 304ex where userid='$userId'";
					$result = $mysqli->query($sql);
					while($row = $result->fetch_array(MYSQLI_BOTH)) {
					    		$name = $row['name'];
				    		}	
					$sql = "select number from 304ex";
							$result = $mysqli->query($sql);
					    		while($row = $result->fetch_array(MYSQLI_BOTH)) {
						    		$a = $row['number'] ;
					    		}
					    		$a+=1;
					if($displayname!=""){
						$sql="INSERT INTO 304ex (number,name,userid,msg,worktype,worktime) VALUES ('$a','$displayname','$userId','$m_message','無','$time')";
				$result = $mysqli->query($sql);
					}else{
				$sql="INSERT INTO 304ex (number,name,userid,msg,worktype,worktime) VALUES ('$a','$name','$userId','$m_message','無','$time')";
				$result = $mysqli->query($sql);
					}
			}
					}
					else{
					$sql = "SELECT name from 304ex where userid='$userId'";
					$result = $mysqli->query($sql);
					while($row = $result->fetch_array(MYSQLI_BOTH)) {
					    		$name = $row['name'];
				    		}	
					$sql = "select number from 304ex";
							$result = $mysqli->query($sql);
					    		while($row = $result->fetch_array(MYSQLI_BOTH)) {
						    		$a = $row['number'] ;
					    		}
					    		$a+=1;
						if($displayname!=""){
							$sql="INSERT INTO 304ex (number,name,userid,msg,worktype,worktime) VALUES ('$a','$displayname','$userId','$m_message','無','$time')";
				$result = $mysqli->query($sql);
						}else{
				$sql="INSERT INTO 304ex (number,name,userid,msg,worktype,worktime) VALUES ('$a','$name','$userId','$m_message','無','$time')";
				$result = $mysqli->query($sql);
						}
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
