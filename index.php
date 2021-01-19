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
      <form action="index.php" method="POST">
        <p>
          Frame of size:
          <input class="area-values" type="number" step="0.1" min="0" name="height" value="<?php echo isset($_POST["height"]) ? $_POST["height"] : ""; ?>" placeholder="Height" />
          x
          <input class="area-values" type="number" step="0.1" min="0" name="width" value="<?php echo isset($_POST["width"]) ? $_POST["width"] : ""; ?>" placeholder="Width" />
          <select name="SelectMenu">
            <option value="" selected disabled>
              <?php if (strip_tags(isset($_POST["SelectMenu"]) ? $_POST["SelectMenu"] : "") == "") {
                echo "Please pick";
              } else {
                echo strip_tags(isset($_POST["SelectMenu"]) ? $_POST["SelectMenu"] : "");
              } ?></option>
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
          <input id="email" type="email" name="Email" value="<?php echo strip_tags(isset($_POST["Email"]) ? $_POST["Email"] : ""); ?>" placeholder="Please enter your email" />
        </p>
        <div>
          <input type="checkbox" id="tick" name="db" value="" />
          <label for="tick">Receive mail and future information about my framing
            calculation</label>
        </div>
        <input type="hidden" name="form_submitted" value="1" />
        <input class="submitBtn" type="submit" />
      </form>
    </div>
  </div>

</body>

</html>
<?php
#declaration of the input variables
$height = strip_tags(isset($_POST["height"]) ? $_POST["height"] : "");
$width = strip_tags(isset($_POST["width"]) ? $_POST["width"] : "");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if ($height === "" && $width === "") {
    echo "<p>Please complete all fields.</p>"; //Error message
  } elseif ($height === "") {
    echo "<p>Please complete height field.</p>"; //Error message
  } elseif ($width === "") {
    echo "<p>Please complete width field.</p>"; //Error message
  }
} else {
  if (is_numeric($height) === false || is_numeric($width) === false) {
    $selectMenu = strip_tags(isset($_POST["SelectMenu"]) ? $_POST["SelectMenu"] : "");
    switch ($selectMenu) {
      case "mm":
        $height = $height / 1000;
        $width = $width / 1000;
        break;
      case "cm":
        $height = $height / 100;
        $width = $width / 100;
        break;
      case "inch":
        $height = $height * 0.0254;
        $width = $width * 0.0254;
        break;
    }
    $postage = strip_tags(isset($_POST["postage"]) ? $_POST["postage"] : "");
    $frameArea = (int)$height * (int)$width;
    $priceArea = round((($frameArea * $frameArea) + (90 * $frameArea) + 5), 2);
    $L = max($height, $width);
    if ($postage == "standard") {
      $postageCosts = round(3 * $L + 4, 2);
      $totalPrice = $priceArea + $postageCosts;
      echo "<p>Your frame will cost £$priceArea plus rapid postage of £$postageCosts giving a total price of £$totalPrice.</p>";
      $message = 'Your frame will cost £' . $priceArea . ' plus rapid postage of £' . $postageCosts . ' giving a total price of £' . $totalPrice . '.';
    } else if ($postage == "rapid") {
      $postageCosts = round(4 * $L + 8, 2);
      $totalPrice = $priceArea + $postageCosts;
      echo "<p>Your frame will cost £$priceArea plus rapid postage of £$postageCosts giving a total price of £$totalPrice.</p>";
      $message = 'Your frame will cost £' . $priceArea . ' plus rapid postage of £' . $postageCosts . ' giving a total price of £' . $totalPrice . '.';
    } else {
      echo "<p>Your frame will cost £$priceArea." . "</p>";
      $message = 'Your frame will cost £' . $priceArea . '.';
    }
    // Subject of confirmation email.
    $conf_subject = "Frame Price Estimator";
    $email = $_POST["Email"];
    echo "<p>Email: $email</p>";
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      // Mail confirmation.
      mail($email, $conf_subject, $message);
    }
  }
}
?>