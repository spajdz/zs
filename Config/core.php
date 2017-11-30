<?php
Configure::write('debug', 2);
Configure::write('sendMailError', false);
Configure::write('Error', array(
	'handler'		=> 'ErrorHandler::handleError',
	//'handler'		=> 'AppErrorHandler::handleError',
	'level'			=> E_ALL & ~E_DEPRECATED,
	'trace'			=> true
));
Configure::write('Exception', array(
	'handler'		=> 'ErrorHandler::handleException',
	//'handler'		=> 'AppErrorHandler::handleException',
	'renderer'		=> 'ExceptionRenderer',
	'log'			=> true
));
Configure::write('App.encoding', 'UTF-8');
Configure::write('Config.language', 'spa');
//Configure::write('App.baseUrl', env('SCRIPT_NAME'));
Configure::write('Routing.prefixes', array('admin'));
Configure::write('Cache.disable', false);
//Configure::write('Cache.check', true);
//Configure::write('Cache.viewPrefix', 'prefix');
Configure::write('Session', array(
	'defaults'			=> 'php',
	'cookie'			=> 'HOOKIPA',
	'timeout'			=> 180,
	'cookieTimeout'		=> 1440,
	'checkAgent'		=> false,
	'autoRegenerate'	=> true
));
Configure::write('Security.salt', 'd47359c93375b997e611985425f5d8718fe53f61');
Configure::write('Security.cipherSeed', '386363383834613033326566656536');
//Configure::write('Asset.timestamp', true);
//Configure::write('Asset.filter.css', 'css.php');
//Configure::write('Asset.filter.js', 'custom_javascript_output_filter.php');
Configure::write('Acl.classname', 'DbAcl');
Configure::write('Acl.database', 'default');
date_default_timezone_set('America/Santiago');

/**
 * Motor de cache
 */
$engine		= 'File';

/**
 * Duracion del cache en desarrollo
 */
$duration	= '+999 days';
if ( Configure::read('debug') > 0 )
	$duration		= '+10 seconds';

/**
 * Cambiar a prefijo unico por proyecto
 */
$prefix		= 'hkp_';

/**
 * Configuracion general del cache
 */
Cache::config('_cake_core_', array(
	'engine'		=> $engine,
	'prefix'		=> $prefix . 'cake_core_',
	'path'			=> CACHE . 'persistent' . DS,
	'serialize'		=> ($engine === 'File'),
	'duration'		=> $duration
));
Cache::config('_cake_model_', array(
	'engine'		=> $engine,
	'prefix'		=> $prefix . 'cake_model_',
	'path'			=> CACHE . 'models' . DS,
	'serialize'		=> ($engine === 'File'),
	'duration'		=> $duration
));
Cache::config('query', array(
	'engine'		=> 'File',
	'path'			=> CACHE . 'queries' . DS,
	'duration'		=> '+2 hours',
	'probability'	=> 100
));
