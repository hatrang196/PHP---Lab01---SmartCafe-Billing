# SmartCafe Billing – PHP Lab01

A small PHP app that calculates a coffee shop receipt (Problem A of PHP Lab01). It practices PHP fundamentals: variables, data types, explicit casting, operators, constants, and a clean project structure.

- **Student:** Trần Hà Trang – 22110233 – Class 24TTH
- **Course:** PHP / Web Back-end Fundamentals

## Features

- Simulates raw checkout input (no real form): `$rawQuantity` stays a **string** and is explicitly cast to `int`.
- Calculates subtotal, member discount, packaging fee, service fee, and total.
- Checkout gate returns `READY TO ORDER` or `BLOCKED`.
- Receipt rendered in the browser with `<?= ... ?>` (view contains no business logic).

## Business Rules

| Constant | Value | Rule |
|---|---|---|
| `CURRENCY` | `"VND"` | Display currency |
| `MEMBER_DISCOUNT_RATE` | `0.10` | 10% off subtotal for members |
| `MEMBER_MIN` | `100000` | Discount applies when `subtotal >= 100000` |
| `PACKAGING_FEE_PER_ITEM` | `2000` | `packagingFee = quantity × 2000` |
| `SERVICE_RATE` | `0.05` | 5% of the amount **after discount** |

```
subtotal     = unitPrice × quantity
discount     = (isMember && subtotal >= MEMBER_MIN) ? subtotal × 0.10 : 0
afterDiscount = subtotal − discount
serviceFee   = afterDiscount × 0.05
total        = subtotal − discount + packagingFee + serviceFee
canOrder     = quantity > 0 && productAvailable && customerStatus is "MEMBER" or "GUEST"
```

`customerStatus` is compared with `===` (case-sensitive), so `"member"` is rejected.

## Project Structure

```
PHP-Lab01/
├── index.php              # Entry point: require_once config → data → src → views
├── config/constants.php   # Fixed business rules (UPPER_SNAKE_CASE)
├── data/cafe-data.php     # Raw sample input ($rawQuantity is a string)
├── src/cafe.php           # Casting, calculations, boolean conditions (no HTML)
├── views/receipt.php      # HTML output only, using <?= ?>
├── basic/smartcafe-basic.php  # Original single-file version (kept for comparison)
└── .gitignore
```

## Run

**Browser (XAMPP):** start Apache, place the folder in `htdocs`, then open  
`http://localhost/HCMUS-PHP/PHP-Lab/PHP-Lab01/index.php`

**CLI (Basic version, shows `var_dump` / `gettype` before and after casting):**

```bash
php basic/smartcafe-basic.php
```

To test another case, edit only these variables in `data/cafe-data.php`: `$unitPrice`, `$rawQuantity`, `$customerStatus`, `$productAvailable`.

## Manual Test Matrix

| Case | Input (price, qty, status, available) | Total | Status |
|---|---|---|---|
| T1 Happy path | 45000, "3", MEMBER, true | 133575 | READY TO ORDER |
| T2 Guest (no discount) | 45000, "3", GUEST, true | 147750 | READY TO ORDER |
| T3 Boundary (= MIN) | 50000, "2", MEMBER, true | 98500 | READY TO ORDER |
| T3b Boundary (MIN − 2) | 49999, "2", MEMBER, true | 108997.9 | READY TO ORDER |
| T4 Quantity = 0 | 45000, "0", MEMBER, true | 0 | BLOCKED |
| T5 Unavailable | 45000, "3", MEMBER, false | 133575 | BLOCKED |
| T6 Invalid status | 45000, "3", "member", true | 147750 | BLOCKED |

All 7 cases passed, and the Basic and Refactored versions produce identical results.

## Git Workflow

Work was committed incrementally: initialize → constants & raw data → type inspection & casting → calculation rules → receipt output → refactor (config/data/src/views, via branch + Pull Request) → test evidence.

## Environment

VS Code, XAMPP (Apache + MySQL), PHP 8.x, Git, GitHub CLI.
