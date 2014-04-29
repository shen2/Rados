<?php
class RadosIO{

	protected $_ioctx;

	public function __construct($handle, $poolName){
		$this->_ioctx = rados_ioctx_create($handle, $poolName);
	}

	public function destroy(){
		rados_ioctx_destroy($this->_ioctx);
		
		return $this;
	}

	public function write($objectId, &$content){
		$result = rados_write_full($this->_ioctx, $objectId, $content);
		
		if ($result < 0)
			throw new Exception($result);
		
		return $this;
	}

	public function stat($objectId){
		return rados_stat($this->_ioctx, $objectId);
	}

	public function read($objectId){
		$stat = rados_stat($this->_ioctx, $objectId);
		
		$seg = 8000000;
		if ($stat['psize'] <= $seg)
			return rados_read($this->_ioctx, $objectId, $stat['psize']);
		
		$offset = 0;
		$result = '';
		do{
			$result .= rados_read($this->_ioctx, $objectId, $stat['psize'] - $offset > $seg ? $seg : $stat['psize'] - $offset, $offset);
			$offset += $seg;
		}
		while ($offset < $stat['psize']);
		
		return $result;
	}
	
	public function remove($objectId){
		return rados_remove($this->_ioctx, $objectId);
	}
	
	public function getXattr($objectId, $name){
		return rados_getxattr($this->_ioctx, $objectId, $name);
	}
	
	public function getXattrs($objectId){
		return rados_getxattr($this->_ioctx, $objectId);
	}
	
	public function setXattr($objectId, $name, $value){
		$result = rados_setxattr($this->_ioctx, $objectId, $name, $value);
		
		return $this;
	}
}
