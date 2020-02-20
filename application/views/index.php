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
          <div class="col l3 s12">
          <?php }else{?>
            <div class="col l4 s12">
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
          <div class="col l3 s12">
          <?php }else{?>
            <div class="col l4 s12">
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
          <div class="col l3 s12">
          <?php }else{?>
            <div class="col l4 s12">
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
          <!-- <div class="col l3">
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
          </div> -->
          <?php }?>
        </div>
      </div>
      <div class="col push-sl s9">
      </div>
      <div class="col push-l3 l9 s12">
        <div class="row">
          <div class="col s12 l1">

            <select class="select-m" id="thn">
              <?php foreach($this->Pengadaan_model->get_tahun() as $t){ ;?>
                <option><?= $t->tahun;?></option>
              <?php }?>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col s12" style="position: relative; height:70vh;">
            <canvas id="myChart"></canvas>
          </div>
        </div>
            
      </div>

    </div>

  <!-- page end layout -->

    <!-- end -->
<script>
  $(document).ready(function(){
      $('.slider').slider();
      $('.carousel').carousel();
      $('.select-m').formSelect();
    function loader(){
      $('.waiting').hide();
    }
    setTimeout(loader, 1000);
    setInterval(chart(<?= $this->Pengadaan_model->get_cur_y();?>),10000);
      if(<?= $pks->num_rows();?> > 0){
        swal({
          type: 'warning',
          text: '<?= $pks->num_rows() == 0 ? '': $pks->num_rows(). ' PKS yang akan berakhir';?>'
        })
        
      }

    });

    $('#thn').on('change', function(e){
      let thn = this.value;
      chart(thn);
    })
    
    function chart(thn)
    {
      $.ajax({
        type: 'POST',
        data: {tahun: thn},
        url: '<?= base_url()."pengadaan/get_p";?>',
        dataType: 'JSON',
        success: function(data){
          let ctx = document.getElementById('myChart').getContext('2d');

          if(window.bar != undefined)
            bar.destroy(); 

            bar = new Chart(ctx, {
              type: 'bar',
              data: {
                  labels: data.divisi,
                  datasets: [
                  {
                      label: data.jenis['Pembelian Langsung'],
                      data: data.trans['Pembelian Langsung'],
                      backgroundColor: [
                          'rgba(255, 99, 132, 0.2)',
                          'rgba(54, 162, 235, 0.2)',
                          'rgba(204, 134, 30, 0.2)',
                          
                      ],
                      borderColor: [
                          'rgba(255, 99, 132, 1)',
                          'rgba(54, 162, 235, 1)',
                          'rgba(204, 134, 30, 1)',
                          
                      ],
                      borderWidth: 1
                  },
                  {
                      label: data.jenis['Penunjukan Langsung'],
                      data: data.trans['Penunjukan Langsung'],
                      backgroundColor: [
                          'rgba(255, 99, 132, 0.2)',
                          'rgba(54, 162, 235, 0.2)',
                          'rgba(204, 134, 30, 0.2)',
                          
                      ],
                      borderColor: [
                          'rgba(255, 99, 132, 1)',
                          'rgba(54, 162, 235, 1)',
                          'rgba(204, 134, 30, 1)',
                          
                      ],
                      borderWidth: 1
                  },
                  {
                      label: data.jenis['Pemilihan Langsung'],
                      data: data.trans['Pemilihan Langsung'],
                      backgroundColor: [
                          'rgba(255, 99, 132, 0.2)',
                          'rgba(54, 162, 235, 0.2)',
                          'rgba(204, 134, 30, 0.2)',
                          
                      ],
                      borderColor: [
                          'rgba(255, 99, 132, 1)',
                          'rgba(54, 162, 235, 1)',
                          'rgba(204, 134, 30, 1)',
                          
                      ],
                      borderWidth: 1
                  },
                   {
                      label: data.jenis['Pelelangan'],
                      data: data.trans['Pelelangan'],
                      backgroundColor: [
                          'rgba(255, 99, 132, 0.2)',
                          'rgba(54, 162, 235, 0.2)',
                          'rgba(204, 134, 30, 0.2)',
                          
                      ],
                      borderColor: [
                          'rgba(255, 99, 132, 1)',
                          'rgba(54, 162, 235, 1)',
                          'rgba(204, 134, 30, 1)',
                          
                      ],
                      borderWidth: 1
                  }

                  ]
              },
              options: {
                  scales: {
                      yAxes: [{
                          ticks: {
                              beginAtZero: true
                          }
                      }]
                    },
                    title: {
                      display: true,
                      text: 'Pengadaan'
                    },
                  legend: {
                      display: false,
                      labels: {
                          fontColor: 'rgb(255, 99, 132)',

                      }
                  },

              }
            });
        }
      })
    }
</script>