<?
include_once(DOCUMENT_ROOT."includes/database.php");
require_once(DOCUMENT_ROOT."includes/tableHandler.class.php");

class InstrumentLogDAO extends TableHandler{

	function InstrumentLogDAO(){
			
		$this->table = "Remarks";
		$this->id = "id";
		$this->fields = array
		(
			'username',
			'instrument',
			'remarks',
			'date',
			'DATE_FORMAT(time,\'%l:%i  %p\') as time'
		);
	}
	
	function searchLogs($pagenum, $pageSize = 20, $fromDate, $toDate, $instruments, $orderby='' , $ascordesc ){
		$where = "";
		if($fromDate!='00:00:0000' && $toDate != '00:00:0000'){
			$where = " WHERE STR_TO_DATE(date, '%Y:%m:%d') between STR_TO_DATE('$fromDate', '%Y:%m:%d') and STR_TO_DATE('$toDate', '%Y:%m:%d')";
		}
		if($instruments[0] != '-1') {
			if(strcmp($where,"")==0) {
				$where.=" WHERE instrument IN (";
			} else {
				$where .= " AND instrument IN (";
			}
			if(count($instruments)>1) {
				for($i=0;$i<count($instruments)-1;$i++) {
					$where.="'".$instruments[$i]."',";
				}
				$where.="'".$instruments[count($instruments)-1]."'";
			} else {
				$where.="'".$instruments[0]."'";
			}
			$where.=")";
			
 		}
		//echo $pagenum." ".$fromDate." ".$toDate." ".$instrument." ".$where;
		//$this->getList($pageSize, 'Date','DESC, Time DESC', $where, $pagenum);
		$ordertype = "ASC";
		if($ascordesc % 2 == 0)
			$ordertype = "DESC";
			
		if( $orderby == '' )
			$this->getList($pageSize, 'Time', $ordertype , $where, $pagenum);
		else
			$this->getList($pageSize,  $orderby , $ordertype , $where, $pagenum);
	}
	
 
}
?>