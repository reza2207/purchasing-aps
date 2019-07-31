<style>
#table-detail tr:hover
{
background: #D7A42B;color:white;
}
#modal_ubah label{color:white;

}
#table-detail tr td {
     padding-top:0px;padding-bottom:0px;font-size: 12px
}
#table-detail td:nth-of-type(1), #table-detail td:nth-of-type(4), #table-detail td:nth-of-type(7){
    font-weight: bolder
}
</style>
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
          <option value="BSK">BSK</option>
          <option value="PDM">PDM</option>
          <option value="EBK">EBK</option>
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
          <th class="text-center align-middle">#</th>
          <th class="text-center align-middle">Tgl. Surat</th>
          <th class="text-center align-middle">No. Surat</th>
          <th class="text-center align-middle">Jenis Surat</th>
          <th class="text-center align-middle">Tgl. Disposisi</th>
          <th class="text-center align-middle">Perihal</th>
          <th class="text-center align-middle">Jenis</th>
          <th class="text-center align-middle">Divisi</th>
          <th class="text-center align-middle">Kewenangan</th>
        </tr>
      </thead>
    </table>
  </div>
</div>

<!-- Modal Structure add-->
<div id="modal_tambah" class="modal modal-fixed-footer">
  <div class="modal-content">
    <?php
    $attrt = array('id'=>'formtambahdata');
    echo form_open('',$attrt);?>
    <h6 id="title-modal"></h6>
    
    <div class="col s12 l12">
      <div class="row">
        <div class="input-field col s12 l3">
          <input name="id_pengadaan" type="text" id="id_pengadaan">
          <label class="active" id="labelidpengadaan">Id Pengadaan</label>
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
          <input type="text" name="jenis_surat">
          <label>Jenis Surat</label>
        </div>
        <div class="input-field col l3 s12">
          <input name="tgl_disposisi" type="text" class="datepicker" id="tp_no_invoice" required>
          <label>Tgl. Disposisi</label>
        </div>
        <div class="input-field col s12 l3">
          <input name="tahun_pengadaan" type="number" maxlength="4" id="tahun_pengadaan" min="<?= date('Y')-2;?>" max="<?= date('Y')+2;?>" required>
          <label>Tahun Pengadaan</label>
        </div>
        <div class="input-field col s12 l6">
          <input name="perihal" type="text" required>
          <label>Perihal</label>
        </div>
        <div class="input-field col s12 l3">
          <input name="no_usulan" type="text" required>
          <label>No. Usulan</label>
        </div>
        <div class="input-field col s12 l3">
          <input name="tgl_usulan" type="text" class="datepicker" required>
          <label>Tgl. Usulan</label>
        </div>
        <div class="input-field col s12 l3">
          <select id="divisi" name="divisi" class="select-m" required>
            <option value="">--pilih--</option>
            <option value="BSK">BSK</option>
            <option value="PDM">PDM</option>
            <option value="EBK">EBK</option>
          </select>
          <label>Divisi</label>
        </div>
        <div class="input-field col s12 l3">
          <select name="jenis_pengadaan" class="select-m" required>
            <option value="Pembelian Langsung">Pembelian Langsung</option>
            <option value="Pemilihan Langsung">Pemilihan Langsung</option>
            <option value="Penunjukan Langsung">Penunjukan Langsung</option>
          </select>
          <label>Jenis</label>
        </div>
        <div class="input-field col s12 l3">
          <select class="select-m" name="pembuat_pekerjaan" required>

            <?php foreach ($select_user as $row){?>
            <option value="<?= $row->username;?>"><?= $row->nama;?></option>
            <?php }?>
          </select>
          <label>Pembuat Pekerjaan</label>
        </div>
        <div class="input-field col s12 l6">
          <input name="keterangan" type="text" id="tp_nominal">
          <label>Keterangan</label>
        </div>
        
        <div class="input-field col s12 l3" style="margin-top: 2rem;">
           <select id="kewenangan" name="kewenangan">
           </select>
          <label class='active' style=";top: -14px;">Kewenangan</label>
        </div>
      </div>
      <div class="row" style="max-height: 197px;overflow: scroll;" border="1">
        <table border="1" class="stripped highlight bordered" id="tbitem" style="font-size: 10px;table-layout: auto;width: 100%">
          <thead>
            <tr class='teal text-white' style="font-size: 10px">
              <th class="text-center" >#</th>
              <th class="text-center">Item</th>
              <th class="text-center">Ukuran</th>
              <th class="text-center">Bahan</th>
              <th class="text-center">Jumlah</th>
              <th class="text-center">Satuan</th>
              <th class="text-center">HPS (USD)</th>
              <th class="text-center">HPS (IDR)</th>
              <th class="text-center">HPS Satuan (IDR)</th>
              <th class="text-center">Penawaran (IDR)</th>
              <th class="text-center">Realisasi (Nego)(USD)</th>
              <th class="text-center">Realisasi (Nego)(Rp)</th>
              <th class="text-center">Realisasi (QTY/Unit)</th>
              <th class="text-center">Jumlah Realisasi</th>
              <th class="text-center">No. Kontrak</th>
              <th class="text-center">Tgl. Kontrak</th>
              <th class="text-center">Nama Vendor</th>
              <th class="text-center"></th>
              <!--th class="text-center">Bank Garansi</th-->
            </tr>
          </thead>
          <tbody class="rowitem" data-id="0">
          </tbody>
          <tfoot>
            <td class="text-center" colspan="13"></td>
            <td class="text-center teal text-white" id="total">Total</td>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <?php 
    if(isset($_SESSION['role'])){
      if($_SESSION['role'] == "superuser"){?>
        <button class="waves-effect blue waves-green btn-flat tooltipped" id="btn-tmbh-item" data-position="left" data-delay="50" data-tooltip="klik untuk menambah row"><i class="fa fa-plus"></i></button>
        <button class="waves-effect yellow waves-green btn-flat" id="btn-ubah"><i class="fa fa-pencil"></i></button>
        <button class="waves-effect red waves-yellow btn-flat" id="btn-hapus"><i class="fa fa-trash"></i></button>
    <?php }elseif($_SESSION['role'] == "admin"){?>
        <button class="waves-effect blue waves-green btn-flat tooltipped" id="btn-tmbh-item" data-position="left" data-delay="50" data-tooltip="klik untuk menambah row"><i class="fa fa-plus"></i></button>
    <?php }
    }?>
    <button class="modal-close waves-effect waves-yellow btn-flat">CLOSE</button>
    <button id="btn-prosesbaru" class="waves-effect blue waves-green btn-flat">PROSES</button>
  </div>
  <?= form_close();?>
