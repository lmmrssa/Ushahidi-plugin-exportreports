<?php defined('SYSPATH') or die('No direct script access.');

class Exportreports_Install {

	public function __construct() {
	}

	public function run_install() {
		copy(SYSPATH.'../plugins/exportreports/export_reports_readme.txt', SYSPATH.'../media/export_reports_readme.txt');
	}
	
	/**
	 * Function: uninstall
	 *
	 */
	public function uninstall() {
		@unlink(SYSPATH.'../media/export_reports_readme.txt');
	}

}