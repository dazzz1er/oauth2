<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    function __construct() {
    	$this->middleware('oauth');
    }

    public function hello() {
    	return 'You made it in!';
    }
}
