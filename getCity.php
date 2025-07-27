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

// 获取当前日期
$current_date = date('Y-m-d');

// 查询 end_date 小于等于当前日期的 city 并去重
$sql = "SELECT DISTINCT city FROM Wo_Events WHERE end_date <= ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $current_date);
$stmt->execute();
$result = $stmt->get_result();

$cities = [];
while ($row = $result->fetch_assoc()) {
    $cities[] = $row['city'];
}

// 关闭连接
$stmt->close();
$conn->close();

// 输出 JSON 结果
echo json_encode(["cities" => $cities]);
?>