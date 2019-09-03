<style>
  #image-preview {
    width: 150px;
    height: 150px;
    position: relative;
    overflow: hidden;
    background-color: #ffffff;
    color: #ecf0f1;
    border-radius: 100px
  }
  #image-preview input {
    line-height: 200px;
    font-size: 200px;
    position: absolute;
    opacity: 0;
    z-index: 10;
  }

  #image-old{
    position:relative;
  }
  #image-old label{
    position: absolute;
    padding-top: 50px;
    width: 150px;
    color:black;
    text-shadow: 3px 2px 2px #46d53d;
    text-align: center;
  }
  #image-preview label {
    position: absolute;
    z-index: 5;
    opacity: 0.8;
    cursor: pointer;
    
    width: 150px;
    height: 150px;
    
    line-height: 50px;
    text-transform: uppercase;
    top: 0;
    padding-top: 48px;
    left: 0;
    right: 0;
    bottom: 0;
    margin: auto;
    text-align: center;
  }
  #image-preview i {
    position: absolute;
    z-index: 5;
    opacity: 0.8;
    cursor: pointer;
    font-size: 5em;
    width: 150px;
    height: 150px;
    padding-top: 48px;
    line-height: 50px;
    text-transform: uppercase;
    top: -20px;
    
    left: 0;
    right: 0;
    bottom: 0;
    margin: auto;
    text-align: center;
  }
</style>
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
            <?= form_open('', array('id'=>'form_cp'));?>
              <div class="row">
                <div class="input-field col s6">
                  <label>New Password:</label>
                  <input type="password" id="newpassword" class="validate" name="newpassword">
                </div>
                <div class="input-field col s6">
                  <input type="password" id="confpass" class="default" name="confpassword">
                  <label>Confirm New Password :</label>
                </div>
              </div>
              <!-- <div class="row">
                <div class="input-field col s6">
                  <input type="text" class="default" name="question" value="<?= $user->recovery_q;?>">
                  <label>Question Recovery:</label>
                </div>
                <div class="input-field col s6">
                  <input type="text" class="default" value="<?= $user->answer_rec;?>" name="answer">
                  <label>Answer Recovery:</label>
                </div>
              </div> -->
              <div class="row">
                <div class="input-field col s6">
                  <button class="btn teal">Submit</button>
                </div>
              </div>
            <?= form_close();?>
          </div>
          <div id="menu2" class="col s12">
            <?= form_open_multipart('', array('id'=>'form_pict'));?>
              <div class="row">
                <div class="input-field col s6" id="image-old">
                  <img class="responsive-img circle" src="<?= base_url().$user->profil_pict;?>" style='height:150px;width: 150px'><br>
                  <label>Old Photo</label>
                </div>
                <div class="input-field col s6" id="image-preview">
                  <label for="image-upload" id="image-label"><i class='fa fa-camera'></i></label>
                  <input type="file" id="image-upload" name="image" >
                </div>
              </div>
              <div class="row">
                <div class="file-field input-field col s6">
                  
                  <button class="btn teal" type="submit" id="btn-upload">Upload</button>
                </div>
              </div>
            <?= form_close();?>
          </div>
          <div id="menu3" class="col s12">Test 3</div>
        </div>
      </div>

    </div>
<script src="<?= base_url().'assets/js/jquery.uploadPreview.min.js';?>"></script>
<script>
  $(document).ready(function(){
    $('.tabs').tabs();
     $.uploadPreview({
      input_field: "#image-upload",   // Default: .image-upload
      preview_box: "#image-preview",  // Default: .image-preview
      label_field: "#image-label",    // Default: .image-label
      label_default: "Choose File",   // Default: Choose File
      label_selected: "Change File",  // Default: Change File
      no_label: false                 // Default: false
    });

    $('#form_cp').on('submit', function(e){
      let form = $(this);
      e.preventDefault();
      let newpassword = $('#newpassword').val();
      let confpass = $('#confpass').val();
      if(newpassword != confpass){
        swal({
          type: 'error',
          text: 'Password didn\'t match',
          showConfirmButton: true,
          allowOutsideClick: false,
        })
      }else{
        $.ajax({
          type: 'POST',
          url : '<?= base_url()."";?>',
          data: $(this).serialize(),
          success: function(result){
            let data = JSON.parse(response);
            if(data.type = 'success'){
            swal({
                type: data.type,
                text: data.message,
                showConfirmButton: true,
                allowOutsideClick: false,
                showCancelButton:true
              }).then(function(){
                $(form)[0].reset();
              })
            }else{
              swal({
                type: data.type,
                text: data.message,
                showConfirmButton: true,
                allowOutsideClick: false,
                showCancelButton:true
              })
            }
          }
        })
      }
      
    })

    $('#form_pict').submit(function(e){
      let form = this;
      e.preventDefault();
      swal({
        type: 'question',
        text: 'Are you sure to change your profile picture?',
        showConfirmButton: true,
        allowOutsideClick: false,
        showCancelButton:true
      }).then(function(){

        $.ajax({
          url: '<?= base_url()."setting/update_photo_profile";?>',
          type: 'post',
          data: new FormData(form),
          contentType: false,
          processData: false,
          success: function(response){
            let data = JSON.parse(response);
            if(data.type = 'success'){
              swal({
                type: data.type,
                text: data.message,
                showConfirmButton: true,
                allowOutsideClick: false,
                showCancelButton:true
              }).then(function(){
                window.location.href="<?=base_url().'setting';?>"; 
              })
            }else{
              swal({
                type: data.type,
                text: data.message,
                showConfirmButton: true,
                allowOutsideClick: false,
                showCancelButton:true
              })
            }
          }
        })
      }, function(isConfirm){
        if(isConfirm == 'cancel'){
          swal({
            type: 'success',
            text: 'Okay',
            showConfirmButton: true,
          })
        }
      })
    })


  });
</script>