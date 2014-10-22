

						function alert()
						{
						}

						
						function lastMod( last ) 
						{
										 return 'Raed Shomali &copy; 2008 - <b>I am an exception, try to catch me !</b>';
						}


						function addPostfix( day )
						{
										switch( day )
										{
											case 1 : return day + "st" ;
											case 2 : return day + "nd" ;
											case 3 : return day + "rd" ;
											case 21 : return day + "st" ;
											case 22 : return day + "nd" ;
											case 23 : return day + "rd" ;
											case 31 : return day + "st" ;

											default : return day + "th" ;
										}
						}


						function convert( month )
						{
						 				 switch( month )
										 {
										 				 case 0 : return 'Jan' ;
										 				 case 1 : return 'Feb' ;
										 				 case 2 : return 'Mar' ;
										 				 case 3 : return 'Apr' ;
										 				 case 4 : return 'May' ;
										 				 case 5 : return 'June' ;
										 				 case 6 : return 'July' ;
										 				 case 7 : return 'Aug' ;
										 				 case 8 : return 'Sep' ;
										 				 case 9 : return 'Oct' ;
										 				 case 10 : return 'Nov' ;
										 				 case 11 : return 'Dec' ;
										 }
						}
						
						var name = "" ;
						
						function loadRows( rowName , end )
						{
						 				 array = new Array( end ) ;
										 
										 // Name ID
						 				 name = rowName ;
						
										 for( var i = 0 ; i < end ; i ++ )
										 {		
										 			// Default Open and Closed 
													
													if( name != "poem" )
													{
													 		array[ i ] = i == 0 ? 0 : 1 ;
													}
													else
													{
										 			 		array[ i ] = 1 ;
													}
													
										 			switch_row( i , end - i ) ;
										 }
						}
						
						function switch_row( row , id )
   					{
						 				 if( array[ row ] == 1 )
										 {
										 		 document.getElementById( name + id + 'Content').style.display = 'none';
												 document.getElementById( name + id + 'Sign').src = 'Icons/plus.gif';
												 document.getElementById( name + id + 'Color').style.backgroundColor = '#025580';
												 
												 // Update Value
												 array[ row ] = 0 ;
										 }
										 else
										 {
										 		 document.getElementById( name + id + 'Content').style.display = '';
												 document.getElementById( name + id + 'Sign').src = 'Icons/minus.gif';
												 document.getElementById( name + id + 'Color').style.backgroundColor = '#025580';
												 
												 // Update Value
												 array[ row ] = 1 ;
										 }
   					}
