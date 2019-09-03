<style>
#table-detail tr:hover
{
background: #D7A42B;color:white;
}
#modal-ubah label{color:white;

}
#table-detail tr td {
     padding-top:0px;padding-bottom:0px;font-size: 12px
}
#table-detail td:nth-of-type(1), #table-detail td:nth-of-type(4), #table-detail td:nth-of-type(7){
    font-weight: bolder
}
#t_perihal{
    background-color: #0b6347;font-family: comfortaa;text-align: center;color:white;
  }
  #tbisiinvoice th, td{
    padding: 0px 5px;
    
  }
</style>
<div class="waiting hide" id="waiting">
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
      </div>
    </div>
    <div class="warning-text">Loading...<i class='fa fa-smile-o'></i></div>
  </div>
</div>
<div class="row first">
  <!-- <div class="col s12"> -->
  <div class="col push-l3 l9" style="left: 333.25px;">
    <div class="row row-filter" style="margin-bottom: 0px;">

      <div class="input-field col s12 l1">
        <select id="tahunselect" class="select-m">

          <?php foreach ($tahun as $row){?>
            <option value="<?= $row->tahun ;?>"><?= $row->tahun ;?></option>
          <?php }?>
          <option value="semua">semua</option>
        </select>
        <label>Tahun</label>
      </div>

      <div class="input-field col s12 l1">
        
        <select id="divisiselect" class="select-m" >
          <option value="semua">semua</option>
          <?php foreach ($divisi as $dv){?>
          <option value="<?= $dv->divisi;?>"><?= $dv->divisi;?></option>
          <?php }?>
        </select>
        <label>Divisi</label>
      </div>
      <div class="input-field col s12 l2">
        <button class="waves-effect green waves-blue btn-flat" id="btn-filter"><i class="fa fa-filter"></i></button>
      </div>
    </div>
    <table class="table display"  id="table" style="font-family:'Times New Roman', Times, serif; font-size: 12px;width: 100%">
      <thead class="thead-dark teal">
        <tr class="rowhead">
          <th class="center align-middle">#</th>
          <th class="center align-middle">Tgl. Surat</th>
          <th class="center align-middle">No. Surat</th>
          <th class="center align-middle">Jenis Surat</th>
          <th class="center align-middle">Tgl. Disposisi</th>
          <th class="center align-middle">Perihal</th>
          <th class="center align-middle">Jenis</th>
          <th class="center align-middle">Divisi</th>
          <th class="center align-middle">Kewenangan</th>
        </tr>
      </thead>
    </table>
  </div>
</div>

