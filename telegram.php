<?php
$token = getenv("BOT_TOKEN");
$chat_id = getenv("CHAT_ID");

// التأكد من استقبال البيانات بشكل صحيح
$data = json_decode(file_get_contents("php://input"), true);

// التحقق من وجود القيم
$name = isset($data['name']) ? $data['name'] : '❓ غير محدد';
$type = isset($data['type']) ? $data['type'] : '❓ غير معروف';
$details = isset($data['details']) ? $data['details'] : '❓ بدون تفاصيل';

// تركيب الرسالة
$text = "📢 بلاغ جديد:\n".
        "👤 الاسم: ".$name."\n".
        "📌 نوع الإنذار: ".$type."\n".
        "📝 التفاصيل:\n".$details;

// إرسال الرسالة
file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=".urlencode($text));
?>
