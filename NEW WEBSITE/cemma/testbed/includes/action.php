<script type="text/javascript">

function doAction(action,id,formName){
	 
		if(typeof(formName) == 'undefined')
			formName = 'myForm';

		switch(action){
		
			case 1: //Sorting
				document.forms[formName].orderby.value = id;
				if(document.forms[formName].o.value == 1)
					document.forms[formName].o.value = 0;
				else
					document.forms[formName].o.value = 1;
				
				document.forms[formName].action = "?action="+action;

				document.forms[formName].submit();
				break;
			
			case 2: //Edit a record
				//alert("edit");
				document.forms[formName].action = "editCustomer.php?id="+id;
				document.forms[formName].submit();
				break;
				
			case 3: //Remove a record
				
				//alert("pop");
				var confirmBox = confirm("Are you sure you want to Remove the Customer?");
				if(confirmBox == true){
					document.forms[formName].action = "?id="+id+"&action="+action;
					document.forms[formName].submit();
				}
				
				break;

			case 4: //Pagination
				document.forms[formName].action ="?resultpage="+id;
				document.forms[formName].submit();
				break;
				
			case 5:
				document.getElementById("orderby").value = id;
				if(document.getElementById("o").value == 1)
					document.getElementById("o").value = 0;
				else
					document.getElementById("o").value = 1;
				
				document.forms[formName].action = "?action="+action;

				document.forms[formName].submit();
				break;
				
			default:
				break;
				
		}
		
}

</script>