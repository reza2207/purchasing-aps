
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
      <div class="row col l12 s12">
        <?= form_open();?>
        <div class="col s10 push-s1 l10 push-l2">
          <div class="row">
            <div class="input-field col s12 l4 push-l2">
              <input id="username" type="text" class="validate">
              <label>Username</label>
            </div>
            <div class="input-field col s12 l4 push-l2">
              <input id="password" type="password" class="validate">
              <label>Password</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12 l8 push-l2">
              <input id="full_name" type="text" class="validate">
              <label>Full Name</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12 l4 push-l2">
              <input id="recovery" type="text" class="validate">
              <label>Recovery Question</label>
            </div>
            <div class="input-field col s12 l4 push-l2">
              <input id="recovery_answer" type="text" class="validate">
              <label>Recovery Question Answer</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12 l4 push-l2">
              <input>
            </div>
            <div class="input-field col s12 l4 push-l2">
              <select id="role">
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
        </div>
        <?= form_close();?>
      </div>
      <!--JavaScript at end of body for optimized loading-->
      
<script>

  $(document).ready(function(){
    $('select').formSelect();

    $('form').on('submit', function(e){
      e.preventDefault();
      let username = $('#username').val();
      let password = $('#password').val();
      let full_name = $('#full_name').val();
      let recovery = $('#recovery').val();
      let role = $('#role').val();
      let recovery_answer = $('#recovery_answer').val();

      $.ajax({
        type: "POST",
        url : "<?= site_url().'user/submit_register';?>",
        data: {username: username, password: password, full_name: full_name, recovery: recovery, recovery_answer: recovery_answer, role: role},
        success: function(response){
          let data = JSON.parse(response)
          if(data.status == 'success'){
            
            swal({
            type: data.status,
            text: data.pesan,
            }).then(function(){//redirect to 
            /*$('#username').val('');
            $('#password').val('');
            $('#full_name').val('');
            $('#recovery').val('');
            $('#role').val('');
            $('#recovery_answer').val('');*/
            })
          }else{
            $(".print-error-msg").css('display','block');
            $("#print-error-msg").html(data.pesan);
          }
        }
      })
      //swal(first_name);

    })
  });
</script>

    </body>
  </html>
        