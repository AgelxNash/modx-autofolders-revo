<?php
$mtime = microtime();
$mtime = explode(" ", $mtime);
$mtime = $mtime[1] + $mtime[0];
$tstart = $mtime;
set_time_limit(0);

define('PKG_NAME','AutoFolders');
define('PKG_NAME_LOWER','autofolders');
define('PKG_VERSION','0.2.0');
define('PKG_RELEASE','pl');


$root = dirname(__FILE__).'/';
$sources= array (
    'root' => $root,
    'build' => $root ,
    'data' => $root . 'data/',
    'props' => $root . 'data/props/',
    'source_core' => dirname($root).'/core/components/'.PKG_NAME_LOWER,
    'plugins' => dirname($root).'/core/components/'.PKG_NAME_LOWER.'/elements/plugins/',
    'docs' => dirname($root).'/core/components/'.PKG_NAME_LOWER.'/docs/',
	'lexicon' => dirname($root) . '/core/components/'.PKG_NAME_LOWER.'/lexicon/',
);
unset($root);

require_once $sources['build'] . 'includes/functions.php';
require_once $sources['build'] . 'build.config.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';

$modx= new modX();
$modx->initialize('mgr');
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget('ECHO'); echo '<pre>'; flush();

$modx->loadClass('transport.modPackageBuilder','',false, true);
$builder = new modPackageBuilder($modx);
$builder->createPackage(PKG_NAME_LOWER,PKG_VERSION,PKG_RELEASE);
$builder->registerNamespace(PKG_NAME_LOWER,false,true,'{core_path}components/'.PKG_NAME_LOWER.'/');

$modx->getService('lexicon','modLexicon');
$modx->lexicon->load('autofolders:properties');

$category= $modx->newObject('modCategory');
$category->set('id',1);
$category->set('category',PKG_NAME);

$plugins = include $sources['data'].'transport.plugins.php';
if (!is_array($plugins)) {
	$modx->log(modX::LOG_LEVEL_ERROR,'Could not package in plugins.');
} else {
	$category->addMany($plugins);
	$modx->log(modX::LOG_LEVEL_INFO,'Packaged in '.count($plugins).' plugins.');
}

$attr = array(
    xPDOTransport::UNIQUE_KEY => 'category',
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::RELATED_OBJECTS => true,
    xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
        'Plugins' => array(
			xPDOTransport::UNIQUE_KEY => 'name',
			xPDOTransport::PRESERVE_KEYS => false,
			xPDOTransport::UPDATE_OBJECT => true,
			xPDOTransport::RELATED_OBJECTS => true,
			xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array(
				'PluginEvents' => array(
					xPDOTransport::PRESERVE_KEYS => true,
					xPDOTransport::UPDATE_OBJECT => false,
					xPDOTransport::UNIQUE_KEY => array('pluginid', 'event'),
				)
			)
		)
    )
);

$vehicle = $builder->createVehicle($category, $attr);
unset($attr);
$modx->log(modX::LOG_LEVEL_INFO, 'Adding file resolvers ...');
$vehicle->resolve('file',array(
    'source' => $sources['source_core'],
    'target' => "return MODX_CORE_PATH . 'components/';",
));

$modx->log(modX::LOG_LEVEL_INFO, 'Packaged in folders.'); flush();
$builder->putVehicle($vehicle);

/* now pack in the license file, readme and setup options */
$builder->setPackageAttributes(array(
    'license' => file_get_contents($sources['docs'] . 'license.txt'),
    'readme' => file_get_contents($sources['docs'] . 'readme.txt'),
    'changelog' => file_get_contents($sources['docs'] . 'changelog.txt')
));
$modx->log(modX::LOG_LEVEL_INFO,'Packaged in package attributes.'); flush();

$modx->log(modX::LOG_LEVEL_INFO,'Packing...'); flush();
$builder->pack();

$mtime= microtime();
$mtime= explode(" ", $mtime);
$mtime= $mtime[1] + $mtime[0];
$tend= $mtime;
$totalTime= ($tend - $tstart);
$totalTime= sprintf("%2.4f s", $totalTime);

$modx->log(modX::LOG_LEVEL_INFO,"\n<br />Package Built.<br />\nExecution time: {$totalTime}\n");

exit ();