<?php ob_start();
echo "<?xml version=\"1.0\"?>"; ?>
<export xmlns="http://www.w3.org/2005/Atom">
	<updated><?php echo gmdate("c", time()); ?></updated>
	<link rel="alternate" type="text/html" href="<?php echo url::base(); ?>"/>
	<generator uri="<?php echo url::base(); ?>" version="1.0">Export Report Plugin - HTSolution</generator>
	<?php
	// Event::report_download_xml_head - Add to the xml head
	Event::run('ushahidi_action.report_download_xml_head');
		
	foreach ($incidents as $incident) {
		echo '<id>'.$incident->incident_id.'</id>';
		echo '<title>'.exportreports_helper::_csv_text($incident->incident_title).'</title>';
		$link = url::base().'reports/view/'.$incident->incident_id;
		echo '<link  rel="alternate" type="text/html" href="'.$link.'" />';
		echo '<published>'.$incident->incident_date.'</published>';
		echo '<location>'.exportreports_helper::_csv_text($incident->location_name).'</location>';
		$incident->incident_category = ORM::Factory('category')->join('incident_category', 'category_id', 'category.id')->where('incident_id', $incident->incident_id)->find_all();
		foreach($incident->incident_category as $category) {
			if ($category->category_title) {
				echo '<category>'.exportreports_helper::_csv_text($category->category_title).'</category>';
			}
		}
		echo '<longitude>'.exportreports_helper::_csv_text($incident->longitude).'</longitude>';
		echo '<latitude>'.exportreports_helper::_csv_text($incident->longitude).'</latitude>';
		echo '<content type="xhtml" xml:lang="en">'
		.exportreports_helper::_csv_text($incident->incident_description)
		.'</content>';
		
		$custom_fields = customforms::get_custom_form_fields($incident->incident_id,'',false);
		if (!empty($custom_fields)) {
			echo '<customfields>';
			foreach($custom_fields as $custom_field) {
				$tag = exportreports_helper::_xml_tag($custom_field['field_name']);
				echo '<'.$tag.'>'.exportreports_helper::_csv_text($custom_field['field_response']).'</'.$tag.'>';
			}
			echo '</customfields>';
		}
		$incident_orm = ORM::factory('incident', $incident->incident_id);
		$incident_person = $incident_orm->incident_person;
		if($incident_person->loaded) {
			echo '<person>';
				echo '<firstname>'.exportreports_helper::_csv_text($incident_person->person_first).'</firstname>';
				echo '<lastname>'.exportreports_helper::_csv_text($incident_person->person_last).'</lastname>';
				echo '<email>'.exportreports_helper::_csv_text($incident_person->person_email).'</email>';
			echo '</person>';
		}
		if ($incident->incident_active) {
			echo '<approved>YES</approved>';
		} else {
			echo '<approved>NO</approved>';
		}
		if ($incident->incident_verified) {
			echo '<verified>YES</verified>';
		} else {
			echo '<verified>NO</verified>';
		}
		
		Event::run('ushahidi_filter.report_download_xml_incident', $incident->incident_id);
		
	}
	?>
</export>
<?php
$report_xml = ob_get_clean();

// Output to browser
header("Content-type: text/xml");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Disposition: attachment; filename=" . time() . ".xml");
header("Content-Length: " . strlen($report_xml));
echo $report_xml;
exit;
?>