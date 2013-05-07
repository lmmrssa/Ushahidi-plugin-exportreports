=== About ===
name: Export Reports
website: https://github.com/HTSolution/Ushahidi-plugin-exportreports
description: Add export button on report index page to export filter on CSV/XML
author: HTSolution Pvt. Ltd.
author website: http://himalayantechies.com

== Description ==
Add export button on report index page to export filter on CSV/XML

== Installation ==
1. Copy the entire /exportreports/ directory into your /plugins/ directory.
2. Activate the plugin.
__NOTE:__
If activating plugin does not show CSV/XML button on report main page then inside themes/default/views/reports/main.php view search for
 
	<div id="filter-controls">
		<p>
			<a href="#" class="small-link-button reset" id="reset_all_filters"><?php echo Kohana::lang('ui_main.reset_all_filters'); ?></a>
			<a href="#" id="applyFilters" class="filter-button"><?php echo Kohana::lang('ui_main.filter_reports'); ?></a>
		</p>
	
and add following code below

    <?php Event::run('ushahidi_action.report_filters_controls_ui'); ?>