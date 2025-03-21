<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function company()
    {
        return view('settings/company');
    }
    
    public function currencies()
    {
        return view('settings/currencies');
    }
    
    public function language()
    {
        return view('settings/language');
    }
    
    public function notification()
    {
        return view('settings/notification');
    }
    
    public function notificationAlert()
    {
        return view('settings/notificationAlert');
    }
    
    public function paymentGateway()
    {
        return view('settings/paymentGateway');
    }
    
    public function theme()
    {
        return view('settings/theme');
    }

    public function changeReceiptFooter(){

    }

    public function changeReceiptHeader(){
    }

    public function updateCurrencies(){

    }

    public function changeReceiptStamp(){

    }

    public function changeLogo()
    {

    }

    public function changeColors(){
        
    }
    
}
