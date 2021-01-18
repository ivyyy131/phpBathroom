<html lang="en">
<head>
	<meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ivy`s bathroom calculator</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="style.css" />
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
</head>
<body>

 <h1 class="heading">Frame Price Estimator</h1>
      <div class="form-container">
        <form action="framing.php" method="post">
          <p>
            Frame of size:
            <input
              class="area-values"
              type="int"
              name="length"
              value="<?php echo isset($_POST["length"]) ? $_POST["length"] : ""; ?>"
              placeholder="Height"
            />
            x
            <input
              class="area-values"
              type="int"
              name="width"
              value="<?php echo isset($_POST["width"]) ? $_POST["width"] : ""; ?>"
              placeholder="Width"
            />
            <select name="SelectMenu">
			        <option style="color: darkgrey" value="" selected disabled> <?php if(strip_tags(isset($_POST["SelectMenu"]) ? $_POST["SelectMenu"] : "") == "")
              {echo "Please pick";} else{ echo strip_tags(isset($_POST["SelectMenu"]) ? $_POST["SelectMenu"] : "");} ?> <br>
              <option value="cm">cm</option>
              <option value="mm">mm</option>
              <option value="inch">inch</option>
            </select>
          </p>
          <p>
            Postage:
            <input type="radio" name="postage" value="standard" /> standard
            <input type="radio" name="postage" value="rapid" /> rapid
          </p>
          <p>
            <label for="email">Email:</label>
            <input
              id="email"
              type="email"
              name="Email"
              value="<?php echo strip_tags(isset($_POST["Email"]) ? $_POST["Email"] : "");?>"
              placeholder="Please enter your email"
            />
          </p>
          <div>
            <input type="checkbox" id="tick" name="db" value="" />
            <label for="tick"
              >Receive mail and future information about my framing
              calculation</label
            >
          </div>
          <input class="submitBtn" type="submit"  />
        </form>
		</body>
	</html>
    <?php
    #declaration of the input variables
    $len = strip_tags(isset($_POST["length"]) ? $_POST["length"] : "");
    $width = strip_tags(isset($_POST["width"]) ? $_POST["width"] : "");
    if ($len === "" && $width === ""){
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            echo "<p>Please complete all fields.</p>";//Error message
        }
    }
    elseif ($len === "") { //conditions for erroneous submission
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            echo "<p>Please complete length field.</p>";//Error message
        }
    }
    elseif ($width === "") {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            echo "<p>Please complete width field.</p>";//Error message
        }
    }
    else {
        if(is_numeric($len) === false || is_numeric($width) === false){
            echo "<p>The width and height must be non-empty, numeric and between 0.2 and 2.0 m (or equivalent in other units).</p>";//Error message
        }
        else{
            $selectMenu = strip_tags(isset($_POST["SelectMenu"]) ? $_POST["SelectMenu"] : "");
            switch ($selectMenu) {
                case "mm":
                    $len = $len / 1000;
                    $width = $width / 1000;
                    break;
                case "cm":
                    $len = $len / 100;
                    $width = $width / 100;
                    break;
                case "inch":
                    $len = $len * 0.0254;
                    $width = $width * 0.0254;
                    break;
                default:
                    echo "<p>Please choose a metric option.</p>";
            }

            #Condition for metric input.
            if ($selectMenu !== "") {
                if(($len < 0.2 || $len > 2.0) || ($width < 0.2 || $width > 2.0)){
                    echo "<p>The width and height must be non-empty, numeric and between 0.2 and 2.0 m (or equivalent in other units).</p>";//Error message
                }
                else{
                    $postage = strip_tags(isset($_POST["postage"]) ? $_POST["postage"] : "");
                    $frameArea = $len * $width;
                    $priceArea = round((($frameArea * $frameArea) + (90 * $frameArea) + 5), 2);
                    $L = max($len, $width);
                    if ($postage == "standard") {
                        $postageCosts = round(3 * $L + 4, 2);
                        $totalPrice = $priceArea + $postageCosts;
                        echo "<p>Your frame will cost £$priceArea plus rapid postage of £$postageCosts giving a total price of £$totalPrice.</p>";
                        $message = 'Your frame will cost £'.$priceArea.' plus rapid postage of £'.$postageCosts.' giving a total price of £'.$totalPrice.'.';
                    } else if ($postage == "rapid") {
                        $postageCosts = round(4 * $L + 8, 2);
                        $totalPrice = $priceArea + $postageCosts;
                        echo "<p>Your frame will cost £$priceArea plus rapid postage of £$postageCosts giving a total price of £$totalPrice.</p>";
                        $message = 'Your frame will cost £'.$priceArea.' plus rapid postage of £'.$postageCosts.' giving a total price of £'.$totalPrice.'.';
                    } else {
                        echo "<p>Your frame will cost £$priceArea." . "</p>";
                        $message = 'Your frame will cost £'.$priceArea.'.';
                    }

                    // Subject of confirmation email.
                    $conf_subject = "Frame Price Estimator";
                    $email = $_POST["Email"];
                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        // Mail confirmation.
                        mail( $email, $conf_subject, $message);
                    }

          
                }
            }
        }
    }
    ?>

