<div class="row first">
  <!-- <div class="col s12"> -->
  
  <div class="col push-s3 s9">
    <ul class="collection with-header"  id="reminder">
      <li class="collection-item red accent-4 white-text"><marquee id="marquee"><?= $tdr;?> TDR yang akan berakhir</marquee>
      </li>
    </ul>
    
    <table class="table display"  id="table" style="font-family:'Times New Roman', Times, serif; font-size: 12px">
      <thead class="teal white-text">
        <tr class="rowhead">
          <th>#</th>
          <th>No. TDR</th>
          <th>Nama Vendor</th>      
          <th>Alamat</th>
          <th>Sub Bidang Usaha</th>
          <th>Kualifikasi</th>
          <th>Tanggal Berlaku</th>
          <th>Tanggal Berakhir</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
    </table>
  </div>

</div>

<!-- Modal Structure -->
  <div id="modaledit" class="modal modal-fixed-footer">
    <div class="modal-content">
      <h6 id="title-modal"></h6>
      <?= form_open();?>
        <div class="col s12 l12">
          <div class="row">
            <div class="input-field col s12 l6">
              <input id="no_srt_vendor" type="text" class="validate">
              <label class="active">No. Surat Vendor</label>
            </div>  
            <div class="input-field col s12 l6">
              <input id="nm_vendor" type="text" class="validate">
              <label class="active">Nama Vendor</label>
            </div>
            <div class="input-field col s12 l12">
              <input id="alamat" type="text" class="validate">
              <label class="active">Alamat</label>
            </div>  
            <div class="input-field col s12 l12">
              <input id="sub_bdg_usaha" type="text" class="validate">
              <label class="active">Sub Bidang Usaha</label>
            </div>
            <div class="input-field col s12 l4">
              <input id="tgl_mulai" type="date" class="validate">
              <label class="active">Tgl. Berlaku</label>
            </div>  
            <div class="input-field col s12 l4">
              <input id="tgl_akhir" type="date" class="validate">
              <label class="active">Tgl. Berakhir</label>
            </div>
            <div class="input-field col s12 l4">
              <input id="kualifikasi" type="text" class="validate">
              <label class="active">Kualifikasi</label>
            </div>
            <div class="input-field col s12 l12">
              <input id="file_tdr" type="text" class="validate">
              <label class="active">File TDR</label>
            </div>
          </div>
        </div>
      <?= form_close();?>
    </div>
    <div class="modal-footer">
      <button class="modal-close waves-effect waves-yellow btn-flat">CANCEL</button>
      <button id="edit-button" class="waves-effect waves-green btn-flat">EDIT</button>
    </div>
  </div>

