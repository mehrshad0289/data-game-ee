# مأموریت جمع‌آوری سوال‌وجواب و توضیحات هاب از الدورادو

هر بار **دقیقاً دو محصول**. هر محصول همهٔ هاب‌هایش. بعد از این دو تا **توقف**. محصول سوم را شروع نکن.

Repository: https://github.com/mehrshad0289/data-game-ee  
Branch: `main`  
مسیر محلی: `C:\Users\Asus\Desktop\charjino\data-game-ee`

منبع متن فقط صفحهٔ زندهٔ https://www.eldorado.gg/ است. متن را از روی همان صفحه کپی کن. ترجمه نکن. خلاصه نکن. جمله‌ای که روی صفحه نیست ننویس.

استیم را برندار. اگر اسم محصول Steam است، همان فایل صف را حذف کن و بعدی را بردار.

## صف

| پوشه | معنی |
|---|---|
| `hub-queue/<slug>.json` | محصولی که هنوز تمام نشده. تمام‌شدن = حذف همین فایل |
| `hub-claimed/<slug>.json` | همین الان دست یک نفر است. انتخابش نکن |
| `hub-copy/<slug>/<hub>/` | خروجی همان هاب |

۶۵۸ محصول در صف است: ۳۹۹ بازی `games-completed` (بدون استیم) و ۲۵۹ محصول فیزر که پوشهٔ بازی جدا ندارند. `fazerTypes` داخل JSON می‌گوید این محصول روی دیتابیس شارژینو شارژ (`topup`) یا گیفت (`giftcard`) یا کلید (`gamekey`) دارد.

## هاب‌های یک محصول

اسم پوشه فقط یکی از این‌هاست:

`accounts` · `currency` · `items` · `top-ups` · `gift-cards`

هاب لازم را این‌طور بساز:

1. اگر `workbook` دارد، شیت مشخصات را بخوان. ردیف اکانت → `accounts`. ردیف ارز → `currency`. ردیف آیتم → `items`.
2. اگر `fazerTypes` شامل `topup` است → `top-ups`.
3. اگر `fazerTypes` شامل `giftcard` یا `gamekey` است → `gift-cards`.
4. روی الدورادو هر صفحهٔ دیگری از همین پنج نوع برای **همین اسم** دیدی، آن را هم اضافه کن.

اگر برای یک هاب لازم صفحهٔ همان محصول روی الدورادو نیست، `missing.json` بگذار. توضیح نساز.

اگر کل محصول روی الدورادو هیچ صفحه‌ای ندارد، فقط یک فایل:

`hub-copy/<slug>/missing.json`

و بعد اسم را از صف پاک کن.

## فایل‌ها

`faq.json` وقتی صفحه هست:

```json
{
  "slug": "SLUG",
  "name": "NAME ON THE PAGE",
  "hub": "accounts",
  "sourceUrl": "https://www.eldorado.gg/EXACT-PAGE",
  "present": true,
  "items": [
    { "q": "QUESTION COPIED FROM THE PAGE", "a": "ANSWER COPIED FROM THE PAGE" }
  ]
}
```

اگر صفحه هست و بلوک سوال ندارد:

```json
{
  "slug": "SLUG",
  "name": "NAME ON THE PAGE",
  "hub": "accounts",
  "sourceUrl": "https://www.eldorado.gg/EXACT-PAGE",
  "present": false,
  "items": []
}
```

`present: true` با `items` خالی ممنوع است. `q` و `a` خالی ممنوع است.

`description.txt` وقتی صفحه هست:

```text
https://www.eldorado.gg/EXACT-PAGE

PARAGRAPH COPIED FROM THE PAGE

NEXT PARAGRAPH COPIED FROM THE PAGE
```

خط اول همان `sourceUrl` است. بعد یک خط خالی. هر پاراگراف بلوک توضیحات پایین صفحه با یک خط خالی جدا شود. عنوان آگهی، قیمت و نام فروشنده توضیح نیست.

