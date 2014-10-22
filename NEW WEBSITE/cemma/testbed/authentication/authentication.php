<?php

	if(!isset($_SESSION))
		session_start();

	$GLOBALS['invalid'];
	
 	include_once ("../includes/database.php");
 
        $username =  $_POST['username'];
        $password =  $_POST['password'];
		
		$sql = "SELECT Uname,Passwd,Manager_ID,ClassLevel,Customer_ID  FROM Customer where Uname = '$username'";
		$result = mysql_query($sql,$connection);
		if(mysql_num_rows($result)==0){


			$sql2 = "SELECT UserName,Passwd,Class,UserClass,ActiveUser,Email, ResponseEmail FROM user where UserName = '$username'";
			$result2 = mysql_query($sql2,$connection);
			if(mysql_num_rows($result2)==0){
				$invalid = "error_login";
				header('Location: ../login.php?'.$invalid);
			}
			else
			{
				$row = mysql_fetch_assoc($result2);
				if($row['UserName'] == $username && $row['Passwd'] == $password){
					if($row['ResponseEmail']!='Pending')
					//if($row['ActiveUser']='active' || $row33['ActiveUser']=NULL)
					{
						$_SESSION['login'] = $row['UserName'];
						$_SESSION['password'] = $row['Passwd'];
						$_SESSION['mid'] = 1;
						//$_SESSION['Cust_ID_of_Manager']= $row['Customer_ID'];
						
						if($row['UserClass']==1)
						{
							$_SESSION['ClassLevel']= 1;
						}
						if($row['UserClass']==2)
						{
							$_SESSION['ClassLevel']= 2;
						}
						if($row['UserClass']==3)
						{
							$_SESSION['ClassLevel']= 3;
						}
						if($row['UserClass']==5)
						{
							$_SESSION['ClassLevel']= 5;
						}
						if($row['UserClass']==4 || $row['UserClass']==NULL)
						{
							$_SESSION['ClassLevel']= 4;
						}
						//$_SESSION['AdminClass']= $row['Class'];
					
						$_SESSION['User']='User';
						//$_SESSION['Customer_ID']= $row['Customer_ID'];
					
						header('Location: ../membersusers.php');
					}
					else
					{
						$email = $row['Email'];
						header('Location: http://cemma-usc.net/cemma/testbed/UpdateStatus.php?email='.$email.'&first=true&showlogin=true');
					}
				}

				else{
					$invalid = "error_login";
					header('Location: ../login.php?'.$invalid);
				}

			}
		}
		
		else{
			$row = mysql_fetch_assoc($result);
			if($row['Uname'] == $username && $row['Passwd'] == $password){
				$_SESSION['login'] = $row['Uname'];
				$_SESSION['password'] = $row['Passwd'];
				$_SESSION['mid'] = $row['Manager_ID'];
				//$_SESSION['Cust_ID_of_Manager']= $row['Customer_ID'];
				$_SESSION['ClassLevel']= $row['ClassLevel'];
				$_SESSION['Customer_ID']= $row['Customer_ID'];
				
				header('Location: ../members.php');

			}

			else{
				$invalid = "error_login";
				header('Location: ../login.php?'.$invalid);
			}

		
		}
		
		mysql_close($connection);

?>