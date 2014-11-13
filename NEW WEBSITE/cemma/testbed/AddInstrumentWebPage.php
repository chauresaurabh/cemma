<?
include_once('constants.php');
include_once(DOCUMENT_ROOT."includes/checklogin.php");
include_once(DOCUMENT_ROOT."includes/checkadmin.php");
 
include (DOCUMENT_ROOT.'tpl/header.php');
  
 ?>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">

		<style>
			.form-horizontal {
			max-width: 910px;
			padding: 15px 15px 15px;
			margin: 0 auto 5px;
 			border: 1px solid #e5e5e5;
			-webkit-border-radius: 10px;
			-moz-border-radius: 10px;
			border-radius: 10px;
			-webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
			-moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
 		  }
		  
		 fieldset.scheduler-border {
    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
}

legend.scheduler-border {
    font-size: 24px !important;
    font-weight: bold !important;
    text-align: left !important;
	 width:inherit; /* Or auto */
    padding:0 10px; /* To give a bit of padding on the left and right */
    border-bottom:none;
 }
  
	 </style>

   <? include ('newheader.php'); ?>
                             	
     <div class="container">
      
      <br /><br />
      <form class="form-horizontal" role="form" method="post" id="instrform" name="instrform" action="AddInstrumentWebPage.php?submit=1" enctype="multipart/form-data">
          <h2 >Add New Instrument</h3>
            <hr />
           
                <br /> 
              <div class="form-group">
                
                   <label class="control-label col-sm-2">Instrument Name </label>
                              <div class="col-md-4">
                               <input class="form-control" type="text" placeholder="Instrument Name" name="instrumentname" id="instrumentname" style="width:300px">
                              </div>
              </div>
              
              <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Description</label>
                <div class="col-sm-10">
                   <textarea class="form-control" rows="3" style="resize:none" name="description" id="description"></textarea>
                </div>
              </div>
              
              <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label" >Instrument Image</label>
                <div class="col-md-4">
                  		<input type="file" id="uploadfile" name="uploadfile"  />
                </div>
              </div>
            
              
                <hr />
               
                	<fieldset class="scheduler-border">
                        <legend class="scheduler-border">Contact Details</legend>
                         
                         <h4 align="center">Primary Contact</h4>
                      <form class="form-horizontal">
                           
                          <div class="form-group">
                              <label class="control-label col-sm-2"  >First Name</label>
                              <div class="col-md-4">
                               <input class="form-control" type="text" id="primaryfirstname" name="primaryfirstname">
                              </div>
                              <label class="control-label col-sm-2" >Last Name</label>
                              <div class="col-md-4">
                               <input class="form-control" type="text"  id="primarylastname" name="primarylastname">
                              </div>
                              <br /><br />
                              
                              <label class="control-label col-sm-2">Email</label>
                              <div class="col-md-4">
                               <input class="form-control" type="text" id="primaryemail" name="primaryemail">
                              </div>
                              <label class="control-label col-sm-2">Phone Number</label>
                              <div class="col-md-4">
                               <input class="form-control" type="text" id="primaryphonenumber" name="primaryphonenumber">
                              </div>
                              
                          </div>
                     <hr />
               
                         <h4 align="center">Secondary Contact 1</h4>

                          <div class="form-group">
                              <label class="control-label col-sm-2">First Name</label>
                              <div class="col-md-4">
                               <input class="form-control" type="text" id="secondaryfirstname1" name="secondaryfirstname1">
                              </div>
                              <label class="control-label col-sm-2">Last Name</label>
                              <div class="col-md-4">
                               <input class="form-control" type="text"  id="secondarylastname1" name="secondarylastname1">
                              </div>
                              <br /><br />
                              <label class="control-label col-sm-2">Email</label>
                              <div class="col-md-4">
                               <input class="form-control" type="text" id="secondaryemail1" name="secondaryemail1" >
                              </div>
                              <label class="control-label col-sm-2">Phone Number</label>
                              <div class="col-md-4">
                              <input class="form-control" type="text" id="secondaryphonenumber1" name="secondaryphonenumber1" >
                              </div>
                              
                          </div>

 					 <hr />
               
                         <h4 align="center">Secondary Contact 2</h4>

                          <div class="form-group">
                              <label class="control-label col-sm-2">First Name</label>
                              <div class="col-md-4">
                               <input class="form-control" type="text"  id="secondaryfirstname2" name="secondaryfirstname2">
                              </div>
                              <label class="control-label col-sm-2">Last Name</label>
                              <div class="col-md-4">
                               <input class="form-control" type="text" id="secondarylastname2" name="secondarylastname2">
                              </div>
                              <br /><br />
                              <label class="control-label col-sm-2">Email</label>
                              <div class="col-md-4">
                               <input class="form-control" type="text" id="secondaryemail2" name="secondaryemail2" >
                              </div>
                              <label class="control-label col-sm-2">Phone Number</label>
                              <div class="col-md-4">
                               <input class="form-control" type="text" id="secondaryphonenumber2" name="secondaryphonenumber2">
                              </div>
                              
                          </div>
					 </form>
                             
                 </fieldset>
                 
            			 <div class="col-sm-offset-2 col-sm-10">
                           <button class="btn btn-primary" type="submit" id="addinstrument" >Add Instrument</button>
                        </div>
                        <div class="col-sm-offset-2 col-sm-10">
                           <button class="btn btn-primary" type="submit" id="addinstrument" >Update</button>
                        </div>
                        
 		</form>
      				  
    </div>
    
    <div class="modal fade" id="successMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"> Center for Electron Microscopy and Microanalysis </h4>
      </div>
      <div class="modal-body" id="modal-body">
         	New Instrument Added Successfully!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
       </div>
    </div>
  </div>
