<?php
class uri{
	function segs(){
		global $query_segments;
		return $query_segments;
	}

	function seg( $index ){
		return @$this->segs()[$index];
	}
}