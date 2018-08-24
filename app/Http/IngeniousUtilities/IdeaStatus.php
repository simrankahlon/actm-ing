<?php
namespace App\Http\IngeniousUtilities;

Class IdeaStatus
{
	protected static $status = [
		"Logg" 						=> "LOGG",
		"Return For Updation"					=> "RETURNFORUPDATN",
		"Accepted"		=> "ACCEPTED",
		"Pending"	=> "PENDING",
		"Shared for approval by Client" => "SHAREDFORAPPROVAL",
		"Implemented" => "IMPLEMENTED",
		"Rejected"    => "REJECTED"
		];

	public static function all() {
		return static::$status;
	}
}
?>