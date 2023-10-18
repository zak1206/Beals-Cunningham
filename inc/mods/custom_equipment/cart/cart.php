<?php


$cart = new Cart();

class Cart
{
    public $cartJSON;

    public $itemsTotal;
    public $taxTotal;
    public $purchaseLocation;
    public $cartItems;
    public $cartItemsCount;

    //Cart Item Vars
    public $item_id;
    public $name;
    public $eq_type;
    public $price;
    public $url;
    public $eq_tabs;
    public $qty;

    public function __construct()
    {
    }

    public function AddNewCartItem($nitemid, $nname, $nprice, $nurl, $nqty, $nshipType = 'pickup_only')
    {
        $item = array([
            "uniqId" => $this->generateRandomId(),
            "id" => $nitemid,
            "name" => $nname,
            "ship_type" => $nshipType,
            "price" => $nprice,
            "url" => $nurl,
            "applied_discount" => 0,
            "qty" => $nqty
        ]);

        if (!isset($_COOKIE['cartData'])) {
            //No Cart Data Cookie - Need To Create One
            $cartData = array([
                "shop_location" => -1,
                "shipping_type" => "NULL",
                "pickup" => "false",
                "applied_tax" => 0.0,
                "applied_discount" => 0.0,
                "cart_total" => 0.0,
                "cartItems" => $item,
                "coupons" => array([])
            ]);
        } else {
            //Cart Data COOKIE Exists - Proceed

            //Check if item already exists in the cart
            if ($this->ItemExistsInCart($nitemid, $nprice) == false) {
                //Item Does Not Already Exist in Cart
                //Get Cookie and Add New Item To It
                $cartData = json_decode($_COOKIE['cartData'], true);
                $cartItems = $cartData[0]['cartItems'];

                $item = array(
                    "uniqId" => $this->generateRandomId(),
                    "id" => $nitemid,
                    "name" => $nname,
                    "ship_type" => $nshipType,
                    "price" => $nprice,
                    "url" => $nurl,
                    "applied_discount" => 0,
                    "qty" => $nqty
                );

                $cartItems[] = $item;
                $cartData[0]['cartItems'] = $cartItems;
            } else {
                //Item exists in cart
                //Loop through each item in cart > increase qty if exists

                $cartData = json_decode($_COOKIE['cartData'], true);
                $cartItems = $cartData[0]['cartItems'];
                $uniqId = '';
                $newQty = 0;

                foreach ($cartItems as &$item) {
                    if ($item['id'] == $nitemid && $item['price'] == $nprice) {
                        $uniqId = $item['uniqId'];
                        $newQty = intval($item['qty']) + 1;
                    }
                }

                $retArray = $this->SetItemQty($uniqId, $newQty);
                $cartData = $retArray['cartData'];
            }
        }

        setcookie('cartData', json_encode($cartData, true), 0, '/');

        return $cartData;
    }

    public function SetItemQty($uniqId, $qty)
    {
        try {
            // Retrieve and decode the JSON string from the cookie, decode twice
            $cartData = json_decode($_COOKIE['cartData'], true);
            $cartItems = $cartData[0]['cartItems'];
            $cartItemsNew = array();
            $itemTotal = 0;
            $cartTotalNew = 0;

            foreach ($cartItems as &$item) {
                if ($item['uniqId'] == $uniqId) {

                    $itemNew = array(
                        "uniqId" => $item['uniqId'],
                        "id" => $item['id'],
                        "name" => $item['name'],
                        "ship_type" => $item['ship_type'],
                        "price" => $item['price'],
                        "url" => $item['url'],
                        "applied_discount" => $item['applied_discount'],
                        "qty" => $qty
                    );

                    $itemTotal = doubleval($qty) * doubleval($item['price']);
                    $cartTotalNew = $cartTotalNew + (intval($qty) * doubleval($item['price']));

                    $cartItemsNew[] = $itemNew;
                    $cartData[0]['cartItems'] = $cartItemsNew;
                } else {
                    $cartTotalNew = $cartTotalNew + (intval($item['qty']) * doubleval($item['price']));
                    $cartItemsNew[] = $item;
                }
            }

            $cartDataNew = array([
                "shop_location" => -1,
                "shipping_type" => $cartData[0]['shipping_type'],
                "pickup" => $cartData[0]['pickup'],
                "applied_tax" => $cartData[0]['applied_tax'],
                "applied_discount" => $cartData[0]['applied_discount'],
                "cart_total" => $cartTotalNew,
                "cartItems" => $cartItemsNew,
                "coupons" => $cartData[0]['coupons']
            ]);

            setcookie('cartData', json_encode($cartDataNew, true), 0, '/');
            return array("itemTotal" => $itemTotal, "cartTotal" => $cartTotalNew, "cartData" => $cartDataNew);
        } catch (Exception $ex) {
            echo "<script>" . "console.log('Error: " . $ex->getMessage() . "');</script>";
            return -1;
        }
    }

