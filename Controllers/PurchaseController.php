<?php 

namespace Controllers;
use Model\Purchase as Purchase;
use Model\Showtime as Showtime;

class PurchaseController  
{
    

    public function create()
    {
        $showtime=$_POST['showtime'];
        $Amount=$_POST['Amount'];
        $purchase=new Purchase(date("Y-m-d H:i:s"),$Amount);

    }
}













?>