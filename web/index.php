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
require_once('./crawl_page.php');
date_default_timezone_set("Asia/Taipei");

echo date('Y-m-d H:i:s');
echo (string)date('H');
//echo date('i');
//echo date('s');
//echo get_day(date('d'));
//echo get_r(4);
//echo get_choice1("1 2 3 4 1個替代役");
//echo get_choice2("1 2 3 4 5 6 7 2個替代役");
//echo get_choice3("1 2 3 4 5 6 7 3個替代役");




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
					else if($message['text']=="8+9")
                	{
                		$m_message = "王聖文";
                		
                	}
					else if($message['text']=="翻滾吧")
                	{
                		$m_message = "小郭";
                		
                	}
					else if($message['text']=="懶惰人")
                	{
                		$m_message = "阿宏";
                		
                	}
					else if($message['text']=="柯南")
                	{
                		$m_message = "阿皓";
                		
                	}
					else if($message['text']=="小雞雞")
                	{
                		$m_message = "阿勇";
                		
                	}
					else if($message['text']=="跨年")
                	{
                		$m_message = "你們有想過機器人不能跨年嗎? 沒有 你們只想到自己";
                		
                	}
				//	else if((string)date('H') == "15" && (string)date('i') == "44" && (string)date('s') == "00")
                //	{
                //		$m_message = "你好";
                		
                 //   }
				//else if((string)date('i') == "51")
                //	{
                //		$m_message = "你好";
                		
                  //  }
			
                	else if(stristr($message['text'],"號班表"))
                	{
                		$m_day = preg_replace('/[^\d]/','',$message['text']);
                		if((int)$m_day>32)
                			break; 
                		$m_message = get_day($m_day);
                	}
					//全替代役抽籤
				//	else if(stristr($message['text'],"個替代役"))
					//	{
                		//$m_number = preg_replace('/[^\d]/','',$message['text']);
                		//if((int)$m_number>10 or (int)$m_number<0)
                			//break;
                		//$m_message = get_r($m_number);
						//}
					
					//自行輸入抽籤的人
					else if(stristr($message['text'],"抽1個出差"))
                	{
						$m_choice = preg_replace('/[^\d]/','',$message['text']);
                		$m_choice = $message['text'];
                	    $m_message = get_choice1($m_choice);
                    }
					else if(stristr($message['text'],"抽2個出差"))
                	{
						$m_choice = preg_replace('/[^\d]/','',$message['text']);
                		$m_choice = $message['text'];
                	    $m_message = get_choice2($m_choice);
                    }

					else if(stristr($message['text'],"抽3個出差"))
                	{
						$m_choice = preg_replace('/[^\d]/','',$message['text']);
                		$m_choice = $message['text'];
                	    $m_message = get_choice3($m_choice);
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
                    else if($message['text']=="菜單")
                    {
                        $m_message = crawl_page("http://www.egv.org.tw/index.php?option=com_content&view=article&id=238:1060828-0903&catid=36:2015-07-05-17-05-44&Itemid=83");
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
