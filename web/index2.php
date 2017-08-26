<?php
	/* 輸入申請的Line Developers 資料  */
	$channel_id = "1532141759";
	$channel_secret = "b59c0147973f523cca2165c4357250fa";
	$channel_access_token = "hfKZRBMAdhy2zb8+w6lGxT125nw95ZeThqvZU2Jge0+uX04sAfaY8RLO/YQ0TWpKwhscvpoUnyXkOPK7t6jW834BRYxDkX+EZqoGgNB7MMpnLg1HfPS8OV7SX6VfZ1EucWDXRDRUSKZaR1WP69WATAdB04t89/1O/w1cDnyilFU=";
	$myURL = "https://cuibotde.herokuapp.com:443/callback"
	//  當有人發送訊息給bot時 我們會收到的json
	// 	{
	// 	  "events": 
	// 	  [
	// 		  {
	// 			"replyToken": "nHuyWiB7yP5Zw52FIkcQobQuGDXCTA",
	// 			"type": "message",
	// 			"timestamp": 1462629479859,
	// 			"source": {
	// 				 "type": "user",
	// 				 "userId": "U206d25c2ea6bd87c17655609a1c37cb8"
	// 			 },
	// 			 "message": {
	// 				 "id": "325708",
	// 				 "type": "text",
	// 				 "text": "Hello, world"
	// 			  }
	// 		  }
	// 	  ]
	// 	}
	 
	 $receive = json_decode(file_get_contents("php://input"));
	 var_dump($receive);
	

	
?>