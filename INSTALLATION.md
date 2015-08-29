#Bytecoin Faucet Installation

This faucet runs on a linux environment with PHP and MYSQL, and it was tested on Ubuntu 15.04 with PHP 5.6.4 and MariaDB 5.5.

Faucet is set to work on the same server as bytecoin wallet and bytecoin daemon.

First of all you need to create a database for the faucet to save all requests:
```
CREATE TABLE IF NOT EXISTS `payouts` (
`id` bigint(20) unsigned NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `payout_amount` double NOT NULL,
  `payout_address` varchar(100) NOT NULL,
  `payment_id` varchar(75) NOT NULL,
  `timestamp` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
```

After you create database you need to edit config.php with all your custom parameters and also database information.


Now for faucet to communicate with bytecoin wallet you need to run simplewallet as this:

```bash
./simplewallet --wallet-file=wallet.bin --pass=password --rpc-bind-port=8070 --rpc-bind-ip=127.0.0.1
```

Note: Run this command after you already created a wallet.

And bytecoin daemon as this:

```bash
./bytecoind --rpc-bind-ip=127.0.0.1
```

* wallet.bin needs to be the wallet file name that you enter when you created your wallet.
* password needs to be the password to open your wallet
* rpc-bind-port and rpc-bind-ip can be changed if so, you need to edit index.php and request.php (Please don't edit, as you may end opening the wallet rpc to the public)

You can also use screen program to keep the simplewallet and bytecoind running on background.