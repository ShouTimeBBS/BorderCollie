<?php
header('Content-Type: text/html; charset=utf-8');
$apiKey = 'DeepSeekAPI'; 

$cities = $_POST['cities'] ?? [];
if (empty($cities)) {
    echo '<p>💔 没有城市数据</p>';
    exit;
}

$eventUrl = "getInfo.php?city=" . urlencode(implode(',', $cities));
$eventData = @file_get_contents($eventUrl);
$events = json_decode($eventData, true)['events'] ?? [];
if (empty($events)) {
    echo '<p>💔 这些城市暂时没有兽聚呢...</p>';
    exit;
}

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => 'https://api.deepseek.com/v1/chat/completions',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
CURLOPT_POSTFIELDS => json_encode([
        'model' => 'deepseek-chat',
        'messages' => [
            [
                "role" => "system",
                "content" => "用福瑞萌系风格推荐～尽量把所有的都描述的详细一点，有必要的话可以提供城市的相关信息，但一定要有亲和力"
                ."推荐要素：\n"
                ."温馨提示用💡"
                ."用讲述的方式介绍这些活动，而不是古板的格式"
                ."适当使用<p>来进行分段，使用<strong>进行强调，使用html语句和内嵌css来为内容添加颜色、标记重要信息\让它变得更好看更有色彩，使用包括<br>等标签来美化返回结果,同时给兽聚的名字加上超链接，位置是“https://www.shoutime.net/events/+id”，加上target=“_blank“"
                ."最后提醒这段文字是用AI生成，仅作为参考建议。"
            ],
            [
                "role" => "user",
                "content" => "请推荐最棒的活动：\n".json_encode($events, JSON_UNESCAPED_UNICODE)
            ]
        ],
        'temperature' => 0.7,
        'max_tokens' => 800
    ]),
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey
    ]
]);
$response = curl_exec($ch);
curl_close($ch);
$result = json_decode($response, true);
echo $result['choices'][0]['message']['content'] ?? '<p>（抖耳朵）推荐列表被藏起来啦～</p>';
?>
