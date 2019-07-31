
  <!-- Page Layout here -->
    <div class="row first">
      <div class="col push-s3 s9">
        <div class="row">
          <div class="col s12">
            <ul class="tabs">
              <li class="tab col s3"><a href="#menu1">Change Password</a></li>
              <li class="tab col s3"><a class="" href="#menu2">Change Picture</a></li>
              <li class="tab col s3"><a href="#menu3">Test 4</a></li>
            </ul>
          </div>
          <div id="menu1" class="col s12">
            <?php $att = array('id'=>'form_cp');?>
            <?= form_open('', $att);?>
              <div class="row">
                <div class="col s6">
                  New Password:
                  <div class="input-field inline">
                    <input type="password" class="default" name="newpassword">
                    <!-- <span class="helper-text" data-error="wrong" data-success="right">Helper text</span> -->
                  </div>
                </div>
                <div class="col s12">
                  Confirm Password:
                  <div class="input-field inline">
                    <input type="password" class="default" name="confpassword">
                  </div>
                </div>
                <div class="col s12">
                  Recovery Question:
                  <div class="input-field inline">
                    <input type="text" class="default" name="recoveryQ">
                  </div>
                </div>
                <div class="col s12">
                  Recovery Answer:
                  <div class="input-field inline">
                    <input type="text" class="default" name="recoveryA">
                  </div>
                </div>
              </div>
            <?= form_close();?>
          </div>
          <div id="menu2" class="col s12">Test 2</div>
          <div id="menu3" class="col s12">Test 3</div>
        </div>
      </div>

    </div>

<script>
  $(document).ready(function(){
      $('.tabs').tabs();
      

    });
</script>