<?php
require_once('../lib/sendgrid/sendgrid-php.php');
$mail = array(
    "acc_subject" => "Activate your LifeCare Account ",
    "acc_title" => "Account Activation",
    "acc_content" => "Thank you for signing up in our platform. Just one more step before we roll. Please set a password and activate your account. To activate your account, click the button below.",
    "acc_button" => "Click Here to Verify Account & Reset Password",

    "fg_subject" => "Reset your Password",
    "fg_title" => "Reset your Password",
    "fg_content" => "We've received a request to reset your password. if you didn't make the request, please ignore this email.",
    "fg_button" => "Click Here to Reset your password"
);

function sendmail($to, $subject, $title, $content, $button, $link, $token)
{
    $button_area = "";
    if (isset($button) && isset($link)) {
        $button_area = '
		<tr><td style="padding: 20px 0 20px 0; font-family: Arial, sans-serif;" align="center">
			<a href="' . $link . '" target="_blank" style="padding: 8px 20px;border: 1px solid #ffffff;border-radius: 6px; color: #716df9; background-color: #ffffff; text-decoration: none; font-weight: bold;">
				' . $button . '
			</a>
		</td></tr>';
    }

    $token_area = "";
    if (isset($token) && $token != "") {
        $token_area = '
		<tr><td align="center" style="padding: 10px 0 30px 0; color: #ffffff; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
				<strong> Here is your 6 digit number: ' . $token . '</strong>
			</td></tr>';
    }

    $message = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>LifeCare Clinic</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%"> 
		<tr>
			<td style="padding: 10px 0 30px 0;">
				<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
					<tr>
						<td align="center" bgcolor="#716df9" style="padding: 40px 0 30px 0; color: #ffffff; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
							LifeCare
						</td>
					</tr>
					<tr>
						<td bgcolor="#716df9" style="padding: 40px 30px 40px 30px;">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								
								<tr>
									<td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 24px;">
										<b>' . $title . '</b>
									</td>
								</tr>
								<tr>
									<td style="padding: 20px 0 30px 0; color: #ffffff; font-family: Arial, sans-serif; font-size: 21px; line-height: 20px;">
										' . $content . '
									</td>
								</tr>
								' . $token_area . '

								' . $button_area . '
							</table>
						</td>
					</tr>
					<tr>
						<td bgcolor="#716df9" style="padding: 10px 30px 30px 30px;">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td style="padding: 0 0 20px 0; color: #dddddd; font-family: Arial, sans-serif; font-size: 12px;" align="center">
										If you did not create an account in our platform, please ignore this email.
									</td>
								</tr>
								<tr>
									<td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;line-height: 2;" width="75%" align="center">
										<strong>Copyright &copy; ' . date("Y") . ' LifeCare Medical Clinic. All right reserved</strong><br/>
										For questions about this list, please contact
										<a href="#" style="color: #ffffff;">LifeCare@gmail.com</a>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>
';
    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("noreply.lifecare.clinic@gmail.com", "LifeCare Clinic");
    $email->setSubject($subject);
    $email->addTo($to);
    $email->addContent("text/html", $message);
    $apiKey = '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';
    $sendgrid = new \SendGrid($apiKey);
    try {
        $response = $sendgrid->send($email);
        print $response->statusCode() . "\n";
        return true;
    } catch (Exception $e) {
        error_log('Caught exception: ' . $e->getMessage() . "\n");
        return false;
    }
}