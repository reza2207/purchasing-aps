
  <!DOCTYPE html>
  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="<?= base_url().'assets/font-awesome-4.7.0/css/font-awesome.css';?>" rel="stylesheet">
      <link href="<?= base_url().'assets/css/sweetalert2.min.css';?>" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="<?= base_url().'assets/materialize/css/materialize.min.css';?>"  media="screen,projection"/>
      <link rel="stylesheet" type="text/css" href="<?= base_url().'assets/datatables/DataTables-1.10.13/css/jquery.dataTables.min.css';?>"/>
      <link href="<?= base_url().'assets/css/select2.min.css';?>" rel="stylesheet">
      <link href="<?= base_url().'assets/css/balloon.css';?>" rel="stylesheet">
      
      <link href="<?= base_url().'assets/css/reza.css';?>" rel="stylesheet">

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <link rel="icon" href="<?= base_url().'gambar/logo_purch.png';?>">
    </head>
    <title><?= $title == "" ? "" : $title;?></title>
    <style>
    .collapsible-header, .collapsible-body{padding-left: 30px !important;}
    
    </style>
   
    <body class="red lighten-5">
      <div class="navbar-fixed">
        <div class="navbar"  style="width: calc(100%-50%);left:300px;">
          <nav class="nav-wrapper amber darken-4 header" style="">
           
              <a href="#" class="brand-logo show-on-small hide-on-large-only brand-logo "  data-target="slide-out" style="font-size: 19px;">System Purchasing</a>
              <a href="<?= base_url();?>" id="brand-logo" class="show-on-large hide-on-med-and-down brand-logo center" for='dekstop'>Purchasing System</a>
              
              <a href="#" data-target="slide-out" class="sidenav-trigger show-on-small hide-on-up center" style="font-size: 16px"><i class='fa fa-bars'></i></a>

              <ul class="right hide-on-med-and-down">
                <?php if ($_SESSION['role'] == "superuser" ){?>
                <li><a href="<?= base_url().'user/add_user';?>">Add User</a></li>
                <?php } ?>
                <li><a href="<?= base_url('setting');?>">Setting</a></li>
                <li><a href="<?= base_url('user/logout');?>">Logout</a></li>
              </ul>
            </div>
          </nav>
        </div>
      </div>
      <ul id="slide-out" class="sidenav sidenav-fixed orange lighten-2" style=";overflow-y: hidden;">
        <!-- <ul id="slide-out" class="sidenav sidenav-fixed indigo lighten-5"> -->
        <li>
          <div class="user-view" style="display: block;padding-left: 10px">
            <div class="background"> 
              <img src="<?= base_url().'gambar/background.jpg';?>" width="100%" height="100%">
            </div>
            <img id="img-user" class="circle responsive-img tooltip-red" src="<?= base_url().$_SESSION['icon'];?>" style="text-transform: capitalize;display: inline-block;border-style:solid;border-color:#d4e157;height: 100px;width: 100px;filter:grayscale(100%);" aria-label="I am red!">
            
            <span class="name" style="text-transform: capitalize;display: inline-block;position: absolute;padding-left: 10px;font-family: happySchool;letter-spacing: 2px;color:#00b0ff;text-shadow: 3px 2px 2px white;margin-top: 0px;">Hi, <b><?= $_SESSION['nama'];?>!</b></span>
            
          </div>

        </li>
        <style>
          .collapsible-header:hover , .bold a:hover{
            border-left: 6px solid #FF4500;
            
          }
        </style>
        <ul class="collapsible">
          <li class="">
            <div class="collapsible-header">PKS<span class="new badge red" data-badge-caption=""><?= $pks->num_rows();?></span></div>
            <div class="collapsible-body">
              <ul>
                <li><a href="<?= base_url().'pks';?>">List PKS</a></li>
              </ul>
            </div>
          </li>
          <li class="">
            <div class="collapsible-header">Pengadaan</div>
            <div class="collapsible-body">
              <ul>
                <li><a href="<?= base_url().'pengadaan';?>">List Pengadaan</a></li>
              </ul>
            </div>
          </li>
          <li>
            <div class="collapsible-header"> Register</div>
            <div class="collapsible-body">
              <ul>
                <li><a href="<?= base_url().'register/masuk';?>">Surat Masuk</a></li>
                <li><a href="<?= base_url().'register/keluar';?>">Surat Keluar</a></li>
                <li><a href="<?= base_url().'register/lembar_pengolahan';?>">Lembar Pengolahan</a></li>
                <li><a href="<?= base_url().'register/warkat';?>">Warkat Purchasing</a></li>
              </ul>
            </div>
          </li>
        </ul>
        <li class="bold">
            <a href="<?= base_url().'tdr';?>" class="waves-effect waves-teal">TDR</a>
        </li>
        <li class="bold">
            <a href="<?= base_url().'pengumuman';?>" class="waves-effect waves-teal">Pengumuman</a>
        </li>
      </ul>
        <!-- Page Layout here -->
    

  <!-- end page Layout-->
<!--JavaScript at end of body for optimized loading-->
<script src="<?= base_url().'assets/js/jquery.min.js';?>"></script>
<script src="<?= base_url().'assets/js/select2.min.js';?>"></script>

<script src="<?= base_url().'assets/js/select2-materialize.js';?>"></script>
<script src="<?= base_url().'assets/materialize/js/materialize.min.js';?>"></script>
<script src="<?= base_url().'assets/js/sweetalert2.min.js';?>"></script>
<script src="<?= base_url().'assets/js/select2-materialize.js';?>"></script>
<script src="<?= base_url().'assets/datatables/jquery.dataTables.min.js';?>"></script>
<script src="<?= base_url().'assets/datatables/Buttons-1.5.1/js/datatables.buttons.min.js';?>"></script>
<script src="<?= base_url().'assets/datatables/buttons.html5.min.js';?>"></script>
<script src="<?= base_url().'assets/js/moment.js';?>"></script>

<script src="<?= base_url().'assets/datatables/Buttons-1.5.1/js/datatables.buttons.min.js';?>"></script>
<script src="<?= base_url().'assets/datatables/jszip.min.js';?>"></script>
<script src="<?= base_url().'assets/datatables/buttons.html5.min.js';?>"></script>
<script src="<?= base_url().'assets/datatables/buttons.print.min.js';?>"></script>
<script src="<?= base_url().'assets/datatables/Buttons-1.5.1/js/buttons.colVis.min.js';?>"></script>
<script src="<?= base_url().'assets/js/reza.js';?>"></script>
<script src="<?= base_url().'assets/js/tooltip.min.js';?>"></script>
<script src="<?= base_url().'assets/js/popper.min.js';?>"></script>
<script>
  
  $(document).ready(function(){/*
    var ref = $('#img-user');        
    var popup = $('#popup');
    popup.hide();
    new Popper(ref, popup, {
      modifiers: {
        preventOverflow: { enabled: false }
      }
    })*/

    M.updateTextFields();
    $('.sidenav').sidenav();
    $('.collapsible').collapsible();
    $('.sidenav-unfixed').hide();

    $('#slide-out').on('click', )
  });
</script>

    </body>
  </html>