<!-- Modal Structure add-->
<div id="modal_tambah" class="modal modal-fixed-footer">
  <div class="modal-content">
    
    <h6 id="title-modal"></h6>
    <?php
    $attrt = array('id'=>'formtambahdata');
    echo form_open('',$attrt);?>
    <div class="col s12 l12">
      <div class="row">
        <div class="input-field col s12 l3">
          <input name="tahun_pengadaan" type="number" maxlength="4" id="tahun_pengadaan" min="<?= date('Y')-2;?>" max="<?= date('Y');?>" required>
          <label>Tahun Pengadaan</label>
        </div>   
        <div class="input-field col s12 l3">
          <input name="tgl_surat" type="text" class="datepicker" id="tp_tahun_pengadaan" required>
          <label>Tgl. Surat</label>
        </div>
        <div class="input-field col l3 s12">
          <input name="no_surat" type="text" required>
          <label>No. Surat</label>
        </div>
        <div class="input-field col l3 s12">
          <select name="jenis_surat" class="select-m" required>
            <option value="">--pilih--</option>
            <option value="Notin">Notin</option>
            <option value="Memo">Memo</option>
            <option value="Email">Email</option>
          </select>
          <label>Jenis Surat</label>
        </div>
        <div class="input-field col l3 s12">
          <input name="tgl_disposisi" type="text" class="datepicker" id="tp_no_invoice" required>
          <label>Tgl. Disposisi Pimkel</label>
        </div>
        <div class="input-field col s12 l3">
          <select id="divisi" name="divisi" class="select-m" required>
            <option value="">--pilih--</option>
            <?php foreach ($divisi as $d){?>
            <option value="<?= $d->divisi;?>"><?= $d->divisi;?></option>
            <?php }?>
          </select>
          <label>Divisi</label>
        </div>
        <div class="input-field col s12 l3 kelompok hide">
          <input name="kelompok" type="text">
          <label>Kelompok</label>
        </div>
        <div class="input-field col s12 l3">
          <select name="jenis_pengadaan" class="select-m" id="n_jenis_pengadaan" required>
            <option value="Pembelian Langsung">Pembelian Langsung</option>
            
            <option value="Penunjukan Langsung">Penunjukan Langsung</option>
            <option value="Pemilihan Langsung">Pemilihan Langsung</option>
            <option value="Pelelangan">Pelelangan</option>
          </select>
          <label>Metode Pengadaan</label>
        </div>
        <div class="input-field col s12 l6">
          <input name="perihal" type="text" required>
          <label>Perihal</label>
        </div>
        <div class="input-field col s12 l3 usulan hide">
          <input name="no_usulan" type="text" required>
          <label>No. Usulan</label>
        </div>
        <div class="input-field col s12 l3 usulan hide">
          <input name="tgl_usulan" type="text" class="datepicker" required>
          <label>Tgl. Usulan</label>
        </div>
        <div class="input-field col s12 l6">
          <textarea name="keterangan" type="text" id="tp_nominal" class="materialize-textarea"></textarea>
          <label>Keterangan</label>
        </div>
        <div class="input-field col s12 l3 kewenangan hide" style="margin-top: 2rem;">
           <select id="kewenangan" name="kewenangan">
           </select>
          <label class='active' style=";top: -14px;">Kewenangan</label>
        </div>
      </div>
      <div class="row" style="max-height: 197px;overflow: scroll;" border="1">
        <table border="1" class="stripped highlight bordered" id="tbitem" style="font-size: 10px;table-layout: auto;width: 100%">
          <thead>
            <tr class='teal white-text' style="font-size: 10px">
              <th class="center" >#</th>
              <th class="center">Item</th>
              <th class="center">Ukuran</th>
              <th class="center">Bahan</th>
              <th class="center">Jumlah</th>
              <th class="center">Satuan</th>
              <th class="center">HPS (USD)</th>
              <th class="center">HPS (IDR)</th>
              <th class="center">HPS Satuan (IDR)</th>
              <th class="center">Penawaran (IDR)</th>
              <th class="center">Realisasi (Nego)(USD)</th>
              <th class="center">Realisasi (Nego)(Rp)</th>
              <th class="center">Realisasi (QTY/Unit)</th>
              <th class="center">Jumlah Realisasi</th>
              <th class="center">No. Kontrak</th>
              <th class="center">Tgl. Kontrak</th>
              <th class="center">Nama Vendor</th>
              <th class="center"></th>
              <!--th class="center">Bank Garansi</th-->
            </tr>
          </thead>
          <tbody class="rowitem" data-id="0">
          </tbody>
          <tfoot>
            <td class="center" colspan="13"></td>
            <td class="center teal white-text" id="total">Total</td>
          </tfoot>
        </table>
      </div>
    </div>
    <?= form_close();?>
  </div>
  <div class="modal-footer">
    <?php 
    if(isset($_SESSION['role'])){
      if($_SESSION['role'] != "user"){?>
        <button class="waves-effect blue waves-green btn-flat tooltipped white-text" id="btn-tmbh-item" data-position="left" data-delay="50" data-tooltip="klik untuk menambah row"><i class="fa fa-plus"></i></button>
        <button class="modal-close waves-effect waves-yellow btn-flat">CLOSE</button>
        <button id="btn-prosesbaru" type="submit" class="waves-effect blue waves-green  white-text btn-flat">PROSES</button>
      <?php }
    }?>
   
  </div>
  
</div>
<!-- end modal add-->
<!-- modal edit-->
<div id="modal-ubah" class="modal modal-fixed-footer">
  <div class="modal-content">
    <div class="col s12 l12">
      <div class="row">
        sss
      </div>
    </div>
  </div>
