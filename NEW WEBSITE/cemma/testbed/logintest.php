<? 	
	include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/checkadmin.php");

	if($class>-1 && $class<6){
		header('Location: administration.php');
	}

	include (DOCUMENT_ROOT.'tpl/header.php'); 
	
	if(getfilename()=='index.php')
	{
		include (DOCUMENT_ROOT.'tpl/home-top-slider.php');
	}
 ?>
 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">

		<style>
			.form-signin {
			max-width: 400px;
			padding: 19px 29px 29px;
			margin: 0 auto 20px;
 			border: 1px solid #e5e5e5;
			-webkit-border-radius: 10px;
			-moz-border-radius: 10px;
			border-radius: 10px;
			-webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
			-moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
 		  }
 		   
	 </style>
   
  	<br /><br />
    <div class="container">
      
      
      <form role="form" class="form-signin" action="authentication/authentication.php" method="post">
	  <h3 class="form-header">Lab Information System Login</h3>
      <hr />
         <div class="form-group">
          <label for="email">Username:</label>
          <input type="text" class="form-control" id="username" name="username" placeholder="Username" style="color:#000000" />
        </div>
        <div class="form-group">
          <label for="pwd">Password:</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Password" style="color:#000000"/>
        </div>
      
       <div class="form-group">
      
              <button class="btn btn-primary" type="submit">Sign In</button>
              <a class="pull-right" href="#"  data-toggle="modal" data-target="#requestUserNameModal" >Forgot Username?</a><br />
              <a class="pull-right" href="#" data-toggle="modal" data-target="#requestPasswordModal" >Forgot Password?</a>
 
   	 </div>
        
      </form>
    </div>
 
<div class="modal fade" id="requestPasswordModal" tabindex="-1" role="dialog" aria-labelledby="requestPasswordLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="requestPasswordLabel">Enter Your CEMMA Username for Password Recovery</h4>
            </div>

            <div class="modal-body">
                <!-- The form is placed inside the body of modal -->
                <form id="loginForm" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Username</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="enteredusernameforpassword" id="enteredusernameforpassword" />
                        </div>
                    </div>

                   
                    <div class="form-group">
                        <div class="col-sm-5 col-sm-offset-3">
                            <button type="button" class="btn btn-primary"  data-loading-text="Sending Email..." id="requestpasswordbutton" onclick="forgotPassword();">Request Password</button>
                             
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="requestUserNameModal" tabindex="-1" role="dialog" aria-labelledby="requestUsernameLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="requestUsernameLabel">Enter Your Registered Email for Username Recovery</h4>
            </div>

            <div class="modal-body">
                <!-- The form is placed inside the body of modal -->
                <form id="loginForm" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-5">
                            <input type="email" class="form-control" name="enteredemailforusername" id="enteredemailforusername" />
                        </div>
                    </div>

                   
                    <div class="form-group">
                        <div class="col-sm-5 col-sm-offset-3">
                            <button type="button" class="btn btn-primary" onclick="forgotUsername();" data-loading-text="Sending Email..." id="requestusernamebutton">Request Username</button>
                             
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
 
<!-- Modal -->
<div class="modal fade" id="mailSentModal" tabindex="-1" role="dialog" aria-labelledby="mailSentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      
        <h4 class="modal-title" id="mailSentModalLabel"> Center for Electron Microscopy and Microanalysis </h4>
      </div>
      <div class="modal-body" id="modal-body">
         	Your CEMMA Login Details have been emailed to you!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
       </div>
    </div>
  </div>
</div>
 
  <br /><br /><br /><br />
 
   <? include ('tpl/footer.php'); ?>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
 
<script type="text/javascript">
function forgotUsername() {
	  
	  				$.ajax({
								url: 'forgotPassword.php?email='+$('#enteredemailforusername').val(),   
  								type: 'get',
								success: function( response ){
   									     $('#requestUserNameModal').modal('hide');
 										 $('#mailSentModal').modal('show');
 								}
					 });
}
function forgotPassword(){
	  
	 				 $.ajax({
								url: 'forgotPassword.php?username='+$('#enteredusernameforpassword').val(),   
  								type: 'get',
								success: function( response ){
   									     $('#requestPasswordModal').modal('hide');
 										 $('#mailSentModal').modal('show');
 								}
					 });
}
 	
	$('#requestpasswordbutton').click(function() {
  		  $(this).button('loading');
	});
	$('#requestusernamebutton').click(function() {
  		  $(this).button('loading');
	});

 
 </script>
 
 
