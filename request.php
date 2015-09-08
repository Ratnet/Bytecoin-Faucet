	<?php 
	require_once 'classes/recaptcha.php';
	require_once 'classes/jsonRPCClient.php';
	require_once 'config.php';


	$link = mysqli_connect($hostDB, $userDB, $passwordDB, $database);

	function GetRandomValue($min, $max) 
	{ 
		$range = $max-$min; 
		$num = $min + $range * mt_rand(0, 32767)/32767; 

		$num = round($num, 8); 

		return ((float) $num); 
	} 


	//Instantiate the Recaptcha class as $recaptcha
	$recaptcha = new Recaptcha($keys);
	if($recaptcha->set()) {
		if($recaptcha->verify($_POST['g-recaptcha-response'])){
	  	//Checking address and payment ID characters
			$wallet = $str = trim(preg_replace('/[^a-zA-Z0-9]/', '', $_POST['wallet']));
			$paymentidPost = $str = trim(preg_replace('/[^a-zA-Z0-9]/', '', $_POST['paymentid']));
	  	//Getting user IP
			$direccionIP = $_SERVER["REMOTE_ADDR"];



			if(empty($wallet) OR (strlen($wallet) < 95)){
				header("Location: ./?msg=wallet");
				exit();
			}

			if(empty($paymentidPost)){
				$paymentID = "";
			}else{
				if((strlen($paymentidPost) > 64) OR (strlen($paymentidPost) < 64)){
					header("Location: ./?msg=paymentID");
					exit();
				}else{
					$paymentID = $paymentidPost;
				}
			}

				//Looking for cleared address or not
			$clave = array_search($wallet, $clearedAddresses); 

			if(empty($clave))
			{
				$queryCheck = "SELECT `id` FROM `payouts` WHERE `timestamp` > NOW() - INTERVAL ".$rewardEvery." HOUR AND ( `ip_address` = '$direccionIP' OR `payout_address` = '$wallet')";
			}else{
				$queryCheck = "SELECT `id` FROM `payouts` WHERE `timestamp` > NOW() - INTERVAL ".$rewardEvery." HOUR AND ( `ip_address` = '$direccionIP' OR `payment_id` = '$paymentidPost')";
			}

			$resultCheck = mysqli_query($link,$queryCheck);
			if ($row = @mysqli_fetch_assoc($resultCheck)){
				header("Location: ./?msg=notYet");
				exit();
			}

			$bitcoin = new jsonRPCClient('http://127.0.0.1:8070/json_rpc');
			$balance = $bitcoin->getbalance();
			$balanceDisponible = $balance['available_balance'];
			$transactionFee = 1000000;
			$dividirEntre = 100000000;
			$hasta = number_format(round($balanceDisponible/$dividirEntre,8),2,'.', '');

			if($hasta > $maxReward){
				$hasta = $maxReward;
			}
			if($hasta < $minReward+0.1){ 
				header("Location: ./?msg=dry");
				exit();
			} 

			$aleatorio = GetRandomValue($minReward,$hasta);
			
			$cantidadEnviar = ($aleatorio*$dividirEntre)-$transactionFee;


			$destination = array("amount" => $cantidadEnviar, "address" => $wallet);
			$date = new DateTime();
			$timestampUnix = $date->getTimestamp()+5;
			$peticion = array(
				"destinations" => $destination,
				"payment_id"=> $paymentID, 
				"fee" => $transactionFee, 
				"mixin"=>6, 
				"unlock_time" => 0
				);
				//print_r($peticion);
			$transferencia = $bitcoin->transfer($peticion);

			if($transferencia == "Bad address"){
				header("Location: ./?msg=wallet");
				exit();
			}

			if (array_key_exists("tx_hash",$transferencia)) {
				$query = "INSERT INTO `payouts` (`payout_amount`,`ip_address`,`payout_address`,`payment_id`,`timestamp`) VALUES ('$cantidadEnviar','$direccionIP','$wallet','$paymentID',NOW());";
				mysqli_query($link, $query);
				mysqli_close($link);
				header("Location: ./?msg=success&txid=".$transferencia['tx_hash']."&amount=".$aleatorio);
				exit();
			}else{

			}



		}else{
			header("Location: ./?msg=captcha");
			exit();
		}
	}else{
		header("Location: ./?msg=captcha");
		exit();
	}

exit();

	?>