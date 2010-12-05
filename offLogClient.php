<?php
/**
 * OffLog - client  
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

class offLogClient
{
	/**
	 * Refrence to Gearman Client object
	 * 
	 * @var object 	GearmanClient
	 */
	private $gmClient = null;
	
	/**
	 * Reads in the sharedconfig.php $offLogCfg array for the server details
	 * 
	 * @param array $offLogCfg.
	 */
	function __construct($config = array()) 
	{
		$this->gmClient = new GearmanClient();
	
		foreach ($config['gearmanServers'] AS $serverId => $details)
		{
			$this->gmClient->addServer($details['ip'], $details['port']);
		}		
	}
	
	/**
	 * The main logging function, using doBackground uninterupted script flow
	 * 
	 * @param 	big int	$userId		User ID, big int used to accommodate 
	 * @param 	int		$actionId	action ID as per database setup
	 * @param 	text	$payLoad	Meta data string  
	 * 
	 * @return 	string	job id handel    
	 */
	public function logSimpleAction($userId, $actionId, $payLoad = NULL)
	{
		if ($payLoad)
		{
			return $this->gmClient->doBackground('logSimple', json_encode(array('userid' => $userId, 'actionId' => $actionId, 'payload' => $payLoad)));
		}
		else
		{
			return $this->gmClient->doBackground('logSimple', json_encode(array('userid' => $userId, 'actionId' => $actionId)));
		}
	}	

	
	/**
	 * Place holder for other logging action types
	 */
	public function logWatchedAction($userId, $actionId, $payLoad)
	{
		return $this->logSimpleAction($userId, $actionId, $payLoad);
	}


	/**
	 * Place holder for other logging action types
	 */
	
	public function logWatchedUser($userId, $actionId, $payLoad)
	{
		return $this->logSimpleAction($userId, $actionId, $payLoad);
	}
	
	
	/**
	 * Place holder for other logging action types
	 */
	
	public function logErrorReturn($userId, $errorId, $payLoad)
	{
	#	public string GearmanClient::doHigh ( string $function_name , string $workload [, string $unique ] )
	}
}// End class