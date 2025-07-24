<?php
// استدعاء التوكن والمعرف من البيئة
$token = getenv("BOT_TOKEN");
$chat_id = getenv("CHAT_ID");

// التحقق من نوع الطلب
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "⚠️ الطلب غير مسموح، يجب أن يكون POST";
    exit;
}

// استقبال البيانات وفك JSON
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

// التحقق من أن البيانات وصلت بصيغة صحيحة
if (!is_array($data)) {
    http_response_code(400);
    echo "⚠️ البيانات غير صالحة أو ليست بصيغة JSON.";
    exit;
}

// استخراج القيم مع تحقق من وجودها
$name = isset($data['name']) ? $data['name'] : '❓ الاسم غير موجود';
$type = isset($data['type']) ? $data['type'] : '❓ النوع غير محدد';
$details = isset($data['details']) ? $data['details'] : '❓ لا توجد تفاصيل';

// تركيب الرسالة
$message = "📢 بلاغ جديد:\n";
$message .= "👤 الاسم: $name\n";
$message .= "📌 نوع الابتزاز: $type\n";
$message .= "📝 التفاصيل:\n$details";

// إرسال البلاغ إلى تلغرام
$response = file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=" . urlencode($message));

// تأكيد الإرسال
if ($response) {
    echo "✅ تم إرسال البلاغ إلى البوت";
} else {
    http_response_code(500);
    echo "⚠️ فشل في إرسال البلاغ.";
}
?>