    public function RemoveCartItem($id)
    {
        $newCartItems = array();
        $cartData = json_decode($_COOKIE['cartData'], true);

        for ($i = 0; $i < count($cartData[0]['cartItems']); $i++) {
            if ($cartData[0]['cartItems'][$i]['uniqId'] != $id) {
                $newCartItems[] = $cartData[0]['cartItems'][$i];
            }
        }

        $cartData[0]['cartItems'] = $newCartItems;

        //Reset Cart-Total & Applied Tax if Total Cart Count == 0
        if (count($cartData[0]['cartItems']) == 0) {
            $cartData[0]['applied_tax'] = 0.0;
            $cartData[0]['cart_total'] = 0.0;
        }

        setcookie('cartData', json_encode($cartData, true), 0, '/');

        return true;
    }

    public function IncreaseItemQty($itemID, $price, $qty)
    {
        try {
            // Retrieve and decode the JSON string from the cookie, decode twice
            $cartData = json_decode($_COOKIE['cartData'], true);
            $cartItems = $cartData[0]['cartItems'];
            $cartItemsNew = array(); // Use correct array structure$cartItems = $cartData[0]['cartItems'];
            $foundItem = false;

            foreach ($cartItems as &$item) {
                if (($item['id'] == $itemID) && ($item['price'] == $price)) {
                    $currentQty = $item['qty'];

                    if ($qty == -1) {
                        $newQty = intval($currentQty) + 1;
                    } else {
                        $newQty = $qty;
                    }

                    $itemNew = array(
                        "uniqId" => $item['uniqId'],
                        "id" => $item['id'],
                        "name" => $item['name'],
                        "ship_type" => $item['ship_type'],
                        "price" => $item['price'],
                        "url" => $item['url'],
                        "applied_discount" => $item['applied_discount'],
                        "qty" => $newQty
                    );

                    $cartItemsNew[] = $itemNew;
                    $cartData[0]['cartItems'] = $cartItemsNew;
                } else {
                    //Add Cloned Items Into New Array
                    $cartItemsNew[] = $item;
                }
            }

            // Encode the updated $cartData back into a JSON string
            $cartDataNew = array([
                "shop_location" => $cartData[0]['shop_location'],
                "shipping_type" => $cartData[0]['shipping_type'],
                "pickup" =>  $cartData[0]['pickup'],
                "applied_tax" => $cartData[0]['applied_tax'],
                "applied_discount" => $cartData[0]['applied_discount'],
                "cart_total" => 0,
                "cartItems" => $cartItemsNew,
                "coupons" => $cartData[0]['coupons']
            ]);

            $this->UpdateCartTotalAfterDiscount();

            setcookie('cartData', json_encode($cartDataNew, true), 0, '/');

            return $cartDataNew;
        } catch (Exception $e) {
            // Log or print any error messages for debugging
            echo "<script>" . "console.log('Error: " . $e->getMessage() . "');</script>";
            return null;
        }
    }

    public function ItemExistsInCart($nitemId, $nprice)
    {
        $cartData = json_decode($_COOKIE['cartData'], true);
        $cartItems = $cartData[0]['cartItems'];

        for ($j = 0; $j < count($cartItems); $j++) {
            $itemId = $cartItems[$j]['id'];
            $itemPrice = $cartItems[$j]['price'];

            if ($nitemId == $itemId && $nprice == $itemPrice) {
                return true;
            }
        }

        return false;
    }

    public function GetCartTotalNoTax($cartData)
    {
        $priceTotal = 0.0;

        foreach ($cartData[0]['cartItems'] as &$item) {
            $qty = $item['qty'];
            if ($item['applied_discount'] != 0) {
                $priceTotal = $priceTotal + (($item['price'] * $item['applied_discount']) * $qty);
            } else {
                $priceTotal = $priceTotal + ($item['price'] * $qty);
            }
        }

        //Apply Cart Discount If Needed
        if ($cartData[0]['applied_discount'] != 0) {
            $priceTotal = $priceTotal * $cartData[0]['applied_discount'];
        }

        return $priceTotal;
    }

    function SetShopLocation($shopLocID)
    {
        $cartData = json_decode($_COOKIE['cartData'], true);
        $cartItems = $cartData[0]['cartItems'];
        $cartDataNew = array([
            "shop_location" => $shopLocID,
            "pickup" => $cartData[0]['pickup'],
            "applied_tax" => $cartData[0]['applied_tax'],
            "applied_discount" => $cartData[0]['applied_discount'],
            "cart_total" => $cartData[0]['cart_total'],
            "cartItems" => $cartItems,
            "coupons" => $cartData[0]['coupons']
        ]);

        setcookie('cartData', json_encode($cartDataNew, true), 0, '/');

        return true;
    }

    function SetAppliedDiscount($discountAmt)
    {
        $cartData = json_decode($_COOKIE['cartData'], true);
        $cartItems = $cartData[0]['cartItems'];
        $cartDataNew = array([
            "shop_location" => $cartData[0]['shop_location'],
            "pickup" => $cartData[0]['pickup'],
            "applied_tax" => $cartData[0]['applied_tax'],
            "applied_discount" => $discountAmt,
            "cart_total" => $cartData[0]['cart_total'],
            "cartItems" => $cartItems,
            "coupons" => $cartData[0]['coupons']
        ]);

        setcookie('cartData', json_encode($cartDataNew, true), 0, '/');

        $this->UpdateCartTotalAfterDiscount();

        return true;
    }

