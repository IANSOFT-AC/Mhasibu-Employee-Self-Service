<?php 


?>

<?php if($Attachmentmodel->getPath($Attachmentmodel->Document_No, $Attachmentmodel->Line_No)){   ?>

<iframe src="data:application/pdf;base64,<?= $Attachmentmodel->readAttachment($Attachmentmodel->Document_No, $Attachmentmodel->Line_No); ?>" height="950px" width="100%"></iframe>


<?php }  ?>