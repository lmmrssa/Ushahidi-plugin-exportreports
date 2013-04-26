<?php defined('SYSPATH') or die('No direct script access.');

class exportreport {

	public function __construct()
	{
		// Hook into routing
		Event::add('system.pre_controller', array($this, 'add'));
	}
	
	public function add()
	{
		if (Router::$controller == 'reports' AND Router::$method == 'index') {
			plugin::add_stylesheet('exportreports/css/export_reports');
			Event::add('ushahidi_action.header_scripts', array($this, '_filter_control_js'));
			Event::add('ushahidi_action.report_filters_controls_ui', array($this, '_filter_control_ui'));
		}
	}
	
	public function _filter_control_js() {
		$view = new View('export_reports/export_reports_js');
		$view->render(true);
	}
	
	public function _filter_control_ui() {
		$view = new View('export_reports/report_filter_control_ui');
		$view->render(true);
	}
	
}

new exportreport();
