<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';

require '../../vendor/phpmailer/phpmailer/src/Exception.php';
require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../vendor/phpmailer/phpmailer/src/SMTP.php';

$config = parse_ini_file('/var/app/config.ini', true);	// na serveru

$mail = new PHPMailer(true);

try {
	//Server settings
		$mail->SMTPDebug = 0;	//Enable verbose debug output:
			// 0=off,
			// 1=Client commands,
			// 2=Client commands and server responses,
			// 3=As DEBUG_SERVER plus connection status,
			// 4=Low-level data output, all messages.
		$mail->isSMTP();	//Send using SMTP
		$mail->Host       = 'mail.toold.hr';	//Set the SMTP server to send through
		$mail->SMTPAuth   = true;	//Enable SMTP authentication
		$mail->Username   = $config['username'];	//SMTP username
		$mail->Password   = $config['password'];	//SMTP password
		$mail->SMTPSecure = 'ssl';	//Enable implicit TLS encryption
		$mail->Port       = 465;	//TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

	//Recipients
		$mail->setFrom($_POST['email'], $_POST['name']);
		$mail->addAddress('toold@toold.hr', 'toold');	//Add a recipient, name is optional
		$mail->addReplyTo($_POST['email'], $_POST['name']);

	//Attachments
		if (
			array_key_exists('file', $_FILES)
		) {
			for( $ct=0 ; $ct<count($_FILES['file']['tmp_name']) ; $ct++) {
				$ext = PHPMailer::mb_pathinfo($_FILES['file']['name'][$ct], PATHINFO_EXTENSION);

				$uploadfile = tempnam(
					sys_get_temp_dir(),
					hash(
						'sha256',
						$_FILES['file']['name'][$ct]
					)
				) . '.' . $ext;

				$filename = $_FILES['file']['name'][$ct];

				move_uploaded_file(
					$_FILES['file']['tmp_name'][$ct], $uploadfile
				);

				$mail->addAttachment($uploadfile, $filename);
			}
		}

	//Content
		$mail->isHTML(true);	//Set email format to HTML
		$mail->Subject = 'toold - nova poruka - ' . $_POST['name'];
		$mail->Encoding = 'base64';
		$mail->CharSet = 'UTF-8';
		$mail->Body    =
			'<html>
				<head>
					<style type=\"text/css\">
						td {
						padding: 15px;
						vertical-align: top;
						}
						h6, p {
						font-size: 16px;
						padding: 2px;
						margin: 0px;
						}
						h6 {
						color: white;
						background: black;
						border-radius: 4px;
						}
						p {
						padding-left: 15px;
						}
					</style>
				</head>
				<body>
					<table style=\"width:100%\">
						<colgroup>
							<col style=\"width:100px\">
						</colgroup>
						<tr>
							<td><h6>Ime:</h6></td>
							<td><p>' . $_POST['name'] . '</p></td>
						</tr>
						<tr>
							<td><h6>Email:</h6></td>
							<td><p>' . $_POST['email'] . '</p></td>
						</tr>
						<tr>
							<td><h6>Poruka:</h6></td>
							<td><p>' . $_POST['message'] . '</p></td>
						</tr>
					</table>
				</body>
			</html>';
		$mail->AltBody =
			'Ime:' . $_POST['name'] . '\r\n\r\n' .
			'Email:' . $_POST['email'] . '\r\n\r\n' .
			'Poruka:' . $_POST['message'];

	$mail->send();

	$success_msg =
		'<html>
			<head>
				<style type="text/css">
					* {
						font-family: Arial, Helvetica, sans-serif;
					}
					h6 {
						font-size: 2.7vh;
						margin: 1.8vh 0;
					}
					p, a {
						font-size: 1.8vh;
						margin: 0;
						padding: 4px 0;
					}
					img {
						height: 3.6vh;
						padding-bottom: 1.8vh;
					}
				</style>
			</head>
			<body>
				<h6>Obavijest</h6>
				<p>Zahvaljujemo na upitu. Odgovorit ćemo Vam u najkraćem mogućem roku.</p>
				<h6>Notification</h6>
				<p>Thanks for getting in touch. We\'ll get back to you soon.</p>
				<br>
				<hr>
				<br>
				<img src="https://toold.hr/img/logo-mail.jpg">
				<br>
				<a href="toold.hr">toold.hr</a>
				<p>Slavonska avenija 23, 10 040 Zagreb</p>
				<a href="mailto:toold@toold.hr">toold@toold.hr</a>
				<p>+385 99 357 8558</p>
			</body>
		</html>';

	echo $success_msg;
} catch (Exception $e) {
	echo 'Poruka nije uspješno poslana. Mailer Error: {$mail->ErrorInfo}';
}
?>