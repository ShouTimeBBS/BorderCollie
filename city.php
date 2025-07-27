<?php
header('Content-Type: application/json; charset=utf-8');

// 新增：获取POST参数中的城市
$city = trim($_POST['city'] ?? '');
if (empty($city)) {
    echo json_encode(["error" => "出现错误,请联系兽时社区管理员"]);
    exit;
}

$cityData = @file_get_contents('getCity.php');
if (!$cityData) {
    echo json_encode(["error" => "无法获取城市数据"]);
    exit;
}

$cities = json_decode($cityData, true)['cities'] ?? [];
if (empty($cities)) {
    echo json_encode(["error" => "未找到城市"]);
    exit;
}

$apiKey = '这里输入DeepSeekAPI'; 
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
                "content" => "你是个活泼的福瑞，用逗号分隔回答。说话带爪印符号和emoji～比如：'目前有兽聚活动的城市离您最近的有:🐾→ 天津,廊坊。请稍等一下，我整理一下这些信息。'"
            ],
            [
                "role" => "user",
                // 修改这里：将硬编码的"淮北"替换为$city变量
                "content" => "我在{$city}，下面哪些城市离我最近？（如果本地也在,则也写上去,如果没有则只选离本地最近的,最多选3个,）：\n".implode("、", $cities)
            ]
        ],
        'temperature' => 0.6
    ]),
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Authorization: Bearer '.$apiKey
    ]
]);

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo json_encode(["error" => "筛选失败：".curl_error($ch)]);
    exit;
}

$result = json_decode($response, true);
$cityText = $result['choices'][0]['message']['content'] ?? '';
preg_match_all('/[\x{4e00}-\x{9fa5}]+/u', $cityText, $matches);
$nearbyCities = array_slice(array_unique($matches[0]), 0, 3);

if (empty($nearbyCities)) {
    echo json_encode(["error" => "筛选后没有找到城市"]);
    exit;
}

echo json_encode(["cities" => $nearbyCities]);
?>
