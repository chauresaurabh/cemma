<?php
if(!isset($_SESSION))
	session_start();
include_once("dbconfig.php");
include_once("functions.php");

function getTotalHours($st, $et) {
	$starthour = date("G", strtotime($st));
	$startMin = date("i", strtotime($st));
	$endhour = date("G", strtotime($et));
	$endMin = date("i", strtotime($et));
	
	$totalStartMins = $starthour*60 + $startMin;
	$totalEndMins = $endhour*60 + $endMin;
	return ($totalEndMins-$totalStartMins)/60;
}

function getColor($instrument){
	if($instrument=="Akashi 002B - TEM"){
		return 1;
	} else if($instrument=="JEOL 100CX - TEM"){
		return 11;
	} else if($instrument == "DeltaVision OMX - Super resolution"){
		return 3;
	} else if($instrument == "JEOL JEM-2100F"){
		return 12;
	} else if($instrument == "JEOL JIB-4500 - FIB SEM"){
		return 5;
	} else if($instrument == "JEOL JSM-6610 - SEM"){
		return 14;
	} else if($instrument == "JEOL JSM-7001 - SEM"){
		return 7;
	} else if($instrument == "Tousimis 815 - Critical Point Dryer"){
		return 10;
	} else if($instrument == "Ultramicrotomes"){
		return 9;
	} else if($instrument == "Kratos AXIS Ultra"){
		return 21;
	} else {
		-1;
	}
}
function getEmailId($username){
	$sql = "select Email from user where UserName= '$username'";
	$handle = mysql_query($sql);
	$row = mysql_fetch_object($handle);
	
	return $row->Email;
}
function checkPermission($sub, $instrument, $st, $et){
	$db = new DBConnection();
    $db->getConnection();
    //get the user permission
	  $sql = "select Permission from `instr_group` where `Email` = (select Email from user where UserName= '$sub') AND InstrNo = (select InstrumentNo from instrument where InstrumentName = '$instrument')";
	  $handle = mysql_query($sql);
	  $row = mysql_fetch_object($handle);
	  
/*	  $ret['IsSuccess'] = false;
			  $ret['Msg'] = date("i", strtotime($et));
			  $db->closeConnection();
			  return $ret;
	*/  
	  $fromDate = date("Y", strtotime($st))."-".date("m", strtotime($st))."-".date("d", strtotime($st));
	  $toDate = date("Y", strtotime($et))."-".date("m", strtotime($et))."-".date("d", strtotime($et));;
		
	  $sql = "SELECT id FROM schedule_calendar WHERE Color=20 AND  STR_TO_DATE(starttime, '%Y-%m-%d') between STR_TO_DATE('$fromDate', '%Y-%m-%d') AND STR_TO_DATE('$toDate', '%Y-%m-%d')";
	  $findDailyEvents = mysql_query($sql);
	  
	  if($row->Permission=="Peak"){
		  $dayOfWeek = date("w", strtotime($st));
		  
		  //if it is sat or sun or a full day event
		  if($dayOfWeek==6 || $dayOfWeek==0 || (mysql_num_rows($findDailyEvents)>0)){
			  $db->closeConnection();
			  return false;
		  }
		  //if starttime is < 9 am 
		  $starthour = date("G", strtotime($st));
		  if($starthour < 9  || (mysql_num_rows($findDailyEvents)>0)){
			  $db->closeConnection();
			  return false;
		  }
		  //or > 4.30 pm
		  if($starthour >= 16 || (mysql_num_rows($findDailyEvents)>0)){
			  $startMin = date("i", strtotime($st));
			  if($startMin > 30 || $starthour>16){
				  $db->closeConnection();
				  return false;
			  }
		  }
		  //if start hour is < 9am, then we don't need to check for end hour before 9 since start itself is < 9 and above if blocks will take care of it
		  //check for end hour > 4.30pm
		  $endhour = date("G", strtotime($et));
		  if($endhour >= 16 || (mysql_num_rows($findDailyEvents)>0)){
			  $endMin = date("i", strtotime($et));
			  if($endMin > 30 || $endhour>16){
				  $db->closeConnection();
				  return false;
			  }
		  }
	  }
	  $db->closeConnection();
	  return true;
}

