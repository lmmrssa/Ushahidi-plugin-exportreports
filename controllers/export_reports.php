<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @author     John Etherton <john@ethertontech.com>
 * @package    Enhanced Map, Ushahidi Plugin - https://github.com/jetherton/enhancedmap
 * @license	   GNU Lesser GPL (LGPL) Rights pursuant to Version 3, June 2007
 * @copyright  2012 Etherton Technologies Ltd. <http://ethertontech.com>
 * @Date	   2010-12-04
 * Purpose:	   This is main map controller for the enhanced map plugin.
 * Inputs:     Internal calls from modules
 * Outputs:    A map for viewing by users
 *
 * The Enhanced Map, Ushahidi Plugin is free software: you can redistribute
 * it and/or modify it under the terms of the GNU Lesser General Public License
 * as published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * The Enhanced Map, Ushahidi Plugin is distributed in the hope that it will
 * be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with the Enhanced Map, Ushahidi Plugin.  If not, see
 * <http://www.gnu.org/licenses/>.
 *
 * Changelog:
 * 2010-12-04:  Etherton - Initial release
 *
 * Developed by Etherton Technologies Ltd.
 */
class Export_reports_Controller extends Template_Controller {

	public $auto_render = TRUE;
	public $template = 'layout';
	
	public function __construct() {
		parent::__construct();
	}

	public function index($type = 'csv') {
		$this->template = "";
		$this->auto_render = FALSE;
		if (empty($locale)) {
			$locale = Kohana::config('locale.language.0');
		}
		$report_listing = View::factory('export_reports/export_'.$type);
		$report_listing->incidents = reports::fetch_incidents();
		print $report_listing;
	}
	
} // End Main