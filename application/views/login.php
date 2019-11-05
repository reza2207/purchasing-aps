
  <!DOCTYPE html>
  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="<?= base_url().'assets/font-awesome-4.7.0/css/font-awesome.css';?>" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="<?= base_url().'assets/materialize/css/materialize.min.css';?>"  media="screen,projection"/>
      <link href="<?= base_url().'assets/css/sweetalert2.min.css';?>" rel="stylesheet">
      <link href="<?= base_url().'assets/css/reza.css';?>" rel="stylesheet">

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <title>System Monitoring Purchasing</title>
    <style>
    #form-login{
    box-shadow: 10px 10px 5px#888888;
    }
    body{
      background-image: url("<?= base_url().'gambar/background.JPG';?>");
      background-repeat: no-repeat;background-size: 100%;background-position: center;background-size: cover;height:100vh;position: relative;
    }

      </style>
    <body>
      <nav>
        <div class="nav-wrapper deep-orange darken-3">
          <a href="#" data-target="slide-out" class="sidenav-trigger show-on-large brand-logo center" style="font-family: ogresse">System Monitoring Purchasing</a>
        </div>
      </nav>
      <!-- Page Layout here -->
      <div class="row col l12 s12">
        <?= form_open('', 'style="top: 20%;position: absolute;padding-top: 10px;", class="card-panel col s10 push-s1 l4 push-l4" id="form-login"');?>
          <div class="row center-align" style="margin-bottom: 0rem;">
            <div class="input-field col s12 l6 push-l3">
              <input id="username" type="text" class="validate">
              <label for="username">Username</label>
            </div>
          </div>
          <div class="row">
             <div class="input-field col s12 l6 push-l3">
              <input id="password" type="password" class="validate">
              <label for="password">Password</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col l8 push-l4">
              <a href="<?= base_url().'forgot_password';?>">Lupa Password?</a>
              <button class="waves-effect waves-light deep-orange darken-1 btn" type="reset">Reset</button>
              <button class="waves-effect waves-light btn" type="submit" id="login">Login</button>
            </div>
          </div>
          <div class="row">
            <div class="col l12 center">
              <marquee><b>BNI - Divisi Bisnis Kartu &copy 2018</b></marquee>
            </div>
          </div>
        <?= form_close();?>
      </div>
      <div class="row col l12 s12">
        <div class="col s10 push-s1 l4 push-l4 center" style="top: 90%;position: absolute;padding-top: 10px;font-family: comfortaa;color:blue">@2019 <a href="mailto:muhamad.reza@bni.co.id" style="color:blue">Muhamad Reza</a> &reg </div>


      </div>
       <div class="row col l12 s12">
        <div class="col s10 push-s1 l4 push-l4" style="" id="jamlogin"></div>
        

      </div>

    </body>
      <!--JavaScript at end of body for optimized loading-->
      <script src="<?= base_url().'assets/js/jquery.min.js';?>"></script>
      <script src="<?= base_url().'assets/js/sweetalert2.min.js';?>"></script>
      <script src="<?= base_url().'assets/js/moment.js';?>"></script>
      <script src="<?= base_url().'assets/js/locale.js';?>"></script>
      <script type="text/javascript" src="<?= base_url().'assets/materialize/js/materialize.min.js';?>"></script>
      
      <script>


  $(document).ready(function(){
    $('.sidenav').sidenav();
    $('#form-login').hover(function(){
      $(this).css('top', '20%');
    })
    
    window.setInterval(jam, 1000);

    function jam(){
      moment.locale('id');
      let jam = moment().format('Do MMMM YYYY, h:mm:ss a');
      document.getElementById('jamlogin').innerHTML = jam;
    }
    $('#login').on('click', function(e){
      e.preventDefault();
      let username = $('#username').val();
      let password = $('#password').val();

      $.ajax({
        type: 'POST',
        url : "<?= base_url().'user/login';?>",
        data : {username: username, password: password},
        success: function(response){
          
          let data = JSON.parse(response);
          if(data.status == 'success'){
          swal({
              type: data.status,
              text: data.pesan,
              allowOutsideClick: false
              }).then(function(){
                window.location.href="<?=base_url().'welcome';?>"; 
              })
          }else{
            swal({
              type: data.status,
              text: data.pesan,
              })
          }
        }, error: function(){
          console.log('Occured error!')
        }
      })
    })

  });
</script>

    </body>
  </html>
        