

  <body>
    <div class="container" style="">
        <div class="col-md-4 col-sm-6 offset-4">
          <div class="col-md-12 col-sm-12">
            <div class="text-center">
              <img src="<?= BASE_URL ?>assets/img/logo_new.png" alt="YABATECH" width="100px">
              <h4 class="deep-green login">Sign to Applicant Portal</h4>
            </div>
            <div id="error">
            </div>
          </div>
          <div class="col-md-12 col-sm-12">
            <form class="form-signin">
              <label for="appnum" class="label" >
                  <b>Application number</b>
              </label>
              <input type="text" id="appnum" name="appnum" class="form-control input-shadow"  placeholder="e.g: yct1234567 or 12345678AB">


              <label for="password" class="label-password">
                  <b>Password</b>
              </label>
              <input type="password" id="password" name="password" class="form-control input-shadow" placeholder="Your phone no. is your password">
              <div class="text-right margin-buttom-10">
                <a href="#" class="forgot-password">Forgot password?</a>
              </div>
              <input type="hidden" name="form_token" value="<?php echo hash_hmac('sha256', Token::generate_unique('login'), $token); ?>">
              <button class="btn btn-md btn-success login-button btn-block form-control" type="submit" id="login">Sign in</button>
            </form>
          </div>
          <div class="col-md-12 col-sm-12 margin-10">
            <div class="student-portal">
              I have a matric number. <a href="http://portal.yabatech.edu.ng/portalplus">Go to student portal</a>
            </div>
          </div>
          <div class="col-md-12 col-sm-12 other-links inline text-center">
              <a href="http://yabatech.edu.ng" class="deep-green">Home</a>&ensp;
              <a href="http://portal.yabatech.edu.ng/escreening" class="deep-green">E-Screening</a>&ensp;
              <a href="http://portal.yabatech.edu.ng/helpdesk" class="deep-green">Help Desk</a>
          </div>
        </div>
    </div>
  </body>
  <script type="text/javascript" src="<?php echo BASE_URL; ?>ajax/login.js"></script>
