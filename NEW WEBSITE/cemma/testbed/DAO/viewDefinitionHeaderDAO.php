<?php 

include_once(DOCUMENT_ROOT."includes/database.php");
require_once(DOCUMENT_ROOT."includes/tableHandler.class.php");

class ViewDefinitionHeaderDAO extends TableHandler{

	function ViewDefinitionHeaderDAO(){
			
			$this->table = "VDEF_HEADERS";
			$this->id = "ViewDefinitionHeaderId";
			$this->fields = array
			(
				'ViewDefinitionHeaderId',
				'ViewComponentId',
				'Column_Id',
				'Column_Order',
				'Header_Text',
				'Width',
				'Style',
				'Align',
				'Header_Class',
				'Sort_Column_Name',
				'Date_Pattern',
				'Time_Pattern',
				'Is_Link',
				'Is_Active',
				'Is_Sortable',
				'Is_Searchable',
				'Ignore_Case_For_Sort',
				'Column_Data_Type'   	  
			);
			
	}
	
	function getHeadersforComponent($viewComponentId){
	
	$where = " WHERE ViewComponentId = '$viewComponentId' AND Is_Active = 1";
	$this->getList('', $Column_Order, '', $where, 'all');
	while ($row = $this->fetchObject()) {
				$objectCollection[] = $row;
    }
	
	return $objectCollection;
	
	}
	
	function getOrderBy($id){
	 
		switch($id){
	
			case 1:
			return "ViewDefinitionHeaderId";
			break;
		
			case 2:
			return "ViewComponentId";
			break;
			
			case 3: 
			return "Column_Id";
			break;
			
			case 4:
			return "Column_Order";
			break;
			
			case 5:
			return "Header_Text";
			break;
			
			case 6:
			return "Width";
			break;
			
			case 7:
			return "Style";
			break;
			
			case 8:
			return "Align";
			break;
			
			case 9:
			return "Sort_Column_Name";
			break;
			
			case 10:
			return "Date_Pattern";
			break;
			
			case 11:
			return "Time_Pattern";
			break;
			
			case 12:
			return "Is_Link";
			break;
			
			case 12:
			return "Is_Active";
			break;
			
			case 12:
			return "Column_Data_Type";
			break;
			
			default:
			return "ViewDefinitionHeaderId";
			break;
			
			
		}
	}


}
