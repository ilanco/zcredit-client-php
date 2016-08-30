<?php
include('ZCreditResponseData.php');

// Get the data by ZCreditResponseData object
$ResponseData = new ZCreditResponseData();
$ResponseData->GUID = $_REQUEST["GUID"];
$ResponseData->ID = $_REQUEST["ID"];
$ResponseData->Sum = floatval($_REQUEST["Sum"]);
$ResponseData->Currency = $_REQUEST["Currency"];
$ResponseData->Payments = $_REQUEST["Payments"];
$ResponseData->CardNum = $_REQUEST["CardNum"];
$ResponseData->CardName = $_REQUEST["CardName"];
$ResponseData->UniqueID = $_REQUEST["UniqueID"];
$ResponseData->Token = $_REQUEST["Token"];
$ResponseData->ApprovalNumber = $_REQUEST["ApprovalNumber"];
$ResponseData->CustomerName = $_REQUEST["CustomerName"];
$ResponseData->CustomerID = $_REQUEST["CustomerID"];
$ResponseData->CustomerPhone = $_REQUEST["CustomerPhone"];
$ResponseData->CustomerEmail = $_REQUEST["CustomerEmail"];
$ResponseData->CustomerExtraData = $_REQUEST["CustomerExtraData"];

// Or get the data to variables
$GUID = $_REQUEST["GUID"];
$ID = $_REQUEST["ID"];
$Sum = floatval($_REQUEST["Sum"]);
$Currency = $_REQUEST["Currency"];
$Payments = $_REQUEST["Payments"];
$CardNum = $_REQUEST["CardNum"];
$CardName = $_REQUEST["CardName"];
$UniqueID = $_REQUEST["UniqueID"];
$Token = $_REQUEST["Token"];
$ApprovalNumber = $_REQUEST["ApprovalNumber"];
$CustomerName = $_REQUEST["CustomerName"];
$CustomerID = $_REQUEST["CustomerID"];
$CustomerPhone = $_REQUEST["CustomerPhone"];
$CustomerEmail = $_REQUEST["CustomerEmail"];
$CustomerExtraData = $_REQUEST["CustomerExtraData"];





?>
