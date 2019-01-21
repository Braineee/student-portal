<div class="col-md-3 col-sm-4">
  <div class="card mb-4 shadow-sm">
    <img class="card-img-top" src="<?= $_SESSION['applicant_picture'] ?>" alt="Card image cap" height="250px" width="150px;">
    <div class="card-body text-center">
      <p class="card-text">
        <a href="?pg=biodata"><h5><b><strong><?= $_SESSION['applicant_details']->Appnum ?></strong></b></h5></a>
      </p>
      <hr>
      <div class="text-center">
        <h6 class=""><b>
          <?= ucfirst($_SESSION['applicant_details']->Surname) ?>&nbsp;
          <?= ucfirst($_SESSION['applicant_details']->Firstname) ?>&nbsp;
          <?= ucfirst($_SESSION['applicant_details']->Othername) ?>&nbsp;
        </h6></b>
        <small class="text-muted"><?= $_SESSION['applicant_details']->Phone ?></small>
      </div>
    </div>
  </div>
  <hr>
  <div>
    <b><?= strtolower($_SESSION['applicant_details']->program) ?></b>
  </div>
  <br>
  <div>
    <img src="<?= BASE_URL ?>assets/icons/status.svg" alt="user_icon" width="20px" height="20px"> &ensp;
    <b><?= strtolower($_SESSION['applicant_details']->EntrySession) ?></b>
  </div>
  <br>
  <div>
    <small>school fees status:</small><br>
    <img src="<?= BASE_URL ?>assets/icons/status.svg" alt="user_icon" width="20px" height="20px"> &ensp;
    <b>NOT PAID</b>
  </div>
  <br>
  <div>
    <small>Matric generation status:</small><br>
    <img src="<?= BASE_URL ?>assets/icons/status.svg" alt="user_icon" width="20px" height="20px"> &ensp;
    <b>NOT GENERATED</b>
  </div>
  <br>
  <br>
</div>
