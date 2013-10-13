<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends CI_Model
{
	private $table_name; //table name
	private $pk; ////primary key of the table
	//parameter lists
	private $p_id;
	private $category_id;
	private $name;
	private $description;
	private $dt;

	function __construct($param)
	{
		parent::__construct();
		$this->table_name = 'product';
		$this->pk = 'p_id';
		$param = $this->my_util->array_null_filter($param); //filtering the array and removing null entries
		if(array_key_exists($this->pk, $param) && $param[$this->pk]!='')
		{
			$sql="select * from $this->table_name where $this->pk = ".$param[$this->pk];
			$data = $this->my_db->mysql_fetch_sql($sql); //getting the data of the corresponding primary key
			if(count($data)>0)
			{
				 //set only if some data was found
				$this->set_parameters($data[0]);//initializing the parameters with the db values
			}
		} 
		//as this is new data,so setting the variables with the new values
		$this->set_parameters($param); //calling the set parameter function
 	} 

	function insert()
	{
		$param = array();
		$param['category_id'] = $this->category_id;
		$param['name'] = $this->name;
		$param['description'] = $this->description;
		$param['dt'] = date('Y-m-d H:i:s', time());
		$id = $this->my_db->db_insert($this->table_name,$param);	//inserting into db
		return $id;
 	} 

	function update()
	{
		$param = array();
		$param['category_id'] = $this->category_id;
		$param['name'] = $this->name;
		$param['description'] = $this->description;
		$param['dt'] = $this->dt;
		$val = $this->pk;
		$where_param = array( $this->pk => $this->$val);
		$ret = $this->my_db->update($this->table_name,$param,$where_param);	//updating into db files
		return $ret;
 	} 

	function set_parameters($param)
	{
		if($param['p_id'] != ''){ $this->p_id = $param['p_id']; }
		if($param['category_id'] != ''){ $this->category_id = $param['category_id']; }
		if($param['name'] != ''){ $this->name = $param['name']; }
		if($param['description'] != ''){ $this->description = $param['description']; }
		if($param['dt'] != ''){ $this->dt = $param['dt']; }
 	} 

	function fetch_data()
	{
		$param['p_id'] = $this->p_id;
		$param['category_id'] = $this->category_id;
		$param['name'] = $this->name;
		$param['description'] = $this->description;
		$param['dt'] = $this->dt;
		return $param;
 	} 
 }  //class ends 
?>