
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
      <!-- Include Editor style. -->
      <link href="<?= base_url().'assets/materialSummernote-master/css/materialSummernote.css';?>" rel="stylesheet">
      <link href="<?= base_url().'assets/materialSummernote-master/css/codeMirror/codemirror.css';?>" rel="stylesheet">
      <link href="<?= base_url().'assets/materialSummernote-master/css/codeMirror/monokai.css';?>" rel="stylesheet">
      <link href="<?= base_url().'assets/css/materializefont.css';?>" rel="stylesheet">

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <link rel="icon" href="<?= base_url().'gambar/logo_purch.png';?>">
    </head>
    <title><?= $title == "" ? "Purchasing System" : $title;?></title>
    
    <body class="red lighten-5">
      <div class="navbar-fixed">
        <div class="navbar" style="width: calc(100%-50%);left:300px;">
          <nav class="nav-wrapper amber darken-4 header">
            <div id="menu-bars"><button class="waves-effect waves-blue btn-flat white-text " id="button-side"><i class="fa fa-bars"></i></button></div>  
            <a href="#" class="brand-logo show-on-small hide-on-large-only" data-target="slide-out" style="font-size: 19px;">System Purchasing</a>
            <a href="<?= base_url();?>" id="brand-logo" class="show-on-large hide-on-med-and-down brand-logo center" for='dekstop'>Purchasing System</a>
            
            <a href="#" data-target="slide-out" class="sidenav-trigger show-on-small hide-on-up center" style="font-size: 16px"><i class='fa fa-bars'></i></a>

            <ul class="right hide-on-med-and-down">
              <?php if ($_SESSION['role'] == "superuser" ){?>
              <li><a href="<?= base_url().'add_user';?>"><i class="fa fa-user-plus"></i> Add User</a></li>
              <?php } ?>
              <?php if ($_SESSION['role'] != "user" ){?>
              <li><a href="<?= base_url('setting');?>"><i class="fa fa-wrench"></i> Setting</a></li>
              <?php }?>
              <li><a href="<?= base_url('user/logout');?>"><i class="fa fa-sign-out"></i> Logout</a></li>
            </ul>
          </nav>
        </div>
      </div>
      <ul id="slide-out" class="sidenav sidenav-fixed orange lighten-2" style=";overflow-y: hidden;">
        <!-- <ul id="slide-out" class="sidenav sidenav-fixed indigo lighten-5"> -->
        <li>
          <div class="user-view">
            <div class="background"> 
              <img src="<?= base_url().'gambar/background.jpg';?>" width="100%" height="100%">
            </div>
            <img id="img-user" class="circle responsive-img tooltip-red" src="<?= base_url().$_SESSION['icon'];?>">
            
            <span class="name" id="sayhi">Hi, <b><?= $_SESSION['nama'];?>!</b></span>
            
          </div>

        </li>
        <div id="header-side">
          <ul class="collapsible">

            <li>
              <div class="collapsible-header waves-effect">PKS<span class="new badge red" data-badge-caption=""><?= $_SESSION['pks'];?></span></div>
              
                <ul class="collapsible-body">
                  <li><a href="<?= base_url().'pks';?>">List PKS</a></li>
                </ul>
              
            </li>
            <li>
              <div class="collapsible-header waves-effect">Pengadaan</div>
              
                <ul class="collapsible-body">
                  <li><a href="<?= base_url().'pengadaan';?>">List Pengadaan</a></li>
                  <li><a href="<?= base_url().'invoice';?>">List Invoice</a></li>
                </ul>
              
            </li>
            <li>
              <div class="collapsible-header waves-effect">Register</div>
                <ul class="collapsible-body">
                  <li><a href="<?= base_url().'register/masuk';?>">Surat Masuk</a></li>
                  <!-- <li><a href="<?= base_url().'register/keluar';?>">Surat Keluar</a></li> -->
                  <li><a href="<?= base_url().'register/lembar_pengolahan';?>">Lembar Pengolahan</a></li>
                  <li><a href="<?= base_url().'register/warkat';?>">Warkat Purchasing</a></li>
                  <li><a href="<?= base_url().'register/gb';?>">Garansi Bank</a></li>
                </ul>
            </li>
          </ul>
          <li class="bold">
              <a href="<?= base_url().'tdr';?>" class="waves-effect waves-teal">TDR</a>
          </li>
          <!-- <li class="bold">
              <a href="<?= base_url().'pengumuman';?>" class="waves-effect waves-teal">Pengumuman</a>
          </li> -->

          <div style="margin-top: 150px" id="jam"></div>
        </div>
        
      </ul>
      <!-- Page Layout here -->
    

  <!-- end page Layout-->
