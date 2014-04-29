<?php
class Rados{
	
	protected $_cluster;
	
	public function __construct(){
		$this->_cluster = rados_create();
	}
	
	/**
	 * create IOctx Object
	 * @param string $poolName
	 * @return RadosIO
	 */
	public function createIO($poolName){
		return new RadosIO($this->_cluster, $poolName);
	}
	
	public function readConfig($fileName){
		rados_conf_read_file($this->_cluster, $fileName);
		
		return $this;
	}
	
	public function connect(){
		rados_connect($this->_cluster);
		
		return $this;
	}
	
	public function shutdown(){
		rados_shutdown($this->_cluster);
		
		return $this;
	}
	
	public function createPool($poolName){
		return rados_pool_create($this->_cluster, $poolName);
	}
	
	public function poolList(){
		return rados_pool_list($this->_cluster);
	}
}
