<?php namespace App;

use Auth;

class PasswordGrantVerifier {
	
	public function verify($username, $password) {
		$credentials = [
        'email'    => $username,
        'password' => $password,
      ];

      return 1;

      if (Auth::once($credentials)) {
          return Auth::user()->id;
      }

      return false;
	}

}