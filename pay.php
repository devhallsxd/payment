<?php
require realpath(__DIR__) . '/config/init.php';

$accountId = getStr('accountId');
$orderId = getStr('orderId');
$where = "accountId = '{$accountId}' AND orderId='{$orderId}'";
$result = selectData(PAYDB, '*', PAYTABLE, $where);

if ($result->rowCount() < 1) {
    outMsg(-1, 'Order exits');
}

$data = $result->fetch();
$money = $data['money'];
$account = $data['account'];
$userName = $data['userName'];
$payName = $data['payName'];
$svrName = $data['svrName'];

$where2 = "account ='{$account}'";
$result2 = selectData(PAYDB, '*', DLUSTABLE, $where2);
$data2 = $result2->fetch();
$djq = $data2['monery'];

if ($djq == "") {
    $djq = 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Monster-Master Recharge Center</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Orbitron', sans-serif;
            background-color: #0f0f1f;
            color: #fff;
            overflow-x: hidden;
        }

        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('path/to/your/background-image.jpg') no-repeat center center fixed;
            background-size: cover;
            z-index: -1;
        }

        .game-title {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 2.5rem;
            color: #00ffff;
            text-shadow: 0 0 10px #00ffff;
            animation: glow 2s ease-in-out infinite alternate;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(15, 15, 31, 0.8);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.3);
        }

        .page-title {
            text-align: center;
            color: #00ffff;
            font-size: 2rem;
            margin-bottom: 30px;
        }

        .card {
            background-color: rgba(30, 30, 60, 0.6);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .card-header {
            color: #00ffff;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .highlight {
            color: #ff00ff;
            font-weight: bold;
        }

        .balance, .price {
            font-size: 1.2rem;
        }

        .payment-options {
            margin-bottom: 30px;
        }

        .payment-options h3 {
            color: #00ffff;
            margin-bottom: 15px;
        }

        .payment-options label {
            display: block;
            margin-bottom: 10px;
            cursor: pointer;
        }

        .payment-options input[type="radio"] {
            margin-right: 10px;
        }

        .submit-btn {
            display: block;
            width: 100%;
            padding: 15px;
            background-color: #00ffff;
            color: #0f0f1f;
            border: none;
            border-radius: 5px;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #ff00ff;
            box-shadow: 0 0 15px #ff00ff;
        }

        @keyframes glow {
            from {
                text-shadow: 0 0 5px #00ffff, 0 0 10px #00ffff;
            }
            to {
                text-shadow: 0 0 10px #00ffff, 0 0 20px #00ffff, 0 0 30px #00ffff;
            }
        }
    </style>
</head>
<body>
    <div class="background">
        <h1 class="game-title">Monster-Master</h1>
    </div>
    <div class="container">
        <h2 class="page-title">Recharge</h2>
        <div class="card">
            <h3 class="card-header">Recharge Information</h3>
            <div class="card-body">
                <p class="balance">Voucher Balance: <span class="highlight"><?php echo $djq; ?></span></p>
                <p>Server: <?php echo $svrName; ?></p>
                <p>Account: <?php echo $account; ?></p>
                <p>Nickname: <?php echo $userName; ?></p>
                <p>Item: <?php echo $payName; ?></p>
                <p class="price">Amount: <span class="highlight"><?php echo $money; ?> €</span></p>
            </div>
        </div>
        
        <form action="SDK/kdjx_api.php" method="post" target="_blank">
            <input type="hidden" name="orderId" value="<?php echo $orderId; ?>">
            <input type="hidden" name="payName" value="<?php echo $payName; ?>">
            <input type="hidden" name="money" value="<?php echo $money; ?>">
            <input type="hidden" name="account" value="<?php echo $account; ?>">
            <input type="hidden" name="accountId" value="<?php echo $accountId; ?>">
            
            <div class="payment-options">
                <h3>Payment Methods</h3>
                <label>
                    <input type="radio" name="type" value="" checked>
                    <span>SOON</span>
                </label>
                <label>
                    <input type="radio" name="type" value="">
                    <span>SOON</span>
                </label>
                <label>
                    <input type="radio" name="type" value="">
                    <span>SOON</span>
                </label>
            </div>
            
            <button type="submit" class="submit-btn">PAY</button>
        </form>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.querySelector('.container');
            container.style.opacity = '0';
            container.style.transform = 'translateY(50px)';

            setTimeout(() => {
                container.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                container.style.opacity = '1';
                container.style.transform = 'translateY(0)';
            }, 100);

            const submitBtn = document.querySelector('.submit-btn');
            submitBtn.addEventListener('mouseover', () => {
                submitBtn.style.transform = 'scale(1.05)';
            });
            submitBtn.addEventListener('mouseout', () => {
                submitBtn.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>
