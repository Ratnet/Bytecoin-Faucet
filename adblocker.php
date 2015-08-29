<?php require("config.php"); ?>
<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title><?php echo $faucetTitle; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">

        
  </head>

  <body>

    <div class="container">

  <div id="login-form">

    <h3><a href="./"><img src="<?php echo $logo; ?>" height="100"></a><br><?php echo $faucetSubtitle; ?></h3>
    <fieldset>
          <img src="images/abp.jpg" height="100">
          <h1>Please Disable your Adblocker</h1>
          <p><b>We love Adblockers</b> but we need ads to keep the faucet running, every cent we make from faucet ads is used to buy more BCN and give it away here. Please Help Us!</p>
         <a id="backFaucet" style="font-size:10px;" href="./?recheck">I have disabled my adblocker</a>

          <hr>
          <p style="font-size:10px;">Please consider donating to keep the faucet alive. <br>Address: <?php echo $faucetAddress; ?></p></center>

        <footer class="clearfix">
        </footer>
      </form>

    </fieldset>

  </div>

</div>
    
    
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>

  </body>
</html>
