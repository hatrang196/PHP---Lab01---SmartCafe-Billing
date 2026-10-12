<?php
// src/cafe.php

// 1. Type boundary: raw string -> clean int
$quantity        = (int) $rawQuantity;
$rawQuantityType = gettype($rawQuantity);
$quantityType    = gettype($quantity);

// 2. Subtotal
$subtotal = $unitPrice * $quantity;

// 3. Conditions (strict equality + logical operators)
$isMember            = $customerStatus === "MEMBER";
$isGuest             = $customerStatus === "GUEST";
$hasValidCustomer    = $isMember || $isGuest;
$isDiscountEligible  = $isMember && $subtotal >= MEMBER_MIN;

// 4. Fees & Totals (biến trung gian rõ nghĩa)
$discount      = $isDiscountEligible ? $subtotal * MEMBER_DISCOUNT_RATE : 0;
$packagingFee  = $quantity * PACKAGING_FEE_PER_ITEM;
$afterDiscount = $subtotal - $discount;
$serviceFee    = $afterDiscount * SERVICE_RATE;
$total         = $subtotal - $discount + $packagingFee + $serviceFee;

// 5. Checkout gate
$hasValidQuantity = $quantity > 0;
$canOrder         = $hasValidQuantity && $productAvailable && $hasValidCustomer;
$statusText       = $canOrder ? "READY TO ORDER" : "BLOCKED";