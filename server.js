const express = require('express');
const axios = require('axios');
const app = express();

app.use(express.json());  // لتعامل مع البيانات المدخلة بصيغة JSON

const token = 'YOUR_BOT_TOKEN'; // استبدله بتوكن البوت
const url = `https://api.telegram.org/bot${token}/sendMessage`;

// نقطة webhook لتلقي الرسائل
app.post('/webhook', async (req, res) => {
    const message = req.body.message;
    const chat_id = message.chat.id;  // استخرج chat_id من الرسالة

    // إرسال رد للمستخدم
    const responseText = "أهلاً بك! سيتم إرسال الأحاديث قريبًا.";

    // إرسال رسالة باستخدام Telegram API
    try {
        await axios.post(url, {
            chat_id: chat_id,
            text: responseText
        });
        res.send('تم إرسال الرسالة');
    } catch (error) {
        console.error('حدث خطأ في إرسال الرسالة:', error);
        res.status(500).send('حدث خطأ أثناء إرسال الرسالة');
    }
});

// نشر Webhook لـ Telegram
const setWebhook = async () => {
    const webhookUrl = `https://your-project-name.vercel.app/webhook`; // استبدله بالرابط الكامل لمشروعك على Vercel
    await axios.post(`https://api.telegram.org/bot${token}/setWebhook`, {
        url: webhookUrl
    });
};

// إعداد Webhook عند بدء تشغيل التطبيق
setWebhook();

// تحديد المنفذ
const port = process.env.PORT || 3000;
app.listen(port, () => {
    console.log(`Server is running on port ${port}`);
});
