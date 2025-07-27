<?php
header('Content-Type: application/json');

$servername = ""; // 数据库服务器
$username = ""; // 数据库用户名
$password = ""; // 数据库密码
$dbname = ""; // 数据库名

// 创建数据库连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接是否成功
if ($conn->connect_error) {
    die(json_encode(["error" => "数据库连接失败: " . $conn->connect_error]));
}

// 获取 GET 请求中的 city 参数，并拆分为数组
$city_param = isset($_GET['city']) ? $_GET['city'] : '';
if (empty($city_param)) {
    die(json_encode(["error" => "请提供 city 参数"]));
}

$cities = explode(',', $city_param);
$cities = array_map('trim', $cities);

// 获取当前日期
$current_date = date('Y-m-d');

// 生成 SQL 查询
$placeholders = implode(',', array_fill(0, count($cities), '?'));
$sql = "SELECT id, name, theme, style, culture, status, start_date, location, city 
        FROM Wo_Events 
        WHERE city IN ($placeholders) AND end_date >= ?";

$stmt = $conn->prepare($sql);

// 合并城市列表和当前日期参数
$params = array_merge($cities, [$current_date]);

// 创建参数类型字符串（全部为字符串类型 's'）
$types = str_repeat('s', count($params));

// 绑定参数
$stmt->bind_param($types, ...$params);

$stmt->execute();
$result = $stmt->get_result();

$events = [];
while ($row = $result->fetch_assoc()) {
    // 过滤掉值为空的字段
    $filteredRow = array_filter($row, function ($value) {
        return !empty($value);
    });
    $events[] = $filteredRow;
}

// 关闭连接
$stmt->close();
$conn->close();

// 输出 JSON 结果
echo json_encode(["events" => $events]);
?>