</div>
<!--end modal edit-->
<!-- Modal Structure detail-->
<div id="modal_detail" class="modal modal-fixed-footer">
  <div class="modal-content">  
    <div class="col s12 l12">
      <div class="row">
        <table id="table-detail">
          <tr>
            <td id="t_perihal" colspan="9"></td>
          </tr>
          <tr>
            <td>Tahun Pengadaan</td>
            <td>:</td>
            <td id="t_tahun_pengadaan"></td>
            <td>Tgl. Surat</td>
            <td>:</td>
            <td id="t_tgl_surat"></td>
            <td>No. Surat</td>
            <td>:</td>
            <td id="t_no_surat"></td>
          </tr>
          <tr>
            <td>Jenis Surat</td>
            <td>:</td>
            <td id="t_jenis_surat"></td>
            <td>Tgl. Disposisi</td>
            <td>:</td>
            <td id="t_tgl_disposisi"></td>
            <td>SLI</td>
            <td>:</td>
            <td id="t_sli"></td>
          </tr>
          
          <tr>
            <td>Jenis Pengadaan</td>
            <td>:</td>
            <td id="t_jenis_pengadaan"></td>
            <td>Divisi</td>
            <td>:</td>
            <td id="t_divisi"></td>
            <td>Kewenangan</td>
            <td>:</td>
            <td id="t_kewenangan"></td>
          </tr>
          <tr>
            <td>File</td>
            <td>:</td>
            <td id="t_file"></td>
            <td>Keterangan</td>
            <td>:</td>
            <td colspan="4" id="t_keterangan"></td>
          </tr>
        </table>
      </div>
      <div class="row" style="max-height: 300px;overflow: scroll;min-height: 210px" border="1">
        <table border="1" class="highlight stripped" id="tbisiinvoice" style="font-size: 10px;table-layout: fixed;">
          <thead>
            <tr class='teal white-text' style="font-size: 10px">
              <th class="center" width='10'>#</th>
              <th class="center" width='200'>Item</th>
              <th class="center" width='200'>Ukuran</th>
              <th class="center" width='200'>Bahan</th>
              <th class="center" width='80'>Jumlah</th>
              <th class="center" width='80'>Satuan</th>
              <th class="center" width='100'>HPS (USD)</th>
              <th class="center" width='100'>HPS (IDR)</th>
              <th class="center" width='100'>HPS Satuan (IDR)</th>
              <th class="center" width='100'>Penawaran (IDR)</th>
              <th class="center" width='100'>Realisasi (Nego)(USD)</th>
              <th class="center" width='100'>Realisasi (Nego)(Rp)</th>
              <th class="center" width='100'>Realisasi (QTY/Unit)</th>
              <th class="center" width='100'>Jumlah Realisasi</th>
              <th class="center" width='200'>No. Kontrak</th>
              <th class="center" width='80'>Tgl. Kontrak</th>
              <th class="center" width='190'>Nama Vendor</th>
              <th class="center" width='80'>Keberhasilan<br>Negosiasi</th>
              <!--th class="center">Bank Garansi</th-->
              <th class="center" width='150'>Status Pembayaran</th>
              <th class="center" width='38'>Action</th>
            </tr>
          </thead>
          <tbody class="rowisi">
          </tbody>
          
          <tfoot>
            <td class="center" colspan="13"></td>
            <td class="center teal white-text" id="t_total">Total</td>
          </tfoot>
        </table>
      </div>
    </div>
  
  </div>
  <div class="modal-footer">    
    <?php 
    if(isset($_SESSION['role'])){
      if($_SESSION['role'] == "superuser"){?>
        <button class="waves-effect yellow waves-green btn-flat" id="btn-ubah"><i class="fa fa-pencil"></i></button>
        <button class="waves-effect red waves-yellow btn-flat white-text" id="btn-hapus"><i class="fa fa-trash"></i></button>
    <?php }}?>
    <button class="modal-close grey waves-effect waves-yellow btn-flat">CLOSE</button>
    
  </div>
</div>

<!-- start inv-->
<div id="modal_inv" class="modal modal-fixed-footer ">
  <div class="modal-content">
    <?php $attrv = array('id'=>'forminv');?>
    <?= form_open('',$attrv);?>
      <div class="col s12 l12" id="kolominv" style="margin-bottom: 0px;">
        <div class="row">
          <div class="input-field col s12 l1">
            <input name="tahun" type="text" id="tp_tahun_pengadaan_inv" readonly>
            <label>Tahun</label>
          </div>
           <div class="input-field col l3 s12">
            <input type="text" id="tp_nama_vendor" readonly>
            <label>Vendor</label>
          </div>
          <div class="input-field col l3 s12">
            <input name="no_kontrak" type="text" id="tp_no_kontrak" readonly>
            <label>No. Kontrak</label>
          </div>
          <div class="input-field col l2 s12">
            <input type="text" id="tp_nilai_kontrak" readonly>
            <label>Nilai</label>
          </div>
          <div class="input-field col l3 s12">
            <input name="no_invoice" type="text" class="" id="tp_no_invoice" required>
            <label>No. Invoice</label>
          </div>
          <div class="input-field col s12 l3">
            <input name="tgl_invoice" type="text" class="datepicker" id="tp_tgl_invoice" required>
            <label>Tgl. Invoice</label>
          </div>
          <div class="input-field col s12 l6">
            <input name="perihal" type="text" class="" id="tp_perihal" data-length="250" required>
            <label>Perihal</label>
          </div>
          <div class="input-field col s12 l3">
            <input name="nominal" type="number" id="tp_nominal" min="0">
            <label>Nominal</label>
          </div>
          <div class="input-field col s12 l3">
            <input name="memo_keluar" type="text" id="tp_memo_keluar">
            <label>Memo Keluar*</label>
            <span class="helper-text" data-error="wrong" data-success="right">Optional</span>
          </div>
          <div class="input-field col s12 l3">
            <input name="invoice_ke_user" type="text" class="datepicker" id="tp_invoice_ke_user">
            <label>Tgl. Invoice Ke User</label>
          </div>
          <input name="id_vendor" type="text" class="hide" id="tp_id_vendor">
          <div class="input-field col s12 l3">
            <input type="text" class="" id="tp_sisa" readonly>
            <input type="text" class="" id="tps_sisa" hidden>
            <label>Sisa</label>
          </div>
          <div class="input-field col s12 l3">
            <button class="waves-effect waves-green teal btn-flat white-text" id="prosesinv">Proses</button>
          </div>
        </div>
      </div>
    <?= form_close();?>
      <div class="col s12 l12">
        <div class="row" style="margin-bottom: 0px;margin-top: -7px;">
            <blockquote class="row col s12 l12" style="margin-bottom: 0px;">
              Nilai Pengadaan: <span id="nom_pengadaan"></span> | Sisa Pembayaran: <span id="sisa_pengadaan"></span> <?php if($role == 'admin' || $role == 'superuser'){ ;?>|<a href="#" id="tambahdata" class="tooltipped" data-position="right" data-delay="50" data-tooltip="klik untuk menambah data">+ tambah data</a><?php };?>
            </blockquote>
          </div>
        <div class="row" style="margin-bottom: 0px;">
          <table class="" style="font-size: 10px">
            <thead>
              <tr style="font-weight: bolder;" class="center">
                <td>No</td>
                <td>No. Invoice</td>
                <td>Tgl. Invoice</td>
                <td>Keterangan</td>
                <td>No. Memo*</td>
                <td>Tgl. Verifikasi ke User</td>
                <td>Tgl. Kembali Dari User</td>
                <td>Tgl. Ke Bagian Pembayaran</td>
                <td>Nominal</td>
                <td>Action</td>
              </tr>
            </thead>
            <tbody class='rowinv'>
            </tbody>
          </table>
        </div>
      </div>
    
  </div>

  <div class="modal-footer">
    <button class="modal-close waves-effect waves-yellow btn-flat">CLOSE</button>
  </div>
