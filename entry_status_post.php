<?php include ('inc_php_funtions.php'); ?>
<?php
// Ok Transactions Status
if (isset($_POST['approve_entry']))
{

	//$CatsID = $_POST['CatID'];
	$VISITED_URL = $_POST['VISITED_URL']; //Transaction ID
	$sMem = $_POST['tranx_check']; //Transaction ID
	//echo $sMemi = implode(',', $_POST['tranx_num']);
	//exit;
	
	
		if(empty($sMem)) 
			{
				header("location: $VISITED_URL?err=3");
			} 
			else 
			{
			$N = count($sMem);
			
				for($i=0; $i < $N; $i++)
				{	
					
					//Update Transaction List with OK Status				
					$sql2="UPDATE `statement` SET STATUS='1', APPROVED_DATE=NOW(), APPROVED_BY='$EMPLOYEEID_LOGIN' WHERE VNO='$sMem[$i]' AND STATUS='2' ";
						if(!mysqli_query($link, $sql2)){
		echo "ERROR: Could not able to execute $sql2. " . mysqli_error($link);
	}
						
				}
				
			}

	if(empty($sMem))
	{
		header("location: $VISITED_URL?err=3");	
	}
	else
	{
		header("location: $VISITED_URL?err=1");
	}

}


?>