<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AuthorisedAccount extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'authorised_accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type', 'account_id', 'access_token', 'expiration_date'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes to automatically convert into Carbon instances
     * 
     * @var array
     */
    public $dates = ['expiration_date'];

    /**
     * Update the token associated with the account
     * 
     * @param  string  $token
     * @param  string  $expires
     * @return bool
     */
    public function updateToken($token, $expires) {
    	$expires = Carbon::parse($expires);
    	return $this->update([
    		'access_token' => $token,
    		'expiration_date' => $expires
    	]);
    }

    /**
     * Deauthorize use of this third party account
     * @return bool
     */
    public function deauthorize() {
    	return $this->delete();
    }

    /**
     * Limit a query on accounts to an account type
     * 
     * @param  \Illuminate\Database\Query\Builder  $query
     * @param  string                              $type
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeOfType($query, $type) {
    	return $query->where('type', $type);
    }

    /**
     * Limit a query on accounts to those with a valid access token
     * 
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWhereHasValidAccessToken($query) {
    	return $query->whereNotNull('access_token')
    				 ->where('expiration_date', '>=', 'GETDATE()');
    }
}
