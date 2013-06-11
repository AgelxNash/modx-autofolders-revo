<?php
if($modx->event->name=='OnDocFormSave'){
	include_once($modx->getOption('core_path') . 'components/autofolders/functions.php');
	
    // Get the plugin options, setting defaults if they're not available
	$template = $modx->getOption('template', $scriptProperties, '');
	$new_page_template = $modx->getOption('new_page_template', $scriptProperties, '');
	$parent = $modx->getOption('parent', $scriptProperties, '');

	if (empty($parent) || empty($template) || empty($new_page_template)) { return false; } // Those fields are required

	$folder_structure = $modx->getOption('folder_structure', $scriptProperties, 'y/m');
	$date_field = $modx->getOption('date_field', $scriptProperties, 'publishedon');
	$alias_year_format = $modx->getOption('alias_year_format', $scriptProperties, '4');
	$alias_month_format = $modx->getOption('alias_month_format', $scriptProperties, '1');
	$alias_day_format = $modx->getOption('alias_day_format', $scriptProperties, '1');
	$title_year_format = $modx->getOption('title_year_format', $scriptProperties, '4');
	$title_month_format = $modx->getOption('title_month_format', $scriptProperties, '1');
	$title_day_format = $modx->getOption('title_day_format', $scriptProperties, '1');
	$ClassKey = $modx->getOption('classKey', $scriptProperties, 'modDocument');
	$DefaultContent = $modx->getOption('DefaultContent', $scriptProperties);
	
	
	// Is the document we are creating using a template we have been asked to target?
	$tpls = explode(',', $template);
	$tpls = array_map("trim", $tpls);

	// If it's not a template we're targetting, do nothing
	if (!in_array((string)$resource->get('template'), $tpls,true)) { return false; }

	date_default_timezone_set(@date_default_timezone_get()); // Prevent errors in E_STRICT

	// These are ModX's built in date fields. These are really easy to spot
	$modx_builtin_dates = array('pub_date', 'unpub_date', 'createdon', 'editedon', 'deletedon', 'publishedon');

	// If it's one of these, we now know our date / time value
	if (in_array($date_field, $modx_builtin_dates)) {
		$the_date = $resource->get($date_field);
	} else {
		$the_date = $resource->getTVValue($date_field); // If it's a TV
	}
	// Parse the date string
	$dt = strtotime($the_date);

	// If there is no date value found yet, give up
	if ($dt === false || $dt === -1) { // If date can't be parsed, it returns false (PHP5.1) or -1 (<PHP5.1)
		$modx->log(modX::LOG_LEVEL_ERROR, "Could not parse a valid date from the date field ($date_field)");
		return;
	}

	// What are the formats specified?
	$aliases['y'] = getFormattedDate($dt, 'y', $alias_year_format);
	$aliases['m'] = getFormattedDate($dt, 'm', $alias_month_format);
	$aliases['d'] = getFormattedDate($dt, 'd', $alias_day_format);
	$titles['y'] = getFormattedDate($dt, 'y', $title_year_format);
	$titles['m'] = getFormattedDate($dt, 'm', $title_month_format);
	$titles['d'] = getFormattedDate($dt, 'd', $title_day_format);

	$folders = explode('/', $folder_structure); // Explode the folder format
	$last_parent = intval($parent); // Where do we start looking for folders?

	foreach ($folders as $f) {	// Go through each of the folder structure items...
		$theFolderExists = false; //... and check if the required folder exists
		$this_folder_children = $modx->getCollection('modResource', array('parent'=>$last_parent)); // Get all the child resources
		foreach ($this_folder_children as $child) { // Go through the children, and see if any of them have the alias we want
			if ($child->get('alias') == $aliases[$f]) {
				$theFolderExists = true;
				$last_parent = $child->get('id');
				break;
			}
		}
		if (!$theFolderExists) { // If we haven't found the folder, create it
			switch ($f) { // Generate a new title
				case 'y':
					$new_title = $titles['y'];
				break;	
				case 'm':
					$new_title = $titles['m'] . '.' . $titles['y'];
				break;	
				case 'd':
					$new_title = $titles['d'] . '.' . $titles['m'] . '.' . $titles['y'];
				break;	
				default:
					$new_title = '';
				break;
			}
			$response = $modx->runProcessor("resource/create", array(
				'isfolder'=>1,
				'published'=>1,
				'template'=>$new_page_template,
				'pagetitle'=>$new_title,
				'alias'=>$aliases[$f],
				'menutitle'=>$titles[$f],
				'class_key'=>$ClassKey,
				'hidemenu'=>1,
				'parent'=>$last_parent,
				'content'=>$DefaultContent
			));
			if ($response->isError()) {
				$error=$modx->error->failure($response->getMessage());
				$modx->log(modX::LOG_LEVEL_ERROR, $error);
				return false;
			}else{
				$newResource = $response->getObject();
				$last_parent = $newResource['id'];
			}
		}
	}
	if($last_parent!=$resource->get('parent')){
		$resource->set('parent', $last_parent);
		$resource->save();
	}
}