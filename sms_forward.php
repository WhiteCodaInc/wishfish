<?php
header('Content-Type: text/html');
?>
<Response>
  <Message to="<?=$_REQUEST['PhoneNumber']?>">
<?=htmlspecialchars(substr($_REQUEST['From'] . ": " . $_REQUEST['Body'], 0, 160))?>
  </Message>
</Response>