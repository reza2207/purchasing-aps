
    <body class="">
      <div class="row col l12 s12 print-error-msg">
        <div class="col s10 push-s1 l10 push-l2 print-error-msg">
          <div class="row print-error-msg">
            <div class="col s12 l4 push-l2 print-error-msg">
              <span class="red-text text-darken-2 print-error-msg" id="print-error-msg">
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Page Layout here -->
      <div class="row first">
        
        <div class="col s12 offset-l3 l9">
          <?= form_open('', array('id'=>'form_add'));?>
            <div class="row">
              <div class="input-field col s12 l4">
                <input id="username" name="username" type="text" class="validate">
                <label>Username</label>
              </div>
              <div class="input-field col s12 l3">
                <input id="password" type="password" name="password" class="validate">
                <label>Password</label>
              </div>
              <div class="input-field col s12 l3">
                <input id="password_conf" type="password" class="validate">
                <label>Confirm Password</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12 l10">
                <input id="full_name" type="text" name="full_name" class="validate">
                <label>Full Name</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12 l3">
                <input id="recovery" type="text" class="validate" name="recovery">
                <label>Recovery Question</label>
              </div>
              <div class="input-field col s12 l3">
                <input id="recovery_answer" type="text" class="validate" name="recovery_answer">
                <label>Recovery Question Answer</label>
              </div>
              <div class="input-field col s12 l4">
                <select id="role" name="role">
                  <option value="" disabled selected>Choose your option</option>
                  <option value="admin">Admin</option>
                  <option value="user">User</option>
                  <option value="superuser">SuperUser</option>
                </select>
                <label>Role</label>
              </div>
            </div>
            <div class="row show-on-large hide-on-med-and-down">
              <div class="input-field col l4 push-l8 s12">
                <button class="waves-effect waves-light deep-orange darken-1 btn" type="reset">Reset</button>
                <button class="waves-effect waves-light btn register" type="submit">Register</button>
              </div>
            </div>
            <div class="row show-on-small hide-on-med-and-up">
              <div class="input-field col s12">
                <button class="waves-effect waves-light deep-orange darken-1 btn" type="reset">Reset</button>
                <button class="waves-effect waves-light btn" type="submit">Register</button>
              </div>
            </div>
          <?= form_close();?>
        </div>
        
      </div>
      <!--JavaScript at end of body for optimized loading-->
      
<script>

  $(document).ready(function(){
    $('select').formSelect();

    $('#form_add').on('submit', function(e){
      e.preventDefault();
      let password = $('#password').val();
      let password_conf = $('#password_conf').val();
      if(password != password_conf){
        swal({
          type: 'error',
          text: 'Password tidak sama'
        })
      }else{
        $.ajax({
          type: "POST",
          url : "<?= site_url().'user/submit_register';?>",
          data: $(this).serialize(),
          success: function(response){
            let data = JSON.parse(response)
            if(data.status == 'success'){
              
              swal({
              type: data.status,
              text: data.pesan,
              }).then(function(){
              })
            }else{
              $(".print-error-msg").css('display','block');
              $("#print-error-msg").html(data.pesan);
            }
          }
        })
      }
      //swal(first_name);

    })
  });
</script>

    </body>
  </html>
        