function checkHours($instrument, $sub, $st, $et, $id) {
	$totalHours = getTotalHours($st, $et);
	
	$db = new DBConnection();
	$db->getConnection();

	$time = split(" ",$st);
	$eTimes = split(" ", $et);
	
	//if the event ends before 9am or starts after 4.30pm, then it's off-peak, else it's peak
	$dayOfWeek = date("w", strtotime($st));
	
	$fromDate = date("Y", strtotime($st))."-".date("m", strtotime($st))."-".date("d", strtotime($st));
	$toDate = date("Y", strtotime($et))."-".date("m", strtotime($et))."-".date("d", strtotime($et));;
	
	$sql1 = "SELECT id FROM schedule_calendar WHERE Color=20 AND  STR_TO_DATE(starttime, '%Y-%m-%d') between STR_TO_DATE('$fromDate', '%Y-%m-%d') AND STR_TO_DATE('$toDate', '%Y-%m-%d')";
	$findDailyEvents = mysql_query($sql1);
		  
	//if it is sat or sun or a full day event
	if(mysql_num_rows($findDailyEvents)>0 || $dayOfWeek==6 || $dayOfWeek==0 || (strcmp($time[1], "16:30")>=0) || (strcmp($eTimes[1],"09:00")<=0)) {
		$Peak_Or_OffPeak = "Off-Peak";
	} else {
		$Peak_Or_OffPeak = "Peak";
	}
			
	if(strcmp("JEOL JIB-4500 - FIB SEM",$instrument)==0) {
		//4500 has a daily constraint
		$startOfWeek = php2MySqlTime(js2PhpTime($time[0]));
		$endOfWeek = php2MySqlTime(strtotime("-1 minute", strtotime('+1 day',js2PhpTime( $time[0] ))));
	} else {
		//all other instruments have a weekly constraint
		$dayOfWeek = date("w", strtotime($st));
		//check if the booking day is a monday
		if($dayOfWeek == 1) {
			$startOfWeek = php2MySqlTime(js2PhpTime($time[0]));
		} else {
			$startOfWeek = php2MySqlTime(strtotime('last monday',js2PhpTime( $time[0] )));
		}
		
		$endOfWeek = php2MySqlTime(strtotime("-1 minute", strtotime('next monday',js2PhpTime( $time[0] ))));
	}
		
	$sql = "SELECT StartTime, EndTime, Color, Total_Hours, Peak_Or_OffPeak
					FROM `schedule_calendar`
					WHERE `starttime` between '"
					.$startOfWeek."' and '". $endOfWeek ."' AND schedule_calendar.Subject='$sub' AND instrument = '$instrument'";
	if($id != -1) {
		$sql.=" AND id != '$id'";
	}
					
	$handle = mysql_query($sql);
	$peakHours=0;
	$offpeakHours=0;
	while($row = mysql_fetch_object($handle)){
		if(strcmp($Peak_Or_OffPeak, "Peak")==0){
			if(strcmp($row->Peak_Or_OffPeak,"Peak")==0) {
				$peakHours+=$row->Total_Hours;
			}
		} else {
			if(strcmp($row->Peak_Or_OffPeak,"Off-Peak")==0) {
				$offpeakHours+=$row->Total_Hours;
			}
		}
	}
	$db->closeConnection();
	
	#echo $time[1]."  #  ".$eTimes[1]."  #  ".$sql1."      #       ".$sql."      #       ".$Peak_Or_OffPeak."         #        Peakhours: ".$peakHours."  #  Off-peak hours: ".$offpeakHours."   #   total hours: ".$totalHours;
	
	if($Peak_Or_OffPeak == "Peak") {
		if(($peakHours+$totalHours) > 4) {
			return false;
		} else {
			return true;
		}
	} else {
		if(($offpeakHours+$totalHours) > 8) {
			return false;
		} else {
			return true;
		}
	}
}

