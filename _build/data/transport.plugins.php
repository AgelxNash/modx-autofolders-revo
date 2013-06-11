<?php
$plugins = array();
$plugins[0] = $modx->newObject('modPlugin');
$plugins[0]->fromArray(array(
	'id' => 0,
	'name'=>'AF-ExamplePlugin',
	'category' => 0,
	'description' =>'Automatically put news in the correct folders',
	'plugincode' => getSnippetContent($sources['plugins'] . 'plugin.autofolders.php'),
	'disabled' => 1
));
$properties = include $sources['props'].'plugin.php';
$plugins[0]->setProperties($properties);

$events = array();
$events[0] = $modx->newObject('modPluginEvent');
$events[0]->fromArray(array(
	'event' => 'OnDocFormSave',
	'priority' => 0
),'',true,true);
$plugins[0]->addMany($events);
$modx->log(xPDO::LOG_LEVEL_INFO,'Packaged in '.count($events).' Plugin Events.'); flush();

unset($events,$properties);
return $plugins;