<?php
/**
 * OffLog - worker  
 * 
 * The back end worker that takes the logging tasks from Gearman
 * and puts them in the correct memecache slice (ring buffer)
 * 
 * PHP version 5
 *
 * LICENSE: MIT License
 *
 * @category   Reporting
 * @package    Reporting
 * @link       http://www.metalcat.net/offlog/
 * @author     Jeremy Hutchings <email@jeremyhutchings.com> 
 * @license    http://en.wikipedia.org/wiki/MIT_License
 * 
 */

/**
 * Get the config data
 */
include 'config/sharedconfig.php';

/**
 * Connect to the memcache ring buffer
 * 
 * @var object Memcache
 */
$memcache = null;
if (!$memcache = new Memcache($offLogCfg['memcache']['ip'], $offLogCfg['memcache']['port']))
{
	die (date("F j, Y, g:i a") . " Coudn't connect to Memcache");
}
else
{
	echo date("F j, Y, g:i a") . " Connected to Memcache\n";
}

/**
 *  The gearman worker instance
 *  
 * @var unknown_type
 */
$worker= new GearmanWorker(); 


/**
 *  Add the default server, don't use config as worker is run locally
 *  to gearman server atm, so no config defaults to localhost
 */
if (!$worker->addServer() OR !$worker->echo("ping"))
{
	die (date("F j, Y, g:i a") ." Can't connect to gearman server\n");
}
else
{
	echo date("F j, Y, g:i a") . " Connected to Gearman Server\n";
}


/**
 * Add the logging functions 
 */
if (!$worker->addFunction("logSimple", "logSimple_cd"))
{
	die (date("F j, Y, g:i a") . "Couldn't add function :: logSimple");	
}
else
{
	echo date("F j, Y, g:i a") . " Function added :: logSimple\n";
}


/**
 * All set up, now start the worker
 */ 
while ($worker->work());


# ---------------------------------------------------------------------------
#		Logging functions
# ---------------------------------------------------------------------------


function logSimple_cd($job) 
{
	// Get the slice from the time, 0-5
	$slice = substr(date('i'), 0, 1);
	
	// Get the log details
	$bits = json_decode($job->workload());
	
// $get the 	
	// Make sure the action is in the register
	
	var_dump($bits);
	 
  	return  1; 
} 


function memcache_safeadd(&$memcache_obj, $key, $value, $flag, $expire)
{
    if (memcache_add($memcache_obj, $key, $value, $flag, $expire))
    {
        return ($value == memcache_get($memcache_obj, $key));
    }
    return FALSE;
} 
