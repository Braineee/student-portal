<div class="py-5" style="margin-top: 50px;">
  <div class="container">
      <div class="row">

        <?php include('inc/sidebar.php') ?>

        <div class="col-md-9">
          <div class="py-2">
            <h3>Fee Payment & Registration</h3>
          </div>
          <div class="row px-2 py-2">
            <table class="table table-responsive" style="width: 100%; border: 0px;">
              <tr width="100px">
                <td>
                  <img src="<?= BASE_URL ?>assets/icons/status.svg" alt="user_icon" width="20px" height="20px"> &ensp;
                  <span class="text-muted">Application number:</span>
                </td>
                <th>
                  <?= $_SESSION['applicant_details']->Appnum ?>
                </th>
              </tr>
              <tr width="100px">
                <td>
                  <img src="<?= BASE_URL ?>assets/icons/status.svg" alt="user_icon" width="20px" height="20px"> &ensp;
                  <span class="text-muted">Full Name:</span>
                </td>
                <th>
                  <?= $_SESSION['applicant_details']->Surname ?> <?= $_SESSION['applicant_details']->Firstname ?> <?= $_SESSION['applicant_details']->Othername ?>
                </th>
              </tr>
              <tr>
                <td>
                  <img src="<?= BASE_URL ?>assets/icons/status.svg" alt="user_icon" width="20px" height="20px"> &ensp;
                  <span class="text-muted">School:</span>
                </td>
                <th>
                  <?= $_SESSION['applicant_details']->SchoolName ?>
                </th>
              </tr>
              <tr>
                <td>
                  <img src="<?= BASE_URL ?>assets/icons/status.svg" alt="user_icon" width="20px" height="20px"> &ensp;
                  <span class="text-muted">Programme type:</span>
                </td>
                <th>
                  <?= $_SESSION['applicant_details']->PTName ?>
                </th>
              </tr>
              <tr>
                <td>
                  <img src="<?= BASE_URL ?>assets/icons/status.svg" alt="user_icon" width="20px" height="20px"> &ensp;
                  <span class="text-muted">Department:</span>
                </td>
                <th>
                  <?= $_SESSION['applicant_details']->PNName ?>
                </th>
              </tr>
              <tr>
                <td>
                  <img src="<?= BASE_URL ?>assets/icons/status.svg" alt="user_icon" width="20px" height="20px"> &ensp;
                  <span class="text-muted">Programme:</span>
                </td>
                <th>
                  <?= $_SESSION['applicant_details']->program ?>
                </th>
              </tr>
              <tr>
                <td>
                  <img src="<?= BASE_URL ?>assets/icons/status.svg" alt="user_icon" width="20px" height="20px"> &ensp;
                  <span class="text-muted">Session:</span>
                </td>
                <th>
                  <?= $_SESSION['applicant_details']->EntrySession ?>
                </th>
              </tr>
              <tr>
                <td>
                  <img src="<?= BASE_URL ?>assets/icons/status.svg" alt="user_icon" width="20px" height="20px"> &ensp;
                  <span class="text-muted">Amount:</span>
                </td>
                <th>
                  20000
                </th>
              </tr>
            </table>
            <div class="col-md-12 col-sm-12 py-2" >
              <form  method="post" action="http://portal.yabatech.edu.ng/yctpay/" style="border: solid 1px #cb2431; border-radius:5px;" class="px-4 py-4">
                <span style="color:#cb2431;"><b>Caution.</b></span>
                <p>Please ensure you have confirmed your details before proceeding to make this payment.</p>
                <hr>
    						<input name="studentnumber" type="hidden" id="studentnumber" value="<?PHP echo $std_app_num; ?>" />
    						<input name="sessionid" type="hidden" id="sessionid" value="<?PHP echo $new_session; ?>" />
    						<input name="paymentid" type="hidden" id="paymentid" value="<?PHP echo $payment_id; ?>" />
    						<input name="paymentamount" type="hidden" id="paymentamount" value="<?php echo number_format(($amount_to_pay), 2, ".",""); ?>" />
    					  <input name="paymentdescription" type="hidden" id="paymentdescription" value="<?PHP echo $payment_desc; ?>" />
    						<button
                  type="submit"
                  name="process" id="process"
                  style="margin-top:5px;"
                  class="btn payment-button">
                  <b>Proceed with payment</b>
                </button>
    					</form>
            </div>
          </div>
          <br>
          <a href="?pg=fees" class="btn back-button pull-right"><i class="fa fa-arrow-left"></i>&ensp;<b>Go back</b></a>
        </div>
    </div>
  </div>
</div>
