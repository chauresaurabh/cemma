<?
include_once('constants.php');
include_once(DOCUMENT_ROOT."includes/checklogin.php");
include_once(DOCUMENT_ROOT."includes/checkadmin.php");
if($class != 1 || $ClassLevel==3 || $ClassLevel==4){
	//header('Location: login.php');
}
include (DOCUMENT_ROOT.'tpl/header.php');

include_once("includes/instrument_action.php");

?>

<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td class="body" valign="top" align="center"><table border="0" cellpadding="0" cellspacing="0" align="center">
        <tr>
          <td class="body_resize">
          <table border="0" cellpadding="0" cellspacing="0" align="center">
              <tr>
                <td class="left" valign="top"><?	include (DOCUMENT_ROOT.'tpl/admin-loged-in.php'); ?>
                </td>
                <td>
                <table width="100%" border="0" cellpadding="5" cellspacing="0">
                    <tr>
                      <td class="t-top"><div class="title2">Upload Manuals</div></td>
                    </tr>
                    <tr>
                      <td class="t-mid">
                      <table>
                      <tr>
                        <form action="http://cemma-usc.net/schedule/cgi-bin/upload.php" method="post" enctype="multipart/form-data">
                        <td>
                        <label for="file">JSM 7001 Manual:</label>
                        <input type="hidden" value="7001" name="manual"/>
                        </td><td>
                        <input type="file" name="file" id="file">&nbsp;&nbsp;
                        </td><td><input type="submit" name="submit" value="Submit"/></td>
                        </form>
                        </tr>
                        <tr>
                        <form action="http://cemma-usc.net/schedule/cgi-bin/upload.php" method="post" enctype="multipart/form-data">
                        <td>
                        <label for="file">JEOL 2100F Diffraction Manual:</label>
                        <input type="hidden" value="diff" name="manual"/>
                        </td><td><input type="file" name="file" id="file">&nbsp;&nbsp;
                        </td><td><input type="submit" name="submit" value="Submit"></td>
                        </form></tr>
                        <tr>
                        <form action="http://cemma-usc.net/schedule/cgi-bin/upload.php" method="post" enctype="multipart/form-data">
                        <td><label for="file">JEOL 2100 TEM Start up and alignment Manual:</label>
                        <input type="hidden" value="start" name="manual"/>
                        </td><td><input type="file" name="file" id="file">&nbsp;&nbsp;
                        </td><td><input type="submit" name="submit" value="Submit"></td>
                        </form></tr>
                        <tr>
                        <form action="http://cemma-usc.net/schedule/cgi-bin/upload.php" method="post" enctype="multipart/form-data">
                        <td><label for="file">JEOL 2100F STEM Manual:</label>
                        <input type="hidden" value="stem" name="manual"/></td><td>
                        <input type="file" name="file" id="file">&nbsp;&nbsp;
                        </td><td><input type="submit" name="submit" value="Submit"></td>
                        </form></tr>
                        <tr>
                        <form action="http://cemma-usc.net/schedule/cgi-bin/upload.php" method="post" enctype="multipart/form-data">
                        <td><label for="file">Single tilt Holder Manual:</label>
                        <input type="hidden" value="tilt" name="manual"/></td><td>
                        <input type="file" name="file" id="file">&nbsp;&nbsp;
                        </td><td><input type="submit" name="submit" value="Submit"></td>
                        </form></tr>
                        
                        
                          <tr>
                        <form action="http://cemma-usc.net/schedule/cgi-bin/upload.php" method="post" enctype="multipart/form-data">
                        <td>
                        <label for="file">TEST MANUAL</label>
                        <input type="hidden" value="cemmatestmanual" name="manual"/>
                        </td><td><input type="file" name="file" id="file">&nbsp;&nbsp;
                        </td><td><input type="submit" name="submit" value="TEST MANUAL"></td>
                        </form></tr>
                        
                        </table>
                      </td>
                     </tr>
                     <tr>
                      <td class="t-bot2">&nbsp;</td>
                    </tr>
                </table>
	           </td>
            </tr>
         </table>
         </td>
       </tr>
    </table>
  </td>
  </tr>
  </table>
  

</body>
</html>
