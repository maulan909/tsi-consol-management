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
            font-weight: bold;
            /* margin-bottom: 10px; */
        }

        .footer {
            width: 100%;
        }

        .footer .text {
            width: 73%;
            display: inline-block;
        }

        .footer .text.right {
            width: 25%;
            text-align: right;
            display: inline-block;
        }

        .complete {
            text-align: center;
        }
    </style>
</head>
<?php
if (isset($detail['ca_no'])) {
    $external = explode('/', $detail['ca_no']);
    if (strlen(end($external)) === 4) {
        $tipe = "CA";
    }
}
// var_dump($external);
?>

<body>
    <div class="container">
        <div class="header">
            <div class="picklist">PL ke <?php echo (isset($detail['consol'])) ? $detail['consol'] + 1 : 'undetected';  ?> / <?php echo (isset($detail['picklist'])) ? $detail['picklist'] : 'undetected';  ?></div>
            <div class="koli">
                <span class="text">Loc P : <?php echo (isset($detail['palet_no'])) ? $detail['palet_no'] : '';  ?></span>
                <span class="text">Loc F : <?php echo (isset($detail['palet_no'])) ? $detail['palet_no'] : '';  ?></span>
            </div>
        </div>
        <div class="hero">
            <h3><?php echo (isset($detail['kota'])) ? $detail['kota'] . " | " . $detail['zona'] : '';  ?></h3>
        </div>
        <div class="body">
            <div class="heading">FROZEN</div>
        </div>
        <div class="footer">
            <div class="text">
                <?php
                if (isset($tipe) && $tipe === "CA") {
                    echo $external[0] . "/" . $external[1] . "/" . $external[2] . "/<span style='font-size:36px;font-weight:bold;'>" . $external[3] . "</span>";
                } else {
                    echo (isset($detail['ca_no'])) ? $detail['ca_no'] : '';
                }
                ?>
            </div>
            <div class="text right">Q : <?= $detail['current']; ?> Koli</div>
            <?php
            if (isset($detail['picklist']) && isset($detail['consol'])  && ($detail['consol'] + 1) == $detail['picklist']) {
            ?>
                <div class="complete">Complete <?= $detail['koli'] + $detail['current']; ?> Koli</div>

            <?php
            } ?>
        </div>
    </div>
</body>

</html>