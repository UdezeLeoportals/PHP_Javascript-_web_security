<?php require_once("./includes/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {redirect_to("./login.php"); }; ?>
<?php
echo add_header($session->username, $session->type);//#782645
?>
<head><title>Result System - Student Cases</title>
<style>
		
	A{
        color: #1c001c;
        background: #f8f7df;
    }
    a:hover{
	color: #2f3ffd;
    }
    .header{
	background:#591434 ;
    }
    td{
	min-width: 10em
    }
</style>
</head>
<body topmargin="0" style="background-color: #F8F7DF">
<!-- ####################################################################################################### -->
<div style="min-height: 35em"><br><br>
<center><table class="takon">
	<tr><td><a href="offences.php" title="Set a Status for a Student Under Disciplinary Action"><img src="images/R2.png" width=70 height=70 >Offence Report | </a></td>
        <td><a href="defer.php" title="Defer a Student's Admission"><img src="images/R3.png" width=70 height=70>Admission Deferment | </a></td>
        <td><a href="change_prog.php" title="Make a Change of Programme"><img src="images/R4.png" width=70 height=70>Change Of Programme | </a></td>
        <td><a href="create_medical.php" title="Create Medical Report"><img src="images/R5.png" width=70 height=70>Medical Report </a></td></tr>
	<tr><td><a href="supplementary.php" title="Create a Report for Supplementary Exams"><img src="images/R6.png" width=70 height=70 > Supplementary Exams | </a></td>
        <td><a href="reinstate.php" title="Reactivate  a student on suspension"><img src="images/R7.png" width=70 height=70 >Reactivate a Definite Leave | </a></td>
	<td><a href="manual_pro.php" title="Restore a Student on Medical Leave"><img src="images/R8.png" width=70 height=70>Reactivate an Indefinite Leave | </a></td>
	<td><a href="nullify.php" title="Nullify An Academic Period"><img src="images/R9.png" width=70 height=70>Nullify A Segment</a></td></tr>
</table>
</div>

<?php echo footer(); ?>
</body>