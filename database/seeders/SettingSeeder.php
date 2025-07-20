<?php

namespace Database\Seeders;

use App\Models\Attributes\RichTextBox;
use App\Models\Attributes\Text;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = Setting::where('key', 'app.about-us')->first();
        if (! $setting) {
            $setting = Setting::create(['key' => 'app.about-us', 'type' => 'rich_text_box']);
            $text = new RichTextBox(['value' => '<p>This is About Us</p>']);
            $text->setting()->associate($setting);
            $text->save();
        }

        $settingContact = Setting::where('key', 'app.contact-us')->first();
        if (! $settingContact) {
            $setting = Setting::create(['key' => 'app.contact-us', 'type' => 'rich_text_box']);
            $text = new RichTextBox(['value' => '<p>This is contact us</p>']);
            $text->setting()->associate($setting);
            $text->save();
        }

        $settingTerms = Setting::where('key', 'app.terms-conditions')->first();
        if (! $settingTerms) {
            $setting = Setting::create(['key' => 'app.terms-conditions', 'type' => 'rich_text_box']);
            $text = new RichTextBox(['value' => '<p>This is terms & conditions</p>']);
            $text->setting()->associate($setting);
            $text->save();
        }

        $settingPrivacy = Setting::where('key', 'app.privacy-policy')->first();
        if (! $settingPrivacy) {
            $setting = Setting::create(['key' => 'app.privacy-policy', 'type' => 'rich_text_box']);
            $text = new RichTextBox(['value' => '<p>This is privacy policy</p>']);
            $text->setting()->associate($setting);
            $text->save();
        }

        $settingMainCompanyName = Setting::where('key', 'mail-service.company_name')->first();
        if (! $settingMainCompanyName) {
            $setting = Setting::create(['key' => 'mail-service.company_name', 'type' => 'text']);
            $text = new Text(['value' => 'green-leaf']);
            $text->setting()->associate($setting);
            $text->save();
        }

        $settingMainCompanyAddress = Setting::where('key', 'mail-service.address')->first();
        if (! $settingMainCompanyAddress) {
            $setting = Setting::create(['key' => 'mail-service.address', 'type' => 'text']);
            $text = new Text(['value' => 'green-leaf Street 24.FT']);
            $text->setting()->associate($setting);
            $text->save();
        }

        $settingMainCompanyNumber = Setting::where('key', 'mail-service.phone_num')->first();
        if (! $settingMainCompanyNumber) {
            $setting = Setting::create(['key' => 'mail-service.phone_num', 'type' => 'text']);
            $text = new Text(['value' => '0101999999']);
            $text->setting()->associate($setting);
            $text->save();
        }

        $settingMainCompanyUrl = Setting::where('key', 'mail-service.url')->first();
        if (! $settingMainCompanyUrl) {
            $setting = Setting::create(['key' => 'mail-service.url', 'type' => 'text']);
            $text = new Text(['value' => 'http://green-leaf.com']);
            $text->setting()->associate($setting);
            $text->save();
        }

        $settingMainCompanyUrlTitle = Setting::where('key', 'mail-service.url_title')->first();
        if (! $settingMainCompanyUrlTitle) {
            $setting = Setting::create(['key' => 'mail-service.url_title', 'type' => 'text']);
            $text = new Text(['value' => 'green-leaf']);
            $text->setting()->associate($setting);
            $text->save();
        }

        $settingAdminName = Setting::where('key', 'admin.name')->first();
        if (! $settingAdminName) {
            $setting = Setting::create(['key' => 'admin.name', 'type' => 'text']);
            $text = new Text(['value' => 'green-leaf admin']);
            $text->setting()->associate($setting);
            $text->save();
        }

        $settingAdminEmail = Setting::where('key', 'admin.email')->first();
        if (! $settingAdminEmail) {
            $setting = Setting::create(['key' => 'admin.email', 'type' => 'text']);
            $text = new Text(['value' => 'admin@green-leaf.com']);
            $text->setting()->associate($setting);
            $text->save();
        }

    }
}
