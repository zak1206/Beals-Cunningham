<?php

$cart = new Cart();

class Cart
{
    public $cartJSON;

    public $itemsTotal;
    public $taxTotal;
    public $purchaseLocation;
    public $items;
    public $itemsCount;

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
        $this->UpdateLocalCartFromCookie();
        $this->SetCartCookieData();
    }

    public function AddNewCartItem($nitemid, $nname, $neqType, $nprice, $nurl, $neqTabs, $nqty)
    {
        $this->items[] = [
            "id" => $nitemid,
            "name" => $nname,
            "eq_type" => $neqType,
            "price" => $nprice,
            "url" => $nurl,
            "eq_tabs" => $neqTabs,
            "qty" => $nqty
        ];

        //array_push($items, $item);

        $this->SetCartItemCookieData($this->items);
    }

    public function SetCartItemCookieData($item)
    {
        $array = array($item);
        $json = json_encode($this->items);
        setcookie('cartItems', $json, time() + 3600);
    }

    public function GetCartItemCookieJSON()
    {
        $cookie = json_decode($_COOKIE['cartItems'], true);
        $this->items = $cookie;
        return $cookie;
    }

    public function SetPurchaseLocation($id)
    {
        //Set Purchase ID Locally
        $this->purchaseLocation = $id;
        //Update Other Local Variables From Cookie Data
        $this->GetCartItemsFromCookie();
        $array = [
            "itemsTotal" => $this->itemsTotal,
            "taxTotal" => $this->taxTotal,
            "purchaseLocation" => $this->purchaseLocation,
            "itemCount" => count($this->GetCartItemCookieJSON()),
            "cartItems" => $this->items
        ];

        $json = json_encode($array, true);
        setcookie('cartData', $json, time() + 3600);
    }

    public function CalculateCartTaxTotal()
    {
        $this->taxTotal = 503.32 * 0.055;
    }

    public function CalculateCartItemsTotal()
    {
        $this->itemsTotal = 503.32;
    }

    public function GetCartItemsFromCookie()
    {
        $this->items = json_decode($_COOKIE['cartItems'], false);
        $this->itemsCount = count($this->items);
        $this->CalculateCartItemsTotal();
        $this->CalculateCartTaxTotal();
    }

    public function GetCartJSON()
    {
        $json = json_decode($_COOKIE['cartData'], true);
        $this->cartJSON = $json;

        return $json;
    }

    public function SetCartCookieData()
    {
        $array = [
            "itemsTotal" => $this->itemsTotal,
            "taxTotal" => $this->taxTotal,
            "purchaseLocation" => $this->purchaseLocation,
            "itemCount" => count($this->GetCartItemCookieJSON()),
            "cartItems" => $this->items
        ];

        $json = json_encode($array, true);
        setcookie('cartData', $json, time() + 3600);
    }

    public function UpdateLocalCartFromCookie()
    {
        $this->GetCartJSON();

        if ($this->cartJSON != null) {
            //UPDATE CLASS VARIABLES WITH EXISTING COOKIE DATA
            $this->purchaseLocation = $this->cartJSON["purchaseLocation"];
            $this->itemsTotal = $this->cartJSON["itemsTotal"];
            $this->taxTotal = $this->cartJSON["taxTotal"];
            $this->items = json_decode($_COOKIE["cartItems"], false);
            $this->itemsCount = count($this->items["cartItems"]);

            $array = [
                "itemsTotal" => $this->itemsTotal,
                "taxTotal" => $this->taxTotal,
                "purchaseLocation" => $this->purchaseLocation,
                "itemCount" => count($this->items),
                "cartItems" => $_COOKIE["cartItems"]
            ];

            $json = json_encode($array, true);
            setcookie('cartData', $json, time() + 3600);
        } else {
            //CREATE NEW COOKIE DATA
            $this->purchaseLocation = -1;
            $this->itemsTotal = 0;
            $this->taxTotal = 0;
            $this->items = array();
            $this->itemsCount = 0;

            $array = [
                "itemsTotal" => $this->itemsTotal,
                "taxTotal" => $this->taxTotal,
                "purchaseLocation" => $this->purchaseLocation,
                "itemCount" => count($this->items),
                "cartItems" => $this->items
            ];

            $json = json_encode($array, true);
            setcookie('cartData', $json, time() + 3600);
        }
    }
}
