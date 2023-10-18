<?php

$coupons = new CouponHandler();

class CouponHandler
{
    public function __construct()
    {
    }

    //Get Name of A Valid Coupon
    // - Returns String
    public function GetCouponName($couponCode)
    {
        include('config.php');
        $name = '';

        $c = $data->query("SELECT * FROM custom_equipment_shop_discounts WHERE active = 'true' AND dis_code = '" . $couponCode . "'") or die($data->error);
        $d = $c->fetch_assoc();

        if ($c->num_rows > 0) {
            $name = $d['coupon_name'];
        }

        return $name;
    }

    //Check if Coupon Code Exists
    public function ApplyCouponCode($code)
    {
        include('config.php');
        $discountPercentage = '';
        $currentTimestamp = time();

        $c = $data->query("SELECT * FROM custom_equipment_shop_discounts WHERE active = 'true' AND date_expire > " . $currentTimestamp . " AND dis_code = '" . $code . "'") or die($data->error);
        $d = $c->fetch_assoc();

        if ($c->num_rows > 0) {
            $discountPercentage = doubleval(intval(str_replace('%', '', $d['discount'])) / 100);
            $cartDataRaw = $_COOKIE["cartData"];
            $cartDataJSON = json_decode($cartDataRaw, true);
            $cartItems = $cartDataJSON[0]['cartItems'];
            $coupons = $cartDataJSON[0]['coupons'];

            if ($d['coupon_type'] == 'cart_discount') {
                //Apply Discount To Entire Cart
                $cartDataJSON[0]['applied_discount'] = $discountPercentage;
                setcookie('cartData', json_encode($cartDataJSON, true), 0, '/');

                $array = array(
                    "valid" => true,
                    "response" => "[" . $d['discount'] . "]  " . $d['coupon_name'] . " - Coupon Applied!",
                    "discount_code" => $code,
                    "discount_percentage" => $discountPercentage,
                    "coupon_name" => $d['coupon_name'],
                    "coupon_type" => $d['coupon_type'],
                    "expiration" => $d['date_expire']
                );

                $coupon = array(
                    "name" => $d['coupon_name'],
                    "code" => $d['dis_code'],
                    "id" => $d['id'],
                    "product" => $d['assign_prod'],
                    "coupon_type" => $d['coupon_type'],
                    "discount_percentage" => $d['discount'],
                    "min_amt_required" => $d['usage_scenario'],
                    "expiration" => $d['date_expire']
                );
                $coupons[] = $coupon;
                $cartDataJSON[0]['coupons'] = $coupons;
                setcookie('cartData', json_encode($cartDataJSON, true), 0, '/');


                echo json_encode($array, true);
            } else if ($d['coupon_type'] == 'product_discount' && $d['assign_prod'] != '') {
                //Apply Discount To Specific Product
                $cartItemsNew = array();

                //find item in cart with matching assignment id -> add applied_discount to item
                foreach ($cartItems as &$item) {
                    if ($item['id'] == $d['assign_prod']) {
                        $itemNew = array(
                            "uniqId" => $item['uniqId'],
                            "id" => $item['id'],
                            "name" => $item['name'],
                            "ship_type" => $item['ship_type'],
                            "price" => $item['price'],
                            "url" => $item['url'],
                            "applied_discount" => $discountPercentage,
                            "qty" => $item['qty']
                        );

                        $cartItemsNew[] = $itemNew;
                    } else {
                        $itemNew = array(
                            "uniqId" => $item['uniqId'],
                            "id" => $item['id'],
                            "name" => $item['name'],
                            "ship_type" => $item['ship_type'],
                            "price" => $item['price'],
                            "url" => $item['url'],
                            "applied_discount" => $item['applied_discount'],
                            "qty" => $item['qty']
                        );

                        $cartItemsNew[] = $itemNew;
                    }

                    $cartDataJSON[0]['cartItems'] = $cartItemsNew;
                    setcookie('cartData', json_encode($cartDataJSON, true), 0, '/');
                }

                $array = array(
                    "valid" => true,
                    "response" => "" . $d['coupon_name'] . " - Coupon Applied!",
                    "discount_code" => $code,
                    "discount_percentage" => $discountPercentage,
                    "coupon_name" => $d['coupon_name'],
                    "coupon_type" => $d['coupon_type'],
                    "expiration" => $d['date_expire']
                );

                $coupon = array([
                    "name" => $d['coupon_name'],
                    "code" => $d['dis_code'],
                    "id" => $d['id'],
                    "product" => $d['assign_prod'],
                    "coupon_type" => $d['coupon_type'],
                    "discount_percentage" => $d['discount'],
                    "min_amt_required" => $d['usage_scenario'],
                    "expiration" => $d['date_expire']
                ]);
                $coupons[] = $coupon;
                $cartDataJSON[0]['coupons'] = $coupons;
                setcookie('cartData', json_encode($cartDataJSON, true), 0, '/');

                echo json_encode($array, true);
            }
        } else {
            //No Code Found!
            $array = array(
                "valid" => false,
                "response" => "Coupon Not Valid!",
                "discount_code" => $code,
                "discount_percentage" => 0.0,
                "coupon_name" => '',
                "coupon_type" => '',
                "expiration" => ''
            );

            echo json_encode($array, true);
        }
    }
}
