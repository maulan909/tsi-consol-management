<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title_pdf ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: sans-serif;
            font-size: 18px;
        }

        .container {
            margin: 10px 10px;
            width: 100%;
            border: 3px solid black;
            padding: 10px 5px;
        }

        .header {
            width: 100%;
            display: inline-block;
        }

        .header .picklist,
        .header .koli {
            display: inline-block;
            width: 48%;
        }

        .header .koli {
            text-align: right;
        }

        .hero {
            text-align: center;
        }

        .hero h2 {
            margin: 0;
            padding: 0;
        }

        .body {
            text-align: center;
            font-size: 65px !important;
            margin-bottom: 10px;
        }

        .footer {
            width: 100%;
        }

        .footer .text,
        .footer .text.right {
            width: 48%;
            display: inline-block;
        }

        .footer .text.right {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="picklist">PL ke <?= $detail['consol'] + 1; ?> / <?= $detail['picklist']; ?></div>
            <div class="koli">
                <span class="text">Loc P : <?= $detail['palet_no']; ?></span>
                <span class="text">Loc F : <?= $detail['palet_no']; ?></span>
            </div>
        </div>
        <div class="hero">
            <h3><?= $detail['kota'] ?></h3>
        </div>
        <div class="body">
            <div class="heading">FROZEN</div>
        </div>
        <div class="footer">
            <div class="text"><?= $detail['ca_no']; ?></div>
            <div class="text right">Q : <?= $detail['current']; ?> Koli</div>
        </div>
    </div>
    <!-- <?php var_dump($detail); ?> -->
</body>

</html>