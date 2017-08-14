<?php
$field_email = $_POST['email'];

// Set email variables
$email_to = 'uparktoronto@gmail.com';
$email_subject = 'Interested Customer'.$field_name;

$headers = 'From: '.$field_email."\r\n";
$headers .= 'Reply-To: '.$field_email."\r\n";

// Set required fields
$required_fields = array('email');

// set error messages
$error_messages = array(
  'email' => 'Please enter a valid Email Address to proceed.'
);

// Set form status
$form_complete = FALSE;

// configure validation array
$validation = array();

// check form submittal
if(!empty($_POST)) {
  // Sanitise POST array
  foreach($_POST as $key => $value) $_POST[$key] = remove_email_injection(trim($value));
  
  // Loop into required fields and make sure they match our needs
  foreach($required_fields as $field) {   
    // the field has been submitted?
    if(!array_key_exists($field, $_POST)) array_push($validation, $field);
    
    // check there is information in the field?
    if($_POST[$field] == '') array_push($validation, $field);
    
    // validate the email address supplied
    if($field == 'email') if(!validate_email_address($_POST[$field])) array_push($validation, $field);
  }
  
  // basic validation result
  if(count($validation) == 0) {
    // Prepare our content string
    $email_content = 'Message from a thejonathantan.com visitor: ' . "\n\n";
    
    // simple email content
    foreach($_POST as $key => $value) {
      if($key != 'submit') $email_content .= $key . ': ' . $value . "\n";
    }
    
    // if validation passed ok then send the email
    mail($email_to, $email_subject, $email_content,$headers);
    
    // Update form switch
    $form_complete = TRUE;
  }
}

function validate_email_address($email = FALSE) {
  return (preg_match('/^[^@\s]+@([-a-z0-9]+\.)+[a-z]{2,}$/i', $email))? TRUE : FALSE;
}

function remove_email_injection($field = FALSE) {
   return (str_ireplace(array("\r", "\n", "%0a", "%0d", "Content-Type:", "bcc:","to:","cc:"), '', $field));
}

?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>UPark - Smart Parking</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">

    <!-- Plugin CSS -->
    <link rel="stylesheet" href="device-mockups/device-mockups.min.css">

    <!-- Custom styles for this template -->
    <link href="css/new-age.css" rel="stylesheet">

  </head>

  <body id="page-top">

    <!-- The Modal -->
    <div id="myModal" class="modal">

      <!-- Modal content -->
      <div class="modal-content">
        <span class="close">&times;</span>
        <div class="container">
        <?php if($form_complete === FALSE): ?>
        <form action="index.php" method="post" >
          <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
              <input type="email" class="form-control emailInput" id="inputEmail3" placeholder="uparktoronto@gmail.com"name="email" value="<?php echo isset($_POST['email'])? $_POST['email'] : ''; ?>"/><?php if(in_array('email', $validation)): ?><span class="error"><?php echo $error_messages['email']; ?></span><?php endif; ?><br />
            </div>
          </div>
          <button type="submit" class="btn btn-outline btn-xl emailBtn">Submit</button>
        </form>
      </div>
      </div>

    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <a class="navbar-brand" href="#">
        <img src="img/upark-logo.png" width="65" height="65" class="d-inline-block align-top" alt="">
      </a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fa fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="#contact">Contact</a>
          </li>
        </ul>
      </div>
    </nav>

    <header class="masthead">
      <div class="container h-100">
        <div class="row h-100">
          <div class="col-lg-7 my-auto">
            <div class="header-content mx-auto">
              <h1 class="mb-5">UPark is a parking lot tracking app that will ease the pain of finding a parking spot</h1>
              <a id="myBtn" class="btn btn-outline btn-xl">Subscribe</a>
            </div>
          </div>
          <div class="col-lg-5 my-auto">
            <div class="device-container">
              <div class="device-mockup iphone6_plus portrait white">
                <div class="device">
                  <div class="screen">
                    <!-- Demo image for screen mockup, you can put an image here, some HTML, an animation, video, or anything else! -->
                    <img src="img/upark-iosmock.png" class="img-fluid" alt="">
                  </div>
                  <div class="button">
                    <!-- You can hook the "home button" to some JavaScript events or just remove it -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>

    <section class="contact bg-primary" id="contact">
      <div class="container">
        <h2>We
          <i class="fa fa-heart"></i>
          friends!</h2>
        <ul class="list-inline list-social">
          <li class="list-inline-item social-twitter">
            <a href="#">
              <i class="fa fa-twitter"></i>
            </a>
          </li>
          <li class="list-inline-item social-facebook">
            <a href="#">
              <i class="fa fa-facebook"></i>
            </a>
          </li>
          <li class="list-inline-item social-google-plus">
            <a href="#">
              <i class="fa fa-google-plus"></i>
            </a>
          </li>
        </ul>
      </div>
    </section>

    <footer>
      <div class="container">
        <p>&copy; 2017 UPark. All Rights Reserved.</p>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/new-age.js"></script>

  </body>

</html>
