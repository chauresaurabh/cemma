/*
 (c) Ger Versluis 2000 version 9.10 14 October 2002
 You may use this script on non commercial sites.
 For info write to menus@burmees.nl
 You may remove all comments for faster loading*
*/
	var NoOffFirstLineMenus=6; //set number of main menu items
	var LowBgColor='#666666';
	var HighBgColor='#990000';
	var FontLowColor='#ffffff';
	var FontHighColor='#ffffff';
	var BorderColor='#d1d1a5';
	var FontFamily="verdana,arial";
	var FontSize=9;
	var FontBold=1;
	var FontItalic=0;
	var BorderWidthMain=10;
	var BorderWidthSub=1;
	var BorderBtwnMain=1;
	var BorderBtwnSub=1;
	var FontItalic=0;
	var MenuTextCentered="left";
	var MenuCentered="center";
	var MenuVerticalCentered="top";
	var ChildOverlap=.3;
	var ChildVerticalOverlap=.3;
	var StartTop=0;
	var StartLeft=.05;
	var VerCorrect=0;
	var HorCorrect=0;
	var LeftPaddng=5;
	var TopPaddng=2;
	var FirstLineHorizontal=0;
	var MenuFramesVertical=1;
	var DissapearDelay=1000;
	var UnfoldDelay=100;
	var TakeOverBgColor=1;
	var FirstLineFrame="contents";
	var SecLineFrame="main";
	var DocTargetFrame="main";
	var TargetLoc="";
	var MenuWrap=1;
	var RightToLeft=0;
	var BottomUp=0;
	var UnfoldsOnClick=0;
	var BaseHref=document.location.href.substring(0,document.location.href.lastIndexOf("/")+1);
	var Arrws=[BaseHref+"_images/tri.gif",5,10,BaseHref+"_images/tridown.gif",10,5,BaseHref+"_images/trileft.gif",5,10,BaseHref+"_images/triup.gif",10,5];
	var MenuUsesFrames=1;
	var RememberStatus=0;
	var PartOfWindow=.75;
	var BuildOnDemand=1;
	var MenuSlide="progid:DXImageTransform.Microsoft.GradientWipe(duration=.2, wipeStyle=1)";
	var MenuShadow="progid:DXImageTransform.Microsoft.DropShadow(color=#888888, offX=3, offY=2, positive=1)";
	var MenuOpacity="progid:DXImageTransform.Microsoft.Alpha(opacity=85)";

	var brows=navigator.userAgent.toLowerCase();
	if(	brows.indexOf('netscape')!= -1 && brows.indexOf('7.')!= -1) { //if netscape 7
			var StartTop=20; //set vertical offset
			var StartLeft=-8; //set horizontal offset
		 }
	 else if( brows.indexOf('netscape')!= -1 && brows.indexOf('6.')!= -1) { //if netscape 6
			var StartTop=20; //set vertical offset
			var StartLeft=0; //set horizontal offset
		 }
	else
		{	var StartTop=20; //set vertical offset
			var StartLeft=0; //set horizontal offset
		 	
		}

function BeforeStart(){return}
function AfterBuild(){return}
function BeforeFirstOpen(){return}
function AfterCloseAll(){return}

Menu1=new Array("GENERAL","","",3,24,140,"maroon","gold","gold","maroon","","",-1,-1,-1,"","General");
	Menu1_1=new Array("Background","background.html","",0,20,124,"maroon","gold","gold","maroon","","",-1,-1,-1,"","CEMMA Background");
	Menu1_2=new Array("Mission Statement","mission.html","",0,20,124,"maroon","gold","gold","maroon","","",-1,-1,-1,"","Mission Statement");
	Menu1_3=new Array("Future Plans","future_plans.html","",0,20,124,"maroon","gold","gold","maroon","","",-1,-1,-1,"","Future Plans");

Menu2=new Array("INSTRUMENTS","","",2,24,140,"maroon","gold","gold","maroon","","",-1,-1,-1,"","Instruments");
	Menu2_1=new Array("Introduction","instruments.html","",0,20,124,"maroon","gold","gold","maroon","","",-1,-1,-1,"","Program");
	// Menu2_2=new Array("Status","javascript:StanWin1=window.open(\"update.html\",\"Stan1\");window[\"StanWin1\"].focus()","",0,20,124,"maroon","gold","gold","maroon","","",-1,-1,-1,"","Update");
	Menu2_2=new Array("Status","update.html","",0,20,124,"maroon","gold","gold","maroon","","",-1,-1,-1,"","Update");

Menu3=new Array("ACTIVITIES","","",3,24,140,"maroon","gold","gold","maroon","","",-1,-1,-1,"","Teaching and Research");
	Menu3_1=new Array("Research","research.html","",0,20,124,"maroon","gold","gold","maroon","","",-1,-1,-1,"","Research");
	Menu3_2=new Array("Teaching","teaching.html","",0,20,124,"maroon","gold","gold","maroon","","",-1,-1,-1,"","Teaching");
	Menu3_3=new Array("Courses","courses.html","",0,20,124,"maroon","gold","gold","maroon","","",-1,-1,-1,"","Courses");

Menu4=new Array("PEOPLE","","",2,24,140,"maroon","gold","gold","maroon","","",-1,-1,-1,"","People");
	Menu4_1=new Array("Executive Committee","executive.html","",0,20,124,"maroon","gold","gold","maroon","","",-1,-1,-1,"","Executive committee");
	Menu4_2=new Array("Staff","staff.html","",0,20,124,"maroon","gold","gold","maroon","","",-1,-1,-1,"","People");

Menu5=new Array("SIGN UP","javascript:StanWin=window.open(\"signup.htm\",\"Stan\");window[\"StanWin\"].focus()","",0,24,140,"maroon","gold","gold","maroon","","",-1,-1,-1,"","Sign up instruments");
	
Menu6=new Array("CONTACT","","",2,24,140,"maroon","gold","gold","maroon","","",-1,-1,-1,"","Contact");
	Menu6_1=new Array("Location","location.html","",0,20,124,"maroon","gold","gold","maroon","","",-1,-1,-1,"","Location");
	Menu6_2=new Array("Contact us","contact_us.html","",0,20,124,"maroon","gold","gold","maroon","","",-1,-1,-1,"","Contact Info");
