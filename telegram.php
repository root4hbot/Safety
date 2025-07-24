<?php
$token = getenv("BOT_TOKEN");
$chat_id = getenv("CHAT_ID");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "⚠️ الطلب غير مسموح، يجب أن يكون POST";
    exit;
}

$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

if (!is_array($data)) {
    http_response_code(400);
    echo "⚠️ البيانات غير صالحة أو ليست بصيغة JSON.";
    exit;
}

$name = isset($data['name']) ? $data['name'] : '❓ الاسم غير موجود';
$type = isset($data['type']) ? $data['type'] : '❓ النوع غير معروف';
$details = isset($data['details']) ? $data['details'] : '❓ لا توجد تفاصيل';

$text = "📢 بلاغ جديد:\n";
$text .= "👤 الاسم: $name\n";
$text .= "📌 نوع الابتزاز: $type\n";
$text .= "📝 التفاصيل:\n$details";

$url = "https://api.telegram.org/bot$token/sendMessage";
$payload = [
    "chat_id" => $chat_id,
    "text" => $text
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

if ($response) {
    echo "✅ تم إرسال البلاغ إلى البوت";
} else {
    http_response_code(500);
    echo "⚠️ فشل في إرسال البلاغ: $error";
}
?>
