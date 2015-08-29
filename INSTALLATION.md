#Bytecoin Faucet Installation

This faucet runs on a linux environment with PHP and MYSQL.

Faucet is set to work on the same server as bytecoin wallet and bytecoin daemon.

First of all you need to edit config.php to your custom parameters.

After you set config.php and after you have created a wallet with simplewallet, for faucet to communicate with bytecoin wallet you need to run simplewallet as this:

```bash
./simplewallet --wallet-file=wallet.bin --pass=password --rpc-bind-port=8070 --rpc-bind-ip=127.0.01
```


* wallet.bin needs to be the wallet file name that you enter when you created your wallet.
* password needs to be the password to open your wallet
* rpc-bind-port and rpc-bind-ip can be changed if so, you need to edit index.php and request.php (Please don't edit, as you may end opening the wallet rpc to the public)

You can also use screen program to keep the simplewallet and bytecoind running on background.