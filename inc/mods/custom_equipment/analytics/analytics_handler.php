<?php

class Analytics
{
    public function __construct()
    {
    }

    //------------- Database Select Functions [WILL EVENTUALLY NEED TO MOVE TO SITE-ADMIN/INSTALLED_BEANS/ SO BACKEND CAN READ THE ANALYTICS DATA]

    //Get Count for Number of Time Item Was Added To Cart
    //Returns int
    public function Get_DateRange_ItemAddedToCart_Count($id, $dateFrom, $dateTo)
    {
        include('config.php');
    }

    //Get Count for Number of Time Item Was Purchased
    //returns int
    public function Get_DateRange_ItemPurchased_Count($id, $qty, $dateFrom, $dateTo)
    {
        include('config.php');
    }

    //Get Most Popular Purchased Item
    //returns int - custom_equipment ID
    public function Get_MostPopularPurchasedItem_ID()
    {
        include('config.php');
    }

    //Get Most Popular Item Added To Cart
    //returns int - custom_equipment ID
    public function Get_MostPopularAddedToCartItem_ID()
    {
        include('config.php');
    }

    //------------- Database Update Functions

    //Increases Amount An Item Was Added To A User's Cart
    public function ItemAddedToCart($id, $date)
    {
        include('config.php');

        //Retrieve Current JSON String for Items_Added_To_Cart
        //Loop Through To Find Same Item ID
        //  -If Exists - UPDATE Counter
        //  -Else - Create new Counter For Item ID [ex. -> { "id":1, "date":time() }]
    }

    //Increases Amount An Item Was Purchased Successfully
    public function ItemPurchased($id, $qty, $date)
    {
        include('config.php');

        //Retrieve Current JSON String for Items_Purchased
        //Loop Through To Find Same Item ID
        //  -If Exists - UPDATE Counter
        //  -Else - Create new Counter For Item ID [ex. -> { "id":1, "qty":X, "date":time() }]
    }

    //Increases Amount An Item Was Clicked On
    public function ItemViewed($id, $qty, $date)
    {
        include('config.php');

        //Retrieve Current JSON String for Items_Viewed
        //Loop Through To Find Same Item ID
        //  -If Exists - UPDATE Counter
        //  -Else - Create new Counter For Item ID [ex. -> { "id":1, "qty":X, "date":time() }]
    }

    //Increases Amount of Times An Order Was Purchased & Received
    public function Purchase_Order_Received($date)
    {
        include('config.php');

        //Get Current Count of Orders_Received
        //Increment Count
        //Update Column With New Count
    }

    //Increases Amount of Times The EStore Home-Page Was Viewed
    public function EStore_Visitor_Received()
    {
        include('config.php');

        //Get Current Count of EStore_Visitor_Count
        //Increment Count
        //Update Column With New Count
    }

    //Increases Amount of Times A Cart Was Made, Then Abandoned
    public function Increment_Abandoned_Cart_Count()
    {
        include('config.php');

        //Get Current Count of Abandoned_Cart_Count
        //Increment Count
        //Update Column With New Count
    }

    //Increases Amount of Revenue Received on Given Day - [Stored as MM/DD/YYYY]
    public function Revenue_Received($amt, $date)
    {
        include('config.php');

        //Get JSON String For Revenue
        //Loop Through to find if current day exists
        //  - If Exists -> Increase revenue for that day
        //  - Else -> Create new Counter For Current date [ex. -> { "date":"09/12/2023", "revenue":X }]
        //Get Revenue For Current Day

    }
}
