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
					
					if($join){
			    		//if($m_message=="進"){
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
					    		$sql = "UPDATE workPunch SET worktype='進',worktime2='$time' where name='$displayname' and worktype='' and number='$number';";
					    		$result = $mysqli->query($sql);
							$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($displayname." "."進");
		    					$response = $bot->pushMessage('C7f5b8de421baf16de46e01f846f162c7', $textMessageBuilder);
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
							$z=0;
							while($z==0){
								sleep(3);
								$sql = "select location,worktime from workPunch where location='' and userid='$userId'";
								$result = $mysqli->query($sql);
								while($row = $result->fetch_array(MYSQLI_BOTH)) {
									$location = $row['location'];
									$worktime = $row['worktime'];
								}
								$sql = "select location from workPunch where worktime='$worktime' and userid='$userId'";
								$result = $mysqli->query($sql);
								while($row = $result->fetch_array(MYSQLI_BOTH)) {
									$location2 = $row['location'];
								}	
								if($location2!="")break;
								if($location==""){
									$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("請定位你的位置");
									$response = $bot->pushMessage($userId, $textMessageBuilder);
								}
							}
						}
					}else if($unjoin){
					//else if($m_message=="出"){
						 $mysqli->close();
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
					    		$sql = "UPDATE workPunch SET worktype='出',worktime2='$time' where name='$displayname' and worktype='' and number='$number';";
					    		$result = $mysqli->query($sql);
							$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($displayname." "."出");
		    					$response = $bot->pushMessage('C7f5b8de421baf16de46e01f846f162c7', $textMessageBuilder);
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
						$z=0;
						while($z==0){
							sleep(3);
							$sql = "select location,worktime from workPunch where location='' and userid='$userId'";
							$result = $mysqli->query($sql);
							while($row = $result->fetch_array(MYSQLI_BOTH)) {
								$location = $row['location'];
								$worktime = $row['worktime'];
							}
							$sql = "select location from workPunch where worktime='$worktime' and userid='$userId'";
							$result = $mysqli->query($sql);
							while($row = $result->fetch_array(MYSQLI_BOTH)) {
								$location2 = $row['location'];
							}	
							if($location2!="")break;
							if($location==""){
								$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("請定位你的位置");
								$response = $bot->pushMessage($userId, $textMessageBuilder);
							}
						}
			    		}else if($m_message=="查"){
						$mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy","fu7wm9fyq2nkgeuk","3306");			$sql = "select name,worktime from mysql where worktype='進'";
						$sql = "select name,worktime from workPunch where worktype='進'";
						$result = $mysqli->query($sql);
						while($row = $result->fetch_array(MYSQLI_BOTH)){ 
							$name = $row['name'];
							$worktime = $row['worktime'];
						}
						    //if($worktime==$date){
							$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($name." ");
							$response = $bot->pushMessage($userid, $textMessageBuilder);
						    //}
					    }
					else if($m_message!='' && $join=true && $unjoin=true && $m_message!='毫無相關' && $m_message!='查'){
						$mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy","fu7wm9fyq2nkgeuk","3306");
						$sql = "select number from test";
					    	$result = $mysqli->query($sql);
					    	while($row = $result->fetch_array(MYSQLI_BOTH)) {
						    	$b = $row['number'] ;
					    	}
						$b+=1;
						if($m_message!='進' && $m_message!='出' && $m_message!='毫無相關'){
							$sql="INSERT INTO test (number,worktest,worktime1) VALUES ('$b','$m_message','$time')";
							$result = $mysqli->query($sql);
						}
						$client->replyMessage(array(
							'replyToken' => $event['replyToken'],
							'messages' => array(
								array(
									'type' => 'template', // 訊息類型 (模板)
                							'altText' => 'simple in and out', // 替代文字
                							'template' => array(
										'type' => 'buttons', // 類型 (按鈕)
										'title' => '選單', // 標題 <不一定需要>
										'text' => '請問'.$m_message.'代表什麼', // 文字
										'actions' => array(
											array(
												'type' => 'message', // 類型 (訊息)
												'label' => '進', // 標籤 1
												/*$mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy","fu7wm9fyq2nkgeuk","3306"),
												$sql="INSERT INTO ininin (inside) VALUES ('$m_message')",
												$result = $mysqli->query($sql),*/
												'text' => '進' // 用戶發送文字
											),
											array(
												'type' => 'message', // 類型 (訊息)
												'label' => '出', // 標籤 2
												/*$mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy","fu7wm9fyq2nkgeuk","3306"),
												$sql="INSERT INTO ininin (outside) VALUES ('$m_message')",
												$result = $mysqli->query($sql),*/
												'text' => '出' // 用戶發送文字
											),
											array(
												'type' => 'message', // 類型 (訊息)
												'label' => '毫無相關', // 標籤 3
												'text' => '毫無相關' // 用戶發送文字
											)
										)
									),
								)
								
							)
							
						)
								     );
						$mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy","fu7wm9fyq2nkgeuk","3306");
						$sql = "select worktest from test/* where  select id, max(date) from tablename group by id*/";
						$result = $mysqli->query($sql);
						while($row = $result->fetch_array(MYSQLI_BOTH)) {
							$worktest = $row['worktest'];
						}
						if($m_message=="進"){
							/*$mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy","fu7wm9fyq2nkgeuk","3306");
							$sql = "select worktest from test";
							$result = $mysqli->query($sql);
							while($row = $result->fetch_array(MYSQLI_BOTH)) {
								$worktest = $row['worktest'];
							}*/
							$sql="INSERT INTO ininin (inside,outside) VALUES ('$worktest','出')";
							$result = $mysqli->query($sql);
							$sql="delete from test where worktest!=''";
							$result = $mysqli->query($sql);
						}else if($m_message=="出"){
							$sql="INSERT INTO ininin (inside,outside) VALUES ('進','$worktest')";
							$result = $mysqli->query($sql);
							$sql="delete from test where worktest!=''";
							$result = $mysqli->query($sql);
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
					if($address!="")
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
					    		$sql = "UPDATE workPunch SET location='$address',longitude='$longitude',latitude='$latitude',worktime2='$time' where name='$displayname' and worktype!=''and userid='$userId' and number='$number' ;";
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
							$sql="SELECT worktype from workPunch where userid='$userId'";
							$result = $mysqli->query($sql);
							while($row = $result->fetch_array(MYSQLI_BOTH)) {
  								$worktype = $row['worktype'] ;
 			 				}
							$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($displayname." ".$worktype);
		    					$response = $bot->pushMessage('C7f5b8de421baf16de46e01f846f162c7', $textMessageBuilder);
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
							$z=0;
							while($z==0){
								sleep(3);
								$sql = "select worktype,worktime from workPunch where worktype='' and userid='$userId'";
								$result = $mysqli->query($sql);
								while($row = $result->fetch_array(MYSQLI_BOTH)) {
									$worktype = $row['worktype'] ;
									$worktime=$row['worktime'];
								}
								$sql = "select worktype from workPunch where worktime='$worktime' and userid='$userId'";
								$result = $mysqli->query($sql);
								while($row = $result->fetch_array(MYSQLI_BOTH)) {
									$worktype2 = $row['worktype'];
								}	
								if($worktype2!="")break;
								if($worktype==""){
									$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("請按進出按紐");
									$response = $bot->pushMessage($userId, $textMessageBuilder);
								}
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
