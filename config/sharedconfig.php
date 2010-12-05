<?php
/**
 * OffLog - Off loading Logger 
 * 
 * Config file
 * 
 * PHP version 5
 *
 * LICENSE: MIT License
 *
 * @category   Reporting
 * @package    Reporting
 * @author     jeremy <jeremy@metalcat.net>
 * @license    http://en.wikipedia.org/wiki/MIT_License
 * @version    SVN: $Id$
 * @link       http://www.metalcat.net/offlog/
 * 
 */


/**
 * Central config array 
 * 
 * @var array
 */
$offLogCfg = array();


/**
 * Gearman servers - more for redundancy
 */
$i = 0;

// First server
$i++;
$offLogCfg['gearmanServers'][$i]['ip'] 	 = '127.0.0.1';
$offLogCfg['gearmanServers'][$i]['port'] = '4730'; // 4730 is default

#$i++;
#$offLogCfg['gearmanServers'][$i]['ip']   = '192.168.0.1';
#$offLogCfg['gearmanServers'][$i]['port'] = '4730'; // 4730 is default


/**
 * Memecache - for the ring buffer
 */

$offLogCfg['memcache']['ip']   = '127.0.0.1';
$offLogCfg['memcache']['port'] = '11211'; // 11211 is default


/**
 * MySQL details for final store reporting database 
 */

$offLogCfg['database']['host']	   = 'localhost';
$offLogCfg['database']['database'] = 'offlog';
$offLogCfg['database']['user']	   = 'offlog';
$offLogCfg['database']['pass']	   = 'offlog';
$offLogCfg['database']['prefix']   = 'ol_';



/**
 * Actions
 */

define("ACTION_USER_LOGON", 	1);
define("ACTION_USER_INVALID",	2);






