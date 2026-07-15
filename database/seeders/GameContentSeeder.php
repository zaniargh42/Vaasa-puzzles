<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Game;
use App\Models\Stage;
use Illuminate\Database\Seeder;

class GameContentSeeder extends Seeder
{
    public function run(): void
    {
        $city = City::query()->updateOrCreate(
            ['slug' => 'vaasa'],
            [
                'name_fa' => 'واسا',
                'name_en' => 'Vaasa',
                'description_fa' => 'شهر ساحلی غرب فنلاند؛ محل اولین بازی‌های شهری این پلتفرم.',
                'is_active' => true,
            ],
        );

        $game = Game::query()->updateOrCreate(
            ['city_id' => $city->id, 'slug' => 'twelve-barrels'],
            [
                'title_fa' => 'دوازده بشکه',
                'title_en' => 'Twelve Barrels: The Hidden Grain of Nikolaistad',
                'subtitle_fa' => 'پروندهٔ غله‌های پنهان نیکولاین‌کائوپونکی',
                'description_fa' => 'نوامبر ۱۸۶۷. بخشی از یک محمولهٔ امدادی چاودار پس از ورود به نیکولاین‌کائوپونکی ناپدید شده است. شما به‌عنوان بازرس ویژهٔ سنا، پانزده ایستگاه شهر را طی می‌کنید تا حقیقت را بیابید.',
                'stage_count' => 15,
                'is_active' => true,
            ],
        );

        Stage::query()->where('game_id', $game->id)->delete();

        foreach ($this->stages() as $stage) {
            Stage::query()->create([
                'game_id' => $game->id,
                ...$stage,
            ]);
        }
    }

