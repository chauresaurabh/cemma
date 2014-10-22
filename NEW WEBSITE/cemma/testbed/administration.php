
<?	include_once('constants.php');
	include_once(DOCUMENT_ROOT."includes/checklogin.php");
	//include_once(DOCUMENT_ROOT."includes/checkadmin.php");
	//echo $ClassLevel;
	//echo '/'.$class;
	/*if($class != 1){
		//header('Location: login.php');
	}
	else
	{
		if($ClassLevel == 2 || $ClassLevel == 5)
		{
				header('Location: customers.php');
		}
		else if($ClassLevel == 3 || $ClassLevel == 4)
		{
//			header('Location: MyAccount.php?id='.$_SESSION['Customer_ID'].')';
			header('Location: EditMyAccountUser.php?id='.$_SESSION['login'].'');	
		}
	}*/
	$username = $_SESSION['login'];
	include (DOCUMENT_ROOT.'includes/DatabaseOld.php');
	$sql = "select InstrumentName from instrument, instr_group, user where user.UserName = '$username' and instr_group.Email=user.Email and instrument.InstrumentNo = instr_group.InstrNo order by InstrumentName";
	
	//echo $sql;
	$result = mysql_query($sql) or die(mysql_error());
	//echo "received results";
	$instr_no=0;
	$instr_name=array();
	while($row=mysql_fetch_array($result))
	{
		$instr_name[$instr_no++]=$row['InstrumentName'];
	}
?>
	
	
	<? include (DOCUMENT_ROOT.'tpl/header.php'); ?>
	<table border="0" cellpadding="0" cellspacing="0" width="100%">   
	
	<tr><td class="body" valign="top" align="center">
    <? include (DOCUMENT_ROOT.'tpl/admin-loged-in.php'); ?> 
    <table border="0" cellpadding="0" cellspacing="0" align="center"><tr><td class="body_resize">
    	<? //echo DOCUMENT_ROOT.'tpl/admin-loged-in.php'; ?>
        <table cellpadding="0" cellspacing="0" border="0" width="820px">
        <tr><td>
<!--        <div id="calback"> 
			<div id="calendar"></div>  
        </div> 
-->
		    <div>

      <div id="calhead" style="padding-left:1px;padding-right:1px;">          
            <div class="cHead">
            <div class="ftitle">
            <table>
            	<tr>
                    <td><div class="akashi" style="width:10px;height:6px;border:1px solid #000;"></div></td><td><span style="font-size:8px">Akashi 002B - TEM</span></td>
                    <td><div class="delta" style="width:10px;height:6px;border:1px solid #000;"></div></td><td><span style="font-size:8px">DeltaVision OMX</span></td>
                	<td><div class="jeol-6610" style="width:10px;height:6px;border:1px solid #000;"></div></td><td><span style="font-size:8px">JEOL JSM-6610 - SEM</span></td>
                    <td><div class="jeol-2100" style="width:10px;height:6px;border:1px solid #000;"></div></td><td><span style="font-size:8px">JEOL JEM-2100F</span></td>
                	<td><div class="jeol-4500" style="width:10px;height:6px;border:1px solid #000;"></div></td><td><span style="font-size:8px">JEOL JIB-4500 - FIB SEM</span></td>
                </tr>
                <tr>
                    <td><div class="jeol-100cx" style="width:10px;height:6px;border:1px solid #000;"></div></td><td><span style="font-size:8px">JEOL 100CX - TEM</span></td>
                    <td><div class="jeol-7001" style="width:10px;height:6px;border:1px solid #000;"></div></td><td><span style="font-size:8px">JEOL JSM-7001 - SEM</span></td>
                    <td><div class="tousimis" style="width:10px;height:6px;border:1px solid #000;"></div></td><td><span style="font-size:8px">Tousimis 815 - Critical Point Dryer</span></td>
                    <td><div class="ultramicrotomes" style="width:10px;height:6px;border:1px solid #000;"></div></td><td><span style="font-size:8px">Ultramicrotomes</span></td>
                    <td><div class="kratos" style="width:10px;height:6px;border:1px solid #000;"></div></td><td><span style="font-size:8px">Kratos AXIS Ultra</span></td>
                </tr>
                <tr>
                	<td><div class="offpeak-hours" style="width:20px;height:10px;border:1px solid #000;"></div></td><td><span style="font-size:12px">Off-Peak time</span> | </td>
                    <td><div style="width:20px;height:10px;border:1px solid #000;background:#FFF"></div></td><td><span style="font-size:12px">Peak time</span></td>
                </tr>
            </table>
            </div>
            <div id="loadingpannel" class="ptogtitle loadicon" style="display: none;">Loading...</div>
             <div id="errorpannel" class="ptogtitle loaderror" style="display: none;">Sorry, could not load your data, please try again later</div>
            </div>          
            
            <div id="caltoolbar" class="ctoolbar">
              <!--<div id="faddbtn" class="fbutton">
                <div><span title='Click to Create New Event' class="addcal">

                New Event                
                </span></div>
            </div>-->
            <div class="btnseparator"></div>
             <div id="showtodaybtn" class="fbutton">
                <div><span title='Click to back to today ' class="showtoday">
                Today</span></div>
            </div>
              <div class="btnseparator"></div>

            <div id="showdaybtn" class="fbutton">
                <div><span title='Day' class="showdayview">Day</span></div>
            </div>
              <div  id="showweekbtn" class="fbutton fcurrent">
                <div><span title='Week' class="showweekview">Week</span></div>
            </div>
              <div  id="showmonthbtn" class="fbutton">
                <div><span title='Month' class="showmonthview">Month</span></div>

            </div>
            <div class="btnseparator"></div>
              <div  id="showreflashbtn" class="fbutton">
                <div><span title='Refresh view' class="showdayflash">Refresh</span></div>
                </div>
             <div class="btnseparator"></div>
            <div id="sfprevbtn" title="Prev"  class="fbutton">
              <span class="fprev"></span>

            </div>
            <div id="sfnextbtn" title="Next" class="fbutton">
                <span class="fnext"></span>
            </div>
            <div class="fshowdatep fbutton">
                    <div>
                        <input type="hidden" name="txtshow" id="hdtxtshow" />
                        <!--<span id="txtdatetimeshow">Loading</span>-->

                    </div>
            </div>
            
            <div class="clear"></div>
            </div>
      </div>
      <div style="padding:1px;">

        <div class="t1 chromeColor">
            &nbsp;</div>
        <div class="t2 chromeColor">
            &nbsp;</div>
        <div id="dvCalMain" class="calmain printborder">
            <div id="gridcontainer" style="overflow-y: visible;">
            </div>
        </div>
        <div class="t2 chromeColor">

            &nbsp;</div>
        <div class="t1 chromeColor">
            &nbsp;
        </div>   
        </div>
     
  </div>

        </td></tr></table>

	  </td></tr></table>
      <div class="clr"></div>
	  </td></tr></table>

  
	</td></tr></table>
   
   	<? include ('tpl/footer.php'); ?>
		
