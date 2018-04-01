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
require_once __DIR__ . '/../scr/LINEBot.php';
require_once __DIR__ . '/../scr/LINEBot/Response.php';
require_once __DIR__ . '/../scr/LINEBot/HTTPClient.php';
require_once __DIR__ . '/../scr/LINEBot/MessageBuilder.php';
require_once __DIR__ . '/../scr/LINEBot/TemplateActionBuilder.php';
require_once __DIR__ . '/../scr/LINEBot/Constant/Meta.php';
require_once __DIR__ . '/../scr/LINEBot/Constant/MessageType.php';
require_once __DIR__ . '/../scr/LINEBot/Constant/ActionType.php';
require_once __DIR__ . '/../scr/LINEBot/Constant/TemplateType.php';
require_once __DIR__ . '/../scr/LINEBot/HTTPClient/Curl.php';
require_once __DIR__ . '/../scr/LINEBot/HTTPClient/CurlHTTPClient.php';
require_once __DIR__ . '/../scr/LINEBot/TemplateActionBuilder.php';
require_once __DIR__ . '/../scr/LINEBot/TemplateActionBuilder/PostbackTemplateActionBuilder.php';
require_once __DIR__ . '/../scr/LINEBot/MessageBuilder/TemplateBuilder.php';
require_once __DIR__ . '/../scr/LINEBot/MessageBuilder/LocationMessageBuilder.php';
require_once __DIR__ . '/../scr/LINEBot/MessageBuilder/TemplateBuilder/ConfirmTemplateBuilder.php';
require_once __DIR__ . '/../scr/LINEBot/MessageBuilder/TextMessageBuilder.php';
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
			if($m_message=="安安")
                	{
				$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($m_message);
		    	$response = $bot->pushMessage('U8acc7f611c6f853ac53e1a474bd77c92', $textMessageBuilder);
			$response = $bot->pushMessage('U0da0177d489bff17a4d77614a0b23257', $textMessageBuilder);
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
				$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('hello');
$response = $bot->pushMessage('U8acc7f611c6f853ac53e1a474bd77c92', $textMessageBuilder);
                	}
                    break;
            }
		    
            break;
        default:
            error_log("Unsupporeted event type: " . $event['type']);
            break;
    }
};
?>
