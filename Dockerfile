# نستخدم صورة تحتوي PHP مع Apache خادم ويب
FROM php:8.2-apache

# ننسخ جميع ملفات المشروع إلى مجلد تشغيل السيرفر
COPY . /var/www/html/

# نفتح منفذ 80 ليستقبل الطلبات HTTP
EXPOSE 80