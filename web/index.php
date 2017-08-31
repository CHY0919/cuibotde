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
require_once('./excel_parser.php');

#$m_day = "九號班表";

#$m_day = preg_replace('/[^\d]/','',$m_day );
#echo $m_day;
#echo nl2br(get_day($m_day));

echo date('Y-m-d H:i:s');

$channelAccessToken = 'hfKZRBMAdhy2zb8+w6lGxT125nw95ZeThqvZU2Jge0+uX04sAfaY8RLO/YQ0TWpKwhscvpoUnyXkOPK7t6jW834BRYxDkX+EZqoGgNB7MMpnLg1HfPS8OV7SX6VfZ1EucWDXRDRUSKZaR1WP69WATAdB04t89/1O/w1cDnyilFU=';
$channelSecret = 'b59c0147973f523cca2165c4357250fa';

$client = new LINEBotTiny($channelAccessToken, $channelSecret);
foreach ($client->parseEvents() as $event) {
    switch ($event['type']) {
        case 'message':
            $message = $event['message'];
            switch ($message['type']) {
                case 'text':
                	$m_message = "";
                	if($message['text']=="幸福翠柏")
                	{
                		$m_message = "健康翠柏、樂活翠柏！";
                	}
                	else if($message['text']=="今天班表"||$message['text']=="今日班表")
                	{
                		$m_message = get_day(date("d"));
                		
                	}
                	else if(stristr($message['text'],"號班表"))
                	{
                		$m_day = preg_replace('/[^\d]/','',$message['text']);
                		if((int)$m_day>32)
                			break;
                		$m_message = get_day($m_day);
                	}
                	else if($message['text']=="明天班表"||$message['text']=="明日班表")
                	{
                		$m_day = (int)date("d")+1;
                		if((int)$m_day>32)
                			break;
                		$m_message = get_day($m_day);
                	}	
                	else if($message['text']=="後天班表")
                	{
                		$m_day = (int)date("d")+2;
                		if((int)$m_day>32)
                			break;
                		$m_message = get_day($m_day);
                	}
                	if($m_message!="")
                	{
                		$client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                                'type' => 'text',
                                'text' => $m_message
                            )
                        )
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
