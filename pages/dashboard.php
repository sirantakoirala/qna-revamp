<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body>
  <?php include("../includes/navbar.php") ?>
  <?php
  $conn = connectToDB();

  // require("../config/db.php");
  if (isset($_POST["addTopic"])) {
    $topic = $_POST["topic"];
    $userId =  $_SESSION['id'];

    $query = "INSERT INTO `topics`(`topic_id`, `topic_subject`, `topic_date`, `topic_by`) VALUES (default,'$topic',default,'$userId')";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    header("Location: ./dashboard.php");
  }

  ?>

  <main style="padding-top: 70px;">
    <div class="container">
      <h1>Welcome, <?php echo $_SESSION["username"] ?></h1>

      <form method="POST" action="./dashboard.php">
        <div class="form-row">
          <div class="col-md-4 mb-3"> <label for="topic">First name</label>
            <input type="text" class="form-control is-valid" name="topic" id="topic" placeholder="Add a topic" required>

          </div>

        </div>
        <div class="form-row">
          <div class="col-md-4 mb-3"> <button class="btn btn-success" type="submit" name="addTopic">Add topic</button></div>

        </div>
      </form>
      <h1>Topics</h1>


      <?php
      function console_log($output, $with_script_tags = true)
      {
        $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
          ');';
        if ($with_script_tags) {
          $js_code = '<script>' . $js_code . '</script>';
        }
        echo $js_code;
      }


      $query = "SELECT t.*,u.username FROM topics t JOIN users u ON u.id = t.topic_by";
      $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
          $topic_subject = $row['topic_subject'];
          $user = $row["username"];
          $id = $row["topic_id"] ?? "";
          $date = $row["topic_date"];
      ?>

          <div class="card border-primary mb-3" style="max-width:100%; margin:20px 0;">
            <div class="card-header border-success">
              <h1><a href="/qna/pages/posts.php?topic_id='<?php echo $id; ?>'"><?php echo $topic_subject; ?></a></h1>
            </div>
            <div class="card-body text-primary">
              <h5 class="card-title">Created By: <?php echo $user ?></h5>
              <p class="card-text">Created on: <?php echo $date ?>.</p>
            </div>
          </div>



      <?php         }
      };
      ?>
    </div>
  </main>
</body>

</html>
