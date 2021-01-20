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
      <form action="submitForm.php" method="POST">
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
            <option value="m">m</option>
            <option value="inch">inch</option>
          </select>
        </p>
        <p>
          Postage:
          <input id="standard" type="radio" name="postage" value="standard" />
          <label for="standard">standard</label>
          <input id="rapid" type="radio" name="postage" value="rapid" />
          <label for="rapid">rapid</label>
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
        <input class="submitBtn" type="submit" name="submit" />
      </form>
    </div>
  </div>

</body>

</html>