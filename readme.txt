=== About ===
name: Export Reports
website: https://github.com/HTSolution/Ushahidi-plugin-exportreports
description: Add export button on report index page to export filter on CSV/XML
author: HTSolution Pvt. Ltd.
author website: http://himalayantechies.com

== Description ==
*Add export button on report index page to export filter on CSV/XML

== Installation ==
1. Copy the entire /exportreports/ directory into your /plugins/ directory.
2. Activate the plugin.
__NOTE: If activating plugin does not show CSV/XML button on report main page then search for <p> tag inside <div id="filter-controls"> tag and add following code below__
	<?php Event::run('ushahidi_action.report_filters_controls_ui'); ?>