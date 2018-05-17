<?php // callback.php

require "vendor/autoload.php";
require_once('vendor/linecorp/line-bot-sdk/line-bot-sdk-tiny/LINEBotTiny.php');

$access_token = 'uHppTCRYPBufbKTig8dJJsW/IyXclI5nf2SsNDcnIV6GkgBTiBOyk7sy5dHi6+UV+Oz6tpXagzwmtOvRfZvfpYFsIe51T9vX2ljZ79r2xu4ktlKY9IXZB9Hwfry1T0VrnNUiczQYzN7RtUwscga7KgdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {

			$text = $event['source']['userId'];
			$replyToken = $event['replyToken'];
			$text =  json_encode($events);

			$messages = [
				'type' => 'text',
				'text' => $text
			];

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
			
			if($event['source']['groupId'] == "C81fe2451f7fbe94a4d47564386844e04")
			{
                exit();
            }

            $resultMsg = groupBtl($events);
            $data['messages'] = $resultMsg;


            
            $post = json_encode($data);
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
		}
	}
}

$this->groupBtl('xxx');

function groupBtl($event)
{
//     $userId = $event['source']['userId'];
//     $text = $event['message']['text'];

//     $checkName = stripos($text, "ชื่อ");
//     if($checkName)
//     {
//         $messages = [
//             'type' => 'text',
//             'text' => 'นี้คือข้อมูล \r\n'.json_encode($event)
//         ];

//         return [$messages];
//     }
	echo $event;
}

function groupBtlGetUser ($userId)
{
    $user = [
        'U40842034a9108a52263b5037fd4a5cef' => [
            'name' => 'เต',
            'userId' => 'U40842034a9108a52263b5037fd4a5cef',
            'walcome' => 'สวัสดีครับ'
        ]
    ];

    return $user[$userId];
}




echo "OK";
