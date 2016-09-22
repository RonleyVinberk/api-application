<?php
    session_start();

    require_once ('file_require/dbconn.php');
    require_once ('libraries/Google/autoload.php');

    // Insert your cient ID and secret 
    // You can get it from : https://console.developers.google.com/
    $client_id = '517441052692-qkahs74mi4dltquf281olmhulmflalib.apps.googleusercontent.com'; 
    $client_secret = 'fIot4096SA-EiMUR7_ptri1U';
    $redirect_uri = 'http://googlelogin.com/google-login-api/';

    // In case of logout request, just unset the session var
    if (isset($_GET['logout'])) { unset($_SESSION['access_token']); }

    /************************************************
    Make an API request on behalf of a user. In
    this case we need to have a valid OAuth 2.0
    token for the user, so we need to send them
    through a login flow. To do this we need some
    information from our API console project.
    *************************************************/
    $client = new Google_Client();
    $client->setClientId($client_id);
    $client->setClientSecret($client_secret);
    $client->setRedirectUri($redirect_uri);
    $client->addScope("email");
    $client->addScope("profile");

    /************************************************
    When we create the service here, we pass the
    client to it. The client then queries the service
    for the required scopes, and uses that when
    generating the authentication URL later.
    *************************************************/
    $service = new Google_Service_Oauth2($client);

    /************************************************
    If we have a code back from the OAuth 2.0 flow,
    we need to exchange that with the authenticate()
    function. We store the resultant access token
    bundle in the session, and redirect to ourself.
    *************************************************/
  
    if (isset($_GET['code'])) {
        $client->authenticate($_GET['code']);
        $_SESSION['access_token'] = $client->getAccessToken();
        header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        exit;
    }

    /************************************************
    If we have an access token, we can make
    requests, else we generate an authentication URL.
    *************************************************/
    if (isset($_SESSION['access_token']) && $_SESSION['access_token']) { $client->setAccessToken($_SESSION['access_token']); } else { $authUrl = $client->createAuthUrl(); }
?>
<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>API Application Test</title>

        <!-- Bootstrap -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
        <style>
            small {
                font-size: 8pt;
            }
            #information-container { padding: 5px; background: none; display: -webkit-box; }
            .pp-custom { max-width: 50px; }
            #btn-custom { top: -2px; position: relative; }
            .btn, .form-control { border-radius: 0 !important; -webkit-border-radius: 0 !important; }
        </style>
    </head>
    
    <body>
        <!-- start body -->
        
        <div class="container-fluid">
            <!-- start container -->
            
            <?php
                // Display user info or display login url as per the info we have.
                if (isset($authUrl)) { 
            ?>
                <div align="center">
                    <!-- Show login URL -->
                    <a class="login" href="<?php echo $authUrl; ?>"><img src="images/google-login-button.png" /></a>
                </div>
            <?php
                } else {
                    // Get user info
                    $user = $service->userinfo->get(); 

                    // Check if user exist in database using COUNT
                    $sql = $con->prepare("SELECT COUNT(google_id) as usercount FROM google_users WHERE google_id = $user->id");
                    $fetch = $sql->fetch(PDO::FETCH_ASSOC); //will return 0 if user doesn't exist

                    // If user already exist change greeting text to "Welcome Back"
                    if(count($fetch) > 0) {
                        echo 'Welcome back! [<a href="'.$redirect_uri.'?logout">Logout</a>]';
                    } else {
                        // Greeting text "Thanks for registering"
                        echo 'Thanks for Registering! [<a href="'.$redirect_uri.'?logout">Logout</a>]';

                        $sql = $con->prepare("INSERT INTO google_users (google_id, google_name, google_email, google_link, google_picture_link) VALUES (?,?,?,?,?)");
                        $sql->bindParam(1, $user->id);
                        $sql->bindParam(2, $user->name);
                        $sql->bindParam(3, $user->email);
                        $sql->bindParam(4, $user->link);
                        $sql->bindParam(5, $user->picture);
                        $sql->execute();
                    }
                    // Print user details
                    /*echo '<pre>';
                    print_r($user);
                    echo '</pre>';*/
            ?>

            <div class="row">
                <!-- start row -->

                <div class="col-xs-12 col-sm-12 col-md-3 offset-md-4">
                    <!-- start col -->

                    <form method="GET" action="" class="form-inline">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" name="city" class="form-control form-control-sm" aria-describedby="city" />
                        </div>
                        <button type="submit"class="btn btn-default btn-sm" id="btn-custom">Go</button>
                    </form>
                    
                    <div id="information-container">
                        <!-- start information-container -->
                        
                        <?php
                            echo "<img src='$user->picture;' class='img-fluid pp-custom' /> &nbsp";
                            echo "<small>";
                            echo $user->name; echo " - " . date("d M Y");
                            echo "</small><br /> &nbsp";
                            require_once "./file_require/proses.php"; 
                        ?>
                        
                        <!-- end information-container -->
                    </div>

                    <!-- end col -->
                </div>

                <!-- end row -->
            </div>

            <!-- end container -->
        </div>
        
        <?php } ?>
        
        <!-- jQuery first, then Tether, then Bootstrap JS. -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/tether.min.js"></script>
        
        <!-- end body -->
    </body>
    
</html>
