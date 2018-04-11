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
			    		if($m_message=="進"){
						$mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy", "fu7wm9fyq2nkgeuk","3306");
				    		$sql = "select location,number,worktime from workPunch where worktype='' and userid='$userId'";
				    		$result = $mysqli->query($sql);
				    		while($row = $result->fetch_array(MYSQLI_BOTH)) {
					    		$location = $row['location'];
							$number=$row['number'];
							$worktime=$row['worktime'];
				    		}	
				    		if($location!=""){
							$client->replyMessage(array(
								'replyToken' => $event['replyToken'],
						    		'messages' => array(
							    		array(
								    		'type' => 'text',
								    		'text' => "歡迎你的到來!!" . "\n" . "祝你使用愉快!!"
							    		),
							    		array(
								    		'type' => 'sticker',
								    		'stickerId' => 106,
								    		'packageId' => 1
							    		),
						    		),
					    		));
					    		$mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy", "fu7wm9fyq2nkgeuk","3306");
					    		$sql = "UPDATE workPunch SET worktype='進' where name='$displayname' and worktype='' and number='$number';";
					    		$result = $mysqli->query($sql);
				    		}else{
					    		$client->replyMessage(array(
						    		'replyToken' => $event['replyToken'],
						    		'messages' => array(
							    		array(
								    		'type' => 'text',
										'text' => "歡迎你的到來!!" . "\n" . "祝你使用愉快!!"
									),
									array(
								    		'type' => 'text',
								    		'text' => "請定位你的位置!!"
						
									),
							    		array(
								    		'type' => 'sticker',
								    		'stickerId' => 106,
								    		'packageId' => 1
							    		),
						    		),
					    		));
					    		$mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy", "fu7wm9fyq2nkgeuk","3306");
					    		$sql = "select number from workPunch";
							$result = $mysqli->query($sql);
					    		while($row = $result->fetch_array(MYSQLI_BOTH)) {
						    		$a = $row['number'] ;
					    		}
					    		$a+=1;
					    		$sql="INSERT INTO workPunch (number,name,userid,worktype,worktime) VALUES ('$a','$displayname','$userId','進','$time')";
					    		$result = $mysqli->query($sql);
							for(int i=0;i<100;i++){
								sleep(5);
								$sql = "select name from workPunch where location='' and userid='$userId'";
								$result = $mysqli->query($sql);
								while($row = $result->fetch_array(MYSQLI_BOTH)) {
									$name = $row['name'] ;
								}	
								if($name!=""){
									$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("請定位你的位置");
									$response = $bot->pushMessage($userId, $textMessageBuilder);
								}
							}
						}
					}else if($m_message=="出"){
						$mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy", "fu7wm9fyq2nkgeuk","3306");
				    		$sql = "select location,number from workPunch where worktype='' and userid='$userId'";
				    		$result = $mysqli->query($sql);
				    		while($row = $result->fetch_array(MYSQLI_BOTH)) {
					    		$location = $row['location'];
							$number=$row['number'];
				    		}	
				    		if($location!=""){
					    		$client->replyMessage(array(
						    		'replyToken' => $event['replyToken'],
						    		'messages' => array(
							    		array(
								    		'type' => 'text',
								    		'text' => "謝謝你的使用!!" . "\n" . "歡迎下次再來!!"
							    		),
							    		array(
								    		'type' => 'sticker',
								    		'stickerId' => 13,
								    		'packageId' => 1
							    		),
						    		),
					    		));
					    		$mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy", "fu7wm9fyq2nkgeuk","3306");
					    		$sql = "UPDATE workPunch SET worktype='出' where name='$displayname' and worktype='' and number='$number';";
					    		$result = $mysqli->query($sql);
						}else{
							$client->replyMessage(array(
								'replyToken' => $event['replyToken'],
								'messages' => array(
									array(
										'type' => 'text',
										'text' => "謝謝你的使用!!" . "\n" . "歡迎下次再來!!"
									),
									array(
								    		'type' => 'text',
								    		'text' => "請定位你的位置!!"
							    		),
							    		array(
								    		'type' => 'sticker',
								    		'stickerId' => 13,
								    		'packageId' => 1
							    		),
						    		),
					    		));
							$mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy", "fu7wm9fyq2nkgeuk","3306");
					    		$sql = "select number from workPunch";
					    		$result = $mysqli->query($sql);
					    		while($row = $result->fetch_array(MYSQLI_BOTH)) {
						    		$a = $row['number'] ;
					    		}
							$a+=1;
							$sql="INSERT INTO workPunch (number,name,userid,worktype,worktime) VALUES ('$a','$displayname','$userId','出','$time')";
							$result = $mysqli->query($sql);
						}	
						for(int i=0;i<100;i++){
							sleep(5);
							$sql = "select name from workPunch where location='' and userid='$userId'";
							$result = $mysqli->query($sql);
							while($row = $result->fetch_array(MYSQLI_BOTH)) {
								$name = $row['name'] ;
							}
							if($name!=""){
								$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("請定位你的位置");
								$response = $bot->pushMessage($userId, $textMessageBuilder);
							}
						}
			    		}
			    		break;
		    
				case 'location' :
					$replyToken=$event['replyToken'];
					$source=$event['source'];
			    		$type = $source['type']; 
			    		$userId=$source['userId'];
			    		$title=$message['title'];
			    		$latitude=$message['latitude'];
			    		$longitude=$message['longitude'];
			    		$address = $message['address'];
			    		$type=$message['type'];
			    		$m_message = $message['text'];
			    		date_default_timezone_set('Asia/Taipei');	   
			    		$time=date("Y-m-d H:i:s");
			    		$response = $bot->getProfile($userId);
			    		$profile = $response->getJSONDecodedBody();
			    		$displayname=$profile['displayName'];
			    		$c=$longitude;
			    		$f=$latitude;
			    		$e="/^121.5/";
			    		$b="/^25.0/";
					if($address!="" && $longitude>=121.5651 && $longitude<=121.5654 && $latitude>=25.0865 && $latitude<=25.0868)
					{
						$mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy", "fu7wm9fyq2nkgeuk","3306");
						$sql = "select worktype,number from workPunch where location='' and longitude='' and latitude='' and userid='$userId'";
				    		$result = $mysqli->query($sql);
				    		while($row = $result->fetch_array(MYSQLI_BOTH)) {
					    		$worktype = $row['worktype'] ;
							$number=$row['number'] ;
				    		}	
				    		if($worktype!=""){
					    		$mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy", "fu7wm9fyq2nkgeuk","3306");
					    		$sql = "UPDATE workPunch SET location='$address',longitude='$longitude',latitude='$latitude' where name='$displayname' and worktype!=''and userid='$userId' and number='$number' ;";
					    		$result = $mysqli->query($sql);
					    		$client->replyMessage(array(
						    		'replyToken' => $event['replyToken'],
						    		'messages' => array(
							    		array(
								    		'type' => 'text',
								    		'text' => "定位成功!!"
							    		),
						    		),
					    		));
						}else{				
					    		$mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy", "fu7wm9fyq2nkgeuk","3306");
					    		$sql = "select number from workPunch";
					    		$result = $mysqli->query($sql);
					    		while($row = $result->fetch_array(MYSQLI_BOTH)) {
						    		$a = $row['number'] ;
					    		}
							$a+=1;
					    		$sql="INSERT INTO workPunch (number,name,userid,location,longitude,latitude,worktime) VALUES ('$a','$displayname','$userId','$address','$longitude','$latitude','$time')";
					    		$result = $mysqli->query($sql);
					    		$client->replyMessage(array(
						    		'replyToken' => $event['replyToken'],
						    		'messages' => array(
							    		array(
								    		'type' => 'template', // 訊息類型 (模板)
								    		'altText' => 'Example confirm template', // 替代文字
								    		'template' => array(
									    		'type' => 'confirm', // 類型 (確認)
									    		'text' => '你現在是要進還是出?', // 文字
									    		'actions' => array(
										    		array(
											    		'type' => 'message', // 類型 (訊息)
											    		'label' => '進', // 標籤 1
											    		'text' => '進'// 用戶發送文字 1
										    		),
										    		array(
											    		'type' => 'message', // 類型 (訊息)
											    		'label' => '出', // 標籤 2
											    		'text' => '出' // 用戶發送文字 2
										    		)
									    		)
								    		)
							    		)
						    		)
					    		));
							for(int i=0;i<100;i++){
								sleep(5);
								$sql = "select name from workPunch where worktype='' and userid='$userId'";
								$result = $mysqli->query($sql);
								while($row = $result->fetch_array(MYSQLI_BOTH)) {
									$name = $row['name'] ;
								}	
								if($name!=""){
									$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("請按進出按紐");
									$response = $bot->pushMessage($userId, $textMessageBuilder);
								}
							}
				    		}
			    		}else{
						$client->replyMessage(array(
						    		'replyToken' => $event['replyToken'],
						    		'messages' => array(
							    		array(
								    		'type' => 'text',
								    		'text' => $longitude . "\n" . $latitude
							    		),
						    		),
					    		));
					}
					break;
			}
			break;
		default:
			error_log("Unsupporeted event type: " . $event['type']);  
			break; 
	}
}
