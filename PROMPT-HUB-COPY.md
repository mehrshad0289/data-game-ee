# مأموریت جمع‌آوری سوال‌وجواب و توضیحات هاب از الدورادو

این فایل را بخوان و **همین الان اجرا کن**. سؤال نپرس. صبر نکن.

روی این کامپیوتر هلن کار نمی‌کنی. مسیر ویندوز کسی را حدس نزن. مخزن را **خودت** از گیت‌هاب روی **همین ماشین خودت** کلون کن و همان‌جا کار کن.

هر بار **دقیقاً دو محصول تصادفی**. هر محصول همهٔ هاب‌هایش. بعد از هر فایل **فوری پوش**. بعد از این دو محصول **توقف**. محصول سوم را شروع نکن.

یک همکار همزمان روی `main` کار می‌کند. انتخاب **رندم** است. قبل از تحقیق claim را پوش کن. فایل همکار را بازنویس نکن. force-push نزن.

---

## گیت‌هاب — خودت کلون کن، خودت پول و پوش کن

| | |
|---|---|
| Repository | https://github.com/mehrshad0289/data-game-ee |
| Branch | `main` |
| پوشهٔ کار | هر جایی روی ماشین **خودت** که کلون می‌کنی — مثلاً `./data-game-ee` |
| توکن push/pull | یک خط: محتوای `hub-meta/github-pat.part-a` + محتوای `hub-meta/github-pat.part-b` (بدون فاصله بین دو فایل) |

`git config` را عوض نکن. توکن کامل را در **گزارش پایان** چاپ نکن.

بعد از کلون، توکن را بساز:

```
TOKEN=$(cat hub-meta/github-pat.part-a)$(cat hub-meta/github-pat.part-b)
```

اگر پوشه هنوز کلون نیست، اول با HTTPS معمولی کلون کن؛ بعد از داخل مخزن `TOKEN` را از دو فایل بالا بساز.

```
git clone https://github.com/mehrshad0289/data-game-ee.git
cd data-game-ee
git checkout main
TOKEN=$(cat hub-meta/github-pat.part-a)$(cat hub-meta/github-pat.part-b)
git -c credential.helper= pull --rebase "https://x-access-token:${TOKEN}@github.com/mehrshad0289/data-game-ee.git" main
```

اگر از قبل کلون داری: `cd` به ریشه، `TOKEN` را مثل بالا، بعد:

```
git pull --rebase "https://x-access-token:${TOKEN}@github.com/mehrshad0289/data-game-ee.git" main
```

هر پوش:

```
git pull --rebase "https://x-access-token:${TOKEN}@github.com/mehrshad0289/data-game-ee.git" main
git push "https://x-access-token:${TOKEN}@github.com/mehrshad0289/data-game-ee.git" HEAD:main
```

اگر پوش رد شد: `git pull --rebase origin main`، تداخل را با نگه‌داشتن فایل همکار حل کن، دوباره پوش کن. اگر claim تو با claim همکار روی **همان slug** خورد، claim خودت را دور بینداز و دو محصول تصادفی **دیگر** بردار.

منبع حقیقت GitHub `main` است، نه حافظه.

PHP را از ریشهٔ کلون صدا بزن: `php tools/hub-pick.php` و `php tools/hub-status.php`.

---

## صف و پیشرفت — همه همین را می‌بینند

| پوشه / فایل | معنی |
|---|---|
| `hub-queue/<slug>.json` | هنوز تمام نشده. تمام = حذف همین فایل از صف و پوش |
| `hub-claimed/<slug>.json` | الان دست یک نفر است. انتخابش نکن |
| `hub-copy/<slug>/<hub>/` | خروجی همان هاب |
| `PROGRESS.md` | عدد باقی / در حال کار / تمام‌شده روی `main` |

بعد از هر `done` این را بزن و `PROGRESS.md` را در همان commit تمام‌شدن بگذار:

```
php tools/hub-status.php
```

استیم را برندار. اگر slug شامل steam است، فایل صف را `git rm` کن، status را به‌روز کن، پوش کن، بعدی را بردار.

`fazerTypes` داخل JSON صف می‌گوید روی دیتابیس شارژینو `topup` / `giftcard` / `gamekey` دارد. همهٔ محصولات صف باید پوشش داده شوند. محصول بدون صفحهٔ الدورادو هم تمام می‌شود: `missing.json`، بعد حذف از صف.

مسیر `workbook` داخل JSON صف نسبی است و داخل همین کلون است؛ مثلاً `games-completed/<folder>/<folder>.xlsx`.

---

## انتخاب رندم — دقیقاً دو تا

بعد از `git pull --rebase origin main`:

```
php tools/hub-pick.php
```

خروجی دو slug است. فقط همان دو تا را claim کرده‌ای. **قبل از باز کردن الدورادو** آن دو فایل `hub-claimed` را commit و پوش کن.

پیام: `claim: <slug1> <slug2>`

اگر اسکریپت گفت `queue empty`، کار تمام است. گزارش بده و توقف کن.

