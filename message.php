<?php
// 设置响应头为 JSON
header('Content-Type: application/json; charset=utf-8');

// 数据库连接信息
$servername = "";
$username = "";  // 你的数据库用户名
$password = "";  // 你的数据库密码
$dbname = "";  // 你的数据库名称

// 创建数据库连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接是否成功
if ($conn->connect_error) {
    echo json_encode(["error" => "连接数据库失败: " . $conn->connect_error]);
    exit;
}

// 获取 POST 请求中的 message
$message = $_POST['message'] ?? '';
$ip = $_POST['ip'] ?? '';

// 验证 message 是否为空
if (empty($message) || empty($location)) {
    echo json_encode(["error" => "message 参数缺失"]);
    exit;
}

// 获取当前时间
$currentTime = date('Y-m-d H:i:s');

// 准备 SQL 插入语句
$sql = "INSERT INTO SI_message (message, time, ip) VALUES (?,  ?, ?)";

// 使用 prepared statements 避免 SQL 注入
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo json_encode(["error" => "准备 SQL 语句失败"]);
    exit;
}

// 绑定参数并执行
$stmt->bind_param("sss", $message, $currentTime, $ip);

if ($stmt->execute()) {
    // 成功插入后返回成功消息
    echo json_encode(["success" => "写入成功", "id" => $stmt->insert_id, "time" => $currentTime]);
} else {
    // 如果插入失败，返回错误信息
    echo json_encode(["error" => "写入失败: " . $stmt->error]);
}

// 关闭数据库连接
$stmt->close();
$conn->close();
?>
