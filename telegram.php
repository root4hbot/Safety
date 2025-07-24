<?php
$token = getenv('BOT_TOKEN');  // التوكن المشفّر
$chat_id = getenv('CHAT_ID');  // معرف البوت أو القناة

$data = json_decode(file_get_contents("php://input"), true);

$text = "📢 بلاغ جديد:\n" .
        "👤 الاسم: " . $data['name'] . "\n" .
        "📌 نوع الابتزاز: " . $data['type'] . "\n" .
        "📝 التفاصيل:\n" . $data['details'];

file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=" . urlencode($text));
?>