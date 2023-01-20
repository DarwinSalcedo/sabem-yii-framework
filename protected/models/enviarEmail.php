<?php

/**
 */
 yii::import('application.extensions.phpmailer.*');

class EnviarEmail 
{
	/**
	 * envia un correo a un usuario
	 */
	#public function enviarCorreo(array $from,array $to, $subject, $message)
	public function enviarCorreo($email,$asunto,$mensaje)
					{

				$mail = new PHPMailer;

				$mail->IsSMTP();                                      // Set mailer to use SMTP
				$mail->Host = 'smtp.mandrillapp.com';                 // Specify main and backup server
				$mail->Port = 587;                                    // Set the SMTP port
				$mail->SMTPAuth = true;                               // Enable SMTP authentication
				$mail->Username = 'darwin.bsd@hotmail.com';                // SMTP username
				$mail->Password = 'iybi_4sulGcoHVHpsA1Hlg';                  // SMTP password
				$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

				$mail->From = 'sabem@gmail.com';
				$mail->FromName = 'SISTEMA DE ASCENSO DE LOS BOMBEROS DEL ESTADO MIRANDA';
				$mail->AddAddress('darwin.bsd@hotmail.com');  // Add a recipient
				$mail->AddAddress($email);               // Name is optional

				$mail->IsHTML(true);                                  // Set email format to HTML

				$mail->Subject = $asunto;
				$mail->Body    = '<strong>'.$mensaje.'</strong>';
				$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

				if(!$mail->Send()) {
				   #echo 'Message could not be sent.';
				   #echo 'Mailer Error: ' . $mail->ErrorInfo;
				 #  Yii::app()->user->setFlash('error','Mailer Error: ' . $mail->ErrorInfo);
				  return false;
					}else
					 	return true;#Yii::app()->user->setFlash('success','Enviado ');

	}

	}

?>
