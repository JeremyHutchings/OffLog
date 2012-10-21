<?php 
/**
 * OffLog - test script for system
 * 
 * 	   0. Ensure Memcache and Gearman are installed
 *     1. Include the client file
 *     2. Pass the config file to the offLogClient constructor
 *     3. Test connect to reporting database
 *     4. Test connect to memcached
 *     5. Make logging  
 * 
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

ini_set('max_execution_time' , 1);

/**
 * 0 - Ensure Memcache and Gearman are installed
 */

$memcache = null;

if (!$memcache = new Memcache)
{
	die("Couldn't start memcache client, is it isntalled correctly ?");
}

echo "<br />Memcache installed in PHP - Success...";

$gearman = null;

if (!$gearman  = new GearmanClient())
{
	die("Couldn't start gearman client, is it isntalled correctly ?");
}

echo "<br />Gearman installed in PHP - Success...";
unset($gearman);

/**
 * 1 & 2 - Include config file, create new client with config 
 */ 

include 'config/sharedconfig.php';
include 'offLogClient.php';

$loggingClient = new offLogClient($offLogCfg);

echo "<br />offLogClient - Success...";

/**
 * 3 - MySQL connection test
 */
$mysqli = new mysqli($offLogCfg['database']['host'], $offLogCfg['database']['user'], $offLogCfg['database']['pass'], $offLogCfg['database']['database']);

if (mysqli_connect_error()) 
{
    die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}

echo "<br />MySQL - Success... {$mysqli->host_info}";


/**
 * 4 - Memcache connection test
 */

$memcache->addServer($offLogCfg['memcache']['ip'], $offLogCfg['memcache']['port']);

if (!$memcache->getServerStatus($offLogCfg['memcache']['ip'], $offLogCfg['memcache']['port']))
{
	die ("Connection to memcache failed, is it isntalled and running ?");
}

echo "<br />Memcache connection - Success... ";


/**
 * 5 - Fire off logging action 1, userid 1, payload "test string"
 */


echo "<br />" . $loggingClient->logSimpleAction(1, ACTION_USER_LOGON, 'test string');
echo "<br />logSimpleAction";


echo "<br />Done - tests complete";




