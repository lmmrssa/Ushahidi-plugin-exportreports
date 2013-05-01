<?php defined('SYSPATH') or die('No direct script access.');
class exportreports_helper_Core {

	protected static $table_prefix;
	
	static function init() {
		// Set Table Prefix
		self::$table_prefix = Kohana::config('database.default.table_prefix');
	}

	public function _csv_text($text) {
		$text = stripslashes(htmlspecialchars($text));
		return $text;
	}
	
	public function _xml_tag($tag) {
		$cleantag = preg_replace(array('/\ /', '/\(/', '/\)/'), array('_', '-', '-'), strip_tags($tag));
		return $cleantag;
	}
	
}
exportreports_helper_Core::init();
?>