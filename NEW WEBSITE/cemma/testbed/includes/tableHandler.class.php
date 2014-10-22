<?php
include_once("database.php");
	if(!isset($_SESSION))
		session_start();

class TableHandler
{      
	 var $results;      
	 var $pageSize;      
	 var $page;      
	 var $row;
	 var $table;
	 var $id;
	 var $order;
	 var $orderby;
	 var $fields = array();
	  
	 function TableHandler() {
	       
	 }
	  
	 function getList($pageSize, $orderby = '',$order = '', $whereBy = '', $page = '' ){
	   
		#echo "Page Size:".$pageSize.'<br>'."OrderBy:".$orderby.'<br>'."Order:".$order.'<br>'."WhereBy:".$whereBy.'<br>'."Page:".$page."<br>"."===<br>";
  	   
	   global $resultpage, $temp_resultpage;
	   if(!isset($resultpage) && $page != ''){
	   		$resultpage = $page;
		}
		
		// Once everything is done use this code instead of the upper one
		
		//$resultpage = $page;
	   

	   $this->orderby = $orderby;
	   $this->order = $order;
	   //echo "order by: ".$orderby;
	   //echo 'Manager ID is '.$mid;

		if(is_numeric($this->orderby) || $this->orderby == ''){
			$query = "SELECT * from ".$this->table." ".$whereBy." ORDER BY ".$this->getOrderBy($this->orderby).' '.$this->getOrder($this->order);	
		}			
		else if(is_numeric($this->order) || $this->orderby == ''){
			$query = "SELECT * from ".$this->table." ".$whereBy." ORDER BY ".$this->orderby.' '.$this->getOrder($this->order);	
		}
		else{
			$query = "SELECT * from ".$this->table." ".$whereBy." ORDER BY ".$this->orderby.' '.$this->order;	
		}
	 	
 		if($this->table=="Remarks")
		{
			$query = "SELECT username,	instrument,	remarks, DATE_FORMAT(STR_TO_DATE(date, '%Y:%m:%d'), '%m/%d/%Y') as date, DATE_FORMAT(time,'%l:%i  %p') as time
			from Remarks ".$whereBy." ORDER BY ".$this->orderby.' '.$this->order;
 		}
 		//echo "Query: ";
		//echo $query;
	  
	   $this->results = mysql_query($query);
		
		if($page != ''){
			if($page != 'all')
				$this->pageSize = $pageSize;
			
		   	else
		   	{
			$this->pageSize = $this->getTotalRecords();
			//$temp_resultpage = 'all';
		   	}
	   }
		
		else{ // Temporary.. remove this after you're done
	
		   if($resultpage != 'all')
			$this->pageSize = $pageSize;
		   else
		   {
			$this->pageSize = $this->getTotalRecords();
			$temp_resultpage = 'all';
		   }
	   }
	   
	   if ((int)$resultpage <= 0) $resultpage = 1;
	   if ($resultpage > $this->getNumPages())      
		 $resultpage = $this->getNumPages();
		$this->setPageNum($resultpage);      
	   	 
	 }
	 
	 function getSingleRecord($id){
	 
	 $query = "SELECT * from ".$this->table." WHERE ".$this->id."=".$id;
	 $this->results = mysql_query($query);
	 }
	 
	 function fetchSingleRecord(){
	 if (!$this->results) return FALSE;
	 return mysql_fetch_array($this->results);
	 
	 }
	 
	 function fetchSingleObject(){
	 if (!$this->results) return FALSE;
	 return mysql_fetch_object($this->results);
	 
	 }
	 
