<?php
class RadosIO{

	protected $_ioctx;

	public function __construct($handle, $poolName){
		$this->_ioctx = rados_ioctx_create($handle, $poolName);
	}
	
	public function destroy(){
		return rados_ioctx_destroy($this->_ioctx);
	}
	
	public function poolSetAuid($auid){
		return rados_ioctx_pool_set_auid($this->_ioctx, $auid);
	}
	
	public function poolGetAuid(){
		return rados_ioctx_pool_get_auid($this->_ioctx);
	}
	
	public function write($oid, $buffer, $offset){
	    return rados_write($this->_ioctx, $oid, $buffer, $offset);
	}
	
	public function writeFull($oid, $buffer){
	    return rados_write_full($this->_ioctx, $oid, $buffer);
	}
	
	/*
	public function read($oid, $size, $offset){
		return rados_read($this->_ioctx, $oid, $size, $offset);
	}
	*/
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
	
	public function remove($oid){
	    return rados_remove($this->_ioctx, $oid);
	}
	
	public function trunc($oid, $size){
		return rados_trunc($this->_ioctx, $oid, $size);
	}
	
	public function append($oid, $buffer){
	    return rados_append($this->_ioctx, $oid, $buffer);
	}
	
	public function cloneRange($dst_oidoid, $dst_offset, $src_offsetobj, $src_offset, $size){
	    return rados_clone_range($this->_ioctx, $dst_oidoid, $dst_offset, $src_offsetobj, $src_offset, $size);
	}
	
	public function getxattr($oid, $name, $size){
	    return rados_getxattr($this->_ioctx, $oid, $name, $size);
	}
	
	public function setxattr($oid, $name, $value){
	    return rados_setxattr($this->_ioctx, $oid, $name, $value);
	}
	
	public function rmxattr($oid, $name){
	    return rados_rmxattr($this->_ioctx, $oid, $name);
	}
	
	public function stat($oid){
	    return rados_stat($this->_ioctx, $oid);
	}
	
	public function getLastVersion(){
	    return getLastVersion($this->_ioctx);
	}
	
	public function getXattrs($oid){
		return rados_getxattr($this->_ioctx, $oid);
	}
		
	public function objectsList(){
		return rados_objects_list($this->_ioctx);
	}
	
	public function snapCreate($snapname){
	    return rados_ioctx_snap_create($this->_ioctx, $snapname);
	}
	
	public function snapRemove($snapname){
	    return rados_ioctx_snap_remove($this->_ioctx, $snapname);
	}
	
	public function rollback($oid, $snapname){
	    return rados_rollback($this->_ioctx, $oid, $snapname);
	}
	
	public function snapList($maxsnaps){
		return rados_ioctx_snap_list($this->_ioctx, $maxsnaps);
	}
	
	public function snapLookup($snapid){
		return rados_ioctx_snap_lookup($this->_ioctx, $snapid);
	}
	
	public function snapGetName($snapid){
	    return rados_ioctx_snap_get_name($this->_ioctx, $snapid);
	}
	
	public function snapGetStamp($snapid){
	    return rados_ioctx_snap_get_stamp($this->_ioctx, $snapid);
	}
}
