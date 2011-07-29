# Urban Airship CodeIgniter Library

## Requirements

1. PHP 5.1+
2. CodeIgniter 2.0.0+

## Usage

	// Load the library
	$this->load->library('urban_airship');
	
	// Setup your json payload variables
	$tokens = array(
	"b0ef35cdc226a3fdc4d3662555ca870df5201a6caced3ec960e57c01edb57aa8",
	"50ef35cdc226a3fdc4d3662555ca870df5201a6caced3ec960e57c01edb57aa2",
	"60ef35cdc226a3fdc4d3662555ca870df5201a6caced3ec960e57c01edb57aa9"
	)
	$aps = array(
		'badge' => '+1',
		'alert' => 'Push Test'
		'sound' => 'default'
		);
    
	// Send the push notification
    $http_code = $this-> urban_airship -> push($tokens, $aps);

	// Http code is here
	echo $http_code
	
I basically wrapped up the code available here into a library: https://support.urbanairship.com/customer/portal/articles/91072-simple-push-using-php-amp-the-api	
This is just for the push, the rest is still coming. I appreciate the help.