دستی از اول فهرست الفبا برندار. دو نفری که همزمان شروع کنند نباید همان دو اسم را بگیرند.

---

## هاب‌های یک محصول

اسم پوشه فقط یکی از این‌هاست: `accounts` · `currency` · `items` · `top-ups` · `gift-cards`

1. اگر `workbook` دارد، شیت مشخصات: اکانت → `accounts`، ارز → `currency`، آیتم → `items`.
2. اگر `fazerTypes` شامل `topup` است → `top-ups`.
3. اگر `fazerTypes` شامل `giftcard` یا `gamekey` است → `gift-cards`.
4. روی الدورادو صفحهٔ دیگری از همین پنج نوع برای **همین اسم** دیدی، آن را هم اضافه کن.

اگر آن هاب صفحه ندارد: `missing.json`. متن نساز.  
اگر کل محصول هیچ صفحه‌ای ندارد: فقط `hub-copy/<slug>/missing.json`، بعد اسم را از صف پاک کن.

متن فقط از صفحهٔ زندهٔ https://www.eldorado.gg/ . ترجمه نکن. خلاصه نکن. جمله‌ای که روی صفحه نیست ننویس.

---

## فایل‌ها

`faq.json` وقتی صفحه هست و سوال دارد:

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

صفحه هست و بلوک سوال ندارد:

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

خط اول همان URL. بعد یک خط خالی. هر پاراگراف با یک خط خالی جدا. عنوان آگهی و قیمت توضیح نیست.

`missing.json`:

```json
{
  "slug": "SLUG",
  "hub": "accounts",
  "found": false,
  "sourceUrl": "https://www.eldorado.gg/PAGE-YOU-OPENED"
}
```

---

## ترتیب اجباری

توضیح را قبل از پوش سوال ننویس. تا پوش این قدم موفق نشده قدم بعد را شروع نکن.

1. مخزن را روی ماشین خودت کلون کن (یا پول کن). `main`.
2. `php tools/hub-pick.php` — دو محصول تصادفی.
3. commit و **پوش claim**. تحقیق نکن تا پوش claim موفق شود.
4. محصول اول:
   1. اسم انگلیسی از سلول «نام کانونیکال» همان xlsx داخل کلون؛ اگر xlsx نیست از `name` صف.
   2. در https://www.eldorado.gg/ همان اسم را جستجو کن.
   3. هاب‌ها به ترتیب `accounts`، `currency`، `items`، `top-ups`، `gift-cards`.
   4. هر هاب: صفحه را باز کن. نیست → `missing.json`، commit، پوش. هست → `faq.json`، commit، پوش، بعد `description.txt`، commit، پوش. تا پوش این هاب تمام نشده هاب بعد را شروع نکن.
   5. همهٔ هاب‌های لازم که فایل دارند: `git rm` روی `hub-queue/<slug>.json` و `hub-claimed/<slug>.json`. `php tools/hub-status.php`. commit `done: <slug>`. پوش.
5. محصول دوم: همان ترتیب از جمع‌آوری تا `done` و پوش.
6. گزارش بده و توقف کن.

## Commit

هر commit فقط همان قدم. دو محصول در یک commit نباشند. سوال و توضیح یک هاب در یک commit نباشند.

- `claim: <slug1> <slug2>`
- `faq: <slug> <hub>`
- `description: <slug> <hub>`
- `missing: <slug> <hub>`
- `done: <slug>`

قبل از هر پوش: `git pull --rebase origin main`.

## تمام‌شده یعنی

- هر هاب لازم یا `missing.json` دارد یا هم `faq.json` و هم `description.txt`.
- `sourceUrl` با `https://www.eldorado.gg/` شروع می‌شود.
- `present: true` حداقل یک سوال و جواب کپی‌شده دارد.
- `description.txt` خط اولش همان URL است و حداقل یک پاراگراف از صفحه دارد.
- `hub-queue/<slug>.json` بعد از پوش موفق حذف شده است.
- `PROGRESS.md` عدد جدید را نشان می‌دهد.

اگر یکی از این‌ها نیست، اسم را از صف پاک نکن.

## گزارش پایان

برای هر محصول: slug، اسم، هر هاب، URL، `present` یا `found: false`، hash.  
از `PROGRESS.md`: باقی، در حال کار، تمام‌شده.  
بعد توقف.

---

# شروع

1. `git clone https://github.com/mehrshad0289/data-game-ee.git` روی ماشین خودت (اگر کلون داری فقط پول کن). `cd` به ریشهٔ کلون. `main`.
2. دو محصول تصادفی را با `php tools/hub-pick.php` بردار و claim را پوش کن.
3. محصول اول را هاب‌به‌هاب جمع کن؛ بعد از هر faq یا missing پوش کن؛ بعد توضیحات را پوش کن؛ بعد از صف حذف کن، `PROGRESS.md` را به‌روز کن، پوش کن.
4. محصول دوم، همان کار.
5. گزارش و توقف.
