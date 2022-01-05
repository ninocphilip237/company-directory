<?php
include './PhpMailerClass/class.smtp.php';
include_once './PhpMailerClass/class.phpmailer.php';
date_default_timezone_set('Asia/Kolkata');
include('config.php');
$link = $text = $templates = $mailtext = "";
$subject = "Hire My Developer - Company Added ";
$company_email = $_REQUEST['email'];
// $company_email ='vidya.b.panicker@vofoxsolutions.com';
//$last_id = 21;
//--------------Encrypting id to URL----------------------
$orig_string = $last_id;
// Store the cipher method 
$ciphering = "AES-128-CTR"; 
// Use OpenSSl Encryption method 
$iv_length = openssl_cipher_iv_length($ciphering); 
$options = 0;  
// Non-NULL Initialization Vector for encryption 
$encryption_iv = '1234567891098769';  
// Store the encryption key 
$encryption_key = "vofoxsolutions";
$encrypt_last_id = openssl_encrypt($orig_string, $ciphering,$encryption_key, $options, $encryption_iv); 
$link = "http://192.168.10.87/company-directory/admin/company_external.php?id=";

$link.= $encrypt_last_id;

$sql11 ="SELECT * FROM email_template"; 
    $query11= $conn -> prepare($sql11);
    $query11-> execute();
    $templates=$query11->fetchAll();
    if($query11->rowCount() > 0)
    {
    foreach($templates as $template){
        $text=$template['template']; 
    }
    }

				$mail          = new PHPMailer;
                $mail->CharSet = "UTF-8";
                $mail->IsSMTP(); // enable SMTP
                //$mail->SMTPDebug = 2; // debugging: 1 = errors and messages, 2 = messages only
                $mail->SMTPAuth   = true; // authentication enabled
                $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
                $mail->Host       = "smtp.gmail.com";
                $mail->Port       = 465; // or 587
                $mail->IsHTML(true);
                $mail->Username = 'aneesh.p@vofoxsolutions.com'; // SMTP username
                $mail->Password = '1234Mails*'; // SMTP password
                $mail->setFrom('aneesh.p@vofoxsolutions.com', 'Hire My Developer');
                $mail->addReplyTo('aneesh.p@vofoxsolutions.com', 'Hire My Developer');
				$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	
                
                // $to = '';
				// $mail->ClearAddresses();  // each AddAddress add to list
				// $mail->ClearCCs();
				// $mail->ClearBCCs();
       
                //Mail Text
                    $mailtext = $mailtext . $text;
                    $mailtext = $mailtext . '<p> Link : <a href="'.$link.' " target="_blank" >'.$link.'</a></p>';
                       
                    // $mail->addCC($addrcc); // Add cc
                    // $mail->addBCC($addrbcc); // Add Bcc
                    $mail->addAddress($company_email); // mail address
                    //adding attachment
                    //$mail->addAttachment('./dayreport_formail/attendancereport.pdf');    // Optional name
                    //setting email subject
                    $mail->Subject = $subject;
                    //setting email body content 
                     $mail->Body    = $mailtext;
                    $mail->send();
                    // if (!$mail->send()) {
                    //     echo 'Message could not be sent.';
                    //     echo 'Mailer Error: ' . $mail->ErrorInfo;
                    // }
  
?>
