<?php
session_start();
include('../config/db.php');
if (isset($_SESSION['authenticated'])) {
} else {
  echo "<script>alert('you need to login first');
    window.location.href='../index.php';</script>";
}

?>


<nav class="navbar navbar-dark navbar-expand-sm bg-dark fixed-top">
  <div class="container">
    <a href="/" class="navbar-brand">
      <i class="fas fa-blog"></i> &nbsp; agora
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div id="navbarCollapse" class="collapse navbar-collapse">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a href="" class="nav-link active"> Home </a>
        </li>
        <li class="nav-item">
          <a href="" class="nav-link active"> Profile </a>
        </li>
        <li class="nav-item">
          <a href="" class="nav-link active"> Settings </a>
        </li>
        <li class="nav-item">
          <a class="btn btn-info my-2 my-sm-0" style="color:white" href="/qna/logout.php">Logout</a>

        </li>

      </ul>
    </div>
  </div>
</nav>