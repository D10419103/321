 <?php

/**
 * Copyright 2016 LINE Corporation
 *
 * LINE Corporation licenses this file to you under the Apache License,
 * version 2.0 (the "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at:
 *
 *   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

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

/*$content = $receive->result[0]->content;
$text = $content->text;*/

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
			    $time=date('Y-m-d h:i:sa');
                    //$debugmsg='123456';
			    
                    //$mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy", "fu7wm9fyq2nkgeuk","3306");
                    
/*$sql = "select Q from workPunch";
$result = $mysqli->query($sql);
			    
while($row = $result->fetch_array(MYSQLI_BOTH)) {
  	$cool = $row['Q'] ;
  }*/
			    /*
		$mysqli->query('select Q from test where cool=456');
		$cool='';
		//$result = $db->query("call getUsers()");
		if($result){
		     // Cycle through results
		    while ($row = $result->fetch_object()){
			$cool = $row;
		    }
		    // Free result set
		    $result->close();
		}    
			    */
	            /*if(mysqli_connect_errno()){ 
                        $debugmsg='資料庫連線失敗';
                    }
                    else{
			    
			    
			 $mysqli->close();
		    }*/
                    if($m_message=="安安"){
				 $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($m_message . "\n" . $displayname . "\n" . $userId ."\n" . $time);
$response = $bot->replyMessage($replyToken, $textMessageBuilder);	  
			    $mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy", "fu7wm9fyq2nkgeuk","3306");
			    $sql="INSERT INTO workPunch (name,userid,worktime) VALUES ('$displayname','$userId','$time')";
			    $result = $mysqli->query($sql);
		    }else if($m_message=="123"){
				 $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($cool. "\n" . $m_message);
$response = $bot->replyMessage($replyToken, $textMessageBuilder);	  
			    $mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy", "fu7wm9fyq2nkgeuk","3306");
			    $sql = "UPDATE test SET workPunch='98765';";
			    $result = $mysqli->query($sql);
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
			$m_message = $message['address'];
			$type=$message['type'];
			    $response = $bot->getProfile($userId);
			    $profile = $response->getJSONDecodedBody();
			    $displayname=$profile['displayName'];
                	if($m_message!="")
                	{
				/*$msg = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($type . "\n" . $m_message . "\n". $longitude . "\n" . $latitude ."\n". $userId ."\n" . $displayname);
$bot->replyMessage($replyToken,$msg);*/
				/*$msg = new \LINE\LINEBot\MessageBuilder\LocationMessageBuilder($type, $m_message, $latitude, $longitude);
$bot->replyMessage($replyToken,$msg);*/
				$mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy", "fu7wm9fyq2nkgeuk","3306");
			    $sql = "UPDATE workPunch SET location='$m_message',longitude='$longitude',latitude='$latitude' where name='$displayname' and location='';";
			    $result = $mysqli->query($sql);
				
				
				$actions = array(
  new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("上班"),
  new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("下班")
);
$button = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder("你現在是要上班還是下班?", $actions);
$msg = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("這訊息要用手機的賴才看的到哦", $button);
$bot->replyMessage($replyToken,$msg);
				/*$client->replyMessage(array(
  'replyToken' => $event['replyToken'],
    'messages' => array(
            array(
                'type' => 'template', // 訊息類型 (模板)
                'altText' => 'Example confirm template', // 替代文字
                'template' => array(
                    'type' => 'confirm', // 類型 (確認)
                    'text' => '你現在是要上班還是下班?', // 文字
                    'actions' => array(
                        array(
                            'type' => 'message', // 類型 (訊息)
                            'label' => '上班', // 標籤 1
                            'text' => '上班' // 用戶發送文字 1
                        ),
                        array(
                            'type' => 'message', // 類型 (訊息)
                            'label' => '下班', // 標籤 2
                            'text' => '下班' // 用戶發送文字 2
                        )
                    )
                )
            )
        )
    ));
				$mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy", "fu7wm9fyq2nkgeuk","3306");
				$sql = "UPDATE workPunch SET worktype='下班' where name='$displayname' and worktype='';";
			    $result = $mysqli->query($sql);*/
                	}
                    break;
			
            }
            break;
        default:
            error_log("Unsupporeted event type: " . $event['type']);
            break;
    }
}
