<?php

namespace App\Guard;

class TestSiteGuard extends \DJB\Guard\Guard {
	
	protected function canFly() {
		if ($this->value !== "can fly") $this->setIssue('can not fly');
	}

}