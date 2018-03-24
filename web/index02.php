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
                    $replyToken=$event['replyToken'];
                	$m_message = $message['text']; $source=$event['source']; $idtype = $source['type'];  $userid=$source['userId'];
                    $roomid=$source['roomId']; $groupid=$source['groupId'];
                    $pictureUrl=$message['pictureUrl'];
			    $response = $bot->getProfile($userId);
			    $profile = $response->getJSONDecodedBody();
                    $displayName = $profile['displayName'];
                    date_default_timezone_set('Asia/Taipei');
			    $time=date('Y-m-d h:i:sa');
                    $debugmsg='123456';
			    
                    $mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy", "fu7wm9fyq2nkgeuk","3306");
                    
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
	            if(mysqli_connect_errno()){ 
                        $debugmsg='資料庫連線失敗';
                    }
                    else{
			    
			    
			 $mysqli->close();
		    }
                    if($m_message=="安安"){
				 $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($m_message . "\n" . $displayName . "\n" . $userid ."\n" . $time);
$response = $bot->replyMessage($replyToken, $textMessageBuilder);	  
			    $mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy", "fu7wm9fyq2nkgeuk","3306");
			    $sql="INSERT INTO workPunch (name,userid,worktime) VALUES ('$displayName','$userid','$time')";
			    $result = $mysqli->query($sql);
			     $mysqli->close();
		    }else if($m_message=="123"){
				 $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($cool. "\n" . $m_message);
$response = $bot->replyMessage($replyToken, $textMessageBuilder);	  
			    $mysqli = new mysqli('edo4plet5mhv93s3.cbetxkdyhwsb.us-east-1.rds.amazonaws.com', "ia8wipiqgptyg9yb", "ywz5dcdawbeq11cy", "fu7wm9fyq2nkgeuk","3306");
			    $sql = "UPDATE test SET workPunch='98765';";
			    $result = $mysqli->query($sql);
			     $mysqli->close();
		    }
                    break;
            }
            break;
        default:
            error_log("Unsupporeted event type: " . $event['type']);
            break;
    }
}