    function SetAppliedTax($tax)
    {
        $cartData = json_decode($_COOKIE['cartData'], true);
        $cartItems = $cartData[0]['cartItems'];

        $cartDataNew = array([
            "shop_location" => $cartData[0]['shop_location'],
            "pickup" => $cartData[0]['pickup'],
            "applied_tax" => $tax,
            "applied_discount" => $cartData[0]['applied_discount'],
            "cart_total" => $cartData[0]['cart_total'],
            "cartItems" => $cartItems,
            "coupons" => $cartData[0]['coupons']
        ]);

        setcookie('cartData', json_encode($cartDataNew, true), 0, '/');

        $this->UpdateCartTotalAfterDiscount();

        return true;
    }

    function UpdateCartWithShippingLabel($url, $rate)
    {
        $cartData = json_decode($_COOKIE['cartData'], true);
        $cartItems = $cartData[0]['cartItems'];

        $cartDataNew = array([
            "shop_location" => $cartData[0]['shop_location'],
            "pickup" => $cartData[0]['pickup'],
            "applied_tax" => $cartData[0]['applied_discount'],
            "applied_discount" => $cartData[0]['applied_discount'],
            "cart_total" => $cartData[0]['cart_total'],
            "cartItems" => $cartItems,
            "coupons" => $cartData[0]['coupons']
        ]);

        setcookie('cartData', json_encode($cartDataNew, true), 0, '/');

        return true;
    }

    function ResetCart()
    {

        $cartDataNew = array([
            "shop_location" => -1,
            "shipping_type" => 'null',
            "shipping_token" => 'null',
            "pickup" => false,
            "applied_tax" => 0,
            "applied_discount" => 0,
            "cart_total" => 0,
            "cartItems" => array([]),
            "coupons" => array([])
        ]);

        $cartDataNew = json_encode($cartDataNew, true);
        setcookie('cartData', $cartDataNew, 0, '/');
    }

    function SetPickupLocation($locationID)
    {
        $cartData = json_decode($_COOKIE['cartData'], true);

        $cartDataNew = array([
            "shop_location" => $locationID,
            "pickup" => true,
            "applied_tax" => $cartData[0]['applied_tax'],
            "applied_discount" => $cartData[0]['applied_discount'],
            "cart_total" => $cartData[0]['cart_total'],
            "cartItems" => $cartData[0]['cartItems'],
            "coupons" => $cartData[0]['coupons']
        ]);

        $cartDataNew = json_encode($cartDataNew, true);
        setcookie('cartData', $cartDataNew, 0, '/');
    }

    function SetShippingToken($token)
    {
        $cartData = json_decode($_COOKIE['cartData'], true);

        $cartDataNew = array([
            "shop_location" => $cartData[0]['shop_location'],
            "pickup" => false,
            "applied_tax" => $cartData[0]['applied_tax'],
            "applied_discount" => $cartData[0]['applied_discount'],
            "cart_total" => $cartData[0]['cart_total'],
            "cartItems" => $cartData[0]['cartItems'],
            "coupons" => $cartData[0]['coupons']
        ]);

        $cartDataNew = json_encode($cartDataNew, true);
        setcookie('cartData', $cartDataNew, 0, '/');
    }

    function UpdateCartTotalAfterDiscount()
    {
        $cartData = json_decode($_COOKIE['cartData'], true);
        $cartItems = $cartData[0]['cartItems'];
        $total = 0;

        //Product Discounts
        foreach ($cartItems as &$item) {
            if ($item['applied_discount'] > 0) {
                $total = $total + (($item['price'] * $item['applied_discount']) * $item['qty']);
            } else {
                $total = $total + ($item['price'] * $item['qty']);
            }
        }

        //Check Cart Discount
        if ($cartData[0]['applied_discount'] > 0) {
            $total = $total + ($total * $cartData[0]['applied_discount']);
        }

        $coupon = array([
            "name" => "Test Coupon",
            "id" => 1,
            "product" => 1509,
            "coupon_type" => "product_coupon",
            "discount_percentage" => "75%",
            "min_amt_required" => 100,
            "expiration" => 234245534535
        ]);

        $cartDataNew = array([
            "shop_location" => $cartData[0]['shop_location'],
            "pickup" => $cartData[0]['pickup'],
            "applied_tax" => $cartData[0]['applied_tax'],
            "applied_discount" => $cartData[0]['applied_discount'],
            "cart_total" => $total,
            "cartItems" => $cartItems,
            "coupons" => $coupon
        ]);

        setcookie('cartData', json_encode($cartDataNew, true), 0, '/');

        return true;
    }

    function generateRandomId($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $id = '';

        for ($i = 0; $i < $length; $i++) {
            $randomIndex = rand(0, strlen($characters) - 1);
            $id .= $characters[$randomIndex];
        }

        return $id;
    }
}
