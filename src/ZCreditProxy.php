<?php
/*
' 	Ver:   
'	Date:
*	
*/
include('ZCreditException.php');

class Languages
{
	const Hebrew = "he-IL";
	const English = "en-US";
}

class CurrencyType
{
	const NIS = 1;
	const USD = 2;
}

class CartItem
{
    public $Name;
    public $PictureURL;
    public $SN;
    public $Amount;
    public $ItemPrice;
}

Class ZCreditHelper 
{
		
	/// <summary>
	/// Create a payment transaction using Z-Credit Redirect.
	/// </summary>
	/// <param name="TerminalNumber">Your Z-Credit terminal number.</param>
	/// <param name="UserName">Your Z-Credit user name.</param>
	/// <param name="PaymentSum"><para>Payment total sum.</para><para>Caution: if left empty the customer will be able to choose the transaction sum himself !!</para></param>
	/// <param name="PaymentsNumber"><para>Number of payments for this transaction.</para><para>Caution: if left empty the customer will be able to choose the number of payments himself !!</para></param>
	/// <param name="Lang">Redirect page language</param>
	/// <param name="Currency">Transaction currency.</param>
	/// <param name="UniqueID"><para>An ID which is returned to the caller after the transaction ends.</para><para>-- Mainly used for validation</para></param>
	/// <param name="ItemDescription">Describe the item which is sold in this transaction.</param>
	/// <param name="ItemQtty"><para>The quantity of items sold in this transaction.</para><para>-- Only shown if ItemDescription is populated</para>para></param>
	/// <param name="ItemPicture"><para>Full image URL of the item.  Caution: The URL must be HTTPS.</para><para>-- Only shown if ItemDescription is populated</para></param>
	/// <param name="RedirectLink">URL which the customer is redirected to, after a successfull transaction.</param>
	/// <param name="NotifyLink"><para>URL which will recieve the transaction data after successfull payment.</para><para>-- Using the POST method</para></param>
	/// <param name="UsePaymentsRange">When true, the redirect page will allow the user to choose from a range of payments from 1 to the number given in the "PaymentsNumber" parameter</param>
	/// <param name="ShowHolderID"><para>When true, the HolderID field will be visible</para><para>-- Otherwise it will be hidden</para></param>
	/// <param name="AuthorizeOnly"><para>This will force the transaction to be a Capture Transaction (J5).</para><para>Caution: Capture transaction are not charged, and is only used to capture an amount of money for future transaction.</para></param>
	/// <param name="HideCustomer"><para>When true, the Customer Data panel will be visible</para><para> -- Otherwise it will be hidden</para></param>
	/// <exception cref="ZCreditException"></exception>
	public static function Pay($TerminalNumber, $UserName, $PaymentSum, $PaymentsNumber,
		$Lang, $Currency, $UniqueID, $ItemDescription, $ItemQtty, $ItemPicture,
		$RedirectLink, $NotifyLink, $UsePaymentsRange, $ShowHolderID, $AuthorizeOnly, $HideCustomer,
		$CustomerName, $CssType, $IsCssResponsive, $CancelLink, $NumberOfFailures, $IsIFrame, $CartItems)
	{           
		$ResGUID = "Error create request";
		try
		{
			$RedirectLink = urlencode($RedirectLink);
			$NotifyLink = urlencode($NotifyLink);
			
      $CartItemsJSON = json_encode($CartItems);
      
			//Create url
			$url = "https://pci.zcredit.co.il/WebControl/RequestToken.aspx";
			$post = "TerminalNumber=$TerminalNumber"
			."&Username=$UserName&PaymentSum=$PaymentSum&PaymentsNumber=$PaymentsNumber&Lang=$Lang"
			."&Currency=$Currency&UniqueID=$UniqueID&ItemDescription=$ItemDescription&ItemQtty=$ItemQtty"
			."&ItemPicture=$ItemPicture&RedirectLink=$RedirectLink&NotifyLink=$NotifyLink"
			."&UsePaymentsRange=$UsePaymentsRange&ShowHolderID=$ShowHolderID&AuthorizeOnly=$AuthorizeOnly"
			."&HideCustomer=$HideCustomer&CustomerName=$CustomerName&CssType=$CssType&IsCssResponsive=$IsCssResponsive&CancelLink=$CancelLink&NumberOfFailures=$NumberOfFailures&IsIFrame=$IsIFrame&CartItems=$CartItemsJSON";
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url); // Create the request url
			curl_setopt($ch, CURLOPT_POSTFIELDS,$post); //Set post value
			curl_setopt($ch, CURLOPT_POST, 1); // Set the request method to POST
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Not return data in brower
			//curl_setopt($ch, CURLOPT_COOKIEJAR, "cookies.txt");  // Set cookie jar
			//curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies.txt"); // Set cookie file
			//curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0"); // Set agent
			//curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888'); //Set the request proxy to null and ignore local
			//curl_setopt($ch, CURLOPT_REFERER, "http://www.google.com"); //Set referer
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			$page = curl_exec($ch);    // Get the response
					
			// Get the guid and the data from the stream
			$Resdata = '';
			$tmpArray = explode("\n", trim($page), 2); 
			if(sizeof($tmpArray) > 1)
			{								
				$ResGUID = $tmpArray[0];
				if (!preg_match('/^\{?[A-Za-z0-9]{8}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{12}\}?$/', $ResGUID)) {
					var_dump($ResGUID);
					throw new Exception("Invalid GUID");
				}
				$Resdata = $tmpArray[1];
			}else
			{
				//throw exception if not exist Resdata
				throw new Exception($page);
			}								
			$url = "https://pci.zcredit.co.il/WebControl/Transaction.aspx?GUID=$ResGUID&DataPackage=$Resdata";	
			header("Location: $url"); // Redirect client to payment page		
						
		}catch(Exception $e)
		{
			// Throw exception
			throw new ZCreditException($ResGUID, $e);
		}
	}
	
	
	
	public static function PayWithInvoice($TerminalNumber, $UserName, $PaymentSum, $PaymentsNumber,
		$Lang, $Currency, $UniqueID, $ItemDescription, $ItemQtty, $ItemPicture,
		$RedirectLink, $NotifyLink, $UsePaymentsRange, $ShowHolderID, $AuthorizeOnly, $HideCustomer,
		$CustomerName, $CustomerPhoneNumber, $CustomerEmail, $CustomerBusinessID,
		$CssType, $IsCssResponsive, $CancelLink, $NumberOfFailures, $IsIFrame, $CartItems)
	{           
		$ResGUID = "Error create request";
		try
		{
			$RedirectLink = urlencode($RedirectLink);
			$NotifyLink = urlencode($NotifyLink);
			
      $CartItemsJSON = json_encode($CartItems);
       
			//Create url
			$url = "https://pci.zcredit.co.il/WebControl/RequestToken.aspx";
			$post = "TerminalNumber=$TerminalNumber"
			."&Username=$UserName&PaymentSum=$PaymentSum&PaymentsNumber=$PaymentsNumber&Lang=$Lang"
			."&Currency=$Currency&UniqueID=$UniqueID&ItemDescription=$ItemDescription&ItemQtty=$ItemQtty"
			."&ItemPicture=$ItemPicture&RedirectLink=$RedirectLink&NotifyLink=$NotifyLink"
			."&UsePaymentsRange=$UsePaymentsRange&ShowHolderID=$ShowHolderID&AuthorizeOnly=$AuthorizeOnly"
			."&HideCustomer=$HideCustomer"
			."&CustomerName=$CustomerName&CustomerPhoneNumber=$CustomerPhoneNumber&CustomerEmail=$CustomerEmail&CustomerBusinessID=$CustomerBusinessID"
			."&CssType=$CssType&IsCssResponsive=$IsCssResponsive&CancelLink=$CancelLink&NumberOfFailures=$NumberOfFailures&IsIFrame=$IsIFrame&CartItems=$CartItemsJSON";
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url); // Create the request url
			curl_setopt($ch, CURLOPT_POSTFIELDS,$post); //Set post value
			curl_setopt($ch, CURLOPT_POST, 1); // Set the request method to POST
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Not return data in brower
			//curl_setopt($ch, CURLOPT_COOKIEJAR, "cookies.txt");  // Set cookie jar
			//curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies.txt"); // Set cookie file
			//curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0"); // Set agent
			//curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888'); //Set the request proxy to null and ignore local
			//curl_setopt($ch, CURLOPT_REFERER, "http://www.google.com"); //Set referer
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			$page = curl_exec($ch);    // Get the response
					
			// Get the guid and the data from the stream
			$Resdata = '';
			$tmpArray = explode("\n", trim($page), 2); 
			if(sizeof($tmpArray) > 1)
			{								
				$ResGUID = $tmpArray[0];
				if (!preg_match('/^\{?[A-Za-z0-9]{8}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{12}\}?$/', $ResGUID)) {
					var_dump($ResGUID);
					throw new Exception("Invalid GUID");
				}
				$Resdata = $tmpArray[1];
			}else
			{
				//throw exception if not exist Resdata
				throw new Exception($page);
			}								
			$url = "https://pci.zcredit.co.il/WebControl/Transaction.aspx?GUID=$ResGUID&DataPackage=$Resdata";	
			header("Location: $url"); // Redirect client to payment page		
						
		}catch(Exception $e)
		{
			// Throw exception
			throw new ZCreditException($ResGUID, $e);
		}
	}
	
}
?>
