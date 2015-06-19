<?php
/**
 * contact.php is a postback application designed to provide a 
 * contact form for users to email our clients.  contact.php references 
 * recaptchalib.php as an include file which provides all the web service plumbing 
 * to connect and serve up the CAPTCHA image and verify we have a human entering data.
 *
 * See document in package for installation instructions.
 *
 * @package nmCAPTCHA
 * @author Bill Newman <williamnewman@gmail.com>
 * @version 2.1 2014/01/20
 * @link http://www.newmanix.com/
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @see contact_include.php 
 * @see recaptchalib.php
 * @see util.js 
 * @todo none
 */

# For each customer/domain, get a key from https://www.google.com/recaptcha/admin#whyrecaptcha (DON'T LET A CUSTOMER USE YOUR KEY) 
# Seattle Central edison ONLY reCAPTCHA keys are below:
$publickey = "6LefkwUTAAAAAPIqSjxqmxCkUx8J7_uhQgJAH48C";
$privatekey = "6LefkwUTAAAAAE-hrwkVzQQNGJc1ZdtqGRYN9PRx";

#EDIT THE FOLLOWING:
$toAddress = "sechon01@seattlecentral.edu";  //place your/your client's email address here - EDISON/ZEPHIR WILL ONLY EMAIL seattlecentral.edu ADDRESSES!
$toName = "Spencer Echon"; //place your client's name here
$website = "Zenlink";  //place NAME of your client's website here
$sendEmail = TRUE; //if true, will send an email, otherwise just show user data.
$recaptchaTheme = "clean"; //options are 'white', 'black', 'clean' or none (empty)
$dateFeedback = true; //if true will show date/time with reCAPTCHA error - style a div with class of dateFeedback
#--------------END CONFIG AREA ------------------------#
include 'contact-lib/contact_include.php'; #complex unsightly code moved here
if (isset($_POST["recaptcha_response_field"]))
{# Check for reCAPTCHA response
    $resp = recaptcha_check_answer ($privatekey,$_SERVER["REMOTE_ADDR"],$_POST["recaptcha_challenge_field"],$_POST["recaptcha_response_field"]);
	if ($resp->is_valid)
	{#reCAPTCHA agrees data is valid (PROCESS FORM & SEND EMAIL)
         handle_POST($skipFields,$sendEmail,$toName,$fromAddress,$toAddress,$website,$fromDomain);        
         #Here we can enter the data sent into a database in a later version of this file
?>
	<!-- START HTML THANK YOU MESSAGE -->
	<div class="contact-feedback">
		<h2>Your Comments Have Been Received!</h2>
		<p>Thanks for the input!</p>
		<p>We'll respond via email within 48 hours, if you requested information.</p>
	</div>    
    <!-- END HTML THANK YOU MESSAGE -->   
    
<?php include ("includes/credentials.php");?>

<?php
// Only process the form if $_POST isn't empty
if ( $_POST['Join_Mailing_List?'] == "Yes"  ) {
  
  // Connect to MySQL
  $mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
  
  // Check our connection
  if ( $mysqli->connect_error ) {
    die( 'Connect Error: ' . $mysqli->connect_errno . ': ' . $mysqli->connect_error );
  }
  
  // Insert our data
  $sql = "INSERT INTO email_list ( name, email ) VALUES ( '{$mysqli->real_escape_string($_POST['name'])}', '{$mysqli->real_escape_string($_POST['email'])}' )";
  $insert = $mysqli->query($sql);
  
  // Print response from MySQL
  if ( $insert ) {
    echo "You are now subscribed to our newsletter!";
  } else {
    die("Error: {$mysqli->errno} : {$mysqli->error}");
  }
  
  // Close our connection
  $mysqli->close();
}
?>
         
<?php
    }else{#reCATPCHA response says data not valid - prepare for feedback
            $error = $resp->error;
			$feedback = dateFeedback($dateFeedback);
            send_POSTtoJS($skipFields); #function for sending POST data to JS array to reload form elements
    }
}
if(!isset($_POST["recaptcha_response_field"])|| $error != "")
{#show form, either for first time, or if data not valid per reCAPTCHA  
?>
	<!-- START HTML FORM -->
	<form action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="post">
	<div>
		<label for="Name">Name</label>:<br />
			<input id="Name" type="text" name="name" required="required" placeholder="Full Name (required)" title="Name is required" autofocus tabindex="10" size="44" />
			</div>
	<div>	
		<label for="Email">Email</label>:<br />
			<input id="Email" type="email" name="email" required="required" placeholder="Email (required)" title="A valid email is required" tabindex="20" size="44" />
	</div>
	<!-- below change the HTML to your form elements - only 'Name' & 'Email' (above) are significant -->
	<div>	
		<label for="HowDidYouHear">How Did You Hear About us?</label>:<br />
			<select id="HowDidYouHear" name="How_Did_You_Hear_About_Us?" required title="How You Heard is required" tabindex="30">
				<option value="">Choose How You Heard</option>
				<option value="On the internet">On the Internet</option>
				<option value="From a Friend">From a Friend</option>
				<option value="Other">Other</option>
			</select>
	</div>
	
	<div>	
		<fieldset>
			<legend>How experienced are you with vaping?</legend>
			<input id="Beginner" type="checkbox" name="Beginner[]" value="Beginner" tabindex="40" /> 
            <label for="Beginner">Beginner</label><br />
			<input id="Intermediate" type="checkbox" name="Intermediate[]" value="Intermediate" /> 
            <label for="Intermediate">Intermediate</label><br />
			<input id="Advanced" type="checkbox" name="Advanced[]" value="Advanced" /> 
            <label for="Advanced">Advanced</label><br />
		</fieldset>
	</div>
	
		<div>	
		<fieldset>
			<legend>Would you like to join our mailing list?</legend>
			<input id="Yes" type="radio" name="Join_Mailing_List?" value="Yes" 
			required="required" title="Mailing list is required" tabindex="50"  
			/> <label for="Yes">Yes</label><br />
			<input id="No" type="radio" name="Join_Mailing_List?" value="No" /> 
            <label for="No">No</label><br />
		</fieldset>
	</div>
	<div>	
		<label for="Comments">Comments</label>:<br />
        <textarea id="Comments" name="Comments" cols="30" rows="4" placeholder="Your comments are important to us!" tabindex="60"></textarea>
	</div>	
	<div>
		<?php 
		echo $feedback;
		echo recaptcha_get_html($publickey, $error); 
		?>
	</div>
	<div>
		<input type="submit" value="submit" />
	</div>
    </form>
	<!-- END HTML FORM -->
<?php
}
?>