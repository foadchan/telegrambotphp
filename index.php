<?php

// 1. الإعدادات الأساسية
$bot_token = '7552519299:AAEhE5noFW-QYiw6ZNcnV2BDMDkp7TaErQE'; // ضع هنا توكن البوت الخاص بك

// 2. الحصول على التحديثات من API (رسائل جديدة)
$update = file_get_contents("https://api.telegram.org/bot$bot_token/getUpdates");
$updates = json_decode($update, TRUE);

// 3. إذا كان هناك تحديثات، نحصل على chat_id من أول رسالة.
if (isset($updates['result'][0])) {
    $chat_id = $updates['result'][0]['message']['chat']['id'];
    
    // حفظ chat_id في ملف أو قاعدة بيانات لاستخدامه لاحقًا
    // سنخزنه في ملف نصي هنا كمثال
    file_put_contents('chat_id.txt', $chat_id);
    
    // يمكنك طباعة الـ chat_id في البداية للتحقق
    echo "Chat ID: " . $chat_id . "\n";
} else {
    echo "لا توجد رسائل جديدة.";
}

// 4. مجموعة من الأحاديث النبوية
$ahadith = [
    "عن عبد الله بن مسعود قال: قال رسول الله صلى الله عليه وسلم: (من لا يشكر الناس لا يشكر الله)",
    "قال رسول الله صلى الله عليه وسلم: (إنما الأعمال بالنيات، وإنما لكل امرئ ما نوى)",
    "قال رسول الله صلى الله عليه وسلم: (من سلك طريقًا يلتمس فيه علمًا، سهل الله له به طريقًا إلى الجنة)",
    "قال رسول الله صلى الله عليه وسلم: (خير الناس أنفعهم للناس)",
    "عن أبي هريرة رضي الله عنه قال: قال رسول الله صلى الله عليه وسلم: (من لا يغفر للناس لا يغفر له)"
];

// 5. دالة لإرسال رسالة إلى التليجرام
function sendMessage($bot_token, $chat_id, $message) {
    $url = "https://api.telegram.org/bot$bot_token/sendMessage?chat_id=$chat_id&text=" . urlencode($message);
    file_get_contents($url); // إرسال الرسالة عبر API
}

// 6. إرسال حديث عشوائي
function sendRandomHadith($bot_token, $chat_id, $ahadith) {
    $random_hadith = $ahadith[array_rand($ahadith)]; // اختيار حديث عشوائي
    sendMessage($bot_token, $chat_id, $random_hadith); // إرسال الحديث
}

// 7. إذا تم العثور على chat_id، نرسل رسالة
if (isset($chat_id)) {
    sendRandomHadith($bot_token, $chat_id, $ahadith); // إرسال حديث
}

?>