</div>
<!-- end modal add-->
<!-- Modal Structure detail-->
<div id="modal_detail" class="modal modal-fixed-footer">
  <div class="modal-content">
    <h6 id="title-modal"></h6>
    
    <div class="col s12 l12">
      <div class="row">
        <table id="table-detail">
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
            <td>Perihal</td>
            <td>:</td>
            <td id="t_perihal" colspan="7"></td>
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
        </table>
      </div>
      <div class="row" style="max-height: 197px;overflow: scroll;" border="1">
        <table border="1" class="stripped highlight bordered" id="tbisiinvoice" style="font-size: 10px;table-layout: auto;width: 100%">
          <thead>
            <tr class='teal' style="font-size: 10px">
              <th class="text-center" >#</th>
              <th class="text-center">Item</th>
              <th class="text-center">Ukuran</th>
              <th class="text-center">Bahan</th>
              <th class="text-center">Jumlah</th>
              <th class="text-center">Satuan</th>
              <th class="text-center">HPS (USD)</th>
              <th class="text-center">HPS (IDR)</th>
              <th class="text-center">HPS Satuan (IDR)</th>
              <th class="text-center">Penawaran (IDR)</th>
              <th class="text-center">Realisasi (Nego)(USD)</th>
              <th class="text-center">Realisasi (Nego)(Rp)</th>
              <th class="text-center">Realisasi (QTY/Unit)</th>
              <th class="text-center">Jumlah Realisasi</th>
              <th class="text-center">No. Kontrak</th>
              <th class="text-center">Tgl. Kontrak</th>
              <th class="text-center">Nama Vendor</th>
              <th class="text-center">Keberhasilan<br>Negosiasi</th>
              <!--th class="text-center">Bank Garansi</th-->
              <th class="text-center">Status Pembayaran</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody class="rowisi">
          </tbody>
        </table>
      </div>
    </div>
  
  </div>
  <div class="modal-footer">    
    <?php 
    if(isset($_SESSION['role'])){
      if($_SESSION['role'] == "superuser"){?>
        <button class="waves-effect yellow waves-green btn-flat" id="btn-ubah"><i class="fa fa-pencil"></i></button>
        <button class="waves-effect red waves-yellow btn-flat" id="btn-hapus"><i class="fa fa-trash"></i></button>
    <?php }}?>
    <button class="modal-close waves-effect waves-yellow btn-flat">CLOSE</button>
    <button id="proses" class="waves-effect blue waves-green btn-flat">PROSES</button>
  </div>
