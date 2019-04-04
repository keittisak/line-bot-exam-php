<?php // callback.php

require "vendor/autoload.php";
require_once('vendor/linecorp/line-bot-sdk/line-bot-sdk-tiny/LINEBotTiny.php');

$access_token = 'gqgEkKz8kKUIJ9XwgmBhK3ZbPnzK2W4H6XfBmLMXZ8UJjzmCy9NSzldWU0XFDYK9+Oz6tpXagzwmtOvRfZvfpYFsIe51T9vX2ljZ79r2xu7UYZj/nyXgUdstJ6qc0aiFAUzQXf303D3Tx8Uq4DcV5QdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
$headers = getallheaders();

// $headers['Host'] = "bots.dialogflow.com";
$headers['Content-type'] = 'application/json;charset=UTF-8';
$url = 'https://bots.dialogflow.com/line/00a963e0-b8e1-435f-affe-92a6cb6be622/webhook';

$post = json_encode($events);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result . "\r\n";

exit();





$url = 'https://api.line.me/v2/bot/message/push';
$data = [
    "to" => "U40842034a9108a52263b5037fd4a5cef",
    'messages' => [
        [
            'type' => 'text',
            'text' => 'test, '.json_encode($headers).', '.$content
        ]
    ],
];
$post = json_encode($data);
$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result . "\r\n";

exit();



// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
        if($event['source']['groupId'] == "C81fe2451f7fbe94a4d47564386844e04")
        {
            exit();
        }

        $userId = $event['source']['userId'];
        $replyToken = $event['replyToken'];
        $text = $event['message']['text'];
        $messages = [
            'type' => 'text',
            'text' => $content
        ];

        $url = 'https://api.line.me/v2/bot/message/push';
        $data = [
            "to" => "U40842034a9108a52263b5037fd4a5cef",
            'messages' => [$messages],
        ];
        $post = json_encode($data);
        $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);

        echo $result . "\r\n";

        exit();


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
			
			
			if($event['source']['groupId'] != "C81fe2451f7fbe94a4d47564386844e04")
			{
                 		//exit();
				$data['messages'][0]['text'] = $content;
            		}else{
				$text = createAnswer($text);
            			$data['messages'][0]['text'] = $text;
			}

		}else{
            $url = 'https://api.line.me/v2/bot/message/reply';
            $data = [
				'replyToken' => $event['replyToken'],
				'messages' => [
                    'type' => 'text',
                    'text' => $content
                ],
            ];
            $post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
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


function createAnswer ($text)
{
        $query = $text;

        $corpus = [
            '1' => [
                'เงี่ยน','เงี้ยน', 'ชักว่าว',
            ],
            '2' => [
                'กินเบียร','เหล้า','มีดื่มไหม','ยังไง'
            ],
            '3' => [
                'วันนี้กินอะไรดี'
            ],
            '4' => [
                'เตะบอล', 'มีเตะบอลไหม'
            ],
            '5' => [
                'ใครไปบาง'
            ],
            '6' => [
                'มึงบอท','บอทควย','บอทว่าไง','สัสบอท','บอทเมิง'
            ],
            '7' => [
                'วันไหน'
            ]

        ];
        
        foreach($corpus as $key => $texts)
        {
            foreach($texts as $index => $text)
            {
                $sim = similar_text($query,$text, $perc);
                $result[$key][$index] = [
                    'key' => $key,
                    'sim' => $sim,
                    'perc' => round($perc,5)
                ];
            }

            usort($result[$key], function($a, $b) {
                return $a['sim'] < $b['sim'];
            });
        }

        foreach($result as $key => $val)
        {
            $results[$key] = [
                'key' => $key,
                'sim' => $val[0]['sim'],
                'perc' => $val[0]['perc'],
            ];
        }
        
        usort($results, function($a, $b) {
            return $a['sim'] < $b['sim'];
        });
        // echo '<pre>';
        // print_r($results);
        // exit();

        $number = rand(10,1000);
        $text = "https://www5.javmost.com/search/{$number}/";
        $botAnswer = [
                    0 => [
                        'แล้วมึงนะจะยังไง','อ่าวแล้วแต่มึงเลย','กูไม่รู้','อยู่ที่มึงอ่ะพร้อมป่าว'
                    ],
                    1 =>[
                        $text, 'ตีหรี่ไปจบๆ'
                    ],
                    2 => [
                        'ไปร้านไหมละ', 'ซื้อเข้ามาเลย', 'รอบ้านรัก', 'เอาไงบอกด้วย','เจ้บุม', 'ร้านไหนก็ได้เพลงชิวๆ', 'ได้หมดไม่เกินเที่ยงคืน','กูยังไงก็ได้ยันเช้า', 'ได้หมดไม่เกินเที่ยงคืน','แล้วเมิงนะยังไง'
                    ],
                    3 => [
                        'แดกอะไรก็แดกครับ', 'ส้นตีนไหม ?', 'กระเพาไปจบๆ', 'ข้าวผัด','สุกกี้ไง','ร้านเจ้บุมก็ได้นะ','ก๋วยเตี๋ยว', 'ลาบส้มตำ','อย่าเยอะ'
                    ],
                    4 => [
                        'กีฬาเป็นยาวิเศษ',
                    ],
                    5 => [
                        'เอาเลยกูไม่ว่าง', 'คนอื่นว่าไง ?', 'กี่โมงดี', 'เอาที่พวกเมิงสะดวก','แล้วแต่พวกเมิงเลย','ไปไม่ได้วะติดธุระอยู่','วันอื่นละกัน','กูผ่านก่อน'
                    ],
                    6 => [
                        'ยุ่งควยอะไรระ', 'อย่ามาเพ่อเจ่อ','เสือกสัส','แล้วไง', 'ไปเล่นที่อื่นไป','เพื่อนเล่นเมิงว่างั้น','ควยทุกคน','ตบกระบานให้','อย่ามายุ่งอารมณ์ไม่ดี','ไปไหนก็ไปลำคาน'
                    ],
                ];
                        $perc = 67;
                        $key = $results[0]['key'];
                        if($key == 6)
                        {
                            $perc = 52;
                        }elseif($key == 7)
                        {
                            $key = 5;
                        }

                        if($results[0]['perc'] > $perc)
                        {
                            $botAnswerKey = $botAnswer[$key];

                            if($key == 2)
                            {
                                $botAnswerKey = array_merge($botAnswer[0],$botAnswer[5]);
                            }
                            $text = $botAnswerKey[array_rand($botAnswerKey)];
                            return $text;
                        }else{
                            exit();
                        }
}

echo "OK";
