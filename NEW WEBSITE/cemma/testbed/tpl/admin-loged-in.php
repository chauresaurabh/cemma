<link rel="stylesheet" type="text/css" href="../testbed/pro_dropdown_2/pro_dropdown_2.css" />
<script src="../testbed/pro_dropdown_2/stuHover.js" type="text/javascript"></script>



<div style="height:40px;background:#fff url(../testbed/pro_dropdown_2/three_0.gif) repeat-x; ">

	<ul id="nav">
    	<a href="administration.php">
        <li class="top">
    	<?	if($_SESSION['ClassLevel']==1) { ?>
        <span class="userType">Administrator : </span><label class="userType" id="currentuserid"><? //echo 'class'.$_SESSION['ClassLevel']."-".$_SESSION['login'].$_SESSION['User'];
            echo $_SESSION['login'];
            ?></label>
        <? } else if($_SESSION['ClassLevel']==2) { ?>
        <span class="userType">Cemma Staff : </span><label class="userType" id="currentuserid"><? //echo 'class'.$_SESSION['ClassLevel']."-".$_SESSION['login'].$_SESSION['User'];
            echo $_SESSION['login'];
        ?></label>
        <? } else if($_SESSION['ClassLevel']==3) {?>
        <span class="userType">Super User : </span><label class="userType" id="currentuserid"><? echo $_SESSION['login'];?></label>
        <? } else if($_SESSION['ClassLevel']==4) { ?>
        <span class="userType">User : </span><label class="userType" id="currentuserid"><? echo $_SESSION['login'];?></label>
        <? } else if($_SESSION['ClassLevel']==5) { ?>
        <span class="userType">Lab/Class : </span><label class="userType" id="currentuserid"><? echo $_SESSION['login'];?></label>
        <? }?>&nbsp;<span class="userType1">|</span>
        </li>
        </a>
		<?	if($_SESSION['ClassLevel']==1) { ?>
		<!-- <li>
			<a href="members.php">Manage Schedule</a>
		</li>
		<li>
			<a href="schedule.php">Manage Schedule-Supercali</a>
		</li>
		<li>
			<a href="schedule_thyme.php">Manage Schedule-Thyme</a>
		</li>-->
		<? }?>
		
		<? if($_SESSION['ClassLevel'] != 4){ ?>

			<li class="top"><a href="#nogo2" id="products" class="top_link"><span class="down">Manage</span></a>
				<ul class="sub">
					<? if($_SESSION['ClassLevel'] == 1){ ?>
						<li><a href="#nogo3" class="fly">Manage Customers</a>
								<ul>
                 					<li><a href="current_customers.php">Current</a></li>
									<li><a href="editCustomer.php?id=&submit_mode=add">New Customer</a></li>
									<li><a href="ArchivedCustomers.php">Archived</a></li>
								</ul>
						</li>
                        <li><a href="#nogo3" class="fly">Manage Calendar</a>
                        	<ul>
								<li><a href="manageCalendar.php">View Events</a></li>
                                <li><a href="addFullDayEvent.php">Add Event</a></li>
                            </ul>
                        </li>
					<? }?>
					<li><a href="#nogo3" class="fly">Manage Instruments</a>
							<ul>
								<li><a href="instruments.php">Instruments</a></li>
								<? if($_SESSION['ClassLevel'] == 1){ ?>
                                	<li><a href="add_instrument.php?id=&submit_mode=add">New Instrument</a></li>
									<li><a href="InstrumentTypes.php">Service Category</a></li>
								<? }?>
							</ul>
					</li>
					<li><a href="#nogo3" class="fly">Manage Users</a>
							<ul>
								<li><a href="currentusers.php">Current</a></li>
								<li><a href="NewRequestsUsers.php">New Requests</a></li>
                                <? if($_SESSION['ClassLevel']==1) {?>
									<li><a href="ArchivedUsers.php">Archived</a></li>
                                <? } ?>
   								<li><a href="InstrumentTraining.php">Training Requests</a></li>

							</ul>
					</li>
					<? if($_SESSION['ClassLevel'] == 1){ ?>
						<li><a href="#no" class="fly">Manage Schools</a>
                        	<ul>
								<li><a href="AddSchool.php?id=&submit_mode=add">New School</a></li>
                                <li><a href="schools.php">Current</a></li>
                            </ul>
                        </li>
                    
						<li><a href="#nogo3" class="fly">Manage Forms</a>
								<ul>
									<li><a href="Permit.php">Permit</a></li>
									<li><a href="Manual.php">Manual</a></li>
									<li><a href="UploadPolicy.php">Policy</a></li>
                                    <li><a href="StaffMembers.php">Staff Members</a></li>
								</ul>
						</li>
					<? }?>
				</ul>
			</li>
			
			<li class="top"><a href="#nogo2" id="products" class="top_link"><span class="down">Email</span></a>
				<ul class="sub">
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
			<li class="top"><a href="#nogo2" id="products" class="top_link"><span class="down">Records</span></a>
				<ul class="sub">
					<? if($_SESSION['ClassLevel'] ==1 ){ ?>
						<li><a href="view_records.php">View</a></li>
						<li><a href="add_record.php">Add</a></li>
						
					<? }?>
					 
                     	<li><a href="#no" class="fly">Queries</a>
                         
                                	<ul>
										<li><a href="statistics.php?id=0">Find Records</a></li>
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
				<li class="top"><a href="#nogo2" id="products" class="top_link"><span class="down">Pricing</span></a>
					<ul class="sub">
						<li><a href="Quotes.php">Create Quotes</a></li>
						<li><a href="Pricing.php">Price List</a></li>
					</ul>
				</li>
				
			<? }?>
		<? }?>
		<li class="top">
        	<? if($_SESSION['ClassLevel'] == 4 ){ ?>
        		<a href="#nogo2" id="products" class="top_link"><span class="down">Manual</span></a>
            <? } else { ?>
            	<a href="#nogo2" id="products" class="top_link"><span class="down">New Users</span></a>
            <? }  ?>
            <ul class="sub">
            	<? if($_SESSION['ClassLevel'] < 3 ){ ?>
                    <li><a href="NewUserPolicy.php">Policies</a></li>
                    <li><a href="NewUserPermit.php">Permit</a></li>
                <? }?>
                <li><a href="NewUserManual.php">Manual</a></li>
            </ul>
        </li>
         
       <li class="top"><a href="#nogo2" id="products" class="top_link"><span class="down">Calendar</span></a>
		 <ul class="sub">
				 
			 <li><a href="schedule_event.php">Calendar</a></li>
 	 	</ul>
	  </li>
        
        
      <li class="top"><a href="#nogo2" id="products" class="top_link"><span class="down">My Account</span></a>
		 <ul class="sub">
			 <li><a href="EditMyAccountUser.php?id=<?=$_SESSION['login']?>" ><span>Account Details</span></a></li>
 	 	</ul>
      </li>
  
		<!-- <li>
			<a href="Cancel.php">Cancel</a>
		</li> -->
		<li class="top"><a href="logout.php" class="top_link"><span>Logout</span></a></li>

	</ul>
</div>