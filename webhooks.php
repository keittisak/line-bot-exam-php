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

			$userId = $event['source']['userId'];
			$replyToken = $event['replyToken'];
			$text = $event['message']['text'];
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
            $query = $text;
            $corpus = array(
                1 => 'ใครไปบาง',
                2 => 'วันนี้กินอะไรดี',
                3 => 'มีเตะบอลไหม',
                4 => 'เย็ดเงี่ยนเงี้ยนชักว่าว',
                5 => 'มีดื่มไหม',
                6 => 'เอาไงร้านไหนดี',
                7 => 'ดื่มเบียร',
                8 => 'เหล้า',
                9 => 'กินเบียร',
                10 => 'เลี้ยงเบียร',
                11 => 'เบียรเย็นๆ',
                12 => 'ยังไงวันนี้'
            );
            
            foreach($corpus as $key => $text)
            {
                $sim = similar_text($query,$text, $perc);
                $result[$key] = [
                    'key' => $key,
                    'sim' => $sim,
                    'perc' => round($perc,5)
                ];
            }
            
            usort($result, function($a, $b) {
                return $a['sim'] < $b['sim'];
            });
    
            $number = rand(10,1000);
            $text = "https://www5.javmost.com/search/{$number}/";

            $botAnswer = [
                1 => [
                    'เอาเลยกูไม่ว่าง', 'คนอื่นว่าไง ?', 'กี่โมงดี',
                ],
                2 => [
                    'แดกอะไรก็แดกครับ', 'ส้นตีนไหม ?', 'กระเพาไปจบๆ', 'ข้าวผัด','สุกกี้ไง','ร้านเจ้บุมก็ได้นะ','ก๋วยเตี๋ยว', 'ลาบส้มตำ'
                ],
                3 => [
                    'กีฬาเป็นยาวิเศษ',
                ],
                4 => [
                    $text, 'ตีหรี่ไปจบๆ'
                ],
                5 => [
                    'กูยังไงก็ได้ยันเช้า', 'ได้หมดไม่เกินเที่ยงคืน'
                ],
                6 => [
                    'เจ้บุม', 'ร้านไหนก็ได้เพลงชิวๆ', 'ได้หมดไม่เกินเที่ยงคืน'
                ],
                7 => [
                    'ไปร้านไหมละ', 'ซื้อเข้ามาเลย', 'รอบ้านรัก', 'เอาไงบอกด้วย'
                ],
            ];
    
            if($result[0]['perc'] > 40)
            {
                $key = $result[0]['key'];
                if(in_array($key,[7,8,9,10,11,12]))
                {
                    $key = 7;
                }
    
                $botAnswerKey = $botAnswer[$key];
                $text = $botAnswerKey[array_rand($botAnswerKey)];

                $data['messages'][0]['text'] = $text;
            }else{
                exit();
            }

            
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








echo "OK";
