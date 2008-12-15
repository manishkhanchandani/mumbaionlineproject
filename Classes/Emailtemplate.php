<?php
class Emailtemplate {
	public function template($to, $name, $patterns, $replacements) {
		switch($name) {
			case 'register':
				$template = "Dear User,
Your email is {EMAIL} and password is: '{PASSWORD}'. You can login on site {SITEURL} with this details.

Regards,
Administrator
";
				break;
			case 'forgot':
				$template = "Dear User,
Your password is: '{PASSWORD}'. You can login on site {SITEURL} with this password.

Regards,
Administrator
";
				break;
		}
		
		$body = preg_replace($patterns, $replacements, $template);
		$body = str_replace("{", "", $body);
		$body = str_replace("}", "", $body);
		@mail($to, $sub, $body, "From:".ADMINNAME."<".ADMINEMAIL.">");
	}
}
?>