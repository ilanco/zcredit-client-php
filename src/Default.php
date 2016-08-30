<?php
include("ZCreditProxy.php");

if(isset($_REQUEST['run']))
{	
	try
	{
		// Call pay method

		/*
		 ZCreditHelper::Pay("0963222014", 
		    "testws", 
		    12.99, 
		    1, 
		    Languages::Hebrew, 
		    CurrencyType::NIS, 
		    "XX232lsUU",
		    "Test Item", 
		    1, 
		    "http://google.com",
		    "http://google.com", 
		    "http://google.com", 
		    false, 
		    false, 
		    false, 
		    false,
		    "Customer Name2", 1, 1);
		   */
		   

			 
						   
						   

		  ZCreditHelper::PayWithInvoice("0963222014", 
		     "testws", 
		     11.99, 
		     1, 
		     Languages::Hebrew, 
		     CurrencyType::NIS, 
		     "XX232lsUU",
		     "Test Item", 
		     1, 
		     "http://google.com",
		     "http://google.com", 
		     "http://google.com", 
		     false, 
		     false, 
		     false, 
		     false,
		     "Customer Name", "0501234567", "x@y.com", "123123111",1, 1);
						   
						   
		   				   
		
						   
		exit();
	}
	catch (ZCreditException $zex)
	{
		$e = $zex->getPrevious();
		if($e != null)
		{
			echo $e->getMessage();
		}else
		{
			echo $zex->getMessage();
		}
	}
	catch (Exception $ex)
	{
		echo $ex->getMessage();
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title></title>
</head>
<body>
    <form id="form1">
    <div>
    This is the ZCredit proxy test page.1
    <br />
    Click the button to test...
    <br />
		<input id="btnTest" type="submit" value="Button" name="run"/>
    </div>
    </form>
</body>
</html>

