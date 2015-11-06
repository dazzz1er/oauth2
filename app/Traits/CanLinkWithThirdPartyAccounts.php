<?php

namespace App\Traits;

trait CanLinkWithThirdPartyAccounts {

	/**
	 * Get all the authorised third party accounts the user has associated with their account
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function authorisedAccounts() {
		return $this->hasMany('authorised_accounts');
	}

	/**
	 * Whether a user has a facebook account linked with their account
	 * @return boolean
	 */
	public function hasLinkedFacebookAccount() {
		return $this->authorisedAccounts()->ofType('facebook')->count() > 0;
	}

	/**
	 * Whether a user has an ETA account linked with their account
	 * @return boolean
	 */
	public function hasLinkedETAAccount() {
		return $this->authorisedAccounts()->ofType('eta')->count() > 0;
	}

	/**
	 * Get the authorised thirty party account model
	 * 
	 * @param  string  $account
	 * @return mixed   bool/App\AuthorisedAccount
	 */
	public function account($account) {
		$accounts = $this->authorisedAccounts()->ofType($account)->get();
		if ($accounts->isEmpty()) return false;
		return $accounts->first();
	}

	/**
	 * Update the access token associated with the account
	 *
	 * Should not be used directly,
	 * instead use $user->account('facebook')->updateToken($token, $expires)
	 * 
	 * @param  string  $account
	 * @param  string  $token
	 * @param  string  $expires
	 * @return bool    bool
	 */
	public function updateToken($account, $token, $expires) {
		$account = $this->account($account);
		if ( ! $account) return false;
		return $account->updateToken($token, $expires);
	}

}