	 function update( $id, $env ){
		
		$temp = array();
		foreach( $this->fields as $field )
		$temp[] = $field."='".addslashes($env[$field])."'";
		$query = "UPDATE ".$this->table." set ".join(",",$temp)."    where ".$this->id."='$id'";
		mysql_query($query) or die( "An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ());  
	}
	 
	 
	 // adding new function to insert records in the system - DAK 12/11/2009
	 function add( $env ){
		$temp = array();
		foreach( $this->fields as $field )
		{
			//$temp[] = $field."='".addslashes($env[$field])."'";
			$field_name[] = $field;
			$field_value[] = "'".addslashes($env[$field])."'";
		}
		$query = "INSERT INTO ".$this->table." (".implode(',', $field_name).") VALUES (".join(",",$field_value).") ";
		//echo ">>".$query;exit;
		mysql_query($query) or die( "An error has ocured in query1: " .mysql_error (). ":" .mysql_errno ());  
	}
	 
	 
	 function remove($id){
	 
	 	$query  = "DELETE from ".$this->table." where ".$this->id."='$id'";
		return mysql_query($query);
		
	 }
	
	 function getNumPages(){      
	   if (!$this->results) return FALSE;      
		 
	   return ceil(mysql_num_rows($this->results) /      
				   (float)$this->pageSize);      
	 }
 
 
	 function setPageNum($pageNum){      
	 
	   if ($pageNum > $this->getNumPages() or      
		   $pageNum <= 0) return FALSE;      
		 
	   $this->page = $pageNum;      
	   $this->row = 0;
	   
	   mysql_data_seek($this->results,($pageNum-1) * $this->pageSize);      
	 }
 
	 function getPageNum()      
	 {      
	   return $this->page;      
	 }
 
	 function isLastPage()      
	 {      
	   return ($this->page >= $this->getNumPages());      
	 }      
     
	 function isFirstPage()      
	 {      
	   return ($this->page <= 1);      
	 }
	 
	 function getStartRecord(){
	 
	 	return ($this->getPageNum()-1)*($this->pageSize) + 1;

	}
	
	function getLastRecord(){
	
		$lastRecord = ($this->getPageNum()-1)*($this->pageSize) + $this->pageSize;
		if($lastRecord > mysql_num_rows($this->results))
			$lastRecord = mysql_num_rows($this->results);
		return $lastRecord;

	}
	
	function getTotalRecords(){
	
		return mysql_num_rows($this->results);
		
 	}
 
	 function fetchArray()      
	 {      
	   if (!$this->results) return FALSE;      
	   if ($this->row >= $this->pageSize) return FALSE;      
	   $this->row++;      
	   return mysql_fetch_array($this->results);      
	 }
	 
	 function fetchObject()      
	 {      
	   if (!$this->results) return FALSE;
	   if ($this->row >= $this->pageSize) return FALSE;
	   $this->row++;      
	   return mysql_fetch_object($this->results);      
	 }
	 
	 function getPageNav($queryvars = ''){
	 	global $resultpage, $temp_resultpage;
		$nav = '';
		
		if (!$this->isFirstPage()){      
		
			 $nav .= '<a href = javascript:doAction(4,1)>First</a> | ';  
			 $nav .= '<a href = javascript:doAction(4,'.($this->getPageNum()-1).')>Prev</a> | ';      
		}

		else{

			 $nav .= 'First | ';  
			 $nav .= 'Prev | ';      

		}

		if (!$this->isLastPage()){      
			 $nav .= '<a href = javascript:doAction(4,'.($this->getPageNum()+1).')>Next</a> | ';
				 
	   		$nav .= '<a href = javascript:doAction(4,'.($this->getNumPages()).')>Last</a> | ';            
		}

		else{

			$nav .= 'Next | ';
			$nav .= 'Last | ';   

		}
			
	   	
		// Remove the last | 

		//$nav = substr($nav,0,-2);
		 if($temp_resultpage != 'all')
		 	$nav .= '<a href = javascript:doAction(4,"all")>View All</a>';    
		 else
		    $nav .= '<a href = javascript:doAction(4,1)>View Less</a>';    
		       
		
	   return $nav;      
	 }
	 
	function getOrder(){
	 
		if($this->order == 0)
			return "";
		else
			return "Desc";
	}	
	
	
	function getRecordsBar(){

	$bar = 	'Showing Records '.$this->getStartRecord().' to  '.$this->getLastRecord().' of '.$this->getTotalRecords();

	return $bar;


	}
	
	function retrieveAll(){
	   
  	   $query = "SELECT * from ".$this->table;
	  
	   $this->results = mysql_query($query);
	   
	   while ($row = mysql_fetch_object($this->results)) {
				$objectCollection[] = $row;
       }
	   
	   return $objectCollection;
	}
	
	function retrieve($id){
	   
  	   $query = "SELECT * from ".$this->table." where ".$this->id."=".$id;
	  	  
	   $this->result = mysql_query($query);
	   $objectCollection = NULL;
	   
	   while ($row = mysql_fetch_object($this->result)) {
				$objectCollection = $row;
       }
	   
	   return $objectCollection;
	}
		
}
   

 
?>

