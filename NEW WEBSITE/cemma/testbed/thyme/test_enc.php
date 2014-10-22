<?php
/*

IONCUBE TESTS

*/

$nl =  ((php_sapi_name() == 'cli') ? "\n" : '<br>');

$ok = true;
$already_installed = false;
$can_install = false;
$no_ini = false;

//
// Where are we?
//
$here = dirname(__FILE__);

//
// Is the loader already installed?
//

if (extension_loaded('ionCube Loader')) {
  $already_installed = true;
}

$io_installed = $already_installed;

$errs = array();




?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><title>Thyme Compatibility Test</title>
<style type='text/css'>
body { font-family: tahoma; font-size: 12px; }
body a { color: #aa0000; }
h4 { color: #aa0000; }
table.testtable { background: #fff; font-size: 12px; border-spacing: 2px; }
table.testtable td { background: #eee; padding: 4px; width: 99%; text-align: left; }
table.testtable th { background: #006699; color: #fff; padding: 4px; text-align: left; }
.passed { color: #090; font-weight: bold; }
.failed { color: #c00; font-weight: bold; }
ul li { padding: 4px; margin-bottom: 4px; }
h4.compat { border: 1px solid #000; background: #0b0; color: #fff; padding: 4px; text-align: center; margin-bottom: 1px; }
div.compat { background: #efffef; }
h4.incompat { border: 1px solid #000; background: #a33;
   color: #fff; padding: 4px; text-align: center; margin-bottom: 1px; }
div.incompat { background: #fee; }
div.incompat p, div.compat p, div.compat, div.incompat { padding: 2px; }
div.copyr { margin: 8px; padding: 8px; text-align: right; font-size: 10px; }
</style>
</head>
<body>
<!---------

TESTS

-------->
<div align='center'>
<div style='width: 85%; text-align: left;'>

<h3 align='center'>Thyme Compatibility Test</h3>

<table align='center' width='100%' class='testtable'>
<tbody>
<?php
/* PHP VERSION CHECK */
$test = explode('.',phpversion());
$test = ($test[0] > 4 || ($test[0] == 4 && $test[1] >= 3));

$php_passed = ($test);

$test = ($test   ? "<span class='passed'>Passed</span>"
   : "<span class='failed'>Failed >= 4.3.0 required</span>");
?>
<tr><th nowrap>PHP Version</th><td><?php echo($test . ' ('.phpversion().')') ?></td></tr>
<?php

/* ZEND OPTIMIZER CHECK */

$zend_passed = (function_exists('zend_loader_enabled')
   && zend_loader_enabled());

$test = ((function_exists('zend_loader_enabled')
   && zend_loader_enabled())
   ? "<span class='passed'>Passed</span>"
   : "<span class='failed'>Failed - Zend Optimizer is not installed.</span><p>
   Zend Optimizer can be downloaded from <a href='http://www.zend.com/en/products/guard/optimizer/' target=_blank>http://www.zend.com</a>.");

?>
<tr><th nowrap>Zend Optimizer</th><td><?php echo($test) ?></td></tr>
<?php

/* IONCUBE CHECK */
$sys_info = ic_system_info();

$dl_required = false;

ob_start();
if (!$already_installed) {
  if ($sys_info['THREAD_SAFE'] && !$sys_info['CGI_CLI']) {
    $errs[] = "Your PHP install appears to have threading support and run-time Loading
is only possible on threaded web servers if using the CGI, FastCGI or
CLI interface.$nl${nl}To run encoded files please install the Loader in the php.ini file.$nl";   
    $ok = false;
  }

  if ($sys_info['DEBUG_BUILD']) {
    $errs[] = "Your PHP installation appears to be built with debugging support
enabled and this is incompatible with ionCube Loaders.$nl${nl}Debugging support in PHP produces slower execution, is
not recommended for production builds and was probably a mistake.${nl}${nl}You should rebuild PHP without the --enable-debug option and if
you obtained your PHP install from an RPM then the producer of the
RPM should be notified so that it can be corrected.$nl";
    $ok = false;
  }

  //
  // Check safe mode and for a valid extensions directory
  //
  if (ini_get('safe_mode')) {
    $errs[] = "PHP safe mode is enabled and run time loading will not be possible.$nl";
    $ok = false;
  }
    elseif (!is_dir(realpath(ini_get('extension_dir')))) {
    echo "The setting of extension_dir in the php.ini file is not a directory
    or may not exist and run time loading will not be possible. You do not need
    write permissions on the extension_dir but for run-time loading to work
    a path from the extensions directory to wherever the Loader is installed
    must exist.$nl";
    $ok = false;
    }


  // If ok to try and find a Loader
if ($ok) {
    //
    // Look for a Loader
    //

    $can_install = true;
    // Old style naming should be long gone now
    $test_old_name = false;

    $_u = php_uname();
    $_os = substr($_u,0,strpos($_u,' '));
    $_os_key = strtolower(substr($_u,0,3));

    $_php_version = phpversion();
    $_php_family = substr($_php_version,0,3);

    $_loader_sfix = (($_os_key == 'win') ? '.dll' : '.so');

    $_ln_old="ioncube_loader.$_loader_sfix";
    $_ln_old_loc="/ioncube/$_ln_old";

    $_ln_new="ioncube_loader_${_os_key}_${_php_family}${_loader_sfix}";
    $_ln_new_loc="/ioncube/$_ln_new";

#    echo "${nl}Looking for Loader '$_ln_new'";
    if ($test_old_name) {
#      echo " or '$_ln_old'";
    }
#    echo $nl.$nl;

    $_extdir = ini_get('extension_dir');
    if ($_extdir == './') {
      $_extdir = '.';
    }

    $_oid = $_id = realpath($_extdir);

    $_here = dirname(__FILE__);
    if ((@$_id[1]) == ':') {
      $_id = str_replace('\\','/',substr($_id,2));
      $_here = str_replace('\\','/',substr($_here,2));
    }
    $_rd=str_repeat('/..',substr_count($_id,'/')).$_here.'/';

    if ($_oid !== false) {
      #echo "Extensions Dir: $_extdir ($_id)$nl";
      #echo "Relative Path:  $_rd$nl";
    } else {
      #echo "Extensions Dir: $_extdir (NOT FOUND)$nl$nl";

      $errs[] = "The directory set for the extension_dir entry in the
php.ini file may not exist, and run time loading will not be possible.
The system administrator should create the $_extdir directory,
or install the Loader in the php.ini file.$nl";
      $ok = false;
    }

    if ($ok) {

      $no_ini = true;

      $_ln = '';
      $_i=strlen($_rd);


      while($_i--) {
   if($_rd[$_i]=='/') {
     if ($test_old_name) {
       // Try the old style Loader name
       $_lp=substr($_rd,0,$_i).$_ln_old_loc;
       $_fqlp=$_oid.$_lp;
       if(@file_exists($_fqlp)) {
         echo "Found Loader:   $_fqlp$nl";
         $_ln=$_lp;
         break;
       }
     }
     // Try the new style Loader name
     $_lp=substr($_rd,0,$_i).$_ln_new_loc;
     $_fqlp=$_oid.$_lp;
     if(@file_exists($_fqlp)) {
       echo "Found Loader:   $_fqlp$nl";
       $_ln=$_lp;
       break;
     }
   }
      } // </while>

      //
      // If Loader not found, try the fallback of in the extensions directory
      //
      if (!$_ln) {
   if ($test_old_name) {
     if (@file_exists($_id.$_ln_old_loc)) {
       $_ln = $_ln_old_loc;
     }
   }
   if (@file_exists($_id.$_ln_new_loc)) {
     $_ln = $_ln_new_loc;
   }

   if ($_ln) {
     echo "Found Loader $_ln in extensions directory.$nl";
   }
      }

      #echo $nl;

      if ($_ln) {
   echo "Trying to install Loader - this may produce an error...$nl$nl";
   dl($_ln);

   if(extension_loaded('ionCube Loader')) {
      
     echo "The Loader was successfully installed and encoded files should be able to
automatically install the Loader when needed.${nl}";
     
          $io_installed = true;
   } else {
     #echo "The Loader was not installed.$nl";
          $io_installed = false;
   }
      } else {
   #echo "Run-time loading should be possible on your system but no suitable Loader was found.$nl$nl";
   
   $dl_required_dl = "$_os Loader"; # for PHP $_php_family";
        $io_installed = false;
       $dl_required = true;
      }
    }

  // IONCUBE is possibe, but no extensions have been found
  } else {

     # print_r($errs);
     $can_install = false;

  }

} else if($already_installed) {

   $can_install = true;

// IONCUBE loader is not possible without php.ini modification
} else {

   # print_r($errs);
   $can_install = false;
}

$inf = ob_get_contents();
ob_end_clean();

$ioncube_passed = $ok;

if($ok) {
   $test = "<span class='passed'>Passed</span>". ($inf ? "<p>".$inf."</p>" : "");

   if(!$zend_passed && $dl_required) {
   $test .="<p><i>Though run-time loading of IonCube is possible, you must
   still download and install the IonCube loader.</i></p>
   <p><ol><li>Download the
   <b>{$dl_required_dl}</b> from <a
      href='http://www.ioncube.com/loaders.php' target=_blank
   >http://www.ioncube.com/loaders.php</a> (free)</li>
   <li>Unzip the loaders file</li>
   <li>Upload the resulting folder (<b>ioncube</b>) to your web server</li>
   </ol>
   </p>

"; }
   
} else {

$test = "<span class='failed'>Failed</span><p>".$inf."</p>".
   (count($errs) ? "<p>Additional info:</p><ul><li>".join('</li><li>',$errs).'</li></ul><p>'
   : '');;


}
?>
<tr><th nowrap>IonCube Loader</th><td><?php echo($test) ?></td></tr>

<?php if(!($zend_passed && $ioncube_passed)): ?>
<tr><td colspan=2 style='text-align: center'><i>Thyme 
requires either IonCube Loader <b>or</b> Zend Optimizer - not both.</i></td></tr>
<?php endif; ?>

</tbody>
</table>
<!--

OVERALL COMPATIBILITY

-->
<?php

#$php_passed
#$zend_passed
#$ioncube_passed

$compat = $php_passed && ($zend_passed || $ioncube_passed);

$zend_ion = ($zend_passed ? 'zend' : 'ioncube');
?>
<?php if($compat): ?>
<h4 class='compat'>Compatibility Passed</h4>
<div class='compat'>
<?php if(!$zend_passed && $dl_required): ?>
<p><i>NOTE: you must still follow the steps above to download
the IonCube loader.</i></p>
<?php endif ?>
<p>You may download and use the <b><?php echo(ucfirst($zend_ion)) ?></b> version of Thyme
 using
the zip file <i><b>or</b></i> Windows installer</p>
<ul>
<li><a href='http://www.thymenews.com/download/trial_download.ioncube.zip'>Zip File</a> - A compressed (zipped) file containing Thyme
<p>
<ol>
<li>Download the zip file by clicking on the Zip File link above.</li>
<li>Unzip the downloaded file.</li>
<li>( <b><i>Optional</i></b> ) Rename the resulting folder thyme-1.3-ioncube>) to something more applicable to your environment. E.g. <i>calendar</i>, <i>events</i>, <i>agenda</i>, <i>thyme</i> etc.</li>
<li>Upload the folder to the public html folder on your web server. The name of the
public html folder
can vary from one hosting provider to another. In most cases it is named <i>public_html</i> or <i>www</i>.</li>
<li>Navigate to the folder in a web browser. E.g. go to
   <i>http://your.site.com/calendar/</i>.</li>
<li>Thyme will guide you through its web-based installation.</li>
</ol>
</p>

</li>
<li><a href='http://www.thymenews.com/download/trial_download.ioncube.exe'>Windows Installer</a> - An installation program that will install Thyme to your web
server from your Windows PC
<p>
<ol>
<li>Download the installer by clicking on the Windows Installer link above.</li>
<li>Locate and run the installer (thyme-1.3-<?php echo($zend_ion); ?>.exe).</li>
<li>The installer will guide you through installing Thyme.</li>
</ol>

</li>
</ul>

</div>




<?php else: ?>
<h4 class='incompat'>Compatibilty Failed</h4>
<div class='incompat'>
<p>
You should ask your hosting provider to install the required software
or make the required changes. Most servers
should be compatible with both Zend Optimizer and IonCube. These can easily 
be installed in a few minutes. 
</p>
<p>Zend Optimizer and / or IonCube loader is a requirement for most commercial PHP software.
</p>
<p><i>Using XAMPP</i> (if you are unsure, then you probably are not)?

    You already have the Zend Optimizer installed!
Click <a href='http://www.thymenews.com/FAQs/Installation/Enabling_Zend_Optimizer_in_XAMPP/'
target=_blank>here</a> for instructions on how to enable it
</p>

</div>
<?php endif ?>
<!--

   ENCODING DESCRIPTION
-->
<h4>Why do I need IonCube or Zend Optimizer?</h4>
<p>Some of Thyme's PHP source files are encoded. This is very common for commercial PHP software.
Files are encoded is to protect intellectual property and not to prohibit
you from customizing Thyme. In fact, most of Thyme's files are not
encoded and allow for full customization.<p>
<p>These encoded
files require either IonCube or Zend Optimizer to be installed on your server so
that they can be decoded and run.</p>

</div></div>
<br /><br /><br /><div class='copyr'>&copy; 2008
<a href='http://www.thymenews.com' target=_blank>eXtrovert Software LLC</a></div>
</body>
</html>
<?php
/*

IONCUBE SUPPORTING FUNCTIONS

*/

function ic_system_info()
{
  $thread_safe = false;
  $debug_build = false;
  $cgi_cli = false;
  $php_ini_path = '';

  ob_start();
  phpinfo(INFO_GENERAL);
  $php_info = ob_get_contents();
  ob_end_clean();

  foreach (split("\n",$php_info) as $line) {
    if (eregi('command',$line)) {
      continue;
    }

    if (eregi('thread safety.*(enabled|yes)',$line)) {
      $thread_safe = true;
    }

    if (eregi('debug.*(enabled|yes)',$line)) {
      $debug_build = true;
    }

    if (eregi("configuration file.*(</B></td><TD ALIGN=\"left\">| => |v\">)([^ <]*)(.*</td.*)
?",$line,$match)) {
      $php_ini_path = $match[2];

      //
      // If we can't access the php.ini file then we probably lost on the match
      //
      if (!@file_exists($php_ini_path)) {
   $php_ini_path = '';
      }
    }

    $cgi_cli = ((strpos(php_sapi_name(),'cgi') !== false) ||
      (strpos(php_sapi_name(),'cli') !== false));
  }

  return array('THREAD_SAFE' => $thread_safe,
          'DEBUG_BUILD' => $debug_build,
          'PHP_INI'     => $php_ini_path,
          'CGI_CLI'     => $cgi_cli);
}

