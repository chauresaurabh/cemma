<?php

include_once(DOCUMENT_ROOT."includes/database.php");
require_once(DOCUMENT_ROOT."includes/tableHandler.class.php");
//include_once(DOCUMENT_ROOT."includes/DatabaseOld.php");
class ViewComponentDAO extends TableHandler{

	function ViewComponentDAO(){
			
			$this->table = "ViewComponent";
			$this->id = "ViewComponentId";
			$this->fields = array
			(
				 'ViewComponentId',
				 'Description',
				 'Display_Pager_Count',
				 'Display_Nav_Bar',
				 'Column_Sort',
				 'Allow_Col_Resize',
				 'Display_Results_Dropdown',
				 'Display_Refresh',
				 'Display_Remove',	
				 'Display_Num_Rows',
				 'Max_Rows',
				 'Table_Height',
				 'Table_Width',
				 'Header_Row_Class',
				 'Header_Link_Class',  	
				 'Cellspacing',
				 'Cellpadding', 	
				 'Border',
				 'Align',
				 'ObjectCollection'

			);
			
	}


}
