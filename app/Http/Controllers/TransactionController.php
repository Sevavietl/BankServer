<?php

namespace App\Http\Controllers;

use App\User;

class TransactionController extends Controller
{
    public function authenticate()
	{
       dd(User::all());
	}

	public function bill()
	{

	}
}
