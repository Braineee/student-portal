
  <div class="py-5" style="margin-top: 50px;">
    <div class="container">
        <div class="row">
          <div class="col-md-3 col-sm-4">
            <div class="card mb-4 shadow-sm">
              <img class="card-img-top" src="<?= $_SESSION['applicant_picture'] ?>" alt="Card image cap" height="250px" width="150px;">
              <div class="card-body text-center">
                <p class="card-text">
                  <h5><b><strong><?= $_SESSION['applicant_details']->Appnum ?></strong></b></h5>
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
          </div>

          <div class="col-md-9">
            <div class="">
              <h3>Dashboard</h3>
              <hr>
            </div>
            <div class="row">
              <section>
                <div class="container py-3">
                  <div class="col-md-12 card" style="padding-left: 0px;padding-right: 0px;">
                    <a href="?pg=biodata" class="text-green">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 text-center v-align py-4">
                          <img src="<?= BASE_URL ?>assets/icons/user.svg" alt="user_icon" width="50px" height="50px">
                        </div>
                        <div class="col-md-8 col-sm-8">
                          <div class="card-block px-3 py-3">
                            <p class="card-text">
                              <b>Biodata</b><br>
                              Here you can print your biodata details.
                            </p>
                          </div>
                        </div>
                    </div>
                    </a>
                  </div>
                </div>
              </section>

              <section>
                <div class="container py-3">
                  <div class="col-md-12 card" style="padding-left: 0px;padding-right: 0px;">
                    <a href="?pg=biodata" class="text-green">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 text-center v-align py-4">
                          <img src="<?= BASE_URL ?>assets/icons/money.svg" alt="user_icon" width="50px" height="50px">
                        </div>
                        <div class="col-md-8 col-sm-8">
                          <div class="card-block px-3 py-3">
                            <p class="card-text">
                              <b>Fee payments & Receipts</b><br>
                              Make your school fees payment here.
                            </p>
                          </div>
                        </div>
                    </div>
                    </a>
                  </div>
                </div>
              </section>
            </div>
            <br>
            <div class="">
              <h3>Admission</h3>
              <hr>
            </div>
            <div class="row">
              <section>
                <div class="container py-3">
                  <div class="col-md-12 card" style="padding-left: 0px;padding-right: 0px;">
                    <a href="?pg=biodata" class="text-green">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 text-center v-align py-4">
                          <img src="<?= BASE_URL ?>assets/icons/award.svg" alt="user_icon" width="50px" height="50px">
                        </div>
                        <div class="col-md-8 col-sm-8">
                          <div class="card-block px-3 py-3">
                            <p class="card-text">
                              <b>Admission letter</b><br>
                              Print your admission letter here.
                            </p>
                          </div>
                        </div>
                    </div>
                    </a>
                  </div>
                </div>
              </section>

              <section>
                <div class="container py-3">
                  <div class="col-md-12 card" style="padding-left: 0px;padding-right: 0px;">
                    <a href="?pg=biodata" class="text-green">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 text-center v-align py-4">
                          <img src="<?= BASE_URL ?>assets/icons/matric.svg" alt="user_icon" width="50px" height="50px">
                        </div>
                        <div class="col-md-8 col-sm-8">
                          <div class="card-block px-3 py-3">
                            <p class="card-text">
                              <b>Matric number</b><br>
                              Generate your matriculation number here
                            </p>
                          </div>
                        </div>
                    </div>
                    </a>
                  </div>
                </div>
              </section>
            </div>
            <br>
            <div class="">
              <h3>Others</h3>
              <hr>
            </div>
            <div class="row">
              <section>
                <div class="container py-3">
                  <div class="col-md-12 card" style="padding-left: 0px;padding-right: 0px;">
                    <a href="?pg=biodata" class="text-green">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 text-center v-align py-4">
                          <img src="<?= BASE_URL ?>assets/icons/hostel.svg" alt="user_icon" width="50px" height="50px">
                        </div>
                        <div class="col-md-8 col-sm-8">
                          <div class="card-block px-3 py-3">
                            <p class="card-text">
                              <b>Hostel & Accomodation</b><br>
                              Make payments and registration <br>for hostel here.
                            </p>
                          </div>
                        </div>
                    </div>
                    </a>
                  </div>
                </div>
              </section>

              <section>
                <div class="container py-3">
                  <div class="col-md-12 card" style="padding-left: 0px;padding-right: 0px;">
                    <a href="?pg=biodata" class="text-green">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 text-center v-align py-4">
                          <img src="<?= BASE_URL ?>assets/icons/checklist.svg" alt="user_icon" width="50px" height="50px">
                        </div>
                        <div class="col-md-8 col-sm-8">
                          <div class="card-block px-3 py-3">
                            <p class="card-text">
                              <b>Payment confirmation & verification</b><br>
                              Click here for all payment <br>conirmation and verification
                            </p>
                          </div>
                        </div>
                    </div>
                    </a>
                  </div>
                </div>
              </section>
            </div>
          </div>

        </div>
      </div>
