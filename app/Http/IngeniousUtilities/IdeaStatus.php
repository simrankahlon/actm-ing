<?php
namespace App\Http\IngeniousUtilities;

Class IdeaStatus
{
	protected static $status = [
		"Return For Updation"					=> "RETURNFORUPDATION",
		"Accepted for Implementation"		=> "ACCEPTED",
		"Shared for approval by Client" => "SHAREDFORAPPROVAL",
		"Rejected"    => "REJECTED"
		];

	public static function all() {
		return static::$status;
	}

	public static function lookup($code){
		$key = array_search($code, static::$status);
		return $key;
	}
}
?>