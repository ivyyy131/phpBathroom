<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ivy`s bathroom calculator</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="style.css" />
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
</head>

<body>
    <div class="container">
        <h1 class="heading">Frame Price Estimator</h1>
        <div class="form-container">
            <?php
            if (isset($_POST['submit'])) {
                #declaration of the input variables
                $height = $_POST['height'];
                $width = $_POST['width'];
                if ($_SERVER["REQUEST_METHOD"] === "POST") {
                    if ($height === "" && $width === "") {
                        echo "<p>Please complete all fields.</p>"; //Error message
                    } elseif ($height === "") {
                        echo "<p>Please complete height field.</p>"; //Error message
                    } elseif ($width === "") {
                        echo "<p>Please complete width field.</p>"; //Error message
                    }
                }
                $selectMenu = strip_tags(isset($_POST["SelectMenu"]) ? $_POST["SelectMenu"] : "");
                switch ($selectMenu) {
                    case "cm":
                        $height = $height / 100;
                        $width = $width / 100;
                        break;
                    case "m":
                        $height = $height;
                        $width = $width;
                        break;
                    case "inch":
                        $height = $height * 0.0254;
                        $width = $width * 0.0254;
                        break;
                    default:
                        echo "<p>Please choose a metric option.</p>";
                }
                $postage = strip_tags(isset($_POST["postage"]) ? $_POST["postage"] : "");
                $frameArea = (float)$height * (float)$width;
                $priceArea = round((($frameArea * $frameArea) + (90 * $frameArea) + 5), 2);
                $L = max($height, $width);
                if ($postage == "standard") {
                    $postageCosts = round(3 * $L + 4, 2);
                    $totalPrice = $priceArea + $postageCosts;
                    echo "<h3>Your frame will cost $priceArea lv plus standard postage of $postageCosts lv giving a total price of $totalPrice lv.</h3>";
                    $message = 'Your frame will cost ' . $priceArea . 'lv plus rapid postage of ' . $postageCosts . 'lv giving a total price of ' . $totalPrice . 'lv.';
                } else if ($postage == "rapid") {
                    $postageCosts = round(4 * $L + 8, 2);
                    $totalPrice = $priceArea + $postageCosts;
                    echo "<h3>Your frame will cost $priceArea lv plus rapid postage of $postageCosts lv giving a total price of $totalPrice lv.</h3>";
                    $message = 'Your frame will cost ' . $priceArea . 'lv plus rapid postage of ' . $postageCosts . 'lv giving a total price of ' . $totalPrice . 'lv.';
                } else {
                    echo "<h3>Your frame will cost $priceArea lv." . "</h3>";
                    $message = 'Your frame will cost ' . $priceArea . 'lv.';
                }
                // Subject of confirmation email.
                $conf_subject = "Frame Price Estimator";
                $mailTo = $_POST["Email"];
                if (filter_var($mailTo, FILTER_VALIDATE_EMAIL)) {
                    // Mail confirmation.
                    mail($mailTo, $conf_subject, $message);
                    echo "<p>Mail sent to $mailTo</p>";
                }
            } ?>
            <a class="submitBtn backBtn" href="/">Back</a>
        </div>
    </div>

</body>

</html>