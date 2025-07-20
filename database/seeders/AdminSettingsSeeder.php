<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->settings() as $setting) {
            DB::table('admin_setting')->insert([
                'admin_id' => 1,
                'setting_key' => $setting['setting_key'],
                'setting_value' => $setting['setting_value'],
            ]);
        }
    }

    public function settings()
    {
        return [
            [
                'setting_key' => 'address',
                'setting_value' => 'airport, Beirut, Lebanon',
            ],
            [
                'setting_key' => 'email',
                'setting_value' => 'info@click-to-pick.com',
            ],
            [
                'setting_key' => 'phone',
                'setting_value' => '+961 76 074 421',
            ],
            [
                'setting_key' => 'facebook',
                'setting_value' => 'https://www.facebook.com/clicktopick8',
            ],
            [
                'setting_key' => 'instagram',
                'setting_value' => 'https://www.instagram.com/clicktopick8',
            ],
            [
                'setting_key' => 'tiktok',
                'setting_value' => 'https://www.tiktok.com/@clicktopick8',
            ],
            [
                'setting_key' => 'x',
                'setting_value' => 'https://www.x.com/clicktopick8',
            ],
            [
                'setting_key' => 'telegram',
                'setting_value' => 'https://t.me/clicktopick8',
            ],
            [
                'setting_key' => 'whatsapp',
                'setting_value' => 'https://wa.me/message/ARXAXWVSDSVQO1',
            ],
            [
                'setting_key' => 'ar_about',
                'setting_value' => 'نحن بوابة الكل في واحد توفر الحقن واللوازم الطبية عالية الجودة. يمنحك موقعنا الإلكتروني الفرصة لتصفح المنتجات الأكثر شعبية في السوق ومقارنتها والحصول عليها بدون متاعب. نهدف إلى تقديم أفضل خدمة للعيادات الطبية والمنتجعات الصحية في جميع أنحاء العالم. نحن نقدم منتجات طبية متميزة للمهنيين الصحيين وجراحي التجميل وأطباء الأمراض الجلدية وخبراء التجميل المرخصين وغيرهم من المتخصصين. اختر من بين الحشوات الجلدية الأصلية ذات العلامات التجارية ، وعلاجات الميزوثيرابي ، وحلول تقويم العظام ، والعديد من المنتجات الأصلية الأخرى ذات العلامات التجارية لتحسين نوعية حياة مريضك. كذلك ، يمكنك العثور على مراجعات لجميع منتجاتنا التي تركها متخصصون مثلك ، ويمكنك حتى ترك مراجعتك الخاصة.',
            ],
            [
                'setting_key' => 'ar_vision',
                'setting_value' => 'بينما نمضي قدما نحو هدفنا المتمثل في أن نكون المورد الأول لتقويم العظام ومستحضرات التجميل ، ومساعدة الناس على الاستمتاع بالحياة من خلال تقديم حل ميسور التكلفة للرعاية الصحية ، نعتزم تزويد عملائنا بأفضل تجربة تسوق ممكنة. من صفحة الترحيب إلى اللحظة التي يصل فيها طلبك إلى عتبة داركم ، بفضل موقع ويب ذكي وقابل للبحث ، وتعليمات سهلة المتابعة ، وفريق خدمة عملاء ودود ومفيد ، نضمن تجربة طلب سريعة وعالية الجودة مع مجموعة متنوعة واضحة وآمنة من طرق الدفع.',
            ],
            [
                'setting_key' => 'ar_mission',
                'setting_value' => 'نحن شركة طبية تقدم مجموعة واسعة من حلول التجميل وتقويم العظام المهنية لأخصائيي الرعاية الصحية في جميع أنحاء العالم. نحن ملتزمون بضمان حصول عملائنا على منتجات عالية الجودة بأسعار الجملة التنافسية من أوروبا. نريد مساعدتك على تحقيق أقصى استفادة من عملك الطبي من خلال تزويدك بالحشوات الجلدية الأصلية ذات العلامات التجارية وغيرها من المنتجات بأقل سعر مضمون. يسعى فريقنا جاهدا لضمان تلبية منتجاتنا وخدماتنا من الدرجة الأولى',
            ],
            [
                'setting_key' => 'en_about',
                'setting_value' => 'We are an all-in-one portal supplying high-quality medical injectables and supplies. Our website give you the chance to browse, compare, and obtain the most popular products on the market hassle-free. We aim to deliver the best service to medical clinics and spas worldwide. We offer premium medical products to health professionals, plastic surgeons, dermatologists, licensed estheticians, and other specialists. Choose from genuine, brand name dermal fillers, mesotherapy treatments, orthopedic solutions, and many other genuine, brand name products to improve your patient’s quality of life. As well, you can find reviews for all of our products left by specialists like you , and you can even leave your own review.',
            ],
            [
                'setting_key' => 'en_vision',
                'setting_value' => 'As we move forward towards our goal of being the premier orthopedic and cosmetic supplier, helping people enjoy life with offering an affordable solution to health care, we intend to provide our customers with the best possible shopping experience. From the welcome page to the moment your order reaches your doorstep, by virtue of a smart, searchable website, easy-to-follow instructions, and a friendly and helpful customer service team, we guarantee a fast, quality order experience with a clear and secure variety of payment methods.',
            ],
            [
                'setting_key' => 'en_mission',
                'setting_value' => 'We are a medical company offering a wide variety of professional cosmetic and orthopedic solutions for health-care professionals around the world. We are dedicated to ensuring our customers get the high quality products at competitive wholesale prices from Europe. We want to help you make the most of your medical business by providing you with the authentic, brand name dermal fillers and other products at the guaranteed lowest price. Our team strives to ensure that our products and services meet are first-rate',
            ],
        ];
    }
}