function removeAmPm($time) {
	if(substr_count($time,"a")>0){
		//if it's am, then just get rid of 'am' and send the time
		$temp = explode("a", $time);
		return $temp[0];
	} else if(substr_count($time,"p")>0){
		//if it's 'pm', first get rid of the 'pm'
		$temp = explode("p", $time);
		//then, we need to see if the time is like 2:00pm or something
		//if it is, then need to convert it to 14:00
		$t = explode(":", $temp[0]);
		if($t[0]<12){
			$t[0] += 12;
		}
		return $t[0].":".$t[1];
	} else {
		return $time;
	}
}
function addCalendar($instrument, $st, $et, $sub, $ade){

  $ret = array();
  try{
	if($instrument=="none" || $instrument==""){
		$ret['IsSuccess'] = false;
		$ret['Msg'] = "Please select an instrument.";
		return $ret;
	}
	if($_SESSION['ClassLevel']>3){
		$checkPermission = checkPermission($sub, $instrument, $st, $et);
		if($checkPermission==false){
			$ret['IsSuccess'] = false;
			$ret['Msg'] = "You do not have Off-Peak priviledges.";
			return $ret;
		}
		
		if(!checkHours($instrument, $sub, $st, $et, -1)) {
			$ret['IsSuccess'] = false;
			if(strcmp("JEOL JIB-4500 - FIB SEM",$instrument)==0) {
				$ret['Msg'] = "You can only book 4 hrs/day of peak time and 8 hrs/day of off-peak time in advance for this instrument";
			} else {
				$ret['Msg'] = "You can only book 4 hrs/week of peak time and 8 hrs/week of off-peak time in advance for this instrument";
			}
			return $ret;
		}
	}
	$st = removeAmPm($st);
	$et = removeAmPm($et);
	$db = new DBConnection();
    $db->getConnection();
	
	//check if any event exists for the given time
	$time = split(" ",$st);
	
	$eTimes = split(" ", $et);
	
	$fromDate = date("Y", strtotime($st))."-".date("m", strtotime($st))."-".date("d", strtotime($st));
	$toDate = date("Y", strtotime($et))."-".date("m", strtotime($et))."-".date("d", strtotime($et));;
			
	$sql = "SELECT id FROM schedule_calendar WHERE Color=20 AND  STR_TO_DATE(starttime, '%Y-%m-%d') between STR_TO_DATE('$fromDate', '%Y-%m-%d') AND STR_TO_DATE('$toDate', '%Y-%m-%d')";
	$findDailyEvents = mysql_query($sql);
	
	//if the event ends before 9am or starts after 4.30pm, then it's off-peak, else it's peak
	$dayOfWeek = date("w", strtotime($st));
		  
	//if it is sat or sun or a full day event
	if($dayOfWeek==6 || $dayOfWeek==0 || mysql_num_rows($findDailyEvents)>0 || (strcmp($time[1], "16:30")>=0) || (strcmp($eTimes[1],"09:00")<=0)) {
		$Peak_Or_OffPeak = "Off-Peak";
	} else {
		$Peak_Or_OffPeak = "Peak";
	}
	
	$sTime = php2MySqlTime(js2PhpTime($time[0]));
	$eTime = php2MySqlTime(strtotime("-1 minute",strtotime("+1 day",js2PhpTime($time[0]))));
	
	//$sql = "SELECT count(1) as Existing_Events FROM `schedule_calendar` WHERE (`starttime` between '".$sTime."' and '".$eTime."') or (`endtime` between '".$sTime."' and  '".$eTime."') and Subject='$sub' AND instrument = '$instrument'";
	
	$sql = "SELECT StartTime, EndTime FROM schedule_calendar WHERE starttime between '$sTime' and '$eTime' AND instrument = '$instrument'";
	$handle = mysql_query($sql);

	$sTime = php2MySqlTime(strtotime("+1 minute",js2PhpTime($st)));
	$eTime = php2MySqlTime(strtotime("-1 minute",js2PhpTime($et)));
	$cnt = 0;
	while($row = mysql_fetch_object($handle)) {
		if( strcmp($row->EndTime, $sTime)<0 || strcmp($eTime, $row->StartTime) < 0){
			
		} else {
			$cnt+=1;
			break;
		}
	}
	
	if($cnt > 0) {
		$ret['IsSuccess'] = false;
		$ret['Msg'] = "The times overlap with another booking. Please choose a different time";
		return $ret;
	}
	
	$totalHours = getTotalHours($st, $et);
	
	$sql = "insert into `schedule_calendar` (`instrument`, `color`, `subject`, `starttime`, `endtime`, `isalldayevent`, `EmailId`, `Total_Hours`, `Peak_Or_OffPeak`) values ('$instrument', '".getColor($instrument)."', '"
      .mysql_real_escape_string($sub)."', '"
      .php2MySqlTime(js2PhpTime($st))."', '"
      .php2MySqlTime(js2PhpTime($et))."', '"
      .mysql_real_escape_string($ade)."', '"
	  .getEmailId(mysql_real_escape_string($sub))."', '"
	  .$totalHours."', '$Peak_Or_OffPeak')";
    //echo($sql);
	if(mysql_query($sql)==false){
      $ret['IsSuccess'] = false;
      $ret['Msg'] = mysql_error();
    }else{
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'add success';
      $ret['Data'] = mysql_insert_id();
    }
	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  $db->closeConnection();
  return $ret;
}


function addDetailedCalendar($st, $et, $sd, $ed, $sub, $ade, $dscr, $loc, $color, $tz, $instrument){
	if($instrument=="none" || $instrument==""){
		$ret['IsSuccess'] = false;
		$ret['Msg'] = "Please select an instrument.";
		return $ret;
	}
  $ret = array();
  try{
	$st = removeAmPm($st);
	$et = removeAmPm($et);
	
	$st = $sd." ".$st;
	$et = $ed." ".$et;
	
	if($_SESSION['ClassLevel']>3){
	    $checkPermission = checkPermission($sub, $instrument, $st, $et);
		if($checkPermission==false){
			$ret['IsSuccess'] = false;
			$ret['Msg'] = "You do not have Off-Peak priviledges";
			return $ret;
		}
		if(!checkHours($instrument, $sub, $st, $et, -1)) {
			$ret['IsSuccess'] = false;
			if(strcmp("JEOL JIB-4500 - FIB SEM",$instrument)==0) {
				$ret['Msg'] = "You can only book 4 hrs/day of peak time and 8 hrs/day of off-peak time in advance for this instrument";
			} else {
				$ret['Msg'] = "You can only book 4 hrs/week of peak time and 8 hrs/week of off-peak time in advance for this instrument";
			}
			return $ret;
		}
	  }
	  
	
    $db = new DBConnection();
    $db->getConnection();
	
	//check if any event exists for the given time
	$time = split(" ",$st);
	
	$eTimes = split(" ", $et);
	
	$fromDate = date("Y", strtotime($st))."-".date("m", strtotime($st))."-".date("d", strtotime($st));
	$toDate = date("Y", strtotime($et))."-".date("m", strtotime($et))."-".date("d", strtotime($et));;
			
	$sql = "SELECT id FROM schedule_calendar WHERE Color=20 AND  STR_TO_DATE(starttime, '%Y-%m-%d') between STR_TO_DATE('$fromDate', '%Y-%m-%d') AND STR_TO_DATE('$toDate', '%Y-%m-%d')";
	$findDailyEvents = mysql_query($sql);
	
	//if the event ends before 9am or starts after 4.30pm, then it's off-peak, else it's peak
	$dayOfWeek = date("w", strtotime($st));
		  
	//if it is sat or sun or a full day event
	if($dayOfWeek==6 || $dayOfWeek==0 || mysql_num_rows($findDailyEvents)>0 || (strcmp($time[1], "16:30")>=0) || (strcmp($eTimes[1],"09:00")<=0)) {
		$Peak_Or_OffPeak = "Off-Peak";
	} else {
		$Peak_Or_OffPeak = "Peak";
	}
	
	$sTime = php2MySqlTime(js2PhpTime($time[0]));
	$eTime = php2MySqlTime(strtotime("-1 minute",strtotime("+1 day",js2PhpTime($time[0]))));
	
	//$sql = "SELECT count(1) as Existing_Events FROM `schedule_calendar` WHERE (`starttime` between '".$sTime."' and '".$eTime."') or (`endtime` between '".$sTime."' and  '".$eTime."') and Subject='$sub' AND instrument = '$instrument'";
	
	$sql = "SELECT StartTime, EndTime FROM schedule_calendar WHERE starttime between '$sTime' and '$eTime' AND instrument = '$instrument'";
	$handle = mysql_query($sql);

	$sTime = php2MySqlTime(strtotime("+1 minute",js2PhpTime($st)));
	$eTime = php2MySqlTime(strtotime("-1 minute",js2PhpTime($et)));
	$cnt = 0;
	while($row = mysql_fetch_object($handle)) {
		if( strcmp($row->EndTime, $sTime)<0 || strcmp($eTime, $row->StartTime) < 0){
			
		} else {
			$cnt+=1;
			break;
		}
	}
	
	if($cnt > 0) {
		$ret['IsSuccess'] = false;
		$ret['Msg'] = "The times overlap with another booking. Please choose a different time";
		return $ret;
	}
	
	$totalHours = getTotalHours($st, $et);
	
    $sql = "insert into `schedule_calendar` (`instrument`,`subject`, `starttime`, `endtime`, `isalldayevent`, `description`, `location`, `color`, `EmailId`, `Total_Hours`, `Peak_Or_OffPeak`) values ('$instrument', '"
      .mysql_real_escape_string($sub)."', '"
      .php2MySqlTime(js2PhpTime($st))."', '"
      .php2MySqlTime(js2PhpTime($et))."', '"
      .mysql_real_escape_string($ade)."', '"
      .mysql_real_escape_string($dscr)."', '"
      .mysql_real_escape_string($loc)."', '"
      .getColor($instrument)."', '"
	  .getEmailId(mysql_real_escape_string($sub))."', '"
	  .$totalHours."', '$Peak_Or_OffPeak' )";
    //echo($sql);
		if(mysql_query($sql)==false){
      $ret['IsSuccess'] = false;
      $ret['Msg'] = mysql_error();
    }else{
      $ret['IsSuccess'] = true;
	  $ret['Msg'] = 'Added successfully';
      $ret['Data'] = mysql_insert_id();
    }
	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  $db->closeConnection();
  return $ret;
}

function listCalendarByRange($sd, $ed,$instrument){
  $ret = array();
  $ret['events'] = array();
  $ret["issort"] =true;
  $ret["start"] = php2JsTime($sd);
  $ret["end"] = php2JsTime($ed);
  $ret['error'] = NULL;
  try{
    $db = new DBConnection();
    $db->getConnection();
	if($instrument=="" || $instrument=="none"){
		$sql = "SELECT *, Advisor, Telephone
					FROM `schedule_calendar`, user
					WHERE schedule_calendar.Subject='".$_SESSION['login']."' AND user.UserName = schedule_calendar.Subject AND instrument = 'none'
					AND `starttime` between '"
		      		.php2MySqlTime($sd)."' and '". php2MySqlTime($ed)."'

					UNION
					
					SELECT *, Advisor, Telephone
					FROM `schedule_calendar`, user
					WHERE schedule_calendar.Subject='".$_SESSION['login']."' AND user.UserName = schedule_calendar.Subject AND instrument
					IN (
						SELECT InstrumentName
						FROM instrument, instr_group, user
						WHERE "./*user.UserName = '$login'
						AND*/" instr_group.Email = user.Email
						AND instrument.InstrumentNo = instr_group.InstrNo
						ORDER BY InstrumentName
						) AND `starttime` between '"
					.php2MySqlTime($sd)."' and '". php2MySqlTime($ed)."'";
	} else {
    	$sql = "select *, Advisor, Telephone from `schedule_calendar`, user where user.UserName = schedule_calendar.Subject AND `instrument` IN ('".$instrument."', 'none') AND `starttime` between '"
      		.php2MySqlTime($sd)."' and '". php2MySqlTime($ed)."'";
	}
	$handle = mysql_query($sql) or die($sql."   ".mysql_error());
	
    //echo $sql;
    while ($row = mysql_fetch_object($handle)) {
      //$ret['events'][] = $row;
      //$attends = $row->AttendeeNames;
      //if($row->OtherAttendee){
      //  $attends .= $row->OtherAttendee;
      //}
      //echo $row->StartTime;
      $ret['events'][] = array(
        $row->Id,
        $row->Subject,
        php2JsTime(mySql2PhpTime($row->StartTime)),
        php2JsTime(mySql2PhpTime($row->EndTime)),
        $row->IsAllDayEvent,
        0, //more than one day event
        //$row->InstanceType,
        0,//Recurring event,
        $row->Color,
        1,//editable
        $row->Location, 
        $row->Description,//$attends,
		$row->Instrument,
		$row->EmailId,
		$row->Advisor,
		$row->Telephone
      );
    }
	}catch(Exception $e){
     $ret['error'] = $e->getMessage();
  }
 $db->closeConnection();
 return $ret;
}

function listCalendar($day, $type, $instrument){
  $phpTime = js2PhpTime($day);
  //echo $phpTime . "+" . $type;
  switch($type){
    case "month":
      $st = mktime(0, 0, 0, date("m", $phpTime), 1, date("Y", $phpTime));
      $et = mktime(0, 0, -1, date("m", $phpTime)+1, 1, date("Y", $phpTime));
      break;
    case "week":
      //suppose first day of a week is monday 
      $monday  =  date("d", $phpTime) - date('N', $phpTime) + 1;
      //echo date('N', $phpTime);
      $st = mktime(0,0,0,date("m", $phpTime), $monday, date("Y", $phpTime));
      $et = mktime(0,0,-1,date("m", $phpTime), $monday+7, date("Y", $phpTime));
      break;
    case "day":
      $st = mktime(0, 0, 0, date("m", $phpTime), date("d", $phpTime), date("Y", $phpTime));
      $et = mktime(0, 0, -1, date("m", $phpTime), date("d", $phpTime)+1, date("Y", $phpTime));
      break;
  }
  //echo $st . "--" . $et;
  return listCalendarByRange($st, $et, $instrument);
}

function updateCalendar($id, $st, $et){
  $ret = array();
  try{
    $db = new DBConnection();
    $db->getConnection();
	
	$sql = "SELECT Subject, Instrument FROM schedule_calendar WHERE id='$id'";
	$handle = mysql_query($sql);
	$row = mysql_fetch_object($handle);
	
	$sub = $row->Subject;
	$instrument = $row->Instrument;
	
	if($_SESSION['ClassLevel']>3){
		$checkPermission = checkPermission($sub, $instrument, $st, $et);
		if($checkPermission==false){
			$ret['IsSuccess'] = false;
			$ret['Msg'] = "You do not have Off-Peak priviledges.";
			return $ret;
		}
		
		if(!checkHours($instrument, $sub, $st, $et, $id)) {
			$ret['IsSuccess'] = false;
			if(strcmp("JEOL JIB-4500 - FIB SEM",$instrument)==0) {
				$ret['Msg'] = "You can only book 4 hrs/day of peak time and 8 hrs/day of off-peak time in advance for this instrument";
			} else {
				$ret['Msg'] = "You can only book 4 hrs/week of peak time and 8 hrs/week of off-peak time in advance for this instrument";
			}
			return $ret;
		}
	}
	
	$db = new DBConnection();
    $db->getConnection();
	
	$sTime = php2MySqlTime(js2PhpTime($sd));
	$eTime = php2MySqlTime(strtotime("-1 minute",strtotime("+1 day",js2PhpTime($ed))));
	
	//$sql = "SELECT count(1) as Existing_Events FROM `schedule_calendar` WHERE (`starttime` between '".$sTime."' and '".$eTime."') or (`endtime` between '".$sTime."' and  '".$eTime."') and Subject='$sub' AND instrument = '$instrument'";
	
	$sql = "SELECT StartTime, EndTime FROM schedule_calendar WHERE starttime between '$sTime' and '$eTime' AND instrument = '$instrument' AND id!='$id'";
	$handle = mysql_query($sql);

	$sTime = php2MySqlTime(strtotime("+1 minute",js2PhpTime($st)));
	$eTime = php2MySqlTime(strtotime("-1 minute",js2PhpTime($et)));
	$cnt = 0;
	while($row = mysql_fetch_object($handle)) {
		if( strcmp($row->EndTime, $sTime)<0 || strcmp($eTime, $row->StartTime) < 0){
			
		} else {
			$cnt+=1;
			break;
		}
	}
	
	if($cnt > 0) {
		$ret['IsSuccess'] = false;
		$ret['Msg'] = "The times overlap with another booking. Please choose a different time";
		return $ret;
	}
	
	$time = split(" ",$st);
	
	$eTimes = split(" ", $et);
	
	$fromDate = date("Y", strtotime($st))."-".date("m", strtotime($st))."-".date("d", strtotime($st));
	$toDate = date("Y", strtotime($et))."-".date("m", strtotime($et))."-".date("d", strtotime($et));;
			
	$sql = "SELECT id FROM schedule_calendar WHERE Color=20 AND  STR_TO_DATE(starttime, '%Y-%m-%d') between STR_TO_DATE('$fromDate', '%Y-%m-%d') AND STR_TO_DATE('$toDate', '%Y-%m-%d')";
	$findDailyEvents = mysql_query($sql);
	
	//if the event ends before 9am or starts after 4.30pm, then it's off-peak, else it's peak
	$dayOfWeek = date("w", strtotime($st));
		  
	//if it is sat or sun or a full day event
	if($dayOfWeek==6 || $dayOfWeek==0 || mysql_num_rows($findDailyEvents)>0 || (strcmp($time[1], "16:30")>=0) || (strcmp($eTimes[1],"09:00")<=0)) {
		$Peak_Or_OffPeak = "Off-Peak";
	} else {
		$Peak_Or_OffPeak = "Peak";
	}
	
	$totalHours = getTotalHours($st, $et);
	
    $sql = "update `schedule_calendar` set"
      . " `starttime`='" . php2MySqlTime(js2PhpTime($st)) . "', "
      . " `endtime`='" . php2MySqlTime(js2PhpTime($et)) . "', `total_hours` = '$totalHours', `Peak_Or_OffPeak` = '$Peak_Or_OffPeak' "
      . "where `id`=" . $id;
    //echo $sql;
	if(mysql_query($sql)==false){
      $ret['IsSuccess'] = false;
      $ret['Msg'] = mysql_error();
    }else{
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'Updated Successfully';
    }
	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
    $db->closeConnection();
	return $ret;
}

function updateDetailedCalendar($id, $st, $et, $sd, $ed, $sub, $ade, $dscr, $loc, $color, $tz, $instrument){
  $ret = array();
  try{
	
	$st = removeAmPm($st);
	$et = removeAmPm($et);
	
	$st = $sd." ".$st;
	$et = $ed." ".$et;

    if($_SESSION['ClassLevel']>3){
		if($_SESSION['ClassLevel']>3){
			$checkPermission = checkPermission($sub, $instrument, $st, $et);
			if($checkPermission==false){
				$ret['IsSuccess'] = false;
				$ret['Msg'] = "You do not have Off-Peak priviledges";
				return $ret;
			}
	   }
		if(!checkHours($instrument, $sub, $st, $et, $id)) {
			$ret['IsSuccess'] = false;
			if(strcmp("JEOL JIB-4500 - FIB SEM",$instrument)==0) {
				$ret['Msg'] = "You can only book 4 hrs/day of peak time and 8 hrs/day of off-peak time in advance for this instrument";
			} else {
				$ret['Msg'] = "You can only book 4 hrs/week of peak time and 8 hrs/week of off-peak time in advance for this instrument";
			}
			return $ret;
		}
	}
	
	$db = new DBConnection();
    $db->getConnection();
	
	$sTime = php2MySqlTime(js2PhpTime($sd));
	$eTime = php2MySqlTime(strtotime("-1 minute",strtotime("+1 day",js2PhpTime($ed))));
	
	//$sql = "SELECT count(1) as Existing_Events FROM `schedule_calendar` WHERE (`starttime` between '".$sTime."' and '".$eTime."') or (`endtime` between '".$sTime."' and  '".$eTime."') and Subject='$sub' AND instrument = '$instrument'";
	
	$sql = "SELECT StartTime, EndTime FROM schedule_calendar WHERE starttime between '$sTime' and '$eTime' AND instrument = '$instrument' AND id!='$id'";
	$handle = mysql_query($sql);

	$sTime = php2MySqlTime(strtotime("+1 minute",js2PhpTime($st)));
	$eTime = php2MySqlTime(strtotime("-1 minute",js2PhpTime($et)));
	$cnt = 0;
	while($row = mysql_fetch_object($handle)) {
		if( strcmp($row->EndTime, $sTime)<0 || strcmp($eTime, $row->StartTime) < 0){
			
		} else {
			$cnt+=1;
			break;
		}
	}
	
	if($cnt > 0) {
		$ret['IsSuccess'] = false;
		$ret['Msg'] = "The times overlap with another booking. Please choose a different time";
		return $ret;
	}

	$time = split(" ",$st);
	
	$eTimes = split(" ", $et);
	
	$fromDate = date("Y", strtotime($st))."-".date("m", strtotime($st))."-".date("d", strtotime($st));
	$toDate = date("Y", strtotime($et))."-".date("m", strtotime($et))."-".date("d", strtotime($et));;
			
	$sql = "SELECT id FROM schedule_calendar WHERE Color=20 AND  STR_TO_DATE(starttime, '%Y-%m-%d') between STR_TO_DATE('$fromDate', '%Y-%m-%d') AND STR_TO_DATE('$toDate', '%Y-%m-%d')";
	$findDailyEvents = mysql_query($sql);
	
	//if the event ends before 9am or starts after 4.30pm, then it's off-peak, else it's peak
	$dayOfWeek = date("w", strtotime($st));
		  
	//if it is sat or sun or a full day event
	if($dayOfWeek==6 || $dayOfWeek==0 || mysql_num_rows($findDailyEvents)>0 || (strcmp($time[1], "16:30")>=0) || (strcmp($eTimes[1],"09:00")<=0)) {
		$Peak_Or_OffPeak = "Off-Peak";
	} else {
		$Peak_Or_OffPeak = "Peak";
	}
	$totalHours = getTotalHours($st, $et);
	
    $sql = "update `schedule_calendar` set"
      . " `starttime`='" . php2MySqlTime(js2PhpTime($st)) . "', "
      . " `endtime`='" . php2MySqlTime(js2PhpTime($et)) . "', "
      . " `subject`='" . mysql_real_escape_string($sub) . "', "
      . " `isalldayevent`='" . mysql_real_escape_string($ade) . "', "
      . " `description`='" . mysql_real_escape_string($dscr) . "', "
      . " `location`='" . mysql_real_escape_string($loc) . "', "
      . " `instrument`='" . mysql_real_escape_string($instrument) . "', "
      . " `color`='" . getColor($instrument) . "', "
	  . " `EmailId`='" . getEmailId(mysql_real_escape_string($sub)). "', `Total_Hours`='$totalHours', `Peak_Or_OffPeak`='$Peak_Or_OffPeak'"
      . "where `id`=" . $id;
    //echo $sql;
		if(mysql_query($sql)==false){
      $ret['IsSuccess'] = false;
      $ret['Msg'] = mysql_error();
    }else{
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'Updated Successfully';
    }
	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  $db->closeConnection();
  return $ret;
}

function removeCalendar($id){
  $ret = array();
  try{
    $db = new DBConnection();
    $db->getConnection();
	$sql = "select * from `schedule_calendar` where `id` = " . $id;
	$handle = mysql_query($sql);
    //echo $sql;
	$login=$_SESSION['login'];
    $row = mysql_fetch_object($handle);
	if($_SESSION['ClassLevel']>1 && $login != $row->Subject) {
		$ret['IsSuccess'] = false;
		$ret['Msg'] = "You can only delete your own event.";
		return $ret;
	}
	/*
	//currently, the admin doesn't want this to be activated.
	//this block checks if the event to be deleted is less than 24 hours before the event time.
	//if it is, then don't allow deletion.
	if($_SESSION['ClassLevel']>1){
		//time in secs/60 = time in mins/60 = time in hrs/24 = time in days
		$days = (strtotime($row->StartTime) - strtotime(date("Y-m-d H:m:s")))/60/60/24;
		 if($days<=1.0){
			  $ret['IsSuccess'] = false;
			  $ret['Msg'] = "Cannot delete schedules less than a day before the scheduled time";
			  return $ret;
		 }
	}*/
	
	$sql = "delete from `schedule_calendar` where `id`=" . $id;
	if(mysql_query($sql)==false){
      $ret['IsSuccess'] = false;
      $ret['Msg'] = mysql_error();
    }else{
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'Succefully';
    }
	}catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  $db->closeConnection();
  return $ret;
}




header('Content-type:text/javascript;charset=UTF-8');
$method = $_GET["method"];
$instru = $_GET['instrument'];
if($instru==""){
	$instru = $_POST['instrument'];
}
switch ($method) {
    case "add":
        $ret = addCalendar($_POST["instrument"], $_POST["CalendarStartTime"], $_POST["CalendarEndTime"], $_POST["CalendarTitle"], $_POST["IsAllDayEvent"]);
        break;
    case "list":
        $ret = listCalendar($_POST["showdate"], $_POST["viewtype"], $_POST["instrument"]);
        break;
    case "update":
        $ret = updateCalendar($_POST["calendarId"], $_POST["CalendarStartTime"], $_POST["CalendarEndTime"]);
        break; 
    case "remove":
        $ret = removeCalendar( $_POST["calendarId"]);
        break;
    case "adddetails":
		$sd = $_POST["stpartdate"];
		$ed = $_POST["etpartdate"];
        $st = $_POST["stparttime"];
        $et = $_POST["etparttime"];
        if(isset($_GET["id"])){
            $ret = updateDetailedCalendar($_GET["id"], $st, $et, $sd, $ed,
                $_POST["Subject"], isset($_POST["IsAllDayEvent"])?1:0, $_POST["Description"], 
                $_POST["Location"], $_POST["colorvalue"], $_POST["timezone"], $instru);
        }else{
            $ret = addDetailedCalendar($st, $et, $sd, $ed,
                $_POST["Subject"], isset($_POST["IsAllDayEvent"])?1:0, $_POST["Description"], 
                $_POST["Location"], $_POST["colorvalue"], $_POST["timezone"], $instru);
        }        
        break; 


}
echo json_encode($ret); 



?>