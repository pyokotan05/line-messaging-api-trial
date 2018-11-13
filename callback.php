<?php 
$accessToken = 'Y4O+Ps//15cLCZV5cdvmSJb2LvSRr/zuaoTzd5S3y68UVpRDRf93kGdjH9LTc1eY3woKa4DucQZ/MktViQQRebdWAPxrNoCp9F888RcdUipE87Va17h7d1ao+cJ0V9kaQDVSXSlBaOpWv0ximF9qSwdB04t89/1O/w1cDnyilFU='; 
$jsonString = file_get_contents('php://input'); error_log($jsonString); 
$jsonObj = json_decode($jsonString); $message = $jsonObj->{"events"}[0]->{"message"}; 
$replyToken = $jsonObj->{"events"}[0]->{"replyToken"};


 // 送られてきたメッセージの中身からレスポンスのタイプを選択 
if ($message->{"text"} == 'あいさつ') {
     // 確認ダイアログタイプ 
    $messageData = [ 
        'type' => 'template', 
        'altText' => '確認ダイアログ', 
        'template' => [ 'type' => 'confirm', 'text' => 'あなたのインナーチャイルド、今日も元気？', 
            'actions' => [
                [ 'type' => 'message', 'label' => '元気です', 'text' => '元気です' ],
                [ 'type' => 'message', 'label' => 'まあまあです', 'text' => 'まあまあです' ], 
            ] 
        ]
 ]; 
} elseif ($message->{"text"} == 'ボタン') { 
    // ボタンタイプ 
    $messageData = [ 
        'type' => 'template',
         'altText' => 'ボタン', 
        'template' => [
             'type' => 'buttons',
             'title' => 'タイトルです',
             'text' => '選択してね', 
            'actions' => [
                 [ 
                    'type' => 'postback', 
                    'label' => 'webhookにpost送信', 
                    'data' => 'value' 
                ],
                 [
                     'type' => 'uri',
                     'label' => 'google', 
                     'uri' => 'https://google.com' 
                 ]
              ]
          ] 
     ]; 
} elseif ($message->{"text"} == 'カルーセル') {
     // カルーセルタイプ 
    $messageData = [ 
        'type' => 'template', 
        'altText' => 'カルーセル', 
        'template' => [
             'type' => 'carousel', 
            'columns' => [ 
                [ 
                    'title' => 'カルーセル1', 
                    'text' => 'カルーセル1です',
                     'actions' => [
                         [
                            'type' => 'postback',
                             'label' => 'webhookにpost送信',
                             'data' => 'value'
                         ],
                         [ 
                            'type' => 'uri', 
                            'label' => '美容の口コミ広場を見る',
                             'uri' => 'http://clinic.e-kuchikomi.info/'
                         ] 
                    ] 
                ],
                 [ 
                        'title' => 'カルーセル2', 
                        'text' => 'カルーセル2です', 
                        'actions' => [ 
                            [
                                'type' => 'postback', 
                                'label' => 'webhookにpost送信', 
                                'data' => 'value' 
                            ], 
                            [ 
                                'type' => 'uri', 
                                'label' => '女美会を見る', 
                                'uri' => 'https://jobikai.com/' 
                            ] 
                        ] 
                    ], 
                ] 
            ] 
    ];
 }elseif ($message->{"text"} == 'カツドン') {
    // カツドン紹介メッセージ 
    $messageData = [ 
        'type' => 'template',
         'altText' => 'ボタン', 
        'template' => [
             'type' => 'buttons',
             'title' => 'タイトルです',
             'text' => '宮城県仙台市泉区虹の丘2-6-13在住の31歳無職童貞YouTuberカツドン（本名は浅野）のことがもっと知りたい方はこちら！', 
            'actions' => [
                [
                    'type' => 'uri',
                    'label' => 'カツドンチャンネル@wiki', 
                    'uri' => 'https://www65.atwiki.jp/katudonchannel/pages/15.html' 
                ],
                 [
                     'type' => 'uri',
                     'label' => 'カツドンチャンネル破壊動画集', 
                     'uri' => 'https://www.youtube.com/watch?v=8NgJE3cMLcY' 
                 ]
              ]
          ] 
     ]; 
 } elseif ($message->{"text"} == '写真') {
     //カツドン写真集
　  $messageData = [
    'type' ==> 'image',
    'originalContentUrl' ==> 'https://i.ytimg.com/vi/aPMy0sBZct4/hqdefault.jpg'
    'previewImageUrl' ==> 'https://i.ytimg.com/vi/aPMy0sBZct4/hqdefault.jpg'
];
    }   else {
     // それ以外は送られてきたテキストをオウム返し
     $messageData = [ 'type' => 'text', 'text' => $message->{"text"} ]; 
} 
$response = [ 'replyToken' => $replyToken, 'messages' => [$messageData] ]; 
error_log(json_encode($response)); 
$ch = curl_init('https://api.line.me/v2/bot/message/reply'); 
curl_setopt($ch, CURLOPT_POST, true); 
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST'); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response)); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json; charser=UTF-8', 'Authorization: Bearer ' . $accessToken )); 
$result = curl_exec($ch); error_log($result); 
curl_close($ch);