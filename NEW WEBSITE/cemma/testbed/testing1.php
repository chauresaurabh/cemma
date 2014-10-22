<?php
session_start();
$section = $_GET['section'];
if($section==""){
$section='objective';
}
?>
<html lang = "en-GB">
    <head>
        <meta charset = "utf-8">
        <title>Resume</title>
        <link rel = "stylesheet" type="text/css" href="resume-theme.css">
        <style type="text/css">
ul.nav { list-style-type: none; }
.nav { padding: 1em 1em; text-align: center; border-radius: 1em; -moz-border-radius: 1em; -webkit-border-radius: 1em; }
.nav li { display: inline; }
.nav li, .nav a { padding: 1ex 1em; border-radius: 1em; -moz-border-radius: 1em; -webkit-border-radius: 1em; }
html, body { background-color: #cde; color: #000; }
.nav { background-color: #fff; color: #424; }
.nav a, .nav a:visited, .nav:active { color: #424; }
.nav a:hover { background-color: #868; color: #fff; }
#active_section { background-color: #cde; }
.nav a { text-decoration: none; }
.nav { user-select: none; -webkit-user-select: none; -khtml-user-select: none; -moz-user-select: none; -o-user-select: none; }
</style>
    </head>
    <body>
    <header>
        <h1>Manvinder Singh </h1>
        <p class= "head"> (845)-554-8234 <a href = "mailto:manvinder.singh1@marist.edu">manvinder.singh1@marist.edu</a> </p>
        <address> 2904, Cherry Hill Drive,<br /> Poughkeepsie, 12603</address>
    </header>
        <ul class="nav">
    <li>
    <a href="testing1.php?section=objective">Objective</a>
    </li>
<li>
    <a href="testing1.php?section=edu">Education</a>
</li>
    <li>
    <a href="testing1.php?section=skills">Skills</a>
    </li>
    </ul>
        <div id="main">
    <? if($section == 'objective'){?>
    <h2 class="objective">Objective</h2> 
            <p id="goal">Ambitions and detailed-oriented Technical Support Analyst seeking a position in an organization to facilitate   
                                            timely and smooth operations involving in all facets of computer hardware and software.</p>
    <? } else if($section=='edu'){?>
        <div id="edu">
            <h2>Education</h2>
            <p><strong>MS in Information Technology</strong>, Marist, Poughkeepsie, NY <em>(Degree expected in 05/2014)</em></p>
            <p><strong>Bachelor of Science in Mathematics</strong>, State University of New York at New Paltz, <em>May 2012</em></p>
        </div>    
    <? } else if($section=='skills'){?>
        <div id="skills">
            <h2>Skills</h2>
            
            <h3>Technical</h3>
            
            
                <p><span>Operating Systems:</span> MS Windows 95/98/2000/XP/Vista/7, Mac OS</p>
                <p><span>Languages:</span> Java, Java Script, HTML, CSS, Google-MIT App Inventor,SQL</p>
                <p><span>Software:</span> MS Office 2007 (Word, Excel, PowerPoint, Outlook),Visio, MathCad, Mathematica</p>
                <p><span>Hardware:</span> Troubleshooting, experience repairing and reassembling computer components</p>
                
        </div>
    <? }?>    
    </div>
    </body>
</html>