    private function stages(): array
    {
        return [
            [
                'order' => 1,
                'act' => 1,
                'location_fa' => 'کلیسای ارتدوکس سنت نیکلاس و یادمان Setterberg',
                'title_fa' => 'شهری که از نو رسم شد',
                'intro_text' => "نیکولاین‌کائوپونکی، ۲۰ نوامبر ۱۸۶۷\n\nپانزده سال از آتشی می‌گذرد که واسای قدیم را بلعید. شهر تازه با خیابان‌های پهن، میدان‌های باز و ساختمان‌های آجری سر برآورده است؛ اما این بار دشمن آتش نیست.\n\nنامهٔ سنا می‌گوید بخشی از یک محمولهٔ امدادی غله، پس از ورود به شهر ناپدید شده است. نام دو مرد بیش از همه در کوچه‌ها تکرار می‌شود: آنتی ایسوتالو و آنتی رانان‌یروی.\n\nنخست نقشه را پیدا کنید. شهری که از نو طراحی شد، مسیر غله را نیز در خود نگه داشته است.",
                'code' => 'VANKILA',
                'code_alternatives' => null,
                'next_destination_fa' => 'زندان واسا',
            ],
            [
                'order' => 2,
                'act' => 1,
                'location_fa' => 'زندان واسا',
                'title_fa' => 'مردان پشت میله',
                'intro_text' => "مردم شهر می‌گویند حتی میله‌های زندان هم برای مهار نام دو آنتی کافی نیست.\n\nنگهبان دفترش را باز می‌کند:\n\n«من با ترانه و شایعه کار ندارم، بازرس. ساعت ورود، شمارش شبانه و کلیدها را می‌شناسم. اگر این دو نفر غله را برده‌اند، باید اول از میان این اعداد فرار کرده باشند.»",
                'code' => 'VALO',
                'code_alternatives' => ['VALO KIRJOITTAA'],
                'next_destination_fa' => 'آتلیهٔ Julia Widgrén',
            ],
            [
                'order' => 3,
                'act' => 1,
                'location_fa' => 'محل مرتبط با آتلیهٔ Julia Widgrén',
                'title_fa' => 'آنچه نور نگه داشت',
                'intro_text' => "یولیا ویدگرن می‌گوید:\n\n«آدم‌ها برای ثبت چهره‌شان می‌آیند. اما گاهی مهم‌ترین چیز، نه صورت آن‌ها، که خیابان پشت سرشان است.»\n\nاو دو صفحهٔ شیشه‌ای به شما می‌دهد. هر دو یک منظره را ثبت کرده‌اند، اما یکی وارونه است.",
                'code' => 'SJÖBERG',
                'code_alternatives' => ['SJOBERG', 'SJ OBERG'],
                'next_destination_fa' => 'Loftet؛ مغازهٔ H. Sjöberg',
            ],
            [
                'order' => 4,
                'act' => 1,
                'location_fa' => 'Loftet؛ مغازهٔ H. Sjöberg در ۱۸۶۷',
                'title_fa' => 'خریدی برای یک شب تاریک',
                'intro_text' => "شاگرد مغازه جرئت نکرده بود دربارهٔ خرید غیرعادی مشتری سؤال کند. در عوض، نسخهٔ دوم رسید را نگه داشت و روی قفسه‌ها نشانه گذاشت.\n\nمشتری برزنت، طناب، گچ، موم مهر، روغن چراغ و پارچهٔ زمخت خریده بود؛ همهٔ چیزهایی که برای جابه‌جایی شبانهٔ یک بار و ساختن یک سند جعلی لازم است.",
                'code' => 'KIRKKO',
                'code_alternatives' => null,
                'next_destination_fa' => 'کلیسای تثلیث',
            ],
            [
                'order' => 5,
                'act' => 1,
                'location_fa' => 'کلیسای واسا، کلیسای تثلیث',
                'title_fa' => 'شش بشکه برای صفی بی‌پایان',
                'intro_text' => "صدای زنی به نام Elin Sjöström، مسئول داستانی آشپزخانهٔ امدادی، شنیده می‌شود:\n\n«شش بشکه رسید. خودم وزنشان را دیدم. اما صف مردم از روز پیش طولانی‌تر شده بود. شش بشکه برای شهری که گرسنه است، بیشتر شبیه وعده است تا غذا.»",
                'code' => 'RÅDHUS',
                'code_alternatives' => ['RADHUS', 'RÅDHUS'],
                'next_destination_fa' => 'تالار شهر قدیم',
            ],
            [
                'order' => 6,
                'act' => 2,
                'location_fa' => 'Vasa Övningsskola Upper Secondary؛ تالار شهر قدیم',
                'title_fa' => 'ستون خالی',
                'intro_text' => "روی میز تالار شهر چهار دفتر باز است. سه دفتر بوی چاودار، موم و رطوبت می‌دهد. چهارمی بیش از اندازه تمیز است.\n\nکسی عددها را درست جمع کرده؛ اما حقیقت را در جایی میان جمع و تفریق پنهان کرده است.",
                'code' => 'ENNEN',
                'code_alternatives' => null,
                'next_destination_fa' => 'Vasabladet',
            ],
            [
                'order' => 7,
                'act' => 2,
                'location_fa' => 'Vasabladet',
                'title_fa' => 'تیتر پیش از حقیقت',
                'intro_text' => "حروف سربی هنوز گرم‌اند. در ستون اول، نام چاقوکشان با حروفی درشت چاپ شده؛ در ستون سوم، آگهی کوچکی برای خرید غله قرار دارد.\n\nچاپگر می‌گوید:\n\n«خبر را مردی با عصای سرنقره‌ای آورد. نامش را نگفت. متن را آماده کرده بود و عجله داشت پیش از شمارش صبح چاپ شود.»",
                'code' => 'KJELLMAN',
                'code_alternatives' => null,
                'next_destination_fa' => 'مهمان‌خانهٔ Kjellman',
            ],
            [
                'order' => 8,
                'act' => 2,
                'location_fa' => 'محل Hotel Ernst؛ مهمان‌خانهٔ Kjellman در ۱۸۶۷',
                'title_fa' => 'عروسی تاج‌دار',
                'intro_text' => "در شب ۱۸ نوامبر، مجلس عمومی کوچکی با تاج عروس برگزار شده است. بخشی از پول ورود قرار بوده به صندوق فقرا داده شود. نگرانی از ورود چاقوکشان باعث شده نام و ساعت حضور مهمانان ثبت شود.\n\nشهادت نوازنده:\n\n«حدود ساعت هشت، صدای گاری سنگینی را در حیاط پشتی شنیدم. صدا دور نشد؛ بعد از چند دقیقه خاموش شد.»",
                'code' => 'KURTÉN',
                'code_alternatives' => ['KURTEN'],
                'next_destination_fa' => 'دفتر Joachim Kurtén',
            ],
            [
                'order' => 9,
                'act' => 2,
                'location_fa' => 'خانه یا نقطهٔ تاریخی مرتبط با Joachim Kurtén',
                'title_fa' => 'امضای دزدیده‌شده',
                'intro_text' => "Kurtén به حواله نگاه می‌کند:\n\n«این شکل امضای من است، اما این سند من نیست. امضا را می‌توان تقلید کرد. کاغذ دروغ گفتن را سخت‌تر می‌کند. آن را مقابل نور بگیرید.»",
                'code' => '144',
                'code_alternatives' => null,
                'next_destination_fa' => 'Vasa Övningsskola 1–9',
            ],
            [
                'order' => 10,
                'act' => 2,
                'location_fa' => 'Vasa Övningsskola 1–9',
                'title_fa' => 'درس حساب در سال گرسنگی',
                'intro_text' => "روی تخته سه نوع غله و سه وزن نوشته شده است.\n\nدر سالی که هر پیمانه اهمیت دارد، تفاوت میان بشکه و وزن می‌تواند تفاوت میان غذا و یک سند جعلی باشد.\n\nمحمولهٔ مفقود چاودار بوده؛ تعداد مفقود ۱۲ بشکه است؛ سند کارخانه مقدار ۱۴۴ لیویسکا نوشته است.",
                'code' => 'SALONKI',
                'code_alternatives' => null,
                'next_destination_fa' => 'محفل تجار',
            ],
            [
                'order' => 11,
                'act' => 2,
                'location_fa' => 'Bacchus و Svenska Klubben؛ محفل خصوصی تجار در ۱۸۶۷',
                'title_fa' => 'چهار مرد دور یک میز',
                'intro_text' => "چهار تاجر دور یک میز نشسته‌اند: Kurtén، Levón، Wasastjerna و Granholm.\n\nدر پاسخ به پرسش «شهر چه چیزی از دست داده؟»، Granholm می‌گوید:\n\n«دوازده بشکه که شهری را از قحطی نجات نمی‌دهد، بازرس.»\n\nشما مقدار محرمانهٔ دوازده بشکه را برای Granholm بیان نکرده‌اید. روزنامه نیز فقط از «مقداری غله» نوشته است.",
                'code' => 'WASASTJERNA',
                'code_alternatives' => null,
                'next_destination_fa' => 'کاخ Wasastjerna',
            ],
            [
                'order' => 12,
                'act' => 2,
                'location_fa' => 'Wasastjernan palatsi',
                'title_fa' => 'مهری که صاحبش آن را نپذیرفت',
                'intro_text' => "خانه از بالای شیب به شهر نگاه می‌کند؛ درست همان‌طور که ثروت به گرسنگی نگاه می‌کند: از فاصله‌ای امن.\n\nاما داشتن یک خانهٔ بزرگ، مدرک جرم نیست. باید فهمید مهر چگونه از اینجا بیرون رفته است.\n\nنامهٔ Wasastjerna پیشنهاد احتکار را رد کرده و از Granholm خواسته اثر مهر را پس بدهد.",
                'code' => 'TILASTO',
                'code_alternatives' => null,
                'next_destination_fa' => 'کتابخانهٔ اصلی واسا',
            ],
            [
                'order' => 13,
                'act' => 3,
                'location_fa' => 'کتابخانهٔ اصلی واسا',
                'title_fa' => 'عددی که دروغ را محدود می‌کند',
                'intro_text' => "آمار، نام دزد را نمی‌گوید؛ اما بعضی دروغ‌ها را ناممکن می‌کند.\n\nGranholm می‌خواهد شما باور کنید که غله پیش از رسیدن به شهر ناپدید شده است. دفتر گمرک باید نشان دهد بار تا کجا آمده است.\n\nنام تاریخی شهر در جدول «Nikolainkaupunki» است، نه Vaasa.",
                'code' => 'ALMA',
                'code_alternatives' => null,
                'next_destination_fa' => 'گورستان قدیمی واسا',
            ],
            [
                'order' => 14,
                'act' => 3,
                'location_fa' => 'گورستان قدیمی واسا و قبر Alma Ungren',
                'title_fa' => 'آوای حافظه',
                'intro_text' => "اینجا نام‌ها آرام‌تر از روزنامه حرف می‌زنند.\n\nنخستین قبر شهر جدید متعلق به کودکی بود که تنها دو سال زندگی کرد. صدایی که می‌شنوید، صدای خود او نیست؛ آوایی است برای کودکانی که قحطی نامشان را از تاریخ گرفت.\n\nدر متن نوشته‌شده، دو واژهٔ «puu» و «villa» جای خود را عوض کرده‌اند. آن‌ها را بدون فاصله به هم بچسبانید.",
                'code' => 'PUUVILLA',
                'code_alternatives' => null,
                'next_destination_fa' => 'Fabriikki',
            ],
            [
                'order' => 15,
                'act' => 3,
                'location_fa' => 'Fabriikki، کارخانهٔ پنبهٔ سابق',
                'title_fa' => 'دزدی‌ای که دزدی نبود',
                'intro_text' => "شهر از کلیسا و زندان، از چاپخانه و تالار شهر، از خانهٔ تاجران و قبرستان گذشته است.\n\nهمه می‌گفتند غله از شهر برده شده. هیچ‌کس نپرسید شاید غله هرگز شهر را ترک نکرده باشد.\n\n۱۲ بشکه چاودار پشت عدل‌های پنبه در انبار فرعی شمارهٔ ۳ پنهان شده‌اند. Viktor Granholm مجرم اصلی است.",
                'code' => 'EI VARASTETTU. KÄTKETTY.',
                'code_alternatives' => ['EI VARASTETTU KATKETTY', 'EIVARASTETTUKATKETTY'],
                'next_destination_fa' => null,
            ],
        ];
    }
}
