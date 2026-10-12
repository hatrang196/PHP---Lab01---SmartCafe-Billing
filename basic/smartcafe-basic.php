<?php
// basic/smartcafe-basic.php
define('CURRENCY', 'VND');
define('MEMBER_DISCOUNT_RATE', 0.10);
define('MEMBER_MIN', 100000);
define('PACKAGING_FEE_PER_ITEM', 2000);
define('SERVICE_RATE', 0.05);

$productName      = "Salt Coffee";
$unitPrice        = 45000;
$rawQuantity      = "3";
$customerStatus   = "MEMBER";
$productAvailable = true;
$orderNote        = null;

echo "=== RAW DATA ===" . PHP_EOL;
var_dump($productName);
var_dump($unitPrice);
var_dump($rawQuantity);
var_dump($customerStatus);
var_dump($productAvailable);
var_dump($orderNote);

echo "Raw quantity type: " . gettype($rawQuantity) . PHP_EOL;
$quantity = (int) $rawQuantity; // explicit casting
echo "Clean quantity type: " . gettype($quantity) . PHP_EOL;
var_dump($quantity);

$subtotal = $unitPrice * $quantity;
$isMember = $customerStatus === "MEMBER";
$isDiscountEligible = $isMember && $subtotal >= MEMBER_MIN;
$discount = $isDiscountEligible ? $subtotal * MEMBER_DISCOUNT_RATE : 0;
$packagingFee = $quantity * PACKAGING_FEE_PER_ITEM;
$afterDiscount = $subtotal - $discount;
$serviceFee = $afterDiscount * SERVICE_RATE;
$total = $subtotal - $discount + $packagingFee + $serviceFee;

$canOrder = ($quantity > 0) && $productAvailable && ($customerStatus === "MEMBER" || $customerStatus === "GUEST");
$statusText = $canOrder ? "READY TO ORDER" : "BLOCKED";

echo PHP_EOL . "=== SMARTCAFE RECEIPT ===" . PHP_EOL;
echo "Product: " . $productName . PHP_EOL;
echo "Total: " . $total . " " . CURRENCY . PHP_EOL;
echo "Status: " . $statusText . PHP_EOL;