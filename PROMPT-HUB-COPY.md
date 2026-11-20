# مأموریت جمع‌آوری سوال‌وجواب و توضیحات هاب از الدورادو

این فایل را بخوان و **همین الان اجرا کن**. سؤال نپرس. صبر نکن.

هر بار **دقیقاً دو محصول تصادفی**. هر محصول همهٔ هاب‌هایش. بعد از هر فایل **فوری پوش**. بعد از این دو محصول **توقف**. محصول سوم را شروع نکن.

یک همکار همزمان روی `main` کار می‌کند. انتخاب **رندم** است. قبل از تحقیق claim را پوش کن. فایل همکار را بازنویس نکن. force-push نزن.

---

## گیت‌هاب — خودت وصل شو و خودت پول و پوش کن

| | |
|---|---|
| Repository | https://github.com/mehrshad0289/data-game-ee |
| Branch | `main` |
| مسیر | `C:\Users\Asus\Desktop\charjino\data-game-ee` |
| توکن | یک خط داخل `C:\Users\Asus\Desktop\charjino\data-game-ee\.secrets\github.token` |

`git config` را عوض نکن. توکن را در گزارش، چت، remote دائمی، یا commit نگذار. `.secrets/` در gitignore است.

PowerShell از همان پوشه:

```powershell
cd C:\Users\Asus\Desktop\charjino\data-game-ee
git checkout main
git remote set-url origin https://github.com/mehrshad0289/data-game-ee.git
git fetch origin
git pull --rebase origin main
```

پوش (هر بار همین الگو؛ توکن را چاپ نکن):

```powershell
$ask = Join-Path $env:TEMP 'data-game-ee-ask.cmd'
Set-Content -Path $ask -Encoding ascii -Value "@echo off`r`ntype `"C:\Users\Asus\Desktop\charjino\data-game-ee\.secrets\github.token`""
$env:GIT_ASKPASS = $ask
$env:GIT_TERMINAL_PROMPT = '0'
git -c credential.helper= pull --rebase origin main
git -c credential.helper= push "https://x-access-token@github.com/mehrshad0289/data-game-ee.git" HEAD:main
Remove-Item $ask -Force
```

اگر پوش رد شد: `git pull --rebase origin main`، تداخل را با نگه‌داشتن فایل همکار حل کن، دوباره پوش کن. اگر claim تو با claim همکار روی **همان slug** خورد، claim خودت را دور بینداز و دو محصول تصادفی **دیگر** بردار.

منبع حقیقت GitHub `main` است، نه حافظه.

---

## صف و پیشرفت — همه همین را می‌بینند

| پوشه / فایل | معنی |
|---|---|
| `hub-queue/<slug>.json` | هنوز تمام نشده. تمام = حذف همین فایل از صف و پوش |
| `hub-claimed/<slug>.json` | الان دست یک نفر است. انتخابش نکن |
| `hub-copy/<slug>/<hub>/` | خروجی همان هاب |
| `PROGRESS.md` | عدد باقی / در حال کار / تمام‌شده روی `main` |

بعد از هر `done` این را بزن و `PROGRESS.md` را در همان commit تمام‌شدن بگذار:

```powershell
php tools/hub-status.php
```

استیم را برندار. اگر slug شامل steam است، فایل صف را `git rm` کن، status را به‌روز کن، پوش کن، بعدی را بردار.

`fazerTypes` داخل JSON صف می‌گوید روی دیتابیس شارژینو `topup` / `giftcard` / `gamekey` دارد. همهٔ محصولات صف باید پوشش داده شوند. محصول بدون صفحهٔ الدورادو هم تمام می‌شود: `missing.json`، بعد حذف از صف.

---

## انتخاب رندم — دقیقاً دو تا

بعد از `git pull --rebase origin main`:

```powershell
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

1. وصل شو به گیت‌هاب. `main` را پول کن.
2. `php tools/hub-pick.php` — دو محصول تصادفی.
3. commit و **پوش claim**. تحقیق نکن تا پوش claim موفق شود.
4. محصول اول:
   1. اسم انگلیسی از سلول «نام کانونیکال» همان xlsx؛ اگر xlsx نیست از `name` صف.
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

1. `cd C:\Users\Asus\Desktop\charjino\data-game-ee`
2. به https://github.com/mehrshad0289/data-game-ee روی `main` وصل شو و پول کن.
3. دو محصول تصادفی را با `php tools/hub-pick.php` بردار و claim را پوش کن.
4. محصول اول را هاب‌به‌هاب جمع کن؛ بعد از هر faq یا missing پوش کن؛ بعد توضیحات را پوش کن؛ بعد از صف حذف کن، `PROGRESS.md` را به‌روز کن، پوش کن.
5. محصول دوم، همان کار.
6. گزارش و توقف.
