=== About ===
name: Export Reports
website: https://github.com/HTSolution/Ushahidi-plugin-exportreports
description: Add filter on report index page for KML layer.
author: HTSolution Pvt. Ltd.

== Description ==
Adds export links on reports index filter page

== Installation ==
1. Copy the entire /exportreports/ directory into your /plugins/ directory.
2. Activate the plugin.
3. If the export links CSV/XML does not appear on report main page then search for <p> tag inside <div id="filter-controls"> tag and add following code below
Code to be added :
	<?php Event::run('ushahidi_action.report_filters_controls_ui'); ?>