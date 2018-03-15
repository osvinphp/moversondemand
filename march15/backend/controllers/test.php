    <?php
echo "dkldfjkf";
require(APPPATH.'/libraries/Twilio.php');
require(APPPATH.'/libraries/Twilio/autoload.php');
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\VoiceGrant;
use Twilio\Jwt\ClientToken;
 use Twilio\Twiml;



        $response = new Twiml;

        // get the phone number from the page request parameters, if given
        if (isset($_request['To'])) {
            $number = htmlspecialchars($_request['To']);
            $response->dial(array(
                'callerId' => ' +13617920980'
            ))->number($number);
        } else {
            $response->say("Thanks for calling");
        }

        echo $response;
     
      ?>