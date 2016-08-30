<?php
include("ZCreditProxy.php");

if(isset($_REQUEST['run']))
{	
	try
	{
		// Call pay method

		$Item1 = new CartItem();
		$Item1->Name = '<script>alert("123");</script>';
		$Item1->PictureURL = 'http://www.z-credit.com/site/wp-content/uploads/2013/01/02_th.jpg';
		$Item1->SN = 'rrrttt-12';
		$Item1->Amount = 11;
		$Item1->ItemPrice = 1;


		$Item2 = new CartItem();
		$Item2->Name = 'Item2';
		$Item2->PictureURL = 'http://www.z-credit.com/site/wp-content/uploads/2013/01/02_th.jpg';
		$Item2->Amount = 1.1;
		$Item2->ItemPrice = 3.5;

		$Item3 = new CartItem();
		$Item3->Name = 'Item3';
		$Item3->PictureURL = 'http://www.z-credit.com/site/wp-content/uploads/2013/01/02_th.jpg';
		$Item3->Amount = 1;
		$Item3->ItemPrice = 3;

		$Items = array($Item1, $Item2, $Item3);


	

			 
						   
						   

		  ZCreditHelper::PayWithInvoice("0963222014", 
		     "testws", 
		     11.99, 
		     1, 
		     Languages::Hebrew, 
		     CurrencyType::NIS, 
		     "XXX",
		     "Test....", 
		     1, 
		     "http://google.com",
		     "http://google.com", 
		     "http://google.com", 
		     false, 
		     false, 
		     false, 
		     false,
		     "Customer Name", "0501234567", "x@y.com", "123123111",1, 1, "http://google.com", 4, 0, $Items);
						   
						   
		   				   
		
						   
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

