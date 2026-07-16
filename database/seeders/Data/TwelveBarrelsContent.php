<?php

namespace Database\Seeders\Data;

class TwelveBarrelsContent
{
    public static function data(): array
    {
        return [
            'city' => [
                'slug' => 'vaasa',
                'name' => [
                    'fa' => 'واسا',
                    'en' => 'Vaasa',
                    'fi' => 'Vaasa',
                ],
                'description' => [
                    'fa' => 'شهر ساحلی غرب فنلاند؛ محل اولین بازی‌های شهری این پلتفرم.',
                    'en' => 'A coastal city in western Finland; home to the first city games on this platform.',
                    'fi' => 'Rannikkokaupunki Länsi-Suomessa; tämän alustan ensimmäisten kaupunkipelien koti.',
                ],
                'is_active' => true,
            ],

            'game' => [
                'slug' => 'twelve-barrels',
                'title' => [
                    'fa' => 'دوازده بشکه',
                    'en' => 'Twelve Barrels: The Hidden Grain of Nikolaistad',
                    'fi' => 'Kaksitoista tynnyriä',
                ],
                'subtitle' => [
                    'fa' => 'پروندهٔ غله‌های پنهان نیکولاین‌کائوپونکی',
                    'en' => 'The Case of the Hidden Grain of Nikolaistad',
                    'fi' => 'Piilotetun viljan tapaus Nikolainkaupungissa',
                ],
                'description' => [
                    'fa' => 'نوامبر ۱۸۶۷. بخشی از یک محمولهٔ امدادی چاودار پس از ورود به نیکولاین‌کائوپونکی ناپدید شده است. شما به‌عنوان بازرس ویژهٔ سنا، پانزده ایستگاه شهر را طی می‌کنید تا حقیقت را بیابید.',
                    'en' => 'November 1867. Part of an aid shipment of rye vanished after arriving in Nikolaistad. As a special inspector of the Senate, you will visit fifteen stations across the city to uncover the truth.',
                    'fi' => 'Marraskuu 1867. Osa avustuslastista rukiista katosi saapuessaan Nikolainkaupunkiin. Senaatin erikoistarkastajana kierrät kaupungin viisitoista asemaa selvittääksesi totuuden.',
                ],
                'stage_count' => 15,
                'is_active' => true,
            ],

            'stages' => [
                [
                    'order' => 1,
                    'act' => 1,
                    'location' => [
                        'fa' => 'کلیسای ارتدوکس سنت نیکلاس و یادمان Setterberg',
                        'en' => 'St Nicholas Orthodox Church and the Setterberg monument',
                        'fi' => 'Pyhän Nikolauksen ortodoksikirkko ja Setterbergin muistomerkki',
                    ],
                    'title' => [
                        'fa' => 'شهری که از نو رسم شد',
                        'en' => 'A City Drawn Anew',
                        'fi' => 'Uudelleen piirretty kaupunki',
                    ],
                    'intro_text' => [
                        'fa' => "نیکولاین‌کائوپونکی، ۲۰ نوامبر ۱۸۶۷\n\nپانزده سال از آتشی می‌گذرد که واسای قدیم را بلعید. شهر تازه با خیابان‌های پهن، میدان‌های باز و ساختمان‌های آجری سر برآورده است؛ اما این بار دشمن آتش نیست.\n\nنامهٔ سنا می‌گوید بخشی از یک محمولهٔ امدادی غله، پس از ورود به شهر ناپدید شده است. نام دو مرد بیش از همه در کوچه‌ها تکرار می‌شود: آنتی ایسوتالو و آنتی رانان‌یروی.\n\nنخست نقشه را از ستربرگ بگیرید. شهری که از نو طراحی شد، مسیر غله را نیز در خود نگه داشته است.",
                        'en' => "Nikolaistad, 20 November 1867\n\nFifteen years have passed since the fire that consumed old Vaasa. A new city rises with wide streets, open squares, and brick buildings — but this time the enemy is not fire.\n\nA letter from the Senate says part of an aid shipment of grain vanished after entering the city. Two names echo through the alleys more than any others: Antti Isotalo and Antti Rannanjärvi.\n\nFind the map first. The city that was redesigned from scratch has also kept the grain's route within itself.",
                        'fi' => "Nikolainkaupunki, 20. marraskuuta 1867\n\nViisitoista vuotta on kulunut tulipalosta, joka nielaisi vanhan Vaasan. Uusi kaupunki on noussut leveine katuineen, avoine aukioineen ja tiilirakennuksineen — mutta tällä kertaa vihollinen ei ole tuli.\n\nSenaatin kirje kertoo, että osa avustuslastista katosi saavuttuaan kaupunkiin. Kaksi nimeä kaikuu kujilla enemmän kuin muut: Antti Isotalo ja Antti Rannanjärvi.\n\nEtsi ensin kartta. Uudelleen suunniteltu kaupunki on säilyttänyt myös viljan reitin.",
                    ],
                    'code' => 'VANKILA',
                    'code_alternatives' => null,
                    'next_destination' => [
                        'fa' => 'زندان واسا',
                        'en' => 'Vaasa Prison',
                        'fi' => 'Vaasan vankila',
                    ],
                ],
                [
                    'order' => 2,
                    'act' => 1,
                    'location' => [
                        'fa' => 'زندان واسا',
                        'en' => 'Vaasa Prison',
                        'fi' => 'Vaasan vankila',
                    ],
                    'title' => [
                        'fa' => 'مردان پشت میله',
                        'en' => 'Men Behind Bars',
                        'fi' => 'Miehet takana ritilän',
                    ],
                    'intro_text' => [
                        'fa' => "مردم شهر می‌گویند حتی میله‌های زندان هم برای مهار نام دو آنتی کافی نیست.\n\nنگهبان دفترش را باز می‌کند:\n\n«من با ترانه و شایعه کار ندارم، بازرس. ساعت ورود، شمارش شبانه و کلیدها را می‌شناسم. اگر این دو نفر غله را برده‌اند، باید اول از میان این اعداد فرار کرده باشند.»",
                        'en' => "The townspeople say even the prison bars are not enough to contain the name of the two Anttis.\n\nThe guard opens his ledger:\n\n\"I have no use for songs and rumours, inspector. I know the times of entry, the nightly head counts, and the keys. If these two men took the grain, they must first have escaped from among these numbers.\"",
                        'fi' => "Kaupunkilaiset sanovat, etteivät edes vankilan rautatangot riitä pidättelemään kahta Anttia.\n\nVartija avaa kirjanpitonsa:\n\n\"En tee työtä laulujen ja huhujen kanssa, tarkastaja. Tunnen sisääntuloajat, yölliset laskennat ja avaimet. Jos nämä kaksi miestä veivät viljan, heidän on ensin täytynyt paeta näiden lukujen keskeltä.\"",
                    ],
                    'code' => 'VALO',
                    'code_alternatives' => ['VALO KIRJOITTAA'],
                    'next_destination' => [
                        'fa' => 'آتلیهٔ Julia Widgrén',
                        'en' => "Julia Widgrén's studio",
                        'fi' => 'Julia Widgrénin ateljee',
                    ],
                ],
                [
                    'order' => 3,
                    'act' => 1,
                    'location' => [
                        'fa' => 'محل مرتبط با آتلیهٔ Julia Widgrén',
                        'en' => "Site linked to Julia Widgrén's studio",
                        'fi' => 'Julia Widgrénin ateljeehen liittyvä paikka',
                    ],
                    'title' => [
                        'fa' => 'آنچه نور نگه داشت',
                        'en' => 'What the Light Preserved',
                        'fi' => 'Mitä valo säilytti',
                    ],
                    'intro_text' => [
                        'fa' => "یولیا ویدگرن می‌گوید:\n\n«آدم‌ها برای ثبت چهره‌شان می‌آیند. اما گاهی مهم‌ترین چیز، نه صورت آن‌ها، که خیابان پشت سرشان است.»\n\nاو دو صفحهٔ شیشه‌ای به شما می‌دهد. هر دو یک منظره را ثبت کرده‌اند، اما یکی وارونه است.",
                        'en' => "Julia Widgrén says:\n\n\"People come to have their faces recorded. But sometimes the most important thing is not their faces — it is the street behind them.\"\n\nShe gives you two glass plates. Both have captured the same scene, but one is reversed.",
                        'fi' => "Julia Widgrén sanoo:\n\n\"Ihmiset tulevat ikuistuttamaan kasvonsa. Mutta joskus tärkein asia ei ole heidän kasvonsa vaan katu heidän takanaan.\"\n\nHän antaa sinulle kaksi lasilevyä. Molemmat ovat tallentaneet saman näkymän, mutta toinen on peilikuva.",
                    ],
                    'code' => 'SJÖBERG',
                    'code_alternatives' => ['SJOBERG', 'SJ OBERG'],
                    'next_destination' => [
                        'fa' => 'Loftet؛ مغازهٔ H. Sjöberg',
                        'en' => "Loftet; H. Sjöberg's shop",
                        'fi' => 'Loftet; H. Sjöbergin kauppa',
                    ],
                ],
                [
                    'order' => 4,
                    'act' => 1,
                    'location' => [
                        'fa' => 'Loftet؛ مغازهٔ H. Sjöberg در ۱۸۶۷',
                        'en' => "Loftet; H. Sjöberg's shop in 1867",
                        'fi' => 'Loftet; H. Sjöbergin kauppa vuonna 1867',
                    ],
                    'title' => [
                        'fa' => 'خریدی برای یک شب تاریک',
                        'en' => 'Purchases for a Dark Night',
                        'fi' => 'Ostokset pimeää yötä varten',
                    ],
                    'intro_text' => [
                        'fa' => "شاگرد مغازه جرئت نکرده بود دربارهٔ خرید غیرعادی مشتری سؤال کند. در عوض، نسخهٔ دوم رسید را نگه داشت و روی قفسه‌ها نشانه گذاشت.\n\nمشتری برزنت، طناب، گچ، موم مهر، روغن چراغ و پارچهٔ زمخت خریده بود؛ همهٔ چیزهایی که برای جابه‌جایی شبانهٔ یک بار و ساختن یک سند جعلی لازم است.",
                        'en' => "The shop apprentice had not dared to question the customer's unusual purchase. Instead, he kept a duplicate receipt and marked the shelves.\n\nThe customer had bought tarpaulin, rope, chalk, sealing wax, lamp oil, and coarse cloth — everything needed to move a load by night and forge a document.",
                        'fi' => "Kaupan oppipoika ei ollut uskaltanut kysyä asiakkaan epätavallisesta ostoksesta. Sen sijaan hän säilytti kuitin jäljennöksen ja merkitsi hyllyt.\n\nAsiakas oli ostanut kankaita, köyttä, liitaa, sinettilakkaa, lamppuöljyä ja karkeaa kangasta — kaiken, mitä tarvitaan kuorman siirtämiseen yöllä ja väärennetyn asiakirjan tekemiseen.",
                    ],
                    'code' => 'KIRKKO',
                    'code_alternatives' => null,
                    'next_destination' => [
                        'fa' => 'کلیسای تثلیث',
                        'en' => 'Holy Trinity Church',
                        'fi' => 'Pyhän Kolminaisuuden kirkko',
                    ],
                ],
                [
                    'order' => 5,
                    'act' => 1,
                    'location' => [
                        'fa' => 'کلیسای واسا، کلیسای تثلیث',
                        'en' => 'Vaasa Church, Holy Trinity Church',
                        'fi' => 'Vaasan kirkko, Pyhän Kolminaisuuden kirkko',
                    ],
                    'title' => [
                        'fa' => 'شش بشکه برای صفی بی‌پایان',
                        'en' => 'Six Barrels for an Endless Queue',
                        'fi' => 'Kuusi tynnyriä loppumatonta jonoa varten',
                    ],
                    'intro_text' => [
                        'fa' => "صدای زنی به نام Elin Sjöström، مسئول داستانی آشپزخانهٔ امدادی، شنیده می‌شود:\n\n«شش بشکه رسید. خودم وزنشان را دیدم. اما صف مردم از روز پیش طولانی‌تر شده بود. شش بشکه برای شهری که گرسنه است، بیشتر شبیه وعده است تا غذا.»",
                        'en' => "The voice of a woman named Elin Sjöström, the fictional head of the relief kitchen, is heard:\n\n\"Six barrels arrived. I saw their weight myself. But the queue of people had grown longer since the day before. Six barrels for a hungry city are more like a promise than a meal.\"",
                        'fi' => "Kuuluu naisen, Elin Sjöströmin, ääni — kuvitteellisen avustuskeittiön vastuuhenkilön:\n\n\"Kuusi tynnyriä saapui. Näin niiden painon itse. Mutta ihmisjono oli pitempi kuin edellisenä päivänä. Kuusi tynnyriä nälkäiselle kaupungille on enemmän lupaus kuin ateria.\"",
                    ],
                    'code' => 'RÅDHUS',
                    'code_alternatives' => ['RADHUS'],
                    'next_destination' => [
                        'fa' => 'تالار شهر قدیم',
                        'en' => 'The old town hall',
                        'fi' => 'Vanha raatihuone',
                    ],
                ],
                [
                    'order' => 6,
                    'act' => 2,
                    'location' => [
                        'fa' => 'Vasa Övningsskola Upper Secondary؛ تالار شهر قدیم',
                        'en' => 'Vasa Övningsskola Upper Secondary; the old town hall',
                        'fi' => 'Vasa Övningsskola Upper Secondary; vanha raatihuone',
                    ],
                    'title' => [
                        'fa' => 'ستون خالی',
                        'en' => 'The Empty Column',
                        'fi' => 'Tyhjä sarake',
                    ],
                    'intro_text' => [
                        'fa' => "روی میز تالار شهر چهار دفتر باز است. سه دفتر بوی چاودار، موم و رطوبت می‌دهد. چهارمی بیش از اندازه تمیز است.\n\nکسی عددها را درست جمع کرده؛ اما حقیقت را در جایی میان جمع و تفریق پنهان کرده است.",
                        'en' => "Four ledgers lie open on the town hall table. Three smell of rye, wax, and damp. The fourth is suspiciously clean.\n\nSomeone has added the figures correctly — but hidden the truth somewhere between addition and subtraction.",
                        'fi' => "Raatihuoneen pöydällä on neljä avointa kirjanpitoa. Kolmesta haisee ruis, vaha ja kosteus. Neljäs on epäilyttävän siisti.\n\nJoku on laskenut luvut oikein — mutta piilottanut totuuden jonnekin yhteen- ja vähennyslaskujen väliin.",
                    ],
                    'code' => 'ENNEN',
                    'code_alternatives' => null,
                    'next_destination' => [
                        'fa' => 'Vasabladet',
                        'en' => 'Vasabladet',
                        'fi' => 'Vasabladet',
                    ],
                ],
                [
                    'order' => 7,
                    'act' => 2,
                    'location' => [
                        'fa' => 'Vasabladet',
                        'en' => 'Vasabladet',
                        'fi' => 'Vasabladet',
                    ],
                    'title' => [
                        'fa' => 'تیتر پیش از حقیقت',
                        'en' => 'Headline Before the Truth',
                        'fi' => 'Otsikko ennen totuutta',
                    ],
                    'intro_text' => [
                        'fa' => "حروف سربی هنوز گرم‌اند. در ستون اول، نام چاقوکشان با حروفی درشت چاپ شده؛ در ستون سوم، آگهی کوچکی برای خرید غله قرار دارد.\n\nچاپگر می‌گوید:\n\n«خبر را مردی با عصای سرنقره‌ای آورد. نامش را نگفت. متن را آماده کرده بود و عجله داشت پیش از شمارش صبح چاپ شود.»",
                        'en' => "The lead type is still warm. In the first column, the knife men's names are printed in bold; in the third, a small notice offers to buy grain.\n\nThe printer says:\n\n\"A man with a silver-headed cane brought the story. He gave no name. The text was ready, and he was in a hurry to have it printed before the morning count.\"",
                        'fi' => "Lyijytyypit ovat vielä lämpimiä. Ensimmäisessä palstassa veitsimiesten nimet on painettu lihavoituina; kolmannessa on pieni ilmoitus viljan ostosta.\n\nPainaja sanoo:\n\n\"Hopeakärkisellä keppinsä mies toi uutisen. Hän ei antanut nimeään. Teksti oli valmiina, ja hän kiirehti saada sen painettua ennen aamulaskentaa.\"",
                    ],
                    'code' => 'KJELLMAN',
                    'code_alternatives' => null,
                    'next_destination' => [
                        'fa' => 'مهمان‌خانهٔ Kjellman',
                        'en' => "Kjellman's inn",
                        'fi' => 'Kjellmanin majatalo',
                    ],
                ],
                [
                    'order' => 8,
                    'act' => 2,
                    'location' => [
                        'fa' => 'محل Hotel Ernst؛ مهمان‌خانهٔ Kjellman در ۱۸۶۷',
                        'en' => 'Site of Hotel Ernst; Kjellman\'s inn in 1867',
                        'fi' => 'Hotel Ernstin paikka; Kjellmanin majatalo vuonna 1867',
                    ],
                    'title' => [
                        'fa' => 'عروسی تاج‌دار',
                        'en' => 'A Crowned Wedding',
                        'fi' => 'Kruunulliset häät',
                    ],
                    'intro_text' => [
                        'fa' => "در شب ۱۸ نوامبر، مجلس عمومی کوچکی با تاج عروس برگزار شده است. بخشی از پول ورود قرار بوده به صندوق فقرا داده شود. نگرانی از ورود چاقوکشان باعث شده نام و ساعت حضور مهمانان ثبت شود.\n\nشهادت نوازنده:\n\n«حدود ساعت هشت، صدای گاری سنگینی را در حیاط پشتی شنیدم. صدا دور نشد؛ بعد از چند دقیقه خاموش شد.»",
                        'en' => "On the night of 18 November, a small public gathering was held with a bridal crown. Part of the entrance fee was meant for the poor relief fund. Fear of the knife men's arrival led to guests' names and arrival times being recorded.\n\nThe musician's testimony:\n\n\"Around eight o'clock, I heard the sound of a heavy cart in the back yard. The sound did not move away; after a few minutes it fell silent.\"",
                        'fi' => "18. marraskuuta pidettiin pieni yleinen juhla morsiuskruunun kanssa. Osa sisäänpääsymaksusta oli tarkoitettu köyhäinavustukseen. Pelko veitsimiesten saapumisesta sai aikaan, että vieraiden nimet ja saapumisajat kirjattiin.\n\nSoittajan todistus:\n\n\"Noin kahdeksalta kuulin raskaan kärryn äänen takapihalla. Ääni ei liikkunut pois; muutaman minuutin kuluttua se vaikeni.\"",
                    ],
                    'code' => 'KURTÉN',
                    'code_alternatives' => ['KURTEN'],
                    'next_destination' => [
                        'fa' => 'دفتر Joachim Kurtén',
                        'en' => "Joachim Kurtén's office",
                        'fi' => 'Joachim Kurténin toimisto',
                    ],
                ],
                [
                    'order' => 9,
                    'act' => 2,
                    'location' => [
                        'fa' => 'خانه یا نقطهٔ تاریخی مرتبط با Joachim Kurtén',
                        'en' => 'Home or historic site linked to Joachim Kurtén',
                        'fi' => 'Joachim Kurténiin liittyvä koti tai historiallinen paikka',
                    ],
                    'title' => [
                        'fa' => 'امضای دزدیده‌شده',
                        'en' => 'The Stolen Signature',
                        'fi' => 'Varastettu allekirjoitus',
                    ],
                    'intro_text' => [
                        'fa' => "Kurtén به حواله نگاه می‌کند:\n\n«این شکل امضای من است، اما این سند من نیست. امضا را می‌توان تقلید کرد. کاغذ دروغ گفتن را سخت‌تر می‌کند. آن را مقابل نور بگیرید.»",
                        'en' => "Kurtén looks at the voucher:\n\n\"This is the shape of my signature, but this document is not mine. A signature can be copied. Paper makes lying harder. Hold it up to the light.\"",
                        'fi' => "Kurtén katsoo tositetta:\n\n\"Tämä on allekirjoitukseni muoto, mutta tämä asiakirja ei ole minun. Allekirjoituksen voi jäljittää. Paperi tekee valehtelusta vaikeampaa. Pidä sitä valoa vasten.\"",
                    ],
                    'code' => '144',
                    'code_alternatives' => null,
                    'next_destination' => [
                        'fa' => 'Vasa Övningsskola 1–9',
                        'en' => 'Vasa Övningsskola 1–9',
                        'fi' => 'Vasa Övningsskola 1–9',
                    ],
                ],
                [
                    'order' => 10,
                    'act' => 2,
                    'location' => [
                        'fa' => 'Vasa Övningsskola 1–9',
                        'en' => 'Vasa Övningsskola 1–9',
                        'fi' => 'Vasa Övningsskola 1–9',
                    ],
                    'title' => [
                        'fa' => 'درس حساب در سال گرسنگی',
                        'en' => 'An Arithmetic Lesson in a Year of Hunger',
                        'fi' => 'Laskuoppitunti nälkävuonna',
                    ],
                    'intro_text' => [
                        'fa' => "روی تخته سه نوع غله و سه وزن نوشته شده است.\n\nدر سالی که هر پیمانه اهمیت دارد، تفاوت میان بشکه و وزن می‌تواند تفاوت میان غذا و یک سند جعلی باشد.\n\nمحمولهٔ مفقود چاودار بوده؛ تعداد مفقود ۱۲ بشکه است؛ سند کارخانه مقدار ۱۴۴ لیویسکا نوشته است.",
                        'en' => "Three types of grain and three weights are written on the board.\n\nIn a year when every measure matters, the difference between a barrel and a weight can be the difference between food and a forged document.\n\nThe missing shipment was rye; the missing amount is 12 barrels; the factory document lists 144 lispund.",
                        'fi' => "Taululle on kirjoitettu kolme viljalajia ja kolme painoa.\n\nVuonna, jolloin jokaisella mitalla on merkitystä, ero tynnyrin ja painon välillä voi olla ero ruoan ja väärennetyn asiakirjan välillä.\n\nKadonnut lasti oli ruista; kadonnut määrä on 12 tynnyriä; tehtaan asiakirjassa lukee 144 lispundia.",
                    ],
                    'code' => 'SALONKI',
                    'code_alternatives' => null,
                    'next_destination' => [
                        'fa' => 'محفل تجار',
                        'en' => "Merchants' club",
                        'fi' => 'Kauppiaiden seura',
                    ],
                ],
                [
                    'order' => 11,
                    'act' => 2,
                    'location' => [
                        'fa' => 'Bacchus و Svenska Klubben؛ محفل خصوصی تجار در ۱۸۶۷',
                        'en' => "Bacchus and Svenska Klubben; a private merchants' gathering in 1867",
                        'fi' => 'Bacchus ja Svenska Klubben; yksityinen kauppiaiden kokoontumispaikka vuonna 1867',
                    ],
                    'title' => [
                        'fa' => 'چهار مرد دور یک میز',
                        'en' => 'Four Men Around One Table',
                        'fi' => 'Neljä miestä saman pöydän ääressä',
                    ],
                    'intro_text' => [
                        'fa' => "چهار تاجر دور یک میز نشسته‌اند: Kurtén، Levón، Wasastjerna و Granholm.\n\nدر پاسخ به پرسش «شهر چه چیزی از دست داده؟»، Granholm می‌گوید:\n\n«دوازده بشکه که شهری را از قحطی نجات نمی‌دهد، بازرس.»\n\nشما مقدار محرمانهٔ دوازده بشکه را برای Granholm بیان نکرده‌اید. روزنامه نیز فقط از «مقداری غله» نوشته است.",
                        'en' => "Four merchants sit around one table: Kurtén, Levón, Wasastjerna, and Granholm.\n\nIn answer to the question \"What has the city lost?\", Granholm says:\n\n\"Twelve barrels that would not save a city from famine, inspector.\"\n\nYou have not told Granholm the confidential figure of twelve barrels. The newspaper, too, wrote only of \"a quantity of grain.\"",
                        'fi' => "Neljä kauppias istuu saman pöydän ääressä: Kurtén, Levón, Wasastjerna ja Granholm.\n\nVastauksena kysymykseen \"Mitä kaupunki on menettänyt?\" Granholm sanoo:\n\n\"Kaksitoista tynnyriä, jotka eivät pelastaisi kaupunkia nälänhädältä, tarkastaja.\"\n\nEt ole kertonut Granholmille salattua lukua kahtatoista tynnyriä. Sanomalehti kirjoitti myös vain \"määrästä viljaa\".",
                    ],
                    'code' => 'WASASTJERNA',
                    'code_alternatives' => null,
                    'next_destination' => [
                        'fa' => 'کاخ Wasastjerna',
                        'en' => 'Wasastjerna Palace',
                        'fi' => 'Wasastjernan palatsi',
                    ],
                ],
                [
                    'order' => 12,
                    'act' => 2,
                    'location' => [
                        'fa' => 'Wasastjernan palatsi',
                        'en' => 'Wasastjerna Palace',
                        'fi' => 'Wasastjernan palatsi',
                    ],
                    'title' => [
                        'fa' => 'مهری که صاحبش آن را نپذیرفت',
                        'en' => 'A Seal Its Owner Never Accepted',
                        'fi' => 'Sinetti, jota sen omistaja ei hyväksynyt',
                    ],
                    'intro_text' => [
                        'fa' => "خانه از بالای شیب به شهر نگاه می‌کند؛ درست همان‌طور که ثروت به گرسنگی نگاه می‌کند: از فاصله‌ای امن.\n\nاما داشتن یک خانهٔ بزرگ، مدرک جرم نیست. باید فهمید مهر چگونه از اینجا بیرون رفته است.\n\nنامهٔ Wasastjerna پیشنهاد احتکار را رد کرده و از Granholm خواسته اثر مهر را پس بدهد.",
                        'en' => "The house looks down on the city from the top of the slope — just as wealth looks at hunger: from a safe distance.\n\nBut owning a grand house is not proof of guilt. You must understand how the seal left this place.\n\nWasastjerna's letter rejected the hoarding proposal and demanded that Granholm return the seal impression.",
                        'fi' => "Talo katsoo kaupunkiin rinteeltä — aivan kuten varallisuus katsoo nälkää: turvalliselta etäisyydeltä.\n\nMutta suuren talon omistaminen ei ole todiste rikoksesta. Sinun on ymmärrettävä, miten sinetti pääsi pois täältä.\n\nWasastjernan kirje hylkäsi hamstraamisen ehdotuksen ja vaati Granholmia palauttamaan sinettijäljen.",
                    ],
                    'code' => 'TILASTO',
                    'code_alternatives' => null,
                    'next_destination' => [
                        'fa' => 'کتابخانهٔ اصلی واسا',
                        'en' => 'Vaasa Main Library',
                        'fi' => 'Vaasan pääkirjasto',
                    ],
                ],
                [
                    'order' => 13,
                    'act' => 3,
                    'location' => [
                        'fa' => 'کتابخانهٔ اصلی واسا',
                        'en' => 'Vaasa Main Library',
                        'fi' => 'Vaasan pääkirjasto',
                    ],
                    'title' => [
                        'fa' => 'عددی که دروغ را محدود می‌کند',
                        'en' => 'A Number That Limits Lies',
                        'fi' => 'Luku, joka rajoittaa valheita',
                    ],
                    'intro_text' => [
                        'fa' => "آمار، نام دزد را نمی‌گوید؛ اما بعضی دروغ‌ها را ناممکن می‌کند.\n\nGranholm می‌خواهد شما باور کنید که غله پیش از رسیدن به شهر ناپدید شده است. دفتر گمرک باید نشان دهد بار تا کجا آمده است.\n\nنام تاریخی شهر در جدول «Nikolainkaupunki» است، نه Vaasa.",
                        'en' => "Statistics do not name the thief — but they can make some lies impossible.\n\nGranholm wants you to believe the grain vanished before reaching the city. The customs ledger must show how far the cargo got.\n\nThe city's historical name in the table is \"Nikolainkaupunki\", not Vaasa.",
                        'fi' => "Tilastot eivät kerro varkaan nimeä — mutta ne voivat tehdä joitakin valheita mahdottomiksi.\n\nGranholm haluaa sinun uskovan, että vilja katosi ennen kaupunkiin saapumista. Tullikirjan on osoitettava, kuinka pitkälle lasti ehti.\n\nKaupungin historiallinen nimi taulukossa on \"Nikolainkaupunki\", ei Vaasa.",
                    ],
                    'code' => 'ALMA',
                    'code_alternatives' => null,
                    'next_destination' => [
                        'fa' => 'گورستان قدیمی واسا',
                        'en' => 'Vaasa Old Cemetery',
                        'fi' => 'Vaasan vanha hautausmaa',
                    ],
                ],
                [
                    'order' => 14,
                    'act' => 3,
                    'location' => [
                        'fa' => 'گورستان قدیمی واسا و قبر Alma Ungren',
                        'en' => 'Vaasa Old Cemetery and the grave of Alma Ungren',
                        'fi' => 'Vaasan vanha hautausmaa ja Alma Ungrenin hauta',
                    ],
                    'title' => [
                        'fa' => 'آوای حافظه',
                        'en' => 'A Voice of Memory',
                        'fi' => 'Muistin ääni',
                    ],
                    'intro_text' => [
                        'fa' => "اینجا نام‌ها آرام‌تر از روزنامه حرف می‌زنند.\n\nنخستین قبر شهر جدید متعلق به کودکی بود که تنها دو سال زندگی کرد. صدایی که می‌شنوید، صدای خود او نیست؛ آوایی است برای کودکانی که قحطی نامشان را از تاریخ گرفت.\n\nدر متن نوشته‌شده، دو واژهٔ «puu» و «villa» جای خود را عوض کرده‌اند. آن‌ها را بدون فاصله به هم بچسبانید.",
                        'en' => "Here names speak more quietly than the newspaper.\n\nThe first grave of the new city belonged to a child who lived only two years. The voice you hear is not hers; it is a song for the children famine erased from history.\n\nIn the written text, the two words \"puu\" and \"villa\" have swapped places. Join them together without a space.",
                        'fi' => "Täällä nimet puhuvat hiljempaa kuin sanomalehti.\n\nUuden kaupungin ensimmäinen hauta kuului lapselle, joka eli vain kaksi vuotta. Ääni, jonka kuulet, ei ole hänen omansa; se on laulu lapsille, joiden nimet nälänhätä vei historiasta.\n\nKirjoitetussa tekstissä sanat \"puu\" ja \"villa\" ovat vaihtaneet paikkaa. Liitä ne yhteen ilman välilyöntiä.",
                    ],
                    'code' => 'PUUVILLA',
                    'code_alternatives' => null,
                    'next_destination' => [
                        'fa' => 'Fabriikki',
                        'en' => 'Fabriikki',
                        'fi' => 'Fabriikki',
                    ],
                ],
                [
                    'order' => 15,
                    'act' => 3,
                    'location' => [
                        'fa' => 'Fabriikki، کارخانهٔ پنبهٔ سابق',
                        'en' => 'Fabriikki, the former cotton mill',
                        'fi' => 'Fabriikki, entinen puuvillatehdas',
                    ],
                    'title' => [
                        'fa' => 'دزدی‌ای که دزدی نبود',
                        'en' => 'A Theft That Was Not a Theft',
                        'fi' => 'Varkaus, joka ei ollut varkaus',
                    ],
                    'intro_text' => [
                        'fa' => "شهر از کلیسا و زندان، از چاپخانه و تالار شهر، از خانهٔ تاجران و قبرستان گذشته است.\n\nهمه می‌گفتند غله از شهر برده شده. هیچ‌کس نپرسید شاید غله هرگز شهر را ترک نکرده باشد.\n\n۱۲ بشکه چاودار پشت عدل‌های پنبه در انبار فرعی شمارهٔ ۳ پنهان شده‌اند. Viktor Granholm مجرم اصلی است.",
                        'en' => "The city has passed through church and prison, print shop and town hall, merchants' houses and the cemetery.\n\nEveryone said the grain was taken from the city. No one asked whether the grain might never have left it.\n\nTwelve barrels of rye are hidden behind bales of cotton in subsidiary warehouse number 3. Viktor Granholm is the culprit.",
                        'fi' => "Kaupunki on kulkenut kirkon ja vankilan, painamattoman ja raatihuoneen, kauppiaiden talojen ja hautausmaan kautta.\n\nKaikki sanoivat, että vilja vietiin kaupungista. Kukaan ei kysynyt, olisiko vilja ehkä koskaan jättänyt sitä.\n\nKaksitoista ruis tynnyriä on piilotettu puuvillapaalien taakse sivuvarastoon numero 3. Viktor Granholm on syyllinen.",
                    ],
                    'code' => 'EI VARASTETTU. KÄTKETTY.',
                    'code_alternatives' => ['EI VARASTETTU KATKETTY', 'EIVARASTETTUKATKETTY'],
                    'next_destination' => [
                        'fa' => null,
                        'en' => null,
                        'fi' => null,
                    ],
                ],
            ],
        ];
    }
}
