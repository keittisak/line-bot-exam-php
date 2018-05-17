<?php // callback.php

require "vendor/autoload.php";
require_once('vendor/linecorp/line-bot-sdk/line-bot-sdk-tiny/LINEBotTiny.php');

$access_token = 'l+1VpD3vmv65IYaVLiyU879d0C+Gi5uZn5BfOW1XR6Yhz8ECIi7/F7layiifZM+z+Oz6tpXagzwmtOvRfZvfpYFsIe51T9vX2ljZ79r2xu4cDg/FbTR5VZD1udEgdbT8MjwQV/vYx2xL+KTxoyW3eAdB04t89/1O/w1cDnyilFU=';

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
			
			if($event['source']['groupId'] !== "C81fe2451f7fbe94a4d47564386844e04")
			{
                $res = groupBtl($events);
                $post = json_encode($res);
                
			}

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

function groupBtl($event)
{
    $userId = $event['source']['userId'];
    $text = $event['message']['text'];

    $checkName = stripos($text, "ชื่อ");
    if($checkName)
    {
        $messages = [
            'type' => 'text',
            'text' => 'นี้คือข้อมูล /n/r '.json_encode($event)
        ];

        return $messages;
    }
    

    
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
