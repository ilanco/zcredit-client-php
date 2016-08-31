<?php

namespace ZCredit;

class ZCreditHelper
{
    public static function Pay($TerminalNumber, $UserName, $PaymentSum, $PaymentsNumber,
        $Lang, $Currency, $UniqueID, $ItemDescription, $ItemQtty, $ItemPicture,
        $RedirectLink, $NotifyLink, $UsePaymentsRange, $ShowHolderID, $AuthorizeOnly, $HideCustomer,
        $CustomerName, $CssType, $IsCssResponsive, $CancelLink, $NumberOfFailures, $IsIFrame, $CartItems)
    {
        $ResGUID = "Error create request";
        try {
            $RedirectLink = urlencode($RedirectLink);
            $NotifyLink = urlencode($NotifyLink);

            $CartItemsJSON = json_encode($CartItems);

            //Create url
            $url = "https://pci.zcredit.co.il/WebControl/RequestToken.aspx";
            $post = "TerminalNumber=$TerminalNumber"
                . "&Username=$UserName&PaymentSum=$PaymentSum&PaymentsNumber=$PaymentsNumber&Lang=$Lang"
                . "&Currency=$Currency&UniqueID=$UniqueID&ItemDescription=$ItemDescription&ItemQtty=$ItemQtty"
                . "&ItemPicture=$ItemPicture&RedirectLink=$RedirectLink&NotifyLink=$NotifyLink"
                . "&UsePaymentsRange=$UsePaymentsRange&ShowHolderID=$ShowHolderID&AuthorizeOnly=$AuthorizeOnly"
                . "&HideCustomer=$HideCustomer&CustomerName=$CustomerName&CssType=$CssType"
                . "&IsCssResponsive=$IsCssResponsive&CancelLink=$CancelLink&NumberOfFailures=$NumberOfFailures"
                . "&IsIFrame=$IsIFrame&CartItems=$CartItemsJSON";

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
            if (sizeof($tmpArray) > 1) {
                $ResGUID = $tmpArray[0];
                if (!preg_match('/^\{?[A-Za-z0-9]{8}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{12}\}?$/', $ResGUID)) {
                    var_dump($ResGUID);
                    throw new Exception("Invalid GUID");
                }
                $Resdata = $tmpArray[1];
            } else {
                //throw exception if not exist Resdata
                throw new Exception($page);
            }

            $url = "https://pci.zcredit.co.il/WebControl/Transaction.aspx?GUID=$ResGUID&DataPackage=$Resdata";

            return $url;
        } catch(Exception $e) {
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
            if (sizeof($tmpArray) > 1) {
                $ResGUID = $tmpArray[0];
                if (!preg_match('/^\{?[A-Za-z0-9]{8}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{12}\}?$/', $ResGUID)) {
                    var_dump($ResGUID);
                    throw new Exception("Invalid GUID");
                }
                $Resdata = $tmpArray[1];
            } else {
                //throw exception if not exist Resdata
                throw new Exception($page);
            }

            $url = "https://pci.zcredit.co.il/WebControl/Transaction.aspx?GUID=$ResGUID&DataPackage=$Resdata";

            return $url;
        } catch(Exception $e) {
            // Throw exception
            throw new ZCreditException($ResGUID, $e);
        }
    }
}