</div>
<!-- end inv-->
<script>
  $(document).ready(function(){
    $('.tooltipped').tooltip({delay: 50});
   $('.select-m').formSelect();
    $(".select").select2({
      placeholder: 'Select an option',
      //theme: 'material'

    },$('select').css('width','100%'));

    //$('.select2-selection__arrow').addClass("fa fa-spin");

    $('#btn-filter').click(function(){ //button filter event click
        table.ajax.reload();  //just reload table
    });

    $('.datepicker').datepicker({
      container: 'body',
      format: 'dd-mm-yyyy',
      autoClose: true,
      disableWeekends:true,
      firstDay:1
    });
    
    $('tbody .rowitem tr td .datepicker').datepicker({
        container: 'body',
        format: 'yyyy-mm-dd',
        autoClose: true,

    });
   

    $('.modal').modal();
    $('.bg').hide();
    var table = $('#table').DataTable({
      "lengthMenu": [[5,10,25, 50, -1],[5,10,25,50, "All"]],
      "stateSave":false,
      "processing" : true,
      "serverSide": true,
      "order": [],
      "ajax":{
        "url": "<?= site_url('pengadaan/get_data_pengadaan');?>",
        "type": "POST",
        "data": function (data){
          data.tahun = $('#tahunselect').val();
          data.divisi = $('#divisiselect').val();
        }

      },
      "columns":[
        {"data": ['id_pengadaan']},
        {"data": ['tgl_notin']},
        {"data": ['no_notin']},
        {"data": ['jenis_notin_masuk']},
        {"data": ['tgl_disposisi']},
        {"data": ['perihal']},
        {"data": ['jenis_pengadaan']},
        {"data": ['divisi']},
        {"data": ['kewenangan']},
        
      ],
      "dom": 'Bflrtip',
             buttons: [
            { className: 'btn btn-sm light-blue darken-4', text: '[+] Add Data', attr: {id: 'add_data'} },
            { className: 'btn btn-sm light-blue darken-4', text: '<i class="fa fa-refresh"></i>', attr: {id: 'reload'}},
            { extend: 'copy', className: 'btn btn-sm light-blue darken-4', text: '<i class="fa fa-copy"></i>'},
            { extend: 'csv', className: 'btn btn-sm light-blue darken-4'},
            { extend: 'excel', className: 'btn btn-sm light-blue darken-4', text: '<i class="fa fa-file-excel-o"><i>'},
            ],
      "processing": true,
      "language":{
        "processing": "<div class='warning-alert'><i class='fa fa-circle-o-notch fa-spin'></i> Please wait........",
        "buttons": {
          "copyTitle": "<div class='row'><div class='col push-l3 l9' style='font-size:15px'>Copy to clipboard</div></div>",
          "copyKeys":"Press <i>ctrl</i> or <i>\u2318</i> + <i>C</i> to copy the table data<br>to your system clipboard.<br>To cancel, click this message or press escape.",
          "copySuccess":{
            "_": "%d line copied",
            "1": "1 line copied"
          }
        }
      },
      "columnDefs": [
            {
                "targets": [ 0, 1, 2, 3, 4, 6, 7, -1 ],
                "className": 'center'
            }
        ],
        "createdRow" : function(row, data, index){
          $(row).addClass('row');
          $(row).attr('data-id',data['id_pengadaan']);
        }
    })
    
    $('#add_data').on('click', function(){
      $('#formtambahdata input').val('');
       $('#total').html('');
      $('#modal_tambah').modal('open');
       $('.rowitem').empty();
       $('.rowinv tr:last td:first').empty();
    });

    $('#table_filter input ').attr('placeholder', 'Search here...');
    //$('#table_filter label').hide();
    let html = "<div class='input-field'><label class='active'>Search</label>"+
    "<input type='text' class='validate' id='searchnew' style='margin-left: -0.5em;'>"+
    "</div>";
    $('#table_filter label').html(html);

    
    $('#searchnew').on('keyup change', function(){
        table
          .search(this.value)
          .draw();
    });
    $('#reload').on('click', function(){ //reload
      $('#table').DataTable().ajax.reload();
    })
    
    $('#divisi').on('change', function(){
      $('#kewenangan').html('');
      let divisi = this.value;

      if(divisi == 'BSK'){
        $('.kelompok').removeClass('hide');
      }else{
        $('.kelompok').addClass('hide');
        $('.kelompok input').val('');
      }

      if(divisi == ''){
        $(".kewenangan").addClass('hide');
        $('.kewenangan select').find('option[value=""]').prop('selected', true);
      }else{
        $(".kewenangan").removeClass('hide');
      }

      $.ajax({
        type: 'POST',
        url : '<?= base_url()."pengadaan/get_kewenangan";?>',
        data: {'divisi':divisi},
        success: function(response){

          $('#kewenangan').select2({
          placeholder: 'Select an option',
          //theme: 'material'
          },$('select').css('width','100%'));

          let option= $('#kewenangan');
          $.each(JSON.parse(response), function(){ 
              option.append($("<option />").val(this.kewenangan).text(this.kewenangan));
          });

        }
      })
    });

    
    $("[name='table_length']").formSelect();

    //get detail after click in row
    $('tbody').on('click','.row', function(e){

      
      $('#modal_detail').modal('open');
      $('#waiting').removeClass('hide');
      let id = $(this).attr('data-id');//table.row($(this).parents('tr')).data();
      
      $('#btn-ubah').attr('data-id', id);
      $('#btn-hapus').attr('data-id', id);
      $('#btn-comment').attr('data-id', id);
      $('#proses').attr('data-id', id);
      data_tabel(id)
      
    })
    //proses invoice di row detail
    $('#tbisiinvoice tbody').on('click', '.proses-inv',function(e){
      let no_kontrak = $(this).attr('data-id');
      let tahun = $(this).attr('data-tahun');
      let id = $(this).attr('data-pengadaan');
      let idvendor = $(this).attr('data-vendor');
      let nmvendor = $(this).attr('data-nm_vendor');
      $('#kolominv').hide();
      $('#tambahdata').attr('data-kontrak', no_kontrak);
      $('#prosesinv').attr('data-id', id);
      $('#tambahdata').attr('data-pengadaan', id)
      $('#tambahdata').attr('data-tahun', tahun);
      $('#modal_inv').modal('open');
      $('#tp_id_vendor').val(idvendor);
      $('#tp_nama_vendor').val(nmvendor);
      $('#tp_tahun_pengadaan_inv').val(tahun);
      rowinv(no_kontrak, tahun, id);
    })
    $('#n_jenis_pengadaan').on('change', function(e){
      e.preventDefault();
      let jenis = this.value;
      if(jenis == 'Pembelian Langsung'){
        $('.usulan').addClass('hide');
        $('.usulan input').value('');
      }else{
        $('.usulan').removeClass('hide');
      }
    })

    $('#kolominv #tp_nominal').on('change ', function(e){
      let sisa = $('#tps_sisa').val() - this.value;
      $('#tp_sisa').val(sisa);
      if(sisa < 0){
        alert("Pembayaran melebihi batas")
      }

    })
    $('#btn-prosesbaru').on('click', function(e){
      e.preventDefault();
      $.ajax({
        type: 'POST',
        url : '<?= base_url()."pengadaan/submit_new_data";?>',
        data: $('#formtambahdata').serialize(),
        success: function(response){
          let data = JSON.parse(response);
          if(data.type == 'success'){
            swal({
              type: data.type,
              text: data.pesan,
              showConfirmButton: true,
              allowOutsideClick: false,
            }).then(function(){
              $('#modal_tambah').modal('close');
              $('.rowitem').html('');
              $('#table').DataTable().ajax.reload();
            })
          }else{
            swal({
              type: data.type,
              text: data.pesan,
              showConfirmButton: true,
              allowOutsideClick: false,
            })
          }
        }
      })       

    })
    $('#btn-ubah').on('click', function(e){
      
      $('#modal-ubah').modal('open');
    })
    //add invoice
    $('#tambahdata').on('click', function(e){
      let no_kontrak = $(this).attr('data-kontrak');
      let tahun = $(this).attr('data-tahun');
        $('#kolominv').toggle();
        $('#kolominv label').addClass('active');
        $('.rowitem tr:first td:first').text('');

    })
    
    $('#btn-tmbh-item').on('click', function(e){

     e.preventDefault();

      let nomor = $('.rowitem').children().length+1;

      let idselect = 'select'+nomor;
      let idselects = '#'+idselect;
      let rowitem = "<tr height='20'><td>"+nomor+"</td>"+
                      "<td><input type='text' placeholder='item' name='item[]' style='width: 200px'></td>"+
                      "<td><input type='text' placeholder='ukuran' name='ukuran[]' style='width: 200px'></td>"+
                      "<td><input type='text' placeholder='bahan' name='bahan[]' style='width: 200px'></td>"+
                      "<td><input type='number' placeholder='jumlah' name='jumlah[]' style='width: 80px'></td>"+
                      "<td><input type='text' placeholder='satuan' name='satuan[]' style='width: 80px'></td>"+
                      "<td><input type='number' placeholder='hps usd' name='hpsusd[]' style='width: 200px'></td>"+
                      "<td><input type='number' placeholder='hps idr' name='hpsidr[]' style='width: 200px'></td>"+
                      "<td><input type='number' placeholder='hps satuan' name='hpssatuan[]' style='width: 200px'></td>"+
                      "<td><input type='number' placeholder='penawaran' name='penawaran[]' style='width: 200px'></td>"+
                      "<td><input type='number' placeholder='realisasi (usd)' name='realisasiusd[]' style='width: 200px'></td>"+
                      "<td><input type='number' placeholder='realisasi (rp)' name='realisasirp[]' id='realisasirp"+nomor+"' data-id='"+nomor+"' class='realisasirp' style='width: 200px'></td>"+
                      "<td><input type='number' placeholder='realisasi (qty)' name='realisasiqty[]' id='realisasiqty"+nomor+"' data-id='"+nomor+"' class='realisasiqty' style='width: 200px'></td>"+
                      "<td><span id='jumlah"+nomor+"' class='jml'>qty x rp</span></td>"+
                      "<td><input type='text' placeholder='no. kontrak' name='nokontrak[]' style='width: 200px'></td>"+
                      "<td><input type='text' placeholder='tgl. kontrak' class='datepicker' id='tglkontrak"+nomor+"' name='tglkontrak[]' style='width: 200px'></td>"+
                      "<td><select name='vendor[]' style='width: 200px' id='"+idselect+"'><option value=''>--pilih--</option></select></td>"+
                      "<td></td></tr>";
      $('.rowitem').append(rowitem);

      $(idselects).select2({
          placeholder: 'Select an option',
          //theme: 'material'
      },$('select').css('width','200px'));

      $('.datepicker').datepicker({
        container: 'body',
        format: 'dd-mm-yyyy',
        autoClose: true,

      });

      $('.realisasirp, .realisasiqty').on('change', function(){
        let nomorid = $(this).attr('data-id');
        let idjml = '#jumlah'+nomorid;
        let rpreal = '#realisasirp'+nomorid;
        let qtyreal = '#realisasiqty'+nomorid;
        let jml = $(rpreal).val() * $(qtyreal).val();
        $(idjml).attr('data-id', jml);
        $(idjml).text('Rp.'+formatNumber(jml));

        let sum = 0;
        $(".jml").each(function(){
        //var value = $(this).text();
          let value = $(this).attr('data-id');
          if(!isNaN(value) && value.length != 0){
            sum += parseFloat(value);
            $('#total').text('Rp.'+formatNumber(sum));
          }
          
        })
      })

     

      $.post("<?= base_url()."tdr/get_tdr";?>", function(result){
          
        let options = $(idselects);

        $.each(JSON.parse(result), function() {
              options.append($("<option />").val(this.id_vendor).text(this.nm_vendor));
        });

      });
     
    })



    $('#tp_nominal').on('change', function(){
      //var nilai = $('#tp_nilai_kontrak').val();
      let nom = $(this).val();
      let sisaawal = $('#tps_sisa').val();
      let sisaakhir = sisaawal - nom;
      
      $('#tp_sisa').val(sisaakhir);
    })
    $('#prosesinv').on('click', function(e){
      //let no = $('.rowinv tr:last td:first').text();
      e.preventDefault();
      
      let html = '';
      let tahun = $('#tp_tahun_pengadaan').val();
      let no_kontrak = $('#tp_no_kontrak').val();
      let id = $(this).attr('data-id');
    
      $.ajax({
        type: 'POST',
        data: $('#forminv').serialize(),
        url : "<?= base_url().'Pengadaan/submit_invoice';?>",
        success: function(result){
          let data = JSON.parse(result);
          swal({
            type: data.type,
            text: data.pesan,
            showConfirmButton: true,
            allowOutsideClick: false,
          }).then(function(){
            $('#tp_no_invoice, #tp_tgl_invoice, #tp_perihal, #tp_nominal, #tp_memo_keluar, #tp_invoice_ke_user').val('');
            rowinv(no_kontrak, tahun, id);
            data_tabel(id)
          })
        }
      })

    })


    function rowinv(no_kontrak, tahun, id){
      $.ajax({
        type: 'POST',
        url: '<?= base_url()."pengadaan/get_kontrak";?>',
        data: {no_kontrak: no_kontrak, tahun: tahun,id:id},
        success: function(response){
          //  console.log(response);
          let r = JSON.parse(response);
          let html = "";
          $('.rowinv').html('');

          if(r['jml'] > 0){
            $('#tp_no_kontrak').val(no_kontrak);
            $('#tp_tahun_pengadaan_inv').val(tahun);
            $('#tp_sisa').val(r['data'][0].sisapembayaran);
            $('#tps_sisa').val(r['data'][0].sisapembayaran);
            $('#tp_nilai_kontrak').val(r['data'][0].nominalkontrak);
            
            $('#nom_pengadaan').text(formatNumber(r['data'][0].nominalkontrak));
            $('#sisa_pengadaan').text(formatNumber(r['data'][0].sisapembayaran));
          }else{
            $('#tp_no_kontrak').val(no_kontrak);
            $('#tp_tahun_pengadaan').val(tahun);
            $('#tp_nilai_kontrak').val(r['nominalkontrak']);
            $('#tp_sisa').val(r['nominalkontrak']);
            $('#tps_sisa').val(r['nominalkontrak']);
            $('#nom_pengadaan').text(formatNumber(r['nominalkontrak']));
            $('#sisa_pengadaan').text(formatNumber(r['nominalkontrak']));
          }
          
          if(r['jml'] > 0){
            let no = 0;
            for (i = 0; i < r['jml']; i++ ){  
              no++;
              html += "<tr><td>"+no+"</td>"+
                        "<td>"+r['data'][i].no_invoice+"</td>"+
                        "<td>"+r['data'][i].tgl_invoice+"</td>"+
                        "<td>"+r['data'][i].perihal+"</td>"+
                        "<td>"+r['data'][i].memo_keluar+"</td>"+
                        "<td>"+tanggal(r['data'][i].tgl_invoice_diantar)+"</td>"+
                        "<td contenteditable='true' class='edit-tgl' data-id='"+r['data'][i].id_invoice+"' data-idp='"+id+"' data-j='tk'>"+tanggal(r['data'][i].tgl_invoice_kembali)+"</td>"+
                        "<td contenteditable='true' class='edit-tgl' data-id='"+r['data'][i].id_invoice+"' data-idp='"+id+"' data-j='tp'>"+tanggal(r['data'][i].tgl_kebagian_pembayaran)+"</td>"+
                        "<td>"+formatNumber(r['data'][i].nominal)+"</td><td>hapus</td></tr>";

            }
            $('.rowinv').html(html);
            $('.edit-tgl').on('focus', function(e){
              let id = $(this);
              let valbfr = $(this).text();
              let idp = $(this).attr('data-idp');
              let idinv = $(this).attr('data-id');
              //data-j = jenis tgl update inv
              let j = $(this).attr('data-j');
              e.stopPropagation();
              $(this).datepicker({
                container: 'body',
                format: 'dd-mm-yyyy',
                autoClose: true,
                disableWeekends:true,
                firstDay:1,
                onSelect:function(d){
                  let tgl = d.getDate().toString().length == '1' ? '0'+d.getDate().toString() : d.getDate().toString();
                  let bln = (d.getMonth()+1).toString().length == '1' ? '0'+(d.getMonth()+1).toString() : (d.getMonth()+1).toString();
                  let thn = d.getFullYear();
                   date = tgl+'-'+bln+'-'+thn;
                  $(id).text(date);
                },
                onClose:function(c){
                  swal({
                    type: 'question',
                    text: 'Are you sure to changing this data?',
                    showConfirmButton: true,
                    allowOutsideClick: false,
                    showCancelButton:true
                  }).then(function(){
                    let val = $(id).text();
                    $.ajax({
                      type: 'POST',
                      url: '<?= base_url()."Pengadaan/update_inv";?>',
                      data: {id:idinv,tgl:val,j:j},
                      success: function(result){
                        let data = JSON.parse(result);
                        swal({
                          type: data.type,
                          text: data.pesan,
                          showConfirmButton: true,
                          allowOutsideClick: false,
                        }).then(function(){
                          data_tabel(idp)
                        })
                      }
                    })
                  }, function(isConfirm){
                    if(isConfirm == 'cancel'){
                      $(id).text(valbfr)
                    }
                  })
                }
              });
            })
          }else{
            html = '';
            $('.rowinv').html('');
          }
        }
      }) 
    }

    function data_tabel(id){
      $.ajax({
        type:'POST',
        url: '<?= base_url()."pengadaan/get_detail";?>',
        data: {id:id},
        success: function(result){
          $('#waiting').addClass('hide');
          let response = JSON.parse(result);
          let data = response.pengadaan;
          let detail = response.detail;
          let sli = response.sli;
          let html = "";
          $('.rowisi').html('');
          //console.log(response);
          $('#t_tahun_pengadaan').text(data.tahun);
          $('#t_tgl_surat').text(tanggal(data.tgl_notin));
          $('#t_no_surat').text(data.no_notin);
          $('#t_sli').text(sli+' HK');
          $('#t_jenis_surat').text(data.jenis_notin_masuk);
          $('#t_tgl_disposisi').text(tanggal(data.tgl_disposisi));
            
          $('#t_perihal').text(data.perihal);
          $('#t_jenis_pengadaan').text(data.jenis_pengadaan);
          $('#t_divisi').text(data.divisi);
          $('#t_kewenangan').text(data.kewenangan);
          let urlfile = "<a href='<?= base_url()."pengadaan/get_file/?file=";?>"+data.file+"&tahun="+data.tahun+"' target='_blank'>"+data.file+"</a>";
          $('#t_file').html(urlfile);
          if(detail.length > 0){
            let no = 0;
            let sum = 0;
            for(i = 0;i < detail.length;i++){
              no++;
              let nego;
              if(detail[i].realisasi_nego_rp <= detail[i].penawaran){
                nego = "Ya";
              }else{
                nego = "Tidak";
              }
              let proses, status;
              let role = "<?= $role;?>";
              if(role !== 'user'){
               edit = "<a href='#' class='edit-row-detail' data-id='"+detail[i].no_kontrak+"' data-pengadaan='"+id+"' data-vendor='"+detail[i].id_vendor+"'>edit</a>";
                status = "<a href='#' class='proses-inv' data-id='"+detail[i].no_kontrak+"' data-tahun='"+data.tahun+"' data-pengadaan='"+id+"' data-vendor='"+detail[i].id_vendor+"' data-nm_vendor='"+detail[i].nm_vendor+"'>"+detail[i].status+"</a>";
              }else{
                
                status = "<a href='#' data-id='"+detail[i].no_kontrak+"' data-pengadaan='"+id+"' data-vendor='"+detail[i].id_vendor+"'>"+detail[i].status+"</a>";
              }
              
              html += "<tr><td class='center' height='20'>"+no+"</td>"+
                      "<td class='center'>"+detail[i].item+"</td>"+
                      "<td class='center'>"+detail[i].ukuran+"</td>"+
                      "<td class='center'>"+detail[i].bahan+"</td>"+
                      "<td class='center'>"+formatNumber(detail[i].jumlah)+"</td>"+
                      "<td class='center'>"+detail[i].satuan+"</td>"+
                      "<td class='center'>"+formatNumber(detail[i].hps_usd)+"</td>"+
                      "<td class='center'>"+formatNumber(detail[i].hps_idr)+"</td>"+
                      "<td class='center'>"+formatNumber(detail[i].hps_satuan)+"</td>"+
                      "<td class='center'>"+formatNumber(detail[i].penawaran)+"</td>"+
                      "<td class='center'>"+formatNumber(detail[i].realisasi_nego_usd)+"</td>"+
                      "<td class='center'>"+formatNumber(detail[i].realisasi_nego_rp)+"</td>"+
                      "<td class='center'>"+formatNumber(detail[i].realisasi_qty_unit)+"</td>"+
                      "<td class='center jmlnom' data-id='"+detail[i].jml+"'>"+formatNumber(detail[i].jml)+"</td>"+
                      "<td class='center'>"+detail[i].no_kontrak+"</td>"+
                      "<td class='center'>"+tanggal(detail[i].tgl_kontrak)+"</td>"+
                      "<td class='center'>"+detail[i].nm_vendor+"</td>"+
                      "<td class='center' style='font-weight:bolder'>"+nego+"</td>"+
                      "<td class='center'>"+status+"</td>"+
                      "<td class='center'>"+edit+"</td>"+
                      "</tr>";
             
                      sum += parseFloat(detail[i].jml);
            }
            $('#t_total').text('Rp.'+formatNumber(sum));
            $('.rowisi').html(html);
          }
        }
      })
    }
   
  })
</script>