`missing.json` وقتی آن هاب صفحه ندارد:

```json
{
  "slug": "SLUG",
  "hub": "accounts",
  "found": false,
  "sourceUrl": "https://www.eldorado.gg/PAGE-YOU-OPENED"
}
```

`sourceUrl` باید صفحه‌ای باشد که واقعاً باز کردی.

## ترتیب اجباری هر محصول

این ترتیب را به هم نزن. توضیح را قبل از پوش سوال ننویس.

1. `git pull --rebase origin main`
2. فایل‌های `hub-queue/*.json` را به ترتیب اسم بخوان.
3. دو تای اول که در `hub-claimed/` نیستند را بردار.
4. برای هر کدام `hub-claimed/<slug>.json` را بنویس (`claimedAt` به وقت UTC اضافه کن).
5. **فقط همین دو claim** را commit و push کن. قبل از push موفق تحقیق نکن. اگر push رد شد، pull کن و دو تای آزاد بعدی را بردار.
6. محصول اول:
   1. اسم انگلیسی را از سلول «نام کانونیکال» همان xlsx بردار. اگر xlsx نیست، فیلد `name` صف را بگذار.
   2. در https://www.eldorado.gg/ همان اسم را جستجو کن.
   3. هاب‌های لازم را به ترتیب `accounts`، `currency`، `items`، `top-ups`، `gift-cards` انجام بده.
   4. برای هر هاب:
      - صفحه را باز کن.
      - اگر صفحه نیست: `missing.json` را بنویس، commit، push. برو هاب بعد.
      - اگر صفحه هست: `faq.json` را بنویس، commit، push.
      - بعد `description.txt` را بنویس، commit، push.
      - تا push این هاب تمام نشده هاب بعد را شروع نکن.
   5. وقتی همهٔ هاب‌های لازم فایل دارند: `git rm` روی `hub-queue/<slug>.json` و `hub-claimed/<slug>.json`. commit. push.
7. محصول دوم را با همین ترتیب انجام بده.
8. گزارش بده و توقف کن.

## Commit

هر commit فقط فایل‌های همان قدم است. دو محصول در یک commit نباشند. سوال و توضیح یک هاب در یک commit نباشند.

پیام commit:

- `claim: <slug>`
- `faq: <slug> <hub>`
- `description: <slug> <hub>`
- `missing: <slug> <hub>`
- `done: <slug>`

قبل از هر push: `git pull --rebase origin main`.

اگر push پسورد خواست، یک خط فایل `C:\Users\Asus\Desktop\charjino\data-game-ee\.secrets\github.token` را برای push همین ریپو استفاده کن. آن فایل و آن خط را commit نکن و در گزارش ننویس.

## تمام‌شده یعنی

- هر هاب لازم یا `missing.json` دارد یا هم `faq.json` و هم `description.txt`.
- `sourceUrl` با `https://www.eldorado.gg/` شروع می‌شود.
- `present: true` حداقل یک سوال و جواب کپی‌شده دارد.
- `description.txt` خط اولش همان URL است و حداقل یک پاراگراف از صفحه دارد.
- `hub-queue/<slug>.json` بعد از push موفق حذف شده است.

اگر یکی از این‌ها نیست، اسم را از صف پاک نکن.

## گزارش پایان دو محصول

برای هر محصول: slug، اسم، هر هاب، URL، `present` یا `found: false`، hash کامیت‌ها.  
تعداد فایل باقی‌مانده در `hub-queue`.  
بعد توقف.

## دستور شروع

1. `git pull --rebase origin main`
2. دو محصول آزاد اول صف را claim کن و push کن.
3. محصول اول را هاب‌به‌هاب جمع کن؛ بعد از هر `faq.json` یا `missing.json` push کن، بعد توضیحات را push کن، بعد اسم را از `hub-queue` پاک کن و push کن.
4. محصول دوم، همان کار.
5. گزارش و توقف.
