<?php namespace App\Realtime;

use Redis;

class RealtimeBroadcaster {
  
	public static function broadcast() {
		$connection = Redis::connection('default'); // note that Redis may have to be given a new alias in app/config if php redis module is enabled
		$event = 'Test';
		$payload = json_encode(['event' => $event, 'payload' => ['user' => 'danje', 'status' => 'awesome']]);
		$connection->publish('test-channel', $payload);
	}

}

?>