<?php
$token = getenv("BOT_TOKEN");
$chat_id = getenv("CHAT_ID");

// السماح فقط بطلب POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "⚠️ يجب إرسال الطلب بطريقة POST";
    exit;
}

// قراءة البيانات القادمة بصيغة JSON
$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

// التحقق من صلاحية البيانات
if (!is_array($data)) {
    http_response_code(400);
    echo "⚠️ البيانات غير صالحة أو ليست JSON.";
    exit;
}

// استخراج الحقول
$name = isset($data['name']) ? $data['name'] : '❓ الاسم غير محدد';
$type = isset($data['type']) ? $data['type'] : '❓ النوع غير واضح';
$details = isset($data['details']) ? $data['details'] : '❓ لا توجد تفاصيل';

// تركيب الرسالة
$text = "📢 بلاغ جديد:\n";
$text .= "👤 الاسم: $name\n";
$text .= "📌 نوع الابتزاز: $type\n";
$text .= "📝 التفاصيل:\n$details";

// إرسال عبر curl
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

// الرد على المستخدم
if ($response) {
    echo "✅ البلاغ أُرسل بنجاح إلى البوت";
} else {
    http_response_code(500);
    echo "⚠️ فشل في إرسال البلاغ: $error";
}
?>
