<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  class MainEmail {
   function sendMail($name, $phone , $count) {
       $mail = new PHPMailer(true); 
   try {
       //Server settings
       $mail->SMTPDebug = 0;                                 // Enable verbose debug output
       $mail->isSMTP();         
       $mail->CharSet   = "utf-8";                             // Set mailer to use SMTP
       $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
       $mail->SMTPAuth = true;                               // Enable SMTP authentication
       $mail->Username = 'tinhthanhit1995@gmail.com';                 // SMTP username
       $mail->Password = 'Thanh71311@';                           // SMTP password
       $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
       $mail->Port = 465;                                    // TCP port to connect to
    
       //Recipients
       $mail->setFrom('k40cntt@gmail.com', 'Ester-C');
       $mail->addAddress('k40cntt@gmail.com', 'Joe User');     // Add a recipient
       
       $mail->isHTML(true);                         // Set email format to HTML
       $mail->Subject = 'Đơn hàng từ: ' .$name;
       $mail->Body    = 'Số điện thoại:  <b>'.$phone.'</b> <br/> Số lượng : ' .$count;
      
       $mail->send();
       echo 'Message has been sent';
       return true;
   } catch (Exception $e) {
       echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
       return false;
   }
   }
  }


?>