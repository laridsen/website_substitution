<?php

namespace App\Http\Controllers;

use DB;
use Auth;

class ProductController extends Controller
{
    public function displayProducts(){
		$product = DB::table('product')->get();
		return view('boutique', [
			'product' => $product,
			'number' => count($product),
		]);
	}
	
	public function orderManagement(){
		if(Auth::check()){
			DB::table('orders')->insert(
				['ID_product' => request('ID'), 'ID_USERS' => Auth::user()->id, 'Quantity' => request('Quantity'), 'ShippingState' => 0]
			);
			$quantity = DB::table('product')->where('ID', request('ID'))->get('ProdCapacity');
			$product = DB::table('product')->where('ID', request('ID'))->get('Name');
			DB::table('product')->where('ID', request('ID'))->update(['ProdCapacity' => (($quantity[0]->ProdCapacity)-request('Quantity'))]);
			$productName = DB::table('product')->where('ID', request('ID'))->get();
			$users = DB::table('users')->get();
			$message = ('L\'utilisateur '.Auth::user()->name.' '.Auth::user()->first_name.' a passer une commande de '.request('Quantity').' '.$product[0]->Name);
			$notificationNumber = count(DB::table('notifications')->get())+1;
			for($i = 0; $i< count($users);$i++){
				if($users[$i]->Fabman == 1){
					DB::table('notifications')->insert([
						'ID' => $notificationNumber,
						'ID_USERS' => $users[$i]->id,
						'text' => $message,
						'seen' => 0,
						'FabNotif' => 1,
					]);
					$notificationNumber++;
				}
			}
			$mail = new MailController();
			$mail->basic_email(Auth::user()->email,strtoupper(Auth::user()->name).' '.ucfirst(strtolower(Auth::user()->first_name)), $productName[0]->Name, request('Quantity'));
			$mail->fabEmail($productName[0]->Name, request('Quantity'));
		}else {
			echo('<script>alert("Vous devez être connecté pour passer une commande")</script>');//an alert() in js
		}
        return view('welcome');
	}
}