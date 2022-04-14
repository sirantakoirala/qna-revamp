<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>
  <link href="./styles/agora.css" rel="stylesheet"> 
 
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
 <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>-->
  


<style>

  
  
  
 .bg-modal {
   width:100%;
   height:100%;
/*background-color:rgba(0, 0, 0, 0.7);*/
  position:absolute;
   top:0;
   display:flex;
   justify-content:center;
   align-items: center;
  display:none;
  overflow:hidden;
  

  

 }
 .modal-content {
   width:500px;
   height:auto;
   background-color:white;
   border-radius: 4px;
   text-align:center;
   padding:20px;
   position:relative;
   border-color:black;
 }

.close{
position:absolute;
top:0;
right:14px;
font-size:42px;
transform:rotate(42deg);
cursor:pointer;
}
   
.question-title{
  height: 5%;
    width: 99%;
    border-color: black;
    border-radius: 10px;
   
   
    padding-bottom: 2%;
    padding-top: 2%;
    margin-left: 0%;
    margin-top: 2%;
}
 
 
 
 </style>

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
  
  <
  <main style="margin-left: 0%;
    padding-top: 0%;
    margin-top: 0.5%;
    background: white; ">
  <?php include("../includes/sidebar.php") ?>

 <!-- This section is fro the button pop-up when we click the ask question button-->
  <div class="bg-modal">
  
   <div class="modal-content">
     
     <p> Ask question </p> 
   <div class="close">
     +
   </div>
   
   
  <form method="POST" action="./dashboard.php">
  <div class="question-title">
    <input type="text" class="question-title">
  </div>
  <div class="form-row">
  <input type="text" class="form-control is-valid" name="topic" id="topic" placeholder="Add a topic" style="    height: auto; width: 176%; border-color: black; border-radius: 10px; margin: 2%; padding-top: 2%;  padding-bottom: 38%;">
          <div class="col-md-4 mb-3"> <button id="btn btn-success" type="submit" name="addTopic" style= "    float: right; margin-right: 39%; margin-top: 2%; margin-bottom: 2%;  background-color: #4a6884;  border-color: #363636; border-radius: 15px; max-width: auto; width: auto; height: 94%;font-color: white; color: white;">Add topic</button></div>

          <form action="">
  <input type="file" id="myFile" name="filename">

</form>
        </div>
  
        
</form>
   </div>
          </div>


  
    <div class="container" style="background: white;
    padding-top: 2%;
    margin-top: -1%;">
     <label for="topic" style="font-size: 45px; margin-top: -10%;">Ask Question</label>
            <button id="modalbtn"> Add question </button>
            <script>
              

 document.getElementById("modalbtn").addEventListener("click", function() {
	document.querySelector(".bg-modal").style.display = "flex";
});

document.querySelector(".close").addEventListener("click", function() {
	document.querySelector(".bg-modal").style.display = "none";
});

    </script>

          
          
   


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

         

  <div class= "post-body">
           <div class="post-pan" style= "max-width: 70%; margin-left= 10%; border-color:#afafaf; border: solid 1px; border-radius: 9px;margin-bottom: 3%; height:auto;"> 
           <div class= "created">
          <img src="../pictures/svg/person-circle.svg" id="person-logo" style="margin-top: 1%; height: 29px; margin-left: 2%;">
              <h5 class="created" style="margin-top: 1%; float: right; margin-right: 32%;">Posted By: <?php echo $user ?> |  Created on: <?php echo $date ?></h5></div>
              <!--<p class="card-text" style="    margin-bottom: 4%; padding-top: 3%; float: right;">Created on: <?php echo $date ?></p>-->
            
            

           
            <div class="post-pan" style="padding: 3%;  margin-bottom: 2%;background-color: rgba(0,0,0,.03);  rgba(0,0,0,.125); border-color: black;" > 
              <h1 class="post-echo" style="margin-top: 5%;  padding-left: 4%;   font-size: 24px;" > 
             <?php echo $topic_subject;  ?></h1></div>
              <a  href="/qna/pages/posts.php?topic_id='<?php echo $id; ?>'"> 
              <img src="../pictures/svg/chat-left.svg" id="person-logo" style="margin-bottom: 1%; height: 25px; margin-left: 2%;"> </a>
              <img src="../pictures/svg/hand-thumbs-up.svg" id="person-logo" style="margin-bottom: 1%; height: 25px; margin-left: 7%;"> <img src="../pictures/svg/hand-thumbs-down.svg" id="person-logo" style="margin-bottom: 1%; height: 25px; margin-left: 7%;">
            
          </div>
        </div>
        



      <?php         }
      };
      ?>
    </div>
  </main>
</body>

</html>
