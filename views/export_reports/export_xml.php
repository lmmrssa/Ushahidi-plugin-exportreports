<?php
ob_start();
echo '<content>';
foreach ($incidents as $incident) {
	echo '<incident>';
		$incident_id = $incident->incident_id;
		echo '<data><label>#</label>';
			echo '<value>'.$incident->incident_id.'</value>';
		echo '</data>';
		echo '<data><label>INCIDENT TITLE</label>';
			echo '<value>'.reports::_csv_text($incident->incident_title).'</value>';
		echo '</data>';
		echo '<data><label>INCIDENT DATE</label>';
			echo '<value>'.$incident->incident_date.'</value>';
		echo '</data>';
		echo '<data><label>LOCATION</label>';
			echo '<value>'.reports::_csv_text($incident->location_name).'</value>';
		echo '</data>';
		echo '<data><label>DESCRIPTION</label>';
			echo '<value>'.reports::_csv_text($incident->incident_description).'</value>';
		echo '</data>';
		echo '<data><label>CATEGORY</label>';
			$incident->incident_category = ORM::Factory('category')->join('incident_category', 'category_id', 'category.id')->where('incident_id', $incident_id)->find_all();
			foreach($incident->incident_category as $category)
			{
				if ($category->category_title)
				{
					echo '<value>'.reports::_csv_text($category->category_title) . '</value>';
				}
			}
		echo '</data>';
		echo '<data><label>LATITUDE</label>';
			echo '<value>'.reports::_csv_text($incident->latitude).'</value>';
		echo '</data>';
		echo '<data><label>LONGITUDE</label>';
			echo '<value>'.reports::_csv_text($incident->longitude).'</value>';
		echo '</data>';
		
		echo '<data><label>DESCRIPTION</label>';
			echo '<value>'.reports::_csv_text($incident->incident_description).'</value>';
		echo '</data>';
		
		$custom_fields = customforms::get_custom_form_fields($incident_id,'',false);
		if ( ! empty($custom_fields))
		{
			foreach($custom_fields as $custom_field)
			{
				echo '<data><label>'.reports::_csv_text($custom_field['field_name']).'</label>';
					echo '<value>'.reports::_csv_text($custom_field['field_response']).'</value>';
				echo '</data>';
			}
		}
		else
		{
			$custom_field = customforms::get_custom_form_fields('','',false);
			foreach ($custom_field as $custom)
			{
				echo '<data><label>'.reports::_csv_text($custom['field_name']).'</label>';
					echo '<value>'.reports::_csv_text("").'</value>';
				echo '</data>';
			}
		}
		$incident_orm = ORM::factory('incident', $incident_id);
		$incident_person = $incident_orm->incident_person;
		if($incident_person->loaded)
		{
			echo '<data><label>FIRST NAME</label>';
				echo '<value>'.reports::_csv_text($incident_person->person_first).'</value>';
			echo '</data>';
			echo '<data><label>LAST NAME</label>';
				echo '<value>'.reports::_csv_text($incident_person->person_last).'</value>';
			echo '</data>';
			echo '<data><label>EMAIL</label>';
				echo '<value>'.reports::_csv_text($incident_person->person_email).'</value>';
			echo '</data>';
		}
		else
		{
			echo '<data><label>FIRST NAME</label>';
			echo '<value>'.reports::_csv_text("").'</value>';
			echo '</data>';
			echo '<data><label>LAST NAME</label>';
			echo '<value>'.reports::_csv_text("").'</value>';
			echo '</data>';
			echo '<data><label>EMAIL</label>';
			echo '<value>'.reports::_csv_text("").'</value>';
			echo '</data>';
		}
		echo '<data><label>APPROVED</label>';
		if ($incident->incident_active) {
			echo '<value>YES</value>';
		} else {
			echo '<value>NO</value>';
		}
		echo '</data>';
		echo '<data><label>VERIFIED</label>';
		if ($incident->incident_verified) {
			echo '<value>YES</value>';
		} else {
			echo '<value>NO</value>';
		}
		echo '</data>';
		// Incase a plugin would like to add some custom data for an incident
		$event_data = array("report_xml" => "", "incident" => $incident);
		Event::run('ushahidi_filter.report_download_xml_incident', $event_data);
		echo $event_data['report_xml'];
	echo '</incident>';
}
echo '</content>';

$report_xml = ob_get_clean();

// Output to browser
header("Content-type: text/xml");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Disposition: attachment; filename=" . time() . ".xml");
header("Content-Length: " . strlen($report_xml));
echo $report_xml;
exit;
?>