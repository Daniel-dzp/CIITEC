<?php

$cadena="ABCDEFGHIJKLMNPQRSTUVWXYZ123456789123456789";
$numeC=strlen($cadena);
$nuevPWD="";
for ($i=0; $i<8; $i++)
  $nuevPWD.=$cadena[rand()%$numeC]; 

$consulta="insert into usuario set nombre='".$_POST['nombre']."', apellidos='".$_POST['apellidos']."', correo='".$_POST['correo']."', pwd=password('".$nuevPWD."')";

	include("tools/tools.php");
	include("tools/class.phpmailer.php");
	include("tools/class.smtp.php");

	
			// para mandar el email
			$mail = new PHPMailer();
			$mail->IsSMTP();

			$mail->Host = "smtp.gmail.com"; //mail.google
			$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
			$mail->Port = 465; // set the SMTP port for the GMAIL server
			$mail->SMTPDebug = 1; // enables SMTP debug information (for testing)
			// 1 = errors and messages
			// 2 = messages only
			$mail->SMTPAuth = true; //enable SMTP authentication
			
			// correo del remitente
			$mail->Username = "1994.dzp@gmail.com"; // SMTP account username
			$mail->Password = "Akagami123"; // SMTP account password
			  
			$mail->From="1994.dzp@gmail.com";
			$mail->FromName="Registro a SIITEC";
			$mail->Subject = "Registro completo";
			$mail->MsgHTML("<h1>Bienvenido ".$_POST['nombre']." ".$_POST['apellidos']."</h1><h2> tu clave de acceso es : ".$nuevPWD."</h2>");
			$mail->AddAddress($_POST['correo']);
			//$mail->AddAddress("admin@admin.com");
			if(!$mail->Send()){
				echo "Error: " . $mail->ErrorInfo;
			}
			else{
				echo "<br/>".$consulta;
				$db->consulta($consulta);
				
				header("location: index.php?m=4");
			}
	
?>