</div>
 
     <br /><br /><br />
 <? include ('tpl/footer.php'); ?>

  
<script type="text/javascript">
  
 	 function uploadfile() {
 					 
					var file_data = $('#uploadfile').prop('files')[0];   
					var form_data = new FormData();                  
					form_data.append('file', file_data)
 					form_data.append('instrumentname', $('#instrumentname').val() );	
					form_data.append('description', $('#description').val() );	
					form_data.append('primaryfirstname', $('#primaryfirstname').val() );	
					form_data.append('primarylastname', $('#primarylastname').val() );	
					form_data.append('primaryemail', $('#primaryemail').val() );	
					form_data.append('primaryphonenumber', $('#primaryphonenumber').val() );	
					form_data.append('secondaryfirstname1', $('#secondaryfirstname1').val() );	
					form_data.append('secondarylastname1', $('#secondarylastname1').val() );	
					form_data.append('secondaryemail1', $('#secondaryemail1').val() );	
					form_data.append('secondaryphonenumber1', $('#secondaryphonenumber1').val() );	
					form_data.append('secondaryfirstname2', $('#secondaryfirstname2').val() );	
					form_data.append('secondarylastname2', $('#secondarylastname2').val() );	
					form_data.append('secondaryemail2', $('#secondaryemail2').val() );	
					form_data.append('secondaryphonenumber2', $('#secondaryphonenumber2').val() );	
										
					$.ajax({
								url: 'addNewInstrumentWebPage.php',  
								dataType: 'text', 
								cache: false,
								contentType: false,
								processData: false,
								data: form_data,                         
								type: 'post',
								success: function(php_script_response){
									 //
									 var doc = eval("(" + php_script_response + ")");  
									 if(doc.result == 1)
									 {
									 	$('#successMessage').modal('show');
									 } else {
									 	alert('error inserting new instrument');
									 }
 									   
 								}
					 });
					 
 		}
	
	 	$('#addinstrument').on('click', uploadfile );	 

</script>
 


 