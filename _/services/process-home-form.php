<?php
// Website Contact Form Generator 
// http://www.tele-pro.co.uk/scripts/contact_form/ 
// This script is free to use as long as you  
// retain the credit link  

// get posted data into local variables
$EmailFrom = Trim(stripslashes($_POST['email'])); 
$EmailTo = "max@vegasites.com";
$Subject = "30 MINUTES OR LESS - from VEGASiTES.com"; 
$name = Trim(stripslashes($_POST['name'])); 
$tel = Trim(stripslashes($_POST['tel'])); 
$message = Trim(stripslashes($_POST['message'])); 

// validation
$validationOK=true;
if (Trim($EmailFrom)=="") $validationOK=false;
if (Trim($name)=="") $validationOK=false;
if (Trim($message)=="") $validationOK=false;
if (!$validationOK) {
  echo "There was a problem sending your email.<br /><a class='reload' style='cursor:pointer;'>Try again.</a>";
  exit;
}

// prepare email body text
$Body = "";
$Body .= "name: ";
$Body .= $name;
$Body .= "\n";
$Body .= "Tel: ";
$Body .= $tel;
$Body .= "\n";
$Body .= "message: ";
$Body .= $message;
$Body .= "\n";

// send email 
$success = mail($EmailTo, $Subject, $Body, "From: $name - <$EmailFrom>");

// redirect to success page 
if ($success){
  echo "Your request was sent! A Personal Concierge will contact you within 30 minutes.";
}
else{
  echo "There was a problem sending your email.<br /><a class='reload' style='cursor:pointer;'>Try again.</a>";
}
?>

