<?php 
/**
 * @package Database Connection
 * @author Edward Rana
 * @version 1.0.8
 * @since 1.0.0
 */

// Create connection
@$mysqli = new mysqli( DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE );

// Check connection

if ($mysqli->connect_error) {
    //die("Connection failed: "); // . $mysqli->connect_error);
    $GLOBALS['db_connection_failed'] = true;
    $GLOBALS['db_connection_error'] = $mysqli->connect_error;

    echo $mysqli->connect_error;
}

else{
	//echo 'Connected!';
}

class DB{

	public $query = '';
	public $query_str = '';

	public $inner_join = '';

	public $str_where = '';

	public $str_select = '*';

	public $start_group = '';
	public $end_group = '';

	public $limit = '';
	public $offset = '';
	public $order_by = '';



	function __construct(){

		global $mysqli;

		$this->db = $mysqli;

	}

	public function sql( $query ){
		$this->query = $query;
		return mysqli_query($this->db, $query);
	}

	public function query_str( $query_str ){
		$this->query_str = $query_str;
		return $this;
	}

	public function inner_join( $query ){
		$this->inner_join = $query;
		return $this;
	}

	public function select( $fields ){

		$this->str_select = $fields;

		return $this;

	}

	public function get( $tbl ){

		$this->query = "SELECT ".$this->str_select." FROM $tbl";

		$this->str_select = '*';

		if( $this->inner_join ){
			$this->query .= " ".$this->inner_join;
			$this->inner_join = '';
		}

		if( $this->str_where )

		{

			$this->query .= " WHERE ".$this->str_where;

			$this->str_where = '';

		}

		if( $this->order_by )

		{

			$this->query .= " ORDER BY ".$this->order_by;

			$this->order_by = '';

		}

		if( $this->limit )

		{

			$this->query .= " LIMIT ".$this->limit;

			$this->limit = '';

		}

		if( $this->offset )

		{

			$this->query .= " OFFSET ".$this->offset;

			$this->offset = '';

		}

		if( $this->query_str ){
			$this->query .= " ".$this->query_str;
			$this->query_str = '';
		}


		//echo $this->query;

		$result = mysqli_query($this->db, $this->query);



		$data = array();

		if( @mysqli_num_rows($result) > 0 ){

		    // output data of each row

		    while($row = mysqli_fetch_object($result)) {

		        $data[] = $row;

		    }

		} 

       return $data;

	}



	public function insert( $tbl, $data ){

		$str = '';

		foreach( $data as $key => $val ){

			$str .= ", $key = '".mysqli_real_escape_string( $this->db, $val )."'";

		}

		if( !$str )

			return false;

		else

			$str = substr($str, 2);



		$this->query = "INSERT INTO $tbl SET $str";

		if( $this->query_str ){
			$this->query .= " ".$this->query_str;
			$this->query_str = '';
		}

       if( mysqli_query($this->db, $this->query) )

       		return $this->db->insert_id;

       else

       		return false;

	}



	public function last_id(){

		return $this->db->last_id;

	}



	public function update( $tbl, $data ){



		$str = '';

		foreach( $data as $key => $val ){

			$str .= ", $key = '".mysqli_real_escape_string( $this->db, $val )."'";

		}

		if( !$str )

			return false;

		else

			$str = substr($str, 2);



		$this->query = "UPDATE $tbl SET $str";

		if( $this->str_where )

		{

			$this->query .= " WHERE ".$this->str_where;

			$this->str_where = '';

		}

		if( $this->query_str ){
			$this->query .= " ".$this->query_str;
			$this->query_str = '';
		}

       if( mysqli_query($this->db, $this->query) )

       		return true;

       else

       		return false;

	}



	public function delete( $tbl ){

		$this->query = "DELETE FROM $tbl";

		if( $this->str_where )

		{

			$this->query .= " WHERE ".$this->str_where;

			$this->str_where = '';

		}

		if( $this->query_str ){
			$this->query .= " ".$this->query_str;
			$this->query_str = '';
		}

		//echo $this->query; 

		if( mysqli_query($this->db, $this->query) )
			return true;

       else

       		return false;
	}

	public function create_table( $tbl_name, $coloumns ){

		if( !$this->is_table_exists( $tbl_name ) && is_array($coloumns)){

			$coloumns = implode(','.PHP_EOL, $coloumns);
			$sql = "CREATE TABLE $tbl_name (
					$coloumns
				)";

			//echo $sql;

			if( mysqli_query($this->db, $sql) )
				return true;
	       else
	       		return false;
       }
       else{
       		return false;
       }
	}

	public function delete_table( $tbl_name ){
		if( $this->is_table_exists( $tbl_name ) ){
		   $sql = "DROP TABLE $tbl_name";
		   if(mysqli_query($this->db, $sql)){ 
		     return true;
		   }
		   else{
		     return false;
		   }
		}
		else{
			return false;
		}
	}

	public function is_table_exists( $tbl_name ){
		return mysqli_num_rows( mysqli_query($this->db, "SHOW TABLES LIKE '$tbl_name'"));
	}

	public function where( $col, $op, $val = '', $closer = '' ){

		if( !$col ) return $this;
		
		if( !$val ){
			$val = $op;
			$op = '=';	
		}

		$str = $col." ".$op." '".mysqli_real_escape_string($this->db, $val)."'".$closer;

		if( $this->start_group ){
			$str = $this->start_group.$str;
			$this->start_group = '';
		}
		if( $this->end_group ){
			$str = $str.$this->end_group;
			$this->end_group = '';
		}

		if( $this->str_where )
			$str = $this->str_where." AND ".$str;

		$this->str_where = $str;

		return $this;

	}



	public function or_where( $col, $op, $val = '', $closer = '' ){

		if( !$val ){
			$val = $op;
			$op = '=';	
		}

		$str = $col." ".$op." '".mysqli_real_escape_string($this->db, $val)."'".$closer;

		if( $this->start_group ){
			$str = $this->start_group.$str;
			$this->start_group = '';
		}
		if( $this->end_group ){
			$str = $str.$this->end_group;
			$this->end_group = '';
		}

		if( $this->str_where )
			$str = $this->str_where." OR ". $str;

		$this->str_where = $str;

		return $this;

	}

	public function start_group( $str = "(" ){
		$this->start_group = $str;
		return $this;
	}

	public function end_group( $str = ")" ){
		$this->end_group = $str;
		return $this;
	}

	public function limit( $str ){
		$this->limit = $str;
		return $this;
	}

	public function offset( $str ){
		$this->offset = $str;
		return $this;
	}

	public function order_by( $col, $order ){
		$this->order_by = $col." ".$order;
		return $this;
	}

}

$db = new DB;