<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    function __construct() {
    	//$this->middleware('oauth');
    }

    public function hello() {
    	$test_var = "can not fly";
    	(new \App\Guard\TestSiteGuard($test_var))->canFly()->otherwise(function() {
    		throw new \Exception('Failed guard!');
    	});
    	return 'You made it in!';
    }
}