<script>
  $(document).ready(function(){
    $(".select2").select2({
      placeholder: 'Select an option',
      //theme: 'material'

    },$('select').css('width','100%'));
    
    
    $('.select-m').formSelect();
    //$('.select2-selection__arrow').addClass("fa fa-spin");
    $('.datepicker').datepicker({
      container: 'body',
      format: 'dd-mm-yyyy',
      autoClose: true,
      disableWeekends:true,
      firstDay:1

    });
    $('.modal').modal();
    $('.bg').hide();
    var table = $('#table').DataTable({
      "lengthMenu": [[5,10,25, 50, -1],[5,10,25,50, "All"]],
      "stateSave": false,
      "processing" : true,
      "serverSide": true,
      "orderClasses": false,
      "order": [],
      "ajax":{
        "url": "<?= site_url('Tdr/get_data_tdr');?>",
        "type": "POST",
        "data": function ( data ) {
                //data.divisi = $('#divisi-select').val();
                //data.tahun = $('#year-select').val();
                //data.my_task = $('#my_task').val();
                
        }

      },
      "columns":[
        {"data": ['no']},
        {"data": ['no_srt_vendor']},
        {"data": ['nm_vendor']},
        {"data": ['alamat']},
        {"data": ['sub_bdg_usaha']},
        {"data": ['kualifikasi']},
        {"data": ['tgl_mulai']},
        {"data": ['tgl_akhir']},
        {"data": ['status']},
        {"data": ''},
      ],
      "dom": 'Bflrtip',
              buttons: [
            { className: 'btn btn-sm light-blue darken-4', text: '<i class="fa fa-refresh"></i>', attr: {id: 'reload','aria-label':'Refresh Data','data-balloon-pos':'up'}},
            { className: 'btn btn-sm light-blue darken-4', text: '[+] Add Data', attr: {id: 'add_data','aria-label':'Tambah Data','data-balloon-pos':'up'} },
            { extend: 'copy', className: 'btn btn-sm light-blue darken-4', text: '<i class="fa fa-copy"></i>', attr: {'aria-label':'Copy Data','data-balloon-pos':'up'}},
            { extend: 'csv', className: 'btn btn-sm light-blue darken-4'},
            { extend: 'excel', className: 'btn btn-sm light-blue darken-4', text: '<i class="fa fa-file-excel-o"><i>'},
            { className: 'btn btn-sm light-blue darken-4', text: '<i class="fa fa-filter"><i>', attr: {id: 'btn-filter'}}
            ],
      "processing": true,
      "language":{
        "processing": "<div class='warning-alert'><i class='fa fa-circle-o-notch fa-spin'></i> Please wait........",
        "buttons": {
          "copyTitle": "<div class='row'><div class='col push-l3 l9' style='font-size:15px'>Copy to clipboard</div></div>",
          "copyKeys":"Press <i>ctrl</i> or <i>\u2318</i> + <i>C</i> to copy the table data<br>to your system clipboard.<br>To cance, click this message or press escape.",
          "copySuccess":{
            "_": "%d line tercopy",
            "1": "1 line tercopy"
          }
        }
      },
      "columnDefs": [
            {
                "targets": [ 0, 1, 2, 5 ],
                "className": 'center'
            },
            {
              "targets":-1,"data":null,"orderable":false,"defaultContent":"<button class='pdf btn-small'><i class='fa fa-eye '></i></button>","className":"center"
            }
            
        ],
      "createdRow" : function(row, data, index){
        $(row).addClass('row');
        $(row).attr('data-id',data['id_vendor']);

        if(data['file_tdr'] == '' || data['file_tdr'] == 'file'){
          $(row).children().eq(9).hide();
        }else{
          if($(row).children().eq(8).text() == 'Expired'){
            $(row).children().eq(8).css({'color':'red','font-weight':'bolder','font-style':'italic'}).attr('data-id',data['id_vendor']);
            $(row).children().eq(9).children().addClass('red');
          }else if($(row).children().eq(8).text() == 'Expired_Soon'){
            $(row).children().eq(8).css({'color':'orange','font-weight':'bolder','font-style':'italic'});
            $(row).children().eq(9).children().addClass('orange').attr('data-id',data['id_vendor']);
          }else{
            $(row).children().eq(8).css({'color':'green','font-weight':'bolder','font-style':'italic'});
            $(row).children().eq(9).children().addClass('green').attr('data-id',data['id_vendor']);
          }
        }

      
      }
    })
    let html = "<div class='input-field'><label class='active'>Search</label>"+
    "<input type='text' class='validate' id='searchnew' placeholder='Search here...'>"+
    "</div>";
    $('#table_filter label').html(html)
    
    $('#btn-filter').on('click', function(e){
      $('#filter').toggleClass('hide')
    })
    $('#searchnew').on('keyup change', function(){
        table
          .search(this.value)
          .draw();
    })
    $('#reload').on('click', function(){ //reload
      $('#table').DataTable().ajax.reload();
    })
    
    $("[name='table_length']").formSelect();

    $('#table').on('click','.pdf', function(e){
      let id = $(this).attr('data-id');
      window.open("<?= base_url().'Tdr/get_pdf/?id=';?>"+id, '_blank');
    })
    $('.edit').on('click', function(){
      var id = $(this).attr('data-id');
      var nama = $(this).attr('data-vendor');
      $('#modaledit').modal('open');

      $('#title-modal').html(nama);
      $.ajax({
        type: 'POST',
        url: '<?= site_url()."tdr/detail_tdr";?>/'+id,
        data: {id: id},
        success: function(response){
          console.log(response);
          M.updateTextFields();
          var data = JSON.parse(response);
          console.log(data[0]["no_srt_vendor"]);
          $('#no_srt_vendor').val(data[0]["no_srt_vendor"]);
          $('#nm_vendor').val(data[0]["nm_vendor"]);
          $('#alamat').val(data[0]["alamat"]);
          $('#sub_bdg_usaha').val(data[0]["sub_bdg_usaha"]);
          $('#tgl_mulai').val(data[0]["tgl_mulai"]);
          $('#tgl_akhir').val(data[0]["tgl_akhir"]);
          $('#kualifikasi').val(data[0]["kualifikasi"]);
          $('#file_tdr').val(data[0]["file_tdr"]);
        }

      });
    })
      


  });
  
</script>