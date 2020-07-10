<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Xtractor</title>
    <meta content="" name="descriptison">
    <meta content="" name="keywords">
    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <!--  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
 -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.css"/>

<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.js"></script>



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>

<body>
    <a name='top' id='top'></a>

        <!--
        https://revrocket-static-aws.s3-us-west-2.amazonaws.com/system/assets/lib/js/iframe-resizer/js/iframeResizer.min.js
        -->
        <!--
        https://tinyurl.com/wfj6hw5
        -->





<div class='container main-c'>

<h1>Email Viewer</h1>


<?php
$ok = 1;
if (!$ok) {?>

 <form method="POST" style='width:400px;'>
    <div class='input-group'>
        <label class='input-group-addon'>Passphrase</label>
        <input class='form-control input-lg' value='' name='pphrase' placeholder='Type in the Passphrase' />
        <span class='input-group-addon'><button type='submit' class='btn btn-primary'><i class='fa fa-arrow-right'></i> Login</span>
    </div>
</form>


<?php
} else {
	?>



<!-- <div class='alert alert-info fixers' style=''>
    </div> -->


<!--

<div class='update'>
    </div>
    <input type="text" class='form-control' id='delete_ids' />
    <div class='' style='margin-bottom:10px;'>
<?php
for ($x = 1; $x < 15; $x++) {?>
<label class='btn btn-xs btn-default' >
    <input type='radio' name='csv'  class='check-csv' value='data-<?=$x?>' /> data-<?=$x?>
</label>

<?php
}?>
</div> <button class='btn btn-info' onclick='extract()'>Load/Display CSV</button>
<button class='btn btn-default' onclick='getfix()'>Fix/Retry Failed</button>
<button class='btn btn-primary chks' disabled onclick='get_supplier_data(0)'>Check Supplier</button>






-->


<table class='table' id="preview-data">
<tr><th>
    <td>Date</td>
    <td>Subject</td>
    <td>Sent to</td>
    <td>Message</td>
    <td>Status</td>
</th></tr>
    <?php

	foreach ($emails as $email) {
		$sentto = "";
		if (strpos($email->email_to, "a:") !== false) {
			$e = unserialize($email->email_to);
			$sentto = $e[0];
		} else {
			$sentto = $email->email_to;
		}

		$teaser = strip_tags($email->email_message);
		if (strlen($teaser) > 100) {
			$teaser = substr($teaser, 0, 100) . "...";
		}

		?>
<tr>
    <td> <?php echo date('F jS, Y g:a', strtotime($email->email_created)); ?> </td>
    <td><?=$email->email_subject?></td>
    <td><?=$sentto?></td>
    <td><?=$teaser?> <a href='/helper/extractor/show_email/<?=$email->email_id?>' target='_email'> Show Email</a></td>
    <td><?=$email->email_status?></td>
</tr>


        <?}?>
</table>
<!-- <div class='well' id='rep-log'></div>

</div>
 -->

 <?}?>

<style>
.ta{
    min-height:100px;
}

.ta-td{
    min-height:100px;
}

</style>





</body>

</html>