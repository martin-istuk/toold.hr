<?php
if( isset( $_POST[ "email" ] ) ) {

  // Sender
  $sender_name = $_POST["name"]; // required
  $sender_adress = $_POST["email"]; // required
  $sender_message = $_POST["message"]; // required

	// Admin
  $admin_subject = "toold.hr - Nova poruka - " . $sender_name;
  $admin_adress = "toold@toold.hr";

	// Boundary
  $semi_rand = md5(time());
  $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

	// HTML message
	$html_content =
		"<html>
			<head>
			<style type='text/css'>
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
			<table style='width:100%'>
				<colgroup>
				<col style='width:100px'>
				</colgroup>
				<tr>
				<td><h6>Ime:</h6></td>
				<td><p>" . $sender_name . "</p></td>
				</tr>
				<tr>
				<td><h6>Email:</h6></td>
				<td><p>" . $sender_adress . "</p></td>
				</tr>
				<tr>
				<td><h6>Poruka:</h6></td>
				<td><p>" . $sender_message . "</p></td>
				</tr>
			</table>
			</body>
		</html>";

  // Multipart boundary
  $admin_message =
		"--{$mime_boundary}\r\n" .
		"Content-Type: text/html; charset=\"UTF-8\"\r\n" .
		"Content-Transfer-Encoding: 7bit\r\n" .
		$html_content .
		"\r\n";

	// Headers for attachment
  $admin_headers =
		"From: " . $sender_adress . "\r\n" .
		"Reply-To: " . $sender_adress;

  // Check for attachments
  if(!empty($_FILES)){ 
		$admin_headers .=
			"\r\nMIME-Version: 1.0\r\n" .
			"Content-Type: multipart/mixed;\r\n" .
			"boundary='{$mime_boundary}'";
		for($i=0;$i<count($_FILES);$i++){ 
			if(is_file($_FILES[$i])){ 
				$file_name = basename($_FILES[$i]); 
				$file_size = filesize($_FILES[$i]); 
					
				$admin_message .= "--{$mime_boundary}\r\n";
				$fp =    @fopen($_FILES[$i], "rb");
				$data =  @fread($fp, $file_size);
				@fclose($fp);
				$data = chunk_split(base64_encode($data));
				$admin_message .=
					"Content-Type: application/octet-stream; name=\"" .
					$file_name .
					"\"\r\n" .
					"Content-Description: " .
					$file_name .
					"\r\n" .
					"Content-Disposition: attachment;\r\n" .
					" filename=\"" .
					$file_name .
					"\"; size=" .
					$file_size .
					";\r\n" .
					"Content-Transfer-Encoding: base64\r\n" .
					$data .
					"\r\n";
			}
		}
	}

	$admin_message .=	"--{$mime_boundary}--";
	
	// Send mail to admin
	@mail(
		$admin_adress,
		$admin_subject,
		$admin_message,
		$admin_headers
	);

  // Send confirmation mail to sender
  $sender_subject = "Obavijest / Notification - toold.hr";
  $sender_message .=
		"<html>
			<head>
			<style type='text/css'>
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
			<p>Thanks for getting in touch. We'll get back to you soon.</p>
			<br>
			<hr>
			<br>
			<img src='https://toold.hr/img/logo-mail.jpg'>
			<br>
			<a href='toold.hr'>toold.hr</a>
			<p>Slavonska avenija 23, 10 040 Zagreb</p>
			<a href='mailto:toold@toold.hr'>toold@toold.hr</a>
			<p>+385 99 357 8558</p>
			</body>
		</html>" . "\r\n";

  $sender_headers =
		"From: " . $admin_adress . "\r\n" .
		"Reply-To: " . $admin_adress . "\r\n" .
		"Content-Type: text/html; charset=UTF-8";

  @mail(
		$sender_adress,
		$sender_subject,
		$sender_message,
		$sender_headers
  );

	echo $sender_message;
}
?>