</div>

<!-- start inv-->
<div id="modal_inv" class="modal modal-fixed-footer ">
  <div class="modal-content">
    <?php $attrv = array('id'=>'forminv');?>
    <?= form_open('',$attrv);?>
      <div class="col s12 l12" id="kolominv" style="margin-bottom: 0px;">
        <div class="row">
          <div class="input-field col s12 l3">
            <input name="tahun_pengadaan" type="text" id="tp_tahun_pengadaan" readonly>
            <label>Tahun</label>
          </div>
          <div class="input-field col l3 s12">
            <input name="no_kontrak" type="text" id="tp_no_kontrak" readonly>
            <label>No. Kontrak</label>
          </div>
          <div class="input-field col l3 s12">
            <input type="text" id="tp_nilai_kontrak" readonly>
            <label>Nilai Pengadaan</label>
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
            <input name="perihal" type="text" class="" id="tp_perihal" required>
            <label>Perihal</label>
          </div>
          <div class="input-field col s12 l3">
            <input name="nominal" type="number" id="tp_nominal">
            <label>Nominal</label>
          </div>
          <div class="input-field col s12 l3">
            <input name="memo_keluar" type="text" id="tp_memo_keluar">
            <label>Memo Keluar*</label>
          </div>
          <div class="input-field col s12 l3">
            <input name="invoice_ke_user" type="text" class="datepicker" id="tp_invoice_ke_user">
            <label>Tgl. Invoice Ke User</label>
          </div><!-- 
          <div class="input-field col s12 l3">
            <input name="invoice_kembali" type="text" class="datepicker" id="tp_invoice_kembali">
            <label>Tgl. Invoice Kembali</label>
          </div>
          <div class="input-field col s12 l3">
            <input name="invoice_ke_pembayaran" type="text" class="datepicker" id="tp_invoice_kepembayaran">
            <label>Tgl. Invoice ke Pembayaran</label>
          </div> -->
          <div class="input-field col s12 l3">
            <input type="text" class="" id="tp_sisa" readonly>
            <input type="text" class="" id="tps_sisa" hidden>
            <label>Sisa</label>
          </div>
          <div class="input-field col s12 l3">
            <button class="waves-effect waves-green teal btn-flat" id="prosesinv">Proses</button>
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
              <tr style="font-weight: bolder">
                <td>No</td>
                <td>No. Invoice</td>
                <td>Tgl. Invoice</td>
                <td>Keterangan</td>
                <td>No. Memo*</td>
                <td>Tgl. Verifikasi ke User</td>
                <td>Tgl. Kembali Dari User</td>
                <td>Tgl. Ke Bagian Pembayaran</td>
                <td>Nominal</td>
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
      format: 'yyyy-mm-dd',
      autoClose: true,

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
                "targets": [ 0, 1, 2 ],
                "className": ''
            }
        ],
        "createdRow" : function(row, data, index){
          $(row).addClass('row');
          $(row).attr('data-id',data['id_pengadaan']);
        }
    })
    
    $('#add_data').on('click', function(){
      $('#modal_tambah').modal('open');
       $('.rowitem').empty();
       $('.rowinv tr:last td:first').empty();
    });

    $('#table_filter input ').attr('placeholder', 'Search here...');
    //$('#table_filter label').hide();
    var html = "<div class='input-field'><label class='active'>Search</label>"+
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
      var divisi = this.value;
      $.ajax({
        type: 'POST',
        url : '<?= base_url()."pengadaan/get_kewenangan";?>',
        data: {'divisi':divisi},
        success: function(response){

          $('#kewenangan').select2({
          placeholder: 'Select an option',
          //theme: 'material'
          },$('select').css('width','100%'));

          var option= $('#kewenangan');
          $.each(JSON.parse(response), function(){ 
              option.append($("<option />").val(this.kewenangan).text(this.kewenangan));
          });

        }
      })
    });

    $('#tahun_pengadaan').on('change', function(){
      var tahun = this.value;
      $.ajax({
        type : 'POST',
        url : '<?= base_url()."pengadaan/get_id_pengadaan";?>',
        data : {'tahun' : tahun},
        success: function(response){
          $('#id_pengadaan').val(JSON.parse(response));
          $('#labelidpengadaan').addClass('active');
        }

      })
    })
    $("[name='table_length']").formSelect();

    //get detail after click in row
    $('tbody').on('click','.row', function(e){

      $('.modal').modal({
        dismissible : false
      });
      $('#modal_detail').modal('open');

      var id = $(this).attr('data-id');//table.row($(this).parents('tr')).data();
      
      $('#btn-ubah').attr('data-id', id);
      $('#btn-hapus').attr('data-id', id);
      $('#btn-comment').attr('data-id', id);
      $('#proses').attr('data-id', id);
      //$('#title_modal').text(id);
      //console.log(id)
      $.ajax({
        type:'POST',
        url: '<?= base_url()."pengadaan/get_detail";?>',
        data: {id:id},
        success: function(response){
          
          var response = JSON.parse(response);
          var data = response.pengadaan;
          var detail = response.detail;
          var html = "";
          $('.rowisi').html('');
          //console.log(response);
          $('#t_tahun_pengadaan').text(data.tahun);
          $('#t_tgl_surat').text(data.tgl_notin);
          $('#t_no_surat').text(data.no_notin);
          $('#t_jenis_surat').text(data.jenis_notin_masuk);
          $('#t_tgl_disposisi').text(data.tgl_disposisi);
          $('#t_sli').text();
          $('#t_perihal').text(data.perihal);
          $('#t_jenis_pengadaan').text(data.jenis_pengadaan);
          $('#t_divisi').text(data.divisi);
          $('#t_kewenangan').text(data.kewenangan);
          
          if(detail.length > 0){
            var no = 0;
            for(i = 0;i < detail.length;i++){
              no++;
              var nego;
              if(detail[i].hps_satuan=='0'){
                nego = '-';
              }else if((detail[i].realisasi_nego_rp < detail[i].hps_satuan) || (detail[i].realisasi_nego_rp == detail[i].hps_satuan)){
                nego = 'ya';
              }else{
                nego = 'tidak';
              }
              var proses, status;
              var role = "<?= $role;?>";
              if(role !== 'user'){
                proses = "<button class='waves-effect waves-green teal btn-flat' data-id='"+detail[i].id_pengadaan_uniq+"' data-tahun='"+data.tahun+"'>proses</button>";
                status = "<a href='#' class='proses-inv' data-id='"+detail[i].no_kontrak+"'  data-tahun='"+data.tahun+"'>"+detail[i].status+"</a>";
              }else{
                proses = '';
                status = "<a href='#' data-id='"+detail[i].no_kontrak+"'>"+detail[i].status+"</a>";
              }
              html += "<tr><td>"+no+"</td>"+
                      "<td>"+detail[i].item+"</td>"+
                      "<td>"+detail[i].ukuran+"</td>"+
                      "<td>"+detail[i].bahan+"</td>"+
                      "<td>"+formatNumber(detail[i].jumlah)+"</td>"+
                      "<td>"+detail[i].satuan+"</td>"+
                      "<td>"+formatNumber(detail[i].hps_usd)+"</td>"+
                      "<td>"+formatNumber(detail[i].hps_idr)+"</td>"+
                      "<td>"+formatNumber(detail[i].hps_satuan)+"</td>"+
                      "<td>"+formatNumber(detail[i].penawaran)+"</td>"+
                      "<td>"+formatNumber(detail[i].realisasi_nego_usd)+"</td>"+
                      "<td>"+formatNumber(detail[i].realisasi_nego_rp)+"</td>"+
                      "<td>"+formatNumber(detail[i].realisasi_qty_unit)+"</td>"+
                      "<td>"+formatNumber(detail[i].jml)+"</td>"+
                      "<td>"+detail[i].no_kontrak+"</td>"+
                      "<td>"+detail[i].tgl_kontrak+"</td>"+
                      "<td>"+detail[i].nm_vendor+"</td>"+
                      "<td class='center'>"+nego+"</td>"+
                      "<td>"+status+"</td>"+
                      "<td>"+proses+"</td></tr>";
            }
            //console.log(rowid);
            $('.rowisi').html(html);
          }
        }
      })
      
    })
    //proses invoice di row detail
    $('#tbisiinvoice tbody').on('click', '.proses-inv',function(e){
      var no_kontrak = $(this).attr('data-id');
      var tahun = $(this).attr('data-tahun');
      $('#kolominv').hide();
      $('#tambahdata').attr('data-kontrak', no_kontrak);
      $('#tambahdata').attr('data-tahun', tahun);
      $('#modal_inv').modal('open');

      $.ajax({
        type: 'POST',
        url: '<?= base_url()."pengadaan/get_kontrak";?>',
        data: {no_kontrak: no_kontrak, tahun: tahun},
        success: function(response){
          //  console.log(response);
          var r = JSON.parse(response);
          var htmls = "";
          $('.rowinv').html('');

          if(r['jml'] > 0){
            $('#tp_no_kontrak').val(no_kontrak);
            $('#tp_tahun_pengadaan').val(tahun);
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
            var no = 0;
            
            for (i = 0; i < r['jml']; i++ ){
              
              no++;
              htmls += "<tr><td>"+no+"</td>"+
                        "<td>"+r['data'][i].no_invoice+"</td>"+
                        "<td>"+r['data'][i].tgl_invoice+"</td>"+
                        "<td>"+r['data'][i].perihal+"</td>"+
                        "<td>"+r['data'][i].memo_keluar+"</td>"+
                        "<td>"+r['data'][i].tgl_invoice_diantar+"</td>"+
                        "<td>"+r['data'][i].tgl_invoice_kembali+"</td>"+
                        "<td>"+r['data'][i].tgl_kebagian_pembayaran+"</td>"+
                        "<td>"+formatNumber(r['data'][i].nominal)+"</td></tr>";

            }
            $('.rowinv').html(htmls);
          }else{
            htmls = '';
            $('.rowinv').html('');
          }
        }
      })    
    })

    $('#btn-prosesbaru').on('click', function(e){
      e.preventDefault();
      $.ajax({
        'type': 'POST',
        'url' : '<?= base_url()."pengadaan/add_data";?>',
        'data': $('#formtambahdata').serialize(),
        'success': function(response){
          console.log(response);
        }
      })       

    })
    //add invoice
    $('#tambahdata').on('click', function(e){
      
      var no_kontrak = $(this).attr('data-kontrak');
      var tahun = $(this).attr('data-tahun');
        $('#kolominv').toggle();
        $('#kolominv label').addClass('active');
        $('.rowitem tr:first td:first').text('');

    })
    
    $('#btn-tmbh-item').on('click', function(e){

     e.preventDefault();

      var nomor = $('.rowitem').children().length+1;

      var idselect = 'select'+nomor;
      var idselects = '#'+idselect;
      var rowitem = "<tr><td>"+nomor+"</td>"+
                        "<td><input type='text' placeholder='item' name='item[]' style='width: 200px'></td>"+
                        "<td><input type='text' placeholder='ukuran' name='ukuran[]' style='width: 200px'></td>"+
                        "<td><input type='text' placeholder='bahan' name='bahan[]' style='width: 200px'></td>"+
                        "<td><input type='number' placeholder='jumlah' name='jumlah[]' style='width: 200px'></td>"+
                        "<td><input type='text' placeholder='satuan' name='satuan[]' style='width: 200px'></td>"+
                        "<td><input type='number' placeholder='hps usd' name='hpsusd[]' style='width: 200px'></td>"+
                        "<td><input type='number' placeholder='hps idr' name='hpsidr[]' style='width: 200px'></td>"+
                        "<td><input type='text' placeholder='hps satuan' name='hpssatuan[]' style='width: 200px'></td>"+
                        "<td><input type='text' placeholder='penawaran' name='penawaran[]' style='width: 200px'></td>"+
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
        format: 'yyyy-mm-dd',
        autoClose: true,

      });

      $('.realisasirp, .realisasiqty').on('change', function(){
        var nomorid = $(this).attr('data-id');
        var idjml = '#jumlah'+nomorid;
        var rpreal = '#realisasirp'+nomorid;
        var qtyreal = '#realisasiqty'+nomorid;
        var jml = $(rpreal).val() * $(qtyreal).val();
        $(idjml).attr('data-id', jml);
        $(idjml).text('Rp.'+formatNumber(jml));

        var sum = 0;
        $(".jml").each(function(){
        //var value = $(this).text();
          var value = $(this).attr('data-id');
          if(!isNaN(value) && value.length != 0){
            sum += parseFloat(value);
            $('#total').text('Rp.'+formatNumber(sum));
          }
          
        })
      })

     

      $.post("<?= base_url()."tdr/get_tdr";?>", function(result){
          
        var options = $(idselects);

        $.each(JSON.parse(result), function() {
              options.append($("<option />").val(this.id_vendor).text(this.nm_vendor));
        });

      });
     
    })



    $('#tp_nominal').on('change', function(){
      //var nilai = $('#tp_nilai_kontrak').val();
      var nom = $(this).val();
      var sisaawal = $('#tps_sisa').val();
      var sisaakhir = sisaawal - nom;
      
      $('#tp_sisa').val(sisaakhir);
    })
    $('#prosesinv').on('click', function(e){
      var nos = $('.rowinv tr:last td:first').text();
      e.preventDefault();

      var htmlt = '';
      var ttahun = $('#tp_tahun_pengadaan').val();
      var tnokontrak = $('#tp_no_kontrak').val();
      var tnilai = $('#tp_nilai_kontrak').val();
      var tnoinv = $('#tp_no_invoice').val();
      var ttglinv = $('#tp_tgl_invoice').val();
      var tperihal = $('#tp_perihal').val();
      var tnominal = $('#tp_nominal').val();
      var tmemo = $('#tp_memo_keluar').val();
      var tkeuser = $('#tp_invoice_ke_user').val();
      var tkembali = $('#tp_invoice_kembali').val();
      var tpembayaran = $('#tp_invoice_kepembayaran').val();
      nos++;
      htmlt += "<tr><td>"+nos+"</td>"+
                    "<td>"+tnoinv+"</td>"+
                    "<td>"+ttglinv+"</td>"+
                    "<td>"+tperihal+"</td>"+
                    "<td>"+tmemo+"</td>"+
                    "<td>"+tkeuser+"</td>"+
                    "<td>"+tkembali+"</td>"+
                    "<td>"+tpembayaran+"</td>"+
                    "<td>"+tnominal+"</td></tr>";

      $('.rowinv').append(htmlt);
    })
   
  })
</script>