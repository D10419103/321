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

$channelAccessToken = getenv('LINE_CHANNEL_ACCESSTOKEN');
$channelSecret = getenv('LINE_CHANNEL_SECRET');

$client = new LINEBotTiny($channelAccessToken, $channelSecret);

foreach ($client->parseEvents() as $event) {
    switch ($event['type']) {
        case 'message':
            $message = $event['message'];
            switch ($message['type']) {
		    case 'text':   
                	$m_message = $message['text'];
			$type=$message['type'];
                	$source=$event['source'];
              	      	$id=$source['userId'];
			$displayName = $contacts['displayName'];				
                  	$roomid=$source['roomId'];
             	       	$groupid=$source['groupId'];
			date_default_timezone_set('Asia/Taipei');
			if($m_message=="安安")
                	{
                		$client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                                'type' => 'text',
                                'text' => $type ."\n" . $m_message ."\n" . $roomid."\n". date('Y-m-d h:i:sa') . "\n" . $id . "\n" . $groupid. "\n" . $displayName 
                            )	
                        )
                    	));			
                	}else if($m_message=="123"){
				
				$client->replyMessage(array(
  'replyToken' => $event['replyToken'],
    'messages' => array(
            array(
                'type' => 'template', // 訊息類型 (模板)
                'altText' => 'Example confirm template', // 替代文字
                'template' => array(
                    'type' => 'confirm', // 類型 (確認)
                    'text' => 'Are you sure?', // 文字
                    'actions' => array(
                        array(
                            'type' => 'message', // 類型 (訊息)
                            'label' => 'Yes', // 標籤 1
                            'text' => 'Yes' // 用戶發送文字 1
                        ),
                        array(
                            'type' => 'message', // 類型 (訊息)
                            'label' => 'No', // 標籤 2
                            'text' => 'No' // 用戶發送文字 2
                        )
                    )
                )
            )
        )
    ));
			}else if($m_message=="321"){
				$client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
            array(
                'type' => 'template', // 訊息類型 (模板)
                'altText' => 'Example buttons template', // 替代文字
                'template' => array(
                    'type' => 'buttons', // 類型 (按鈕)
                    'thumbnailImageUrl' => 'https://api.reh.tw/line/bot/example/assets/images/example.jpg', // 圖片網址 <不一定需要>
                    'title' => 'Example Menu', // 標題 <不一定需要>
                    'text' => 'Please select', // 文字
                    'actions' => array(
                        array(
                            'type' => 'postback', // 類型 (回傳)
                            'label' => 'Postback example', // 標籤 1
                            'data' => 'action=buy&itemid=123' // 資料
                        ),
                        array(
                            'type' => 'message', // 類型 (訊息)
                            'label' => 'Message example', // 標籤 2
                            'text' => 'Message example' // 用戶發送文字
                        ),
                        array(
                            'type' => 'uri', // 類型 (連結)
                            'label' => 'Uri example', // 標籤 3
                            'uri' => 'https://github.com/GoneTone/line-example-bot-php' // 連結網址
                        )
                    )
                )
            )
        )
                    	));	
			}else if($m_message=="1"){
                        $client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                                'type' => 'template',
                                'altText' => 'Example confirm template',
                                'template' => array(
                                    'type' => 'confirm',
                                    'text' => '請選擇日期',
                                    'actions' => array(
                                        array(
                                        'type' => 'datetimepicker',
                                        'label' => '請選擇',
                                        'data' => 'storeId=12345',
                                        'mode' => 'datetime',
                                        'initial' => '2018-01-01t00:00',
                                        'max' => '2020-12-30t00:00',
                                        'min' => '2017-01-01t00:00'
                                         ),
                                        array(
                                        'type' => 'message',
                                        'label' => '取消',
                                        'text' => '請使用看看'
                                        )
                            ))))));
                    }
                    break;
			  
		    case "image" :
			$type=$message['type'];
			$originalContentUrl=$message['originalContentUrl'];
			$previewImageUrl=$message['previewImageUrl'];
                	if($m_message!="")
                	{
                		$client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                                'type' => 'text',
                                'text' => $type . "\n" . $originalContentUrl . "\n" . $previewImageUrl
                            ),
                        ),
                    	));
                	}
				break;
	
		    case "video" :
			$type=$message['type'];
                	if($m_message!="")
                	{
                		$client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                                'type' => 'text',
                                'text' => $type
                            ),
                        ),
                    	));
                	}
				break;
				
		    case "audio" :
			$type=$message['type'];
                	if($m_message!="")
                	{
                		$client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                                'type' => 'text',
                                'text' => $type
                            ),
                        ),
                    	));
                	}
				break;
                        
                    case 'location' :
			$source=$event['source'];
              	      	$type = $source['type']; 
              	      	$id=$source['userId'];
			$title=$message['title'];
                   	$latitude=$message['latitude'];
                   	$longitude=$message['longitude'];
			$m_message = $message['address'];
			$type=$message['type'];
                	if($m_message!="")
                	{
                		$client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                                'type' => 'text',
                                'text' => $type . "\n" . $m_message . "\n". $longitude . "\n" . $latitude ."\n". $id 
                            ),
                        ),
                    	));
                	}
                    break;
			
		    case 'sticker' :
			$m_message = $message['packageId'];
			$stickerId = $message['stickerId'];
			$type=$message['type'];
			if($m_message !="")
                	{
                	$client->replyMessage(array(
        		'replyToken' => $event['replyToken'],
     			   'messages' => array(
       			     array(
				'type' => 'sticker',
				'stickerId' => $stickerId,
				'packageId' => $m_message
         	   ),
			     array(
                                'type' => 'text',
                                'text' => $type
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
};
?>
