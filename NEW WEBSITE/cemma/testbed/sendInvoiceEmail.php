<?php
require_once ("dompdf/dompdf_config.inc.php");

#$html = '<html><body>' . '<p>Put your html here, or generate it with your favourite ' . 'templating system.</p>' . '</body></html>';
$html= $_POST['html'];
#$html = html_entity_decode($html);
#echo $html;

$dompdf = new DOMPDF();
#$dompdf -> set_base_path("/kunden/homepages/40/d209127057/htdocs/cemma/testbed/");
echo DOMPDF_DIR;
echo ' <br> ';
echo DOMPDF_TEMP_DIR;
$dompdf -> load_html($html);
$dompdf -> render();
echo $path;


// download fpdf class (http://fpdf.org)
#require("/fpd/fpdf.php");

// fpdf object
#$pdf = new FPDF();
// generate a simple PDF (for more info, see http://fpdf.org/en/tutorial/)
#$pdf->AddPage();
#$pdf->SetFont("Arial","B",14);
#$pdf->Cell(40,10, "this is a pdf example");


// email stuff (change data below)
$to = "scoent@gmail.com";
$from = "scoent@gmail.com";
$subject = "send email with pdf attachment";
$message = "<p>Please see the attachment.</p>";

// a random hash will be necessary to send mixed content
$separator = md5(time());

// carriage return type (we use a PHP end of line constant)
$eol = PHP_EOL;

// attachment name
$filename = "Invoice.pdf";

// encode data (puts attachment in proper format)
#$pdfdoc = $pdf->Output("", "S");
$pdfdoc = $dompdf->Output("", "S");
$attachment = chunk_split(base64_encode($pdfdoc));
// main header (multipart mandatory)
$headers  = "From: ".$from.$eol;
$headers .= "MIME-Version: 1.0".$eol;
$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"".$eol.$eol;
$headers .= "Content-Transfer-Encoding: 7bit".$eol;
$headers .= "This is a MIME encoded message.".$eol.$eol;
// message
$headers .= "--".$separator.$eol;
$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
$headers .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
$headers .= $message.$eol.$eol;
// attachment
$headers .= "--".$separator.$eol;
$headers .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol;
$headers .= "Content-Transfer-Encoding: base64".$eol;
$headers .= "Content-Disposition: attachment".$eol.$eol;
$headers .= $attachment.$eol.$eol;
$headers .= "--".$separator."--";

// send message
mail($to, $subject, "", $headers);

?>