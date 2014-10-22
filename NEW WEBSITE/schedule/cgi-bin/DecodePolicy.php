<?php
echo "here<br/>";
include_once('pdf2text.php');
$docConverter = new PDF2Text();
$docConverter->setFilename("../docs/CEMMA_Policies.pdf");
echo "decoding...<br/>";
$docConverter->decodePDF();
echo "done<br/><br/>";
echo $docConverter->decodedtext;
?>