 
	var NoOffFirstLineMenus=5;			// Number of first level items
	var LowBgColor='#990000';			// Background color when mouse is not over
	var LowSubBgColor='#1A1C1B';			// Background color when mouse is not over on subs
	var HighBgColor='#990000';			// Background color when mouse is over
	var HighSubBgColor='#990000';			// Background color when mouse is over on subs
	var FontLowColor='white';			// Font color when mouse is not over
	var FontSubLowColor='white';			// Font color subs when mouse is not over
	var FontHighColor='yellow';			// Font color when mouse is over
	var FontSubHighColor='white';			// Font color subs when mouse is over
	var BorderColor='990000';			// Border color
	var BorderSubColor='black';			// Border color for subs
	var BorderWidth=1;				// Border width
	var BorderBtwnElmnts=1;			// Border between elements 1 or 0
	var FontFamily="tahoma,comic sans ms,technical"	// Font family menu items
	var FontSize=8;				// Font size menu items
	var FontBold=1;				// Bold menu items 1 or 0
	var FontItalic=0;				// Italic menu items 1 or 0
	var MenuTextCentered='center';			// Item text position 'left', 'center' or 'right'
	var MenuCentered='center';			// Menu horizontal position 'left', 'center' or 'right'
	var MenuVerticalCentered='top';		// Menu vertical position 'top', 'middle','bottom' or static
	var ChildOverlap=.2;				// horizontal overlap child/ parent
	var ChildVerticalOverlap=.2;			// vertical overlap child/ parent
	var StartTop=77;				// Menu offset x coordinate
	var StartLeft=0;				// Menu offset y coordinate
	var VerCorrect=0;				// Multiple frames y correction
	var HorCorrect=0;				// Multiple frames x correction
	var LeftPaddng=0;				// Left padding
	var TopPaddng=2;				// Top padding
	var FirstLineHorizontal=1;			// SET TO 1 FOR HORIZONTAL MENU, 0 FOR VERTICAL
	var MenuFramesVertical=1;			// Frames in cols or rows 1 or 0
	var DissapearDelay=1000;			// delay before menu folds in
	var TakeOverBgColor=1;			// Menu frame takes over background color subitem frame
	var FirstLineFrame='navig';			// Frame where first level appears
	var SecLineFrame='space';			// Frame where sub levels appear
	var DocTargetFrame='space';			// Frame where target documents appear
	var TargetLoc='';				// span id for relative positioning
	var HideTop=0;				// Hide first level when loading new document 1 or 0
	var MenuWrap=1;				// enables/ disables menu wrap 1 or 0
	var RightToLeft=0;				// enables/ disables right to left unfold 1 or 0
	var UnfoldsOnClick=0;			// Level 1 unfolds onclick/ onmouseover
	var WebMasterCheck=0;			// menu tree checking on or off 1 or 0
	var ShowArrow=0;				// Uses arrow gifs when 1
	var KeepHilite=1;				// Keep selected path highligthed
	var Arrws=['tri.gif',5,10,'tridown.gif',10,5,'trileft.gif',5,10];	// Arrow source, width and height
 
function BeforeStart(){return}
function AfterBuild(){return}
function BeforeFirstOpen(){return}
function AfterCloseAll(){return}
 
// Menu tree
//	MenuX=new Array(Text to show, Link, background image (optional), number of sub elements, height, width);
//	For rollover images set "Text to show" to:  "rollover:Image1.jpg:Image2.jpg"
 
Menu1=new Array("Home","myhome.php","",0,22,160);
 
Menu2=new Array("Instruments","","",3);
	Menu2_1=new Array("View Instrument","view_instrument.php","",0,22,163);	
	Menu2_2=new Array("Add Instrument","add_instrument.php","",0);
	Menu2_3=new Array("Modify Instrument","modify_instrument.php","",0);
	
 
Menu3=new Array("Customers","","",3);

	Menu3_1=new Array("View Customer","view_customer.php","",0,22, 163);
	Menu3_2=new Array("Add Customer","add_customer.php","",0,22);
	Menu3_3=new Array("Modify Customer","modify_customer.php","",0,22);
	
	
 
Menu4=new Array("Invoice","","",3);
	Menu4_1=new Array("Generate Invoice","generate_invoice.php","",0,22,163);
	Menu4_2=new Array("Add a record","add_record.php","",0);
	Menu4_3=new Array("View Records/Invoices","view_records.php","",0);
	
	
Menu5=new Array("Statistics","statistics.php","",0, 22,120);
	


