<body>

<nav class="site-header navbar navbar-expand-lg navbar-dark bg-darker fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#"><img src="<?= BASE_URL ?>assets/img/logo_new.png" alt="YABATECH" width="50px"></a>
    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse collapse" id="navbarsExample07" style="">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#"><b>Dashboard</b><span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><b>Colleg home</b></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><b>Help desk</b></a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="https://example.com" id="dropdown07" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><b>Other links</b></a>
          <div class="dropdown-menu" aria-labelledby="dropdown07">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
      </ul>
      <div class="my-2 my-md-0 inline">
        <img class="inset" src="<?= $_SESSION['applicant_picture'] ?>" alt="applicant">&nbsp;
        <b style="color:#fff;"><?= ucfirst($_SESSION['applicant_details']->Surname) ?> <?= ucfirst($_SESSION['applicant_details']->Firstname) ?></b>&ensp;
        <a href="?pg=logout">
          <img src="<?= BASE_URL ?>assets/icons/logout.svg" alt="logout" width="30px" data-toggle="tooltip" data-placement="bottom" title="Click this button to sign out">
        </a>
      </div>
    </div>
  </div>
</nav>
