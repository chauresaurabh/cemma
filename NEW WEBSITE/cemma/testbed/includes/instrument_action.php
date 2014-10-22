<script type="text/javascript">

function doAction(action,id){
	 
		switch(action){
		
			case 1: //Sorting
				document.myForm.orderby.value = id;
				if(document.myForm.o.value == 1)
					document.myForm.o.value = 0;
				else
					document.myForm.o.value = 1;
				
				document.myForm.action = "?action="+action;
				document.myForm.submit();
				break;
			
			case 2: //Edit a record
				document.myForm.action = "editInstrument.php?id="+id;
				document.myForm.submit();
				break;
				
			case 3: //Remove a record
				
				
				var confirmBox = confirm("Are you sure you want to continue?");
				if(confirmBox == true){
					document.myForm.action = "?id="+id+"&action="+action;
					document.myForm.submit();
				}
				
				break;

			case 4: //Pagination

				document.myForm.action ="?resultpage="+id;
				document.myForm.submit();
				break;
				
			default:
				break;
				
		}
		
}

</script>

