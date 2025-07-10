<?php
class iconContact {
	public static function getIcon($type,$address) {
		switch($type) {
			case '0':
				$path = '../admin/asset/image/icon-contact/sms.jpg';
				$address = $address;
			break;

			case '1':
				$path = '../admin/asset/image/icon-contact/phone.jpg';
				$address = $address;
			break;

			case 2:
				$path = '../admin/asset/image/icon-contact/email.jpg';
				$address = '<a href="mailto:'.$address.'">'.$address.'</a>';
			break;

			case '3':
				$path = '../admin/asset/image/icon-contact/bbm.jpg';
				$address = $address;
			break;

			case '4':
				$path = '../admin/asset/image/icon-contact/whatsup.png';
				$address = $address;
			break;

			case '5':
				$path = '../admin/asset/image/icon-contact/yahoo.jpg';
				$address = '<a href="ymsgr:sendIM?'.$address.'"><img border=0 src="http://opi.yahoo.com/online?u='.$address.'&m=g&t=1"  style="border: 0px; -webkit-box-shadow: 0px 0px 0px;" /></a>';
			break;

			case '6':
				$path = '../admin/asset/image/icon-contact/gtalk.jpg';
				$address = $address;
			break;

			case '7':
				$path = '../admin/asset/image/icon-contact/msn.jpg';
				$address = $address;
			break;

			case '8':
				$path = '../admin/asset/image/icon-contact/other.jpg';
				$address = $address;
			break;	
		}      

		return array($path, $address);
	}
}
?>