<!--JavaScript at end of body for optimized loading-->
<script src="<?= base_url().'assets/js/jquery.min.js';?>"></script>
<script src="<?= base_url().'assets/js/select2.min.js';?>"></script>

<script src="<?= base_url().'assets/materialize/js/materialize.min.js';?>"></script>
<script src="<?= base_url().'assets/js/sweetalert2.min.js';?>"></script>
<script src="<?= base_url().'assets/js/select2-materialize.js';?>"></script>
<script src="<?= base_url().'assets/datatables/jquery.dataTables.min.js';?>"></script>
<script src="<?= base_url().'assets/datatables/Buttons-1.5.1/js/datatables.buttons.min.js';?>"></script>
<script src="<?= base_url().'assets/datatables/buttons.html5.min.js';?>"></script>
<script src="<?= base_url().'assets/js/moment.js';?>"></script>
<script src="<?= base_url().'assets/js/locale.js';?>"></script>
<script src="<?= base_url().'assets/datatables/Buttons-1.5.1/js/datatables.buttons.min.js';?>"></script>
<script src="<?= base_url().'assets/datatables/jszip.min.js';?>"></script>
<script src="<?= base_url().'assets/datatables/buttons.html5.min.js';?>"></script>
<script src="<?= base_url().'assets/datatables/buttons.print.min.js';?>"></script>
<script src="<?= base_url().'assets/datatables/Buttons-1.5.1/js/buttons.colVis.min.js';?>"></script>
<script src="<?= base_url().'assets/js/reza.js';?>"></script>
<script src="<?= base_url().'assets/js/popper.min.js';?>"></script>
<script src="<?= base_url().'assets/js/tooltip.min.js';?>"></script>


<script src="<?= base_url().'assets/materialSummernote-master/js/zzz_ckMaterializeOverrides.js';?>"></script>
<script src="<?= base_url().'assets/materialSummernote-master/js/codeMirror/codemirror.js';?>"></script>
<script src="<?= base_url().'assets/materialSummernote-master/js/codeMirror/xml.js';?>"></script>
<script src="<?= base_url().'assets/materialSummernote-master/js/materialSummernote.js';?>"></script>

<script>
  
  $(document).ready(function(){
   
    window.setInterval(jam, 1000);

    function jam(){
      moment.locale('id');
      let jam = moment().format('Do MMMM YYYY, ')+"<i class='fa fa-clock-o'></i> "+moment().format('h:mm:ss a');
      document.getElementById('jam').innerHTML = jam;
    }
    M.updateTextFields();
    $('.sidenav').sidenav();
    $('.collapsible').collapsible();
    
    $('#button-side').on('click', function(e){
      $('#slide-out').fadeToggle("slow", "swing");

      if($(this).parent().hasClass('leftside')){
       $(this).parent().removeClass('leftside');
      }else{
        $(this).parent().addClass('leftside');
      }
      if($('.first').children().hasClass('offset-l3 l9')){
        $('.first').children().removeClass('offset-l3 l9').addClass('l12');
        $('#table').DataTable().columns.adjust();
      }else{
        $('.first').children().removeClass('l12').addClass('offset-l3 l9');
        $('#table').DataTable().columns.adjust();
      }

      
    })

  });
</script>

    </body>
  </html>
