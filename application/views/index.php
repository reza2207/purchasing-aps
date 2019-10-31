<!-- loader -->
    <div class="waiting">
      <div class="warning-alert">
        <div class="loader">
          <div class="preloader-wrapper big active">
            <div class="spinner-layer spinner-blue">
              <div class="circle-clipper left">
                <div class="circle"></div>
              </div>
              <div class="gap-patch">
                <div class="circle"></div>
              </div>
              <div class="circle-clipper right">
                <div class="circle"></div>
              </div>
            </div>

            <div class="spinner-layer spinner-red">
              <div class="circle-clipper left">
                <div class="circle"></div>
              </div>
              <div class="gap-patch">
                <div class="circle"></div>
              </div>
              <div class="circle-clipper right">
                <div class="circle"></div>
              </div>
            </div>

            <div class="spinner-layer spinner-yellow">
              <div class="circle-clipper left">
                <div class="circle"></div>
              </div>
              <div class="gap-patch">
                <div class="circle"></div>
              </div>
              <div class="circle-clipper right">
                <div class="circle"></div>
              </div>
            </div>

            <div class="spinner-layer spinner-green">
              <div class="circle-clipper left">
                <div class="circle"></div>
              </div>
              <div class="gap-patch">
                <div class="circle"></div>
              </div>
              <div class="circle-clipper right">
                <div class="circle"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="warning-text">Please Wait...<i class='fa fa-smile-o'></i></div>
      </div>
    </div>
  <!-- Page Layout here -->
    <div class="row first">
      <div class="col s12 offset-l3 l9">
        <div class="row">
          <?php if($_SESSION['role'] != 'user'){?>
          <div class="col l3">
          <?php }else{?>
            <div class="col l4">
          <?php }?>
            <div class="card hoverable">
              <div class="card-image waves-effect waves-block waves-orange orange darken-4" style="height: 250px">
                <div class="white-text" style="text-align: center;padding-top: 10px;font-size: 2em"><a href="<?= base_url().'PKS';?>" class="white-text">PKS</a></div>
                <div style="text-align: center" class="white-text activator"><i class="fa fa-handshake-o" style="font-size: 6em;padding-top: 20px"></i></div>
                <div style="text-align: center;padding-top: 20px" class="white-text activator"><?= $pks->num_rows() == 0 ? '': $pks->num_rows(). ' PKS yang akan berakhir';?></div>
              </div>
              <div class="card-reveal">
                <?php if($pks->num_rows() > 0 ){?>
                <span class="card-title orange darken-4-text text-darken-4" style="font-size: 12px;font-weight: bolder">PKS Yang Akan Berakhir<i class="fa fa-close right"></i></span>
                <?php $no = 1;foreach($pks->result() AS $row){?>
                <p style="font-size: 12px"><?= $no++.'. '.$row->perihal;?></p>
                <?php }
                }else{?>
                <span class="card-title orange darken-4-text text-darken-4" style="font-size: 12px;font-weight: bolder">PKS Yang Akan Berakhir<i class="fa fa-close right"></i></span>
                <p style="font-size: 12px">Nothing...</p>
                <?php }?>
              </div>
            </div>
          </div>
          <?php if($_SESSION['role'] != 'user'){?>
          <div class="col l3">
          <?php }else{?>
            <div class="col l4">
          <?php }?>
            <div class="card hoverable">
              <div class="card-image waves-effect waves-block waves-orange orange darken-4" style="height: 250px">
                <div class="white-text activator" style="text-align: center;padding-top: 10px;font-size: 2em"><a href="<?= base_url().'pengadaan';?>" class="white-text">Pengadaan <?= $year;?></a></div>
                <div style="text-align: center" class="white-text activator"><i class="fa fa-list-ol " style="font-size: 6em;padding-top: 20px"></i></div>
                <div style="text-align: center;padding-top: 20px" class="white-text activator"><?= $pengadaan->num_rows();?> Pengadaan tahun ini</div>
              </div>
              <div class="card-reveal">
               <?php if($pengadaan->num_rows() > 0 ){?>
                <span class="card-title orange darken-4-text text-darken-4" style="font-size: 12px;font-weight: bolder">Pengadaan <?= $year;?><i class="fa fa-close right"></i></span>
                <?php $no = 1;foreach($pengadaan->result() AS $row){?>
                <p style="font-size: 12px"><?= $no++.'. '.$row->perihal;?></p>
                <?php }
                }else{?>
                <span class="card-title orange darken-4-text text-darken-4" style="font-size: 12px;font-weight: bolder">Pengadaan <?= $year;?><i class="fa fa-close right"></i></span>
                <p style="font-size: 12px">Nothing...</p>
                <?php }?>
              </div>
            </div>
          </div>
          <?php if($_SESSION['role'] != 'user'){?>
          <div class="col l3">
          <?php }else{?>
            <div class="col l4">
          <?php }?>
            <div class="card hoverable">
              <div class="card-image waves-effect waves-block waves-orange orange darken-4" style="height: 250px">
                <div class="white-text activator" style="text-align: center;padding-top: 12px;font-size: 25px"><a href="<?= base_url().'register/masuk';?>" class="white-text">Register Masuk <?= $year;?></a></div>
                <div style="text-align: center" class="white-text activator"><i class="fa fa-envelope-o" style="font-size: 6em;padding-top: 20px"></i></div>
                <div style="text-align: center;padding-top: 20px" class="white-text activator"><?= $register_masuk->num_rows();?> Register masuk tahun ini</div>
              </div>
              <div class="card-reveal">
                <?php if($register_masuk->num_rows() > 0 ){?>
                <span class="card-title orange darken-4-text text-darken-4" style="font-size: 12px;font-weight: bolder">Register Surat Masuk <?= $year;?><i class="fa fa-close right"></i></span>
                <?php $no = 1;foreach($register_masuk->result() AS $row){?>
                <p style="font-size: 12px"><?= $no++.'. '.$row->perihal;?></p>
                <?php }
                }else{?>
                <span class="card-title orange darken-4-text text-darken-4" style="font-size: 12px;font-weight: bolder">Register Surat Masuk <?= $year;?><i class="fa fa-close right"></i></span>
                <p style="font-size: 12px">Nothing...</p>
                <?php }?>
              </div>
            </div>
          </div>
          <?php if($_SESSION['role'] != 'user'){?>
          <div class="col l3">
            <div class="card hoverable">
              <div class="card-image waves-effect waves-block waves-orange orange darken-4" style="height: 250px">
                <div class="white-text activator" style="text-align: center;padding-top: 10px;font-size: 2em"><a href="<?= base_url().'register/my_task';?>" class="white-text">My Task</a></div>
                <div style="text-align: center" class="white-text activator"><i class="fa fa-tasks" style="font-size: 6em;padding-top: 20px"></i></div>
                <div style="text-align: center;padding-top: 20px" class="white-text activator">ss</div>
              </div>
              <div class="card-reveal">
                <span class="card-title orange darken-4-text text-darken-4" style="font-size: 12px">My Task<i class="fa fa-close right"></i></span>
                <p>Here is some more information about this product that is only revealed once clicked on.</p>
              </div>
            </div>
          </div>
          <?php }?>
        </div>
      </div>
      <div class="col push-s3 s9">
      </div>
      <div class="col push-s3 s9">
        <div class="collection with-header">
          <li class="collection-header"><h4>Pengumuman</h4></li>
          <a href="#!" class="collection-item">tes</a>
          <a href="#!" class="collection-item">tes</a>
          <a href="#!" class="collection-item">tes</a>
          <a href="#!" class="collection-item">tes</a>
          <a href="#!" class="collection-item">tes</a>
          <li class="collection-item"></a>
        </div>
            
      </div>

    </div>

  <!-- page end layout -->

    <!-- end -->
<script>
  $(document).ready(function(){
      $('.slider').slider();
      $('.carousel').carousel();

    function loader(){
      $('.waiting').hide();
    }
    setTimeout(loader, 1000);
      if(<?= $pks->num_rows();?> > 0){
        swal({
          type: 'warning',
          text: '<?= $pks->num_rows() == 0 ? '': $pks->num_rows(). ' PKS yang akan berakhir';?>'
        })
        
      }

    });
</script>