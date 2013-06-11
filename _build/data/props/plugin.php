<?php
$properties = array(
    array(
        'name' => 'alias_day_format',
        'desc' => 'autofolders.alias_day_format',
        'type' => 'list',
        'options' => array(
			array(
				"value" => "1",
				"text" => "Number (no leading 0)",
				"name" => "Number (no leading 0)"
			),
			array(
				"value" => "2",
				"text" => "Number (leading 0)",
				"name" => "Number (leading 0)"
			),
		),
        'value' => '1',
        'lexicon' => 'autofolders:properties',
    ),
	array(
        'name' => 'alias_month_format',
        'desc' => 'autofolders.alias_month_format',
        'type' => 'list',
        'options' => array(
			array(
				"value" => "1",
				"text" => "Number (no leading 0)",
				"name" => "Number (no leading 0)"
			),
			array(
				"value" => "2",
				"text" => "Number (leading 0)",
				"name" => "Number (leading 0)"
			),
			array(
				"value" => "3",
				"text" => "Text (full name)",
				"name" => "Text (full name)"
			),
			array(
				"value" => "4",
				"text" => "Text (short name)",
				"name" => "Text (short name)"
			)
		),
        'value' => '1',
        'lexicon' => 'autofolders:properties',
    ),
    array(
        'name' => 'alias_year_format',
        'desc' => 'autofolders.alias_year_format',
        'type' => 'list',
        'options' => array(
			array(
				"value" => "4",
				"text" => "4 digit",
				"name" => "4 digit"
			),
			array(
				"value" => "2",
				"text" => "2 digit",
				"name" => "2 digit"
			)
		),
        'value' => '4',
        'lexicon' => 'autofolders:properties',
    ),
    array(
        'name' => 'date_field',
        'desc' => 'autofolders.date_field',
        'type' => 'textfield',
        'options' => '',
        'value' => 'publishedon',
        'lexicon' => 'autofolders:properties',
    ),
    array(
        'name' => 'folder_structure',
        'desc' => 'autofolders.folder_structure',
        'type' => 'list',
        'options' => array(
			array(
				"value" => "y",
				"text" => "y",
				"name" => "y"
			),
			array(
				"value" => "y/m",
				"text" => "y/m",
				"name" => "y/m"
			),
			array(
				"value"  => "y/m/d",
				"text" => "y/m/d",
				"name" => "y/m/d"
			)
		),
        'value' => 'y/m',
        'lexicon' => 'autofolders:properties',
    ),
	array(
        'name' => 'new_page_template',
        'desc' => 'autofolders.new_page_template',
        'type' => 'numberfield',
        'options' => '',
        'value' => '0',
        'lexicon' => 'autofolders:properties',
    ),
	array(
        'name' => 'parent',
        'desc' => 'autofolders.parent',
        'type' => 'numberfield',
        'options' => '',
        'value' => '0',
        'lexicon' => 'autofolders:properties',
    ),
	array(
        'name' => 'template',
        'desc' => 'autofolders.template',
        'type' => 'textfield',
        'options' => '',
        'value' => '0',
        'lexicon' => 'autofolders:properties',
    ),
	array(
        'name' => 'title_day_format',
        'desc' => 'autofolders.title_day_format',
        'type' => 'list',
        'options' => array(
			array(
				"value"=> "1",
				"text" => "Number (no leading 0)",
				"name" => "Number (no leading 0)"
			),
			array(
				"value" => "2",
				"text" => "Number (leading 0)",
				"name" => "Number (leading 0)"
			)
		),
        'value' => '1',
        'lexicon' => 'autofolders:properties',
    ),
	array(
        'name' => 'title_month_format',
        'desc' => 'autofolders.title_month_format',
        'type' => 'list',
        'options' => array(
			array(
				"value" => "1",
				"text" => "Number (no leading 0)",
				"name" => "Number (no leading 0)"
			),
			array(
				"value" => "2",
				"text" => "Number (leading 0)",
				"name" => "Number (leading 0)"
			),
			array(
				"value" => "3",
				"text" => "Text (Full name)",
				"name" => "Text (Full name)"
			),
			array(
				"value" => "4",
				"text" => "Text (Short name)",
				"name" => "Text (Short name)"
			)
		),
        'value' => '2',
        'lexicon' => 'autofolders:properties',
    ),
	array(
        'name' => 'title_year_format',
        'desc' => 'autofolders.title_year_format',
        'type' => 'list',
        'options' => array(
			array(
				"value" => "4",
				"text" => "4 digit",
				"name" => "4 digit"
			),array(
				"value" => "2",
				"text" => "2 digit",
				"name" => "2 digit"
			)
		),
        'value' => '4',
        'lexicon' => 'autofolders:properties',
    ),
	array(
        'name' => 'classKey',
        'desc' => 'autofolders.classKey',
        'type' => 'textfield',
        'options' => '',
        'value' => 'modDocument',
        'lexicon' => 'autofolders:properties',
    ),
	array(
        'name' => 'DefaultContent',
        'desc' => 'autofolders.DefaultContent',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'autofolders:properties',
    ),
);
return $properties;