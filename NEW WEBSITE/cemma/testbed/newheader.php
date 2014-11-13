<link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet">

  <style type="text/css">
    
				ul.nav li.dropdown:hover > ul.dropdown-menu {
				display: block;    
			}

.dropdown-submenu {
    position: relative;
}

.dropdown-submenu>.dropdown-menu {
    top: 0;
    left: 100%;
    margin-top: -6px;
    margin-left: -1px;
    -webkit-border-radius: 0 10px 10px 10px;
    -moz-border-radius: 0 10px 10px;
    border-radius: 0 10px 10px 10px;
}

.dropdown-submenu:hover>.dropdown-menu {
    display: block;
	
}
.dropdown-submenu > a:focus, .dropdown-submenu > a:hover, .dropdown-submenu:focus>a, r, .dropdown-submenu:hover>a,
.dropdown-menu > li a:hover,
.dropdown-menu > li a:focus { background-color: #FFBE0D; background-image:  none; filter: none; text-decoration: none; border: none; color:#990000 }
.dropdown-submenu>a:after {
    display: block;
    content: " ";
    float: right;
    width: 0;
    height: 0;
    border-color: transparent;
    border-style: solid;
    border-width: 5px 0 5px 5px;
    border-left-color: #ccc;
    margin-top: 5px;
    margin-right: -10px;
}

.dropdown-submenu:hover>a:after {
    border-left-color: #fff;
}

.dropdown-submenu.pull-left {
    float: none;
}

.dropdown-submenu.pull-left>.dropdown-menu {
    left: -100%;
    margin-left: 10px;
    -webkit-border-radius: 10px 0 10px 10px;
    -moz-border-radius: 10px 0 10px 10px;
    border-radius: 10px 0 10px 10px;
}
.dropdown-menu {
	background-color:#B40000;
}
 
.dropdown-menu li a{
	color:#FFFFFF;
	font-weight:bold;
}
 
  

  </style>
  
  
   <header class="navbar navbar-fixed-top navbar-inverse" style="margin-top:110px;height:10px;position:absolute">
  
    <div class="container">
        
	  <div class="navbar-collapse nav-collapse collapse navbar-header">
        <ul class="nav navbar-nav">
           
           
         
        <li class="dropdown">
          <a href="logout.php" class="dropdown-toggle js-activated" data-toggle="dropdown" style="color:#FFFFFF;font-weight:bold">
    	<?	if($_SESSION['ClassLevel']==1) { ?>
        <span class="userType">Administrator : </span><label class="userType" id="currentuserid"><?  
            echo $_SESSION['login'];
            ?></label>
        <? } else if($_SESSION['ClassLevel']==2) { ?>
        <span class="userType">Cemma Staff : </span><label class="userType" id="currentuserid"><? 
            echo $_SESSION['login'];
        ?></label>
        <? } else if($_SESSION['ClassLevel']==3) {?>
        <span class="userType">Super User : </span><label class="userType" id="currentuserid"><? echo $_SESSION['login'];?></label>
        <? } else if($_SESSION['ClassLevel']==4) { ?>
        <span class="userType">User : </span><label class="userType" id="currentuserid"><? echo $_SESSION['login'];?></label>
        <? } else if($_SESSION['ClassLevel']==5) { ?>
       <span class="userType">Lab/Class : </span><label class="userType" id="currentuserid"><? echo $_SESSION['login'];?></label>
        <? }?>&nbsp;<span class="userType1">|</span>
         
         </a>
         
         
        </li>
       
           
           
            <!-- --->
       	<? if($_SESSION['ClassLevel'] != 4){ ?>     
            <li class="dropdown">
            <a href="#" class="dropdown-toggle js-activated" data-toggle="dropdown" style="color:#FFFFFF;font-weight:bold">Manage <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<? if($_SESSION['ClassLevel'] == 1){ ?>
						<li class="dropdown-submenu"><a href="#nogo3" >Manage Customers</a>
								<ul class="dropdown-menu">
                 					<li><a href="current_customers.php">Current</a></li>
									<li><a href="editCustomer.php?id=&submit_mode=add">New Customer</a></li>
									<li><a href="ArchivedCustomers.php">Archived</a></li>
								</ul>
						</li>
                        <li  class="dropdown-submenu"><a href="#nogo3" class="dropdown-submenu">Manage Calendar</a>
                        	<ul class="dropdown-menu">
								<li><a href="manageCalendar.php">View Events</a></li>
                                <li><a href="addFullDayEvent.php">Add Event</a></li>
                            </ul>
                        </li>
					<? }?>
					<li  class="dropdown-submenu"><a href="#nogo3" >Manage Instruments</a>
							<ul class="dropdown-menu">
								<li><a href="instruments.php">Instruments</a></li>
								<? if($_SESSION['ClassLevel'] == 1){ ?>
                                	<li><a href="add_instrument.php?id=&submit_mode=add">New Instrument</a></li>
									<li><a href="InstrumentTypes.php">Service Category</a></li>
								<? }?>
							</ul>
					</li>
					<li class="dropdown-submenu"><a href="#nogo3"  >Manage Users</a>
							<ul class="dropdown-menu">
								<li><a href="currentusers.php">Current</a></li>
								<li><a href="NewRequestsUsers.php">New Requests</a></li>
                                <? if($_SESSION['ClassLevel']==1) {?>
									<li><a href="ArchivedUsers.php">Archived</a></li>
                                <? } ?>
   								<li><a href="InstrumentTraining.php">Training Requests</a></li>

							</ul>
					</li>
					<? if($_SESSION['ClassLevel'] == 1){ ?>
						<li  class="dropdown-submenu"><a href="#no" >Manage Schools</a>
                        	<ul  class="dropdown-menu">
								<li><a href="AddSchool.php?id=&submit_mode=add">New School</a></li>
                                <li><a href="schools.php">Current</a></li>
                            </ul>
                        </li>
                    
						<li  class="dropdown-submenu"><a href="#nogo3" class="fly">Manage Forms</a>
								<ul  class="dropdown-menu">
									<li><a href="Permit.php">Permit</a></li>
									<li><a href="Manual.php">Manual</a></li>
									<li><a href="UploadPolicy.php">Policy</a></li>
                                    <li><a href="StaffMembers.php">Staff Members</a></li>
								</ul>
						</li>
					<? }?>
				</ul>
			</li>
            
             <li class="dropdown">
            	<a href="#" class="dropdown-toggle js-activated" data-toggle="dropdown" style="color:#FFFFFF;font-weight:bold">Email <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<? if($_SESSION['ClassLevel'] ==1 ){ ?>
						<li><a href="Email.php?all=1">All</a></li>
					<? }?>

					<li><a href="Email.php?all=2">Instrument-List</a></li>

					<? if($_SESSION['ClassLevel'] ==1 ){ ?>
						<li><a href="EmailInstrStatus.php">All-Instruments Status</a></li>
						<li><a href="EmailAnnually.php">Annual Status Update</a></li>
						<li><a href="EmailPending.php">Pending Users</a></li>
					<? }?>
				</ul>
			</li>
            
            
            <li class="dropdown">
            	<a href="#" class="dropdown-toggle js-activated" data-toggle="dropdown" style="color:#FFFFFF;font-weight:bold">Records <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<? if($_SESSION['ClassLevel'] ==1 ){ ?>
						<li><a href="view_records.php">View</a></li>
						<li><a href="add_record.php">Add</a></li>
						
					<? }?>
					 
                     	<li  class="dropdown-submenu"><a href="#">Queries</a>
                         
                                	<ul class="dropdown-menu">
										<li><a href="statistics.php?id=0" >Find Records</a></li>
                               			<li><a href="statistics.php?id=1">Find Invoices</a></li>
                                        <li><a href="statistics.php?id=2">Instrument Logs</a></li>
                                        <li><a href="statistics.php?id=3">Search Users</a></li>
                                        <li><a href="statistics.php?id=4">Search Customers</a></li>
                                    </ul>
                                
                        </li>
                        <? if($_SESSION['ClassLevel'] ==1 ){ ?>
                       			 <li><a href="generate_invoice.php">Generate Invoice</a></li>
                        <? }?>
				</ul>
			</li>
            
            
            	<? if($_SESSION['ClassLevel'] != 4 ){ ?>
				<li class="dropdown">
            		<a href="#" class="dropdown-toggle js-activated" data-toggle="dropdown" style="color:#FFFFFF;font-weight:bold">Pricing <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="Quotes.php">Create Quotes</a></li>
						<li><a href="Pricing.php">Price List</a></li>
					</ul>
				</li>
				
			<? }?>
           
           	<? }?>
		 <li class="dropdown">
        	<? if($_SESSION['ClassLevel'] == 4 ){ ?>
            		<a href="#" class="dropdown-toggle js-activated" data-toggle="dropdown" style="color:#FFFFFF;font-weight:bold">Manual <b class="caret"></b></a>
            <? } else { ?>
            		<a href="#" class="dropdown-toggle js-activated" data-toggle="dropdown" style="color:#FFFFFF;font-weight:bold">New Users <b class="caret"></b></a>
            <? }  ?>
            <ul class="dropdown-menu">
            	<? if($_SESSION['ClassLevel'] < 3 ){ ?>
                    <li><a href="NewUserPolicy.php">Policies</a></li>
                    <li><a href="NewUserPermit.php">Permit</a></li>
                <? }?>
                <li><a href="NewUserManual.php">Manual</a></li>
            </ul>
        </li>
        
        
      <li class="dropdown">
      <a href="schedule_event.php" class="dropdown-toggle js-activated" data-toggle="dropdown" style="color:#FFFFFF;font-weight:bold">Calendar <b class="caret"></b></a>

		 <ul class="dropdown-menu">
			 <?
			 if($_SESSION['ClassLevel'] ==1 ){ 
			 	$userName = $_SESSION['login'];
				include (DOCUMENT_ROOT.'includes/DatabaseOld.php');
				$instrsql = "select InstrumentName from instrument, instr_group, user where user.UserName = '$userName' and instr_group.Email=user.Email and instrument.InstrumentNo = instr_group.InstrNo order by InstrumentName";
				
				$instrresult = mysql_query($instrsql) or die(mysql_error());
			 
					while($instrrow=mysql_fetch_array($instrresult))
					{
 			?>
						<li><a href="schedule_event.php?calinstrumentname=<?= $instrrow['InstrumentName'];?>"><?= $instrrow['InstrumentName'];?> </a></li>
				   <?  
                    }
                    ?>
			 <?
				 } 
			 else{
			 ?>	 
				 <li><a href="schedule_event.php">Calendar</a></li>
             <? } ?>
 	 	</ul>
	  </li>
        
        
      <li class="dropdown">
      <a href="#" class="dropdown-toggle js-activated" data-toggle="dropdown" style="color:#FFFFFF;font-weight:bold">My Account <b class="caret"></b></a>
		 <ul class="dropdown-menu">
			 <li><a href="EditMyAccountUser.php?id=<?=$_SESSION['login']?>" style="color:#FFFFFF;font-weight:bold"><span>Account Details</span></a></li>
 	 	</ul>
      </li>
      
      	<li class="dropdown">
     			<a href="logout.php"  style="color:#FFFFFF;font-weight:bold">Logout</a>
         </li>
  
            <!-- -->
		  
         </ul>
      </div> <!-- .nav-collapse -->
    </div> <!-- .container -->
  </header> <!-- .navbar -->
 
	<br><br>
	
  <!-- latest jQuery, Boostrap JS and hover dropdown plugin -->
  <script src="http://code.jquery.com/jquery-latest.min.js"></script>
  <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
  <script src="/downloads/bootstrap-hover-dropdown/bootstrap-hover-dropdown.js"></script>

  <script>
    // very simple to use!
    $(document).ready(function() {
      $('.js-activated').dropdownHover().dropdown();
    });
  </script>
  