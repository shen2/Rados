<?php
namespace Rados;

class Cluster{
	
	protected $_cluster;
	
	public function __construct(){
		$this->_cluster = rados_create();
	}
	
	/**
	 * create IOctx Object
	 * @param string $poolName
	 * @return IO
	 */
	public function createIO($poolName){
		return new IO($this->_cluster, $poolName);
	}
	
	/**
	 * 
	 * @param string $fileName
	 * @return self
	 */
	public function readConfig($fileName){
		rados_conf_read_file($this->_cluster, $fileName);
		
		return $this;
	}
	
	/**
	 * 
	 * @return self
	 */
	public function connect(){
		rados_connect($this->_cluster);
		
		return $this;
	}
	
	/**
	 * 
	 * @return self
	 */
	public function shutdown(){
		rados_shutdown($this->_cluster);
		
		return $this;
	}
	
	/**
	 * 
	 * @param string $poolName
	 */
	public function createPool($poolName){
		return rados_pool_create($this->_cluster, $poolName);
	}
	
	public function poolList(){
		return rados_pool_list($this->_cluster);
	}
}
