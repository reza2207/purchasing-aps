<style>
	#table-detail tr td {
			padding-top:0px;padding-bottom:0px;font-size: 12px
	}

	/*#table-detail td:nth-child(2)::before{
			content: ':';
			padding-right: 15px
		}*/
	
	#table-detail td:first-of-type{
		width: 100px;
		font-weight: bolder
	}
	#table-detail td:nth-child(2), #table-detail td:nth-child(5), #table-detail td:nth-child(8){
		width: 10px;
	}
	#table-detail td:nth-child(3){
		width: 20%;
	}
	#table-detail td:nth-child(6){
		width: 13%;
	}
	#table-detail td:nth-child(4){
		width: 80px;
		font-weight: bolder;
	}
	#table-detail td:nth-child(7){
		width: 105px;
		font-weight: bolder;
	}
	#table-detail tr:hover{
	background: #FFA500;
	color:white;
	}
	#d_perihal{
		background-color: #009CFF;font-family: comfortaa;text-align: center;color:white;
	}
	
</style>
<div class="row first">

	<div class="col s12 offset-l3 l9">
		<div class="row hide" id="filter">
			<div class="col l2">
				<label class="active">My Task</label>
				<select class="select-m" id="my_task">
					<option value="">--Pilih--</option>
					<option value="On Process">On Process</option>
					<option value="Finished">Finished</option>
					<option value="All">All</option>
				</select>
			</div>
			<div class="col l2">
				<label class="active">Divisi</label>
				<select class="select-m" id="divisi-select">
					<option value="All">All</option>
					<option value="BSK">BSK</option>
					<option value="PDM">PDM</option>
					<option value="EBK">EBK</option>
					<option value="Others">Lain-lain</option>
				</select>
			</div>
			<div class="col l2">
			<label class="active">Tahun</label>
				<select class="select-m" id="year-select">
					<?php foreach($year as $y):?>
					<option value="<?= $y->tahun;?>"><?= $y->tahun;?></option>
					<?php endforeach;?>
					<option value="All">All</option>
				</select>
			</div>
		</div>
		
		<table class="table display" id="table" style="width: 100%">
			<thead class="teal white-text">
				<tr class="rowhead">
					<th class="center align-middle">#</th>
					<th class="center align-middle">Tgl. Surat</th>
					<th class="center align-middle">No. Surat</th>
					<th class="center align-middle">Tgl. Terima Surat</th>
					<th class="center align-middle">Perihal</th>
					<th class="center align-middle">Jenis</th>
					<th class="center align-middle">Status</th>
				</tr>
			</thead>
		</table>
	</div>
</div>

<!-- Modal Structure add-->
<div id="modal_tambah" class="modal modal-fixed-footer"> 
	<div class="modal-content">
		<h6 id="title-modal"></h6>
		<?php $attrf = array('id'=>'formtambah');?>
		<?= form_open('',$attrf);?>
			<div class="col s12 l12">
				<div class="row">
					<div class="input-field col s12 l4">
						<input name="tgl_terima" type="text" class="datepicker" value="<?= date('d-m-Y');?>">
						<label class="active">Tanggal Terima</label>
					</div>
					<div class="input-field col l4 s12">
						<label class="active">Divisi</label>
						<select name="divisi" class="select-m">
							<option value="">--pilih--</option>  
							<option value="BSK">BSK</option>
							<option value="PDM">PDM</option>
							<option value="EBK">EBK</option>
							<option value="Others">Lain-lain</option>
						</select>
						
					</div>  
					<div class="input-field col s12 l4">
						<label class="active">Jenis Surat</label>
						<select name="jenis_surat" class="select-m" id="jenis_surat">
							<option value="">--pilih--</option>
							<option value="Permintaan Urgent">Permintaan Urgent</option>
							<option value="Permintaan Reguler">Permintaan Reguler</option>
							<option value="Permintaan Ulang">Permintaan Ulang</option>
							<option value="Email">Email</option>
							<option value="Pemberitahuan">Pemberitahuan</option>
						</select>
					</div>  
					<!-- jika email -->
					<div class="input-field col s12 l6 email hide">
						<input name="email" class="">
						<label class="active">Email</label>
					</div>
					<div class="input-field col s12 l6 email hide">
						<input name="tgl_email" class="datepicker">
						<label class="active">Tgl. Email</label>
					</div>
					<!-- jika surat -->
					<div class="input-field col s12 l6 surat hide">
						<input name="no_surat" class="">
						<label class="active">No. Surat</label>
					</div>
					<div class="input-field col s12 l6 surat hide">
						<input name="tgl_surat" class="datepicker">
						<label class="active">Tgl. Surat</label>
					</div>
					<div class="input-field col s12 l12">
						<input name="perihal" type="text" class="">
						<label class="active">Perihal</label>
					</div>  
					<div class="input-field col s12 l6">
						<input name="user" type="text" class="">
						<label class="active">USER</label>
					</div>
					<div class="input-field col s12 l6">
						<input name="kelompok" type="text" class="">
						<label class="active">Kelompok</label>
					</div>
					<div class="input-field col s12 l6 beban hide">
						<input name="anggaran" type="number" class="">
						<label class="active">Anggaran</label>
					</div>
					<div class="input-field col s12 l6 beban hide">
						<input name="beban" type="text" class="">
						<label class="active">Beban Anggaran</label>
					</div>
				</div>
			</div>
		<?= form_close();?>
	</div>
	
	<div class="modal-footer">
		<button class="modal-close grey darken-3 waves-effect waves-yellow btn-flat white-text">CLOSE</button>
		<button id="submit_new" class="waves-effect light-blue accent-4 waves-green btn-flat white-text"><i class="fa fa-save"></i></button>
	</div>	
</div>
<!-- end modal add-->

<!-- Modal Structure detail-->
<div id="modal_detail" class="modal modal-fixed-footer">
	<div class="modal-content">
		
		<div class="col s12 l12">
			<div class="row">
				<div id="d_perihal"></div>
				<table id="table-detail">
					
					<tr>
						<td>Jenis Surat</td>
						<td>:</td>
						<td colspan="4" id="d_jenis_surat"></td>
						<td class='d_tempat'>Tempat Pengadaan</td>
						<td class='d_tempat'>:</td>
						<td class='d_tempat' id="d_tempat_pengadaan"></td>
					</tr>
					<tr>
						<td>Divisi</td>
						<td>:</td>
						<td id="d_divisi"></td>
					
						<td style="font-weight: bold">Kelompok</td>
						<td>:</td>
						<td id="d_kelompok"></td>
					
						<td style="font-weight: bold">User</td>
						<td>:</td>
						<td id="d_user"></td>
					</tr>
					<tr class="row-email">
						<td>Email</td>
						<td>:</td>
						<td id="d_email"></td>
						<td style="font-weight: bold">Tgl. Email</td>
						<td>:</td>
						<td id="d_tgl_email"></td>
						<td style="font-weight: bold">Tgl. Terima Email</td>
						<td>:</td>
						<td id="d_tgl_t_email"></td>
					</tr>
					
					<tr class="row-surat">
						<td>No. Surat</td>
						<td>:</td>
						<td id="d_no_surat"></td>
						<td style="font-weight: bold">Tgl. Surat</td>
						<td>:</td>
						<td id="d_tgl_surat"></td>
						<td style="font-weight: bold">Tgl. Terima Surat</td>
						<td>:</td>
						<td id="d_terima_surat"></td>
					</tr>
					
					<tr>
						<td class="ddpimkel">Tgl. Disposisi Pimkel</td>
						<td class="ddpimkel">:</td>
						<td class="ddpimkel"id="d_disposisi_pimkel"></td>
						<td class="ddmanager" style="font-weight: bold">Tgl. Disposisi Manager</td>
						<td class="ddmanager">:</td>
						<td class="ddmanager" id="d_disposisi_manager"></td>
						<td class="ddpembuat" style="font-weight: bold">Pembuat Pekerjaan</td>
						<td class="ddpembuat">:</td>
						<td class="ddpembuat" id="d_pembuat"></td>
					</tr>
					<tr class="hide">
						<td>Username Pembuat</td>
						<td>:</td>
						<td id="d_unamepembuat"></td>
					</tr>
					<tr>
						<td>Metode Pengadaan</td>
						<td>:</td>
						<td id="d_jenis_pengadaan" colspan="7"></td>
					</tr>
					<tr class='spk'>
						<td>Nama Vendor</td>
						<td>:</td>
						<td id="ds_vendor"></td>
						<td>No. SPK</td>
						<td>:</td>
						<td id="d_no_spk"></td>
						<td>Tgl. SPK</td>
						<td>:</td>
						<td id="d_tgl_spk"></td>
						
					</tr>
					<tr>
						<td>Status Data</td>
						<td>:</td>
						<td style="font-style: italic;font-weight: bolder" colspan="7"><div id="d_status_data"></div></td>
					</tr>
				</table>
			</div>
		</div>
	
	</div>
	<div class="modal-footer">
		<?php if($_SESSION['role'] == "admin" && $_SESSION['jabatan'] == 'mgr'){?>
		<button class="waves-blue btn-flat left teal white-text" id="btn-disposisi">Disposisi</button>
		<?php }
		
		elseif($_SESSION['role'] != "user"){?>
		<button class="waves-blue btn-flat left teal white-text" id="update_surat">Update Surat</button>
		<button class="waves-blue btn-flat left teal white-text" id="btn-disposisi">Disposisi</button>
		<button class="waves-blue btn-flat left teal white-text" id="btn-jenis">Metode Pengadaan</button>
		<button class="waves-blue btn-flat left teal white-text" id="btn-aanwijzing">Aanwijzing</button>
		<button class="waves-effect yellow waves-green btn-flat" id="btn-return" aria-label="Return" data-balloon-pos="up"><i class="fa fa-rotate-left"></i></button>
		<button class="waves-effect yellow waves-green btn-flat" id="btn-ubah" aria-label="Edit" data-balloon-pos="up"><i class="fa fa-pencil"></i></button>
		<button class="waves-effect red waves-yellow btn-flat white-text" id="btn-hapus" title="delete" aria-label="Delete" data-balloon-pos="up"><i class="fa fa-trash"></i></button>
		<button class="waves-effect green waves-green btn-flat white-text" id="btn-proses" aria-label="Proses" data-balloon-pos="up"><i class="fa fa-pencil-square-o"></i></button>
		
		<?php 
		}
		?>
		<button class="modal-close grey darken-3 waves-effect waves-yellow btn-flat white-text">CLOSE</button>
	</div>
</div>

<!-- end modal detail-->
<div id="modal_disposisi" class="modal modal-fixed-footer ">
	<div class="modal-content">
		<?php $attre = array('id'=>'formdisposisi');?>
		<?= form_open('',$attre);?>
			<div class="col s12 l12">
				<div class="row">
					<div class="input-field col l12 s12 dpim">
						<input name="id_register" type="text" hidden id="idRegisterD">
						<input name="tgl_d_pimkel" type="text" class="datepicker" id="dtglDisposisiPimkel">
						<label>Tgl. Disposisi Pimkel</label>
					</div>
					<div class="input-field col l12 s12 dman">
						
					</div>
					<div class="input-field col l12 s12" id="dpembuat">
						
					</div>
				</div> 
			</div>
		<?= form_close();?>
	</div>
	<div class="modal-footer">
		<button class="waves-effect green waves-green btn-flat white-text left" id="tmbhrowpembuat">+Pembuat</button>
		<button class="modal-close grey darken-3 waves-effect waves-yellow btn-flat white-text">CLOSE</button>
		<button id="proses_disposisi" class="waves-effect green waves-green btn-flat white-text">PROSES</button>

	</div>
</div>

<!-- end modal detail-->
<div id="modal_prosesSPK" class="modal modal-fixed-footer">
	<div class="modal-content">
		<?php $attrps = array('id'=>'formprosesSPK');?>
		<?= form_open('',$attrps);?>
			<div class="col s12 l12">
				<div class="row">
					<input name="id_register" type="text" hidden id="idRegisterP">
					<div id="dspk">
						<div class="input-field col l4 s12">
							
							<select name="id_vendor[]" type="text" class="select2" style="">
								<option value="">--select--</option>
								<?php foreach($select_vendor AS $v){?>
								<option value="<?= $v->id_vendor;?>"><?= $v->nm_vendor;?></option>
								<?php };?>
							</select>
							<label class="active" style="top: -14px;">Nama Vendor</label>
						</div>
						<div class="input-field col l4 s12">
							<input name="tgl_spk[]" type="text" class="datepicker">
							<label>Tgl. SPK</label>
						</div>
						<div class="input-field col l4 s12">
							
							<input name="no_spk[]" type="text">
							<label>No. SPK</label>
						</div>
					</div>
					<div id="ddetail">
						
					</div>
				</div> 
			</div>
		<?= form_close();?>
	</div>
	<div class="modal-footer">
		<button class="grey darken-3 waves-effect waves-yellow btn-flat white-text left" id="btntmbhvendor">+ vendor</button>
		<button class="grey darken-3 waves-effect waves-yellow btn-flat white-text hide left" id="btntmbhitem">+ item</button>
		<button class="modal-close grey darken-3 waves-effect waves-yellow btn-flat white-text">CLOSE</button>
		<button id="proses_spk" class="waves-effect green waves-green btn-flat white-text">PROSES</button>

	</div>
</div>
<!-- modal jenis-->
<div id="modal_jenis" class="modal modal-fixed-footer ">
	<div class="modal-content">
		<?php $attrj = array('id'=>'formjenis');?>
		<?= form_open('',$attrj);?>
			<div class="col s12 l12">
				<input name="id_register" type="text" hidden id="idRegisterJ">
				<div class="row">
					<div class="input-field col l12 s12">
						<select name="tempat_pengadaan" class="select-m" id="tempat_pengadaan">
							<option value="">--pilih--</option>
							<option value="BSK">BSK</option>
							<option value="PFA">PFA</option>
						</select>
						<label>Tempat Pengadaan</label>
					</div>
				</div> 
				<div class="row" id="row-jenis">
					<div class="input-field col l12 s12">
						<select name="jenis" class="select-m" id="jenis_pengadaan">
							<option value="">--pilih--</option>
							<option value="Pembelian Langsung">Pembelian Langsung</option>
							<option value="Penunjukan Langsung">Penunjukan Langsung</option>
							<option value="Pemilihan Langsung">Pemilihan Langsung</option>
							<option value="Pelelangan">Pelelangan</option>
						</select>
						<label>Metode Pengadaan</label>
					</div>
				</div> 
			</div>
		<?= form_close();?>
	</div>
	<div class="modal-footer">
		<button class="modal-close grey darken-3 waves-effect waves-yellow btn-flat white-text">CLOSE</button>
		<button id="proses_jenis" class="waves-effect green waves-green btn-flat white-text">PROSES</button>
	</div>
</div>
<!-- end-->
<!-- end modal update-->
<div id="modal_update_surat" class="modal modal-fixed-footer ">
	<div class="modal-content">
		<?php $attru = array('id'=>'formsurat');?>
		<?= form_open('',$attru);?>
			<div class="col s12 l12">
				<div class="row">
					<input name="id_register" type="text" hidden id="idRegisterJ">
					<div class="input-field col s12 l6">
						<label class="active">Jenis Surat</label>
						<select name="jenis_surat" class="validate select-m" id="jenis_surat">
							<option value="">--pilih--</option>
							<option value="Permintaan Urgent">Permintaan Urgent</option>
							<option value="Permintaan Reguler">Permintaan Reguler</option>
						</select>
					</div>
					<div class="input-field col s12 l6">
						<input name="no_surat" class="validate">
						<label class="active">No. Surat</label>
					</div>
					<div class="input-field col s12 l6">
						<input name="tgl_surat" class="validate datepicker">
						<label class="active">Tgl. Surat</label>
					</div>
					<div class="input-field col s12 l6">
						<input name="tgl_terima_surat" class="validate datepicker">
						<label class="active">Tgl. Terima Surat</label>
					</div>
					<div class="input-field col s12 l12">
						<input name="perihal" type="text" class="validate">
						<label class="active">Perihal</label>
					</div> 
				</div> 
			</div>
		<?= form_close();?>
	</div>
	<div class="modal-footer">
		<button class="modal-close grey darken-3 waves-effect waves-yellow btn-flat white-text">CLOSE</button>
		<button id="proses_surat" class="waves-effect green waves-green btn-flat white-text">PROSES</button>
	</div>
</div>


<!-- end modal aanwijzing-->
<div id="modal_aanwijzing" class="modal modal-fixed-footer ">
	<div class="modal-content">
		<?php $attre = array('id'=>'formanwijzing');?>
		<?= form_open('',$attre);?>
			<div class="col s12 l12">
				<div class="row">
					<div class="input-field col l12 s12">
						<input name="id_register" type="text" hidden id="idRegisterA">
						<input name="tgl_aanwijzing" type="text" class="datepicker">
						<label>Tgl. Aanwijzing</label>
					</div>
					<div class="input-field col l12 s12">
						<input name="jam_aanwijzing" type="text" class="timepicker">
						<label>Jam Aanwizjing</label>
					</div>
					<div class="input-field col l12 s12">
						<input name="tempat" type="text">
						<label>Tempat</label>
					</div>
					<div class="input-field col l12 s12">
						<input name="perihal" type="text">
						<label>Perihal</label>
					</div>
					<div class="input-field col l12 s12">
						<input name="peserta" type="text">
						<label>Peserta</label>
					</div>
				</div> 
			</div>
		<?= form_close();?>
	</div>
	<div class="modal-footer">
		<button class="waves-effect green waves-green btn-flat white-text">PROSES</button>
		<button class="modal-close grey darken-3 waves-effect waves-yellow btn-flat white-text">CLOSE</button>
		<button id="proses_aanwijzing" class="waves-effect green waves-green btn-flat white-text">PROSES</button>
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
				"url": "<?= site_url('Register/get_data_surat');?>",
				"type": "POST",
				"data": function ( data ) {
								data.divisi = $('#divisi-select').val();
								data.tahun = $('#year-select').val();
								data.my_task = $('#my_task').val();
				}

			},
			"columns":[
				{"data": ['no']},
				{"data": ['tgl_surat']},
				{"data": ['no_surat']},
				{"data": ['tgl_terima_surat']},
				{"data": ['perihal']},
				{"data": ['jenis_surat']},
				{"data": ['status_data']},
			],
			"dom": 'Bflrtip',
							buttons: [
						{ className: 'btn btn-small light-blue darken-4', text: '<i class="fa fa-refresh"></i>', attr: {id: 'reload','aria-label':'Refresh Data','data-balloon-pos':'up'}},
						{ className: 'btn btn-small light-blue darken-4', text: '[+] Add Data', attr: {id: 'add_data','aria-label':'Tambah Data','data-balloon-pos':'up'} },
						{ extend: 'copy', className: 'btn btn-small light-blue darken-4', text: '<i class="fa fa-copy"></i>', attr: {'aria-label':'Copy Data','data-balloon-pos':'up'}},
						{ extend: 'csv', className: 'btn btn-small light-blue darken-4'},
						{ extend: 'excel', className: 'btn btn-small light-blue darken-4', text: '<i class="fa fa-file-excel-o"><i>'},
						{ className: 'btn btn-small light-blue darken-4', text: '<i class="fa fa-filter"><i>', attr: {id: 'btn-filter'}}
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
							"targets": [ 0, 1, 2, 3, 5, -1 ],
							"className": 'center'
						},
						{
							"targets": [1,3],
							"width": '50px'
						}
				],
			"createdRow" : function(row, data, index){
				$(row).addClass('row');
				$(row).attr('data-id',data['id_register']);
				if(data['jenis_surat'] == 'Email'){
					$(row).css({'background':'#65635D','color':'white'});//#140FF0
				}
			}
		
		})
		
		//$('#table_filter label').hide();
		 $('#table_filter input ').attr('placeholder', 'Search here...');
	    //$('#table_filter label').hide();
	    let tagsearch = "<div class='input-field'><label class='active'>Search</label>"+
	    "<input type='text' class='validate' id='searchnew' style='margin-left: 0;'>"+
	    "</div>";
	    $('#table_filter label').html(tagsearch);
		
		$('#btn-filter').on('click', function(e){
			$('#filter').toggleClass('hide');
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

		$('tbody').on('click','.row', function(e){ //klik detail
			$('#d_disposisi_pimkel').text('');
			$('.row-email').hide();

			$('#btn-disposisi, #btn-aanwijzing, #btn-jenis, .spk').hide();
			 
			$('#d_disposisi_pimkel, #d_disposisi_manager, #d_pembuat, #d_jenis_pengadaan, #d_unamepembuat, #d_jenis_surat, #d_no_surat, #d_tgl_surat, #d_terima_surat,#d_perihal, #d_tempat_pengadaan').text('');
			$('.s-pembuat, #dpembuat').html('');
			$(' #d_jenis_pengadaan,  #d_jenis_pengadaan').parent().hide();
			$('.ddpimkel, .ddmanager, .ddpembuat').hide();

			$('.modal').modal({
				dismissible : false
			});
			$('#modal_detail').modal('open');

			let id = $(this).attr('data-id');//table.row($(this).parents('tr')).data();
			$('#btn-ubah, #btn-hapus, #proses, #btn-disposisi, #update_surat, #proses_disposisi, #proses_spk').attr('data-id', id);
			$('#idRegisterD, #idRegisterA, #idRegisterJ, #idRegisterP').val(id);
			update_modal(id)
			
		}) //end tbody row click



		$('#update_surat').on('click', function(e){
			let id = $(this).attr('data-id');
			$('#modal_update_surat').modal('open')
		})
		$('#btn-hapus').on('click', function(e){
			let id = $(this).attr('data-id');
			swal({
				type: 'question',
				text: 'Are you sure deleting this data?',
				showConfirmButton: true,
				allowOutsideClick: false,
				showCancelButton:true
			}).then(function(){
				$.ajax({
					type: 'POST',
					url : '<?= base_url()."Register/hapus_data";?>',
					data: {id: id},
					success: function(result){
						let data = JSON.parse(result);
						swal({
							type: data.type,
							text: data.pesan,
							showConfirmButton: true,
							allowOutsideClick: false,
						}).then(function(){
							$('#modal_detail').modal('close');
							$('#table').DataTable().ajax.reload();	
						})
					}
				})
			})
		})
		$("#add_data").on('click', function(){
			$('#modal_tambah').modal('open');

		})

		$('#submit_new').on('click', function(e){
			e.preventDefault();
				$.ajax({
					type: 'POST',
					url : '<?= base_url()."Register/add_data_masuk";?>',
					data: $('#formtambah').serialize(),
					success: function(response){
						let data = JSON.parse(response);
						if(data.type == 'error'){
							swal({
								type: data.type,
								text: data.pesan,
								showConfirmButton: true,
							})
						}else{
							swal({
								type: data.type,
								text: data.pesan,
								showConfirmButton: true,
							}).then(function(){
								$('#modal_tambah').modal('close');
								$('#formtambah input').val('');
								
							})
							$('#table').DataTable().ajax.reload();
						}
					}
				})
		})

		$('#tmbhrowpembuat').on('click', function(e){

			$.ajax({
				url : "<?= base_url().'Register/get_user';?>",
				success : function(result){
					let data = JSON.parse(result);
					let pembuat = "";
					
					pembuat += '<select name="pembuat[]" class="select-m s-pembuat">'+
											'<option value="">--pilih--</option>';
					for(i = 0;i < data.length;i++){
					pembuat += '<option value="'+data[i].username+'">'+data[i].nama+'</option>';
										
					}
					pembuat += '</select>';
					pembuat += '<label>Pembuat Pekerjaan</label>';
				$('#dpembuat').append(pembuat);
				$('.select-m').formSelect();
				}
			})	
			
		})

		$('#jenis_surat').on('change', function(e){
			e.preventDefault();
			if(this.value == 'Email'){
				$('.surat').addClass('hide');
				$('.email').removeClass('hide');
				$('.surat input').val('');
				$('.beban').addClass('hide');
			}else if(this.value == '' || this.value == 'Pemberitahuan'){
				$('.surat').removeClass('hide');
				$('.email').addClass('hide');
				$('.email input').val('');
				$('.surat input').val('');
				$('.beban').addClass('hide');
			}else{
				$('.beban').removeClass('hide');
				$('.email').addClass('hide');
				$('.surat').removeClass('hide');
				$('.email input').val('');

			}
		})
		$('#btn-disposisi').on('click', function(e){
			$('#modal_disposisi').modal('open')
			$('#modal_disposisi label').addClass('active')
			$('#dpembuat').html('');
			let id = $(this).attr('data-id');
			let jenis = $('#d_jenis_surat').text();
			
			let dpim = $('#d_disposisi_pimkel').text();
			let dman = $('#d_disposisi_manager').text();
			$('#dtglDisposisiPimkel').datepicker({
				container: 'body',
				format: 'dd-mm-yyyy',
				autoClose: true,
				disableWeekends:true,
				firstDay:1

			}).attr('readonly', false);
			$('#dtglDisposisiManager').datepicker({
				container: 'body',
				format: 'dd-mm-yyyy',
				autoClose: true,
				disableWeekends:true,
				firstDay:1

			})
			let kel = $('#d_kelompok').text();
			let rdman = '<input name="tgl_d_manager" type="text" class="datepicker" id="dtglDisposisiManager">'+
						'<label>Tgl. Disposisi Manager</label>';
			if(kel == 'STL' || kel == 'stl'){
				if(dman ==''){//second //jika  dp manager kosong
					$('#dtglDisposisiPimkel').val(dpim).datepicker('destroy').attr('readonly', true);
					$('.dpim').hide();
					$('.dman').show();
					$('#dpembuat').hide();
					$('.dman').html(rdman);
					$('#dtglDisposisiManager').datepicker({
						container: 'body',
						format: 'dd-mm-yyyy',
						autoClose: true,
						disableWeekends:true,
						firstDay:1

					}).attr('readonly', false);
					$('#tmbhrowpembuat').show();
				}else if(dman !=''){//tri
					$('.dpim').hide();
					$('.dman').show();
					$('#dpembuat').show();
					$('#dtglDisposisiPimkel').val(dpim).datepicker('destroy').attr('readonly', true);
					$('#dtglDisposisiManager').val(dman).datepicker('destroy').attr('readonly', true);
					$('.dman').html(rdman);
					$('#dpembuat').show();
					$('#tmbhrowpembuat').show();

				}else{
					$('.dpim').hide();
					$('#dtglDisposisiPimkel').val(dpim).datepicker('destroy').attr('readonly', true);
					$('#dtglDisposisiManager').val(dman).datepicker('destroy').attr('readonly', true);
					$('.dman').html(rdman);
					$('#dpembuat').hide();
					$('#tmbhrowpembuat').hide();
				}
			}else{
				if(dpim == '' && dpim == ''){//awal
					$('.dpim').show();
					$('.dman').children().remove();
					//$('.dman input').val('');
					$('#dtglDisposisiPimkel').val('');
					$('#tmbhrowpembuat').hide();

				}else if(dpim != '' && dman ==''){//second
					$('.dpim').show();
					$('#dtglDisposisiPimkel').val(dpim).datepicker('destroy').attr('readonly', true);

					$('.dman').html(rdman);
					$('#dtglDisposisiManager').datepicker({
						container: 'body',
						format: 'dd-mm-yyyy',
						autoClose: true,
						disableWeekends:true,
						firstDay:1

					}).attr('readonly', false);
					//$('.dman').show();
					$('#tmbhrowpembuat').show();
				}else if(dpim != '' && dman !=''){//tri

					$('.dman').html(rdman);
					$('.dpim').show();
					$('.dman label').addClass('active')
					//$('.dman').show();
					$('#dtglDisposisiPimkel').val(dpim).datepicker('destroy').attr('readonly', true);
					$('#dtglDisposisiManager').val(dman).attr('readonly', true);
					$('#tmbhrowpembuat').show();

				}else{
					$('.dpim').show();
					$('.dman').html(rdman);
					$('#dtglDisposisiPimkel').val(dpim).datepicker('destroy').attr('readonly', true);
					$('#dtglDisposisiManager').val(dman).datepicker('destroy').attr('readonly', true);
					$('#tmbhrowpembuat').hide();
				}
			}
			
		})

		$('#proses_surat').on('click', function(e){
			swal({
				type: 'question',
				text: 'Are you Sure?',
				showConfirmButton: true,
				allowOutsideClick: false,
				showCancelButton: true
			}).then(function(){
				let id = $(this).attr('data-id');
				$.ajax({
					type: 'POST',
					url : '<?= base_url()."register/update_surat";?>',
					data: $('#formsurat').serialize(),
					success: function(result){
						let data = JSON.parse(result);
						swal({
							type: data.type,
							text: data.pesan,
							showConfirmButton: true,
							allowOutsideClick: false,
						}).then(function(){
							if(data.type=='success'){
								$('#formsurat input').val('');
								$('#modal_update_surat').modal('close');
								$('#d_jenis_surat').text(data.jenis);
								$('#d_no_surat').text(data.no);
								$('#d_tgl_surat').text(data.tgl);
								$('#d_terima_surat').text(data.tgltrm);
								$('#d_perihal').text(data.perihal);
								$('#table').DataTable().ajax.reload();
								$('.row-surat').show();
								$('#update_surat').hide();
							}
						})
					}
				})
			})
		})
		

		$('#proses_disposisi').on('click', function(e){
			e.preventDefault();			
			let id = $(this).attr('data-id');
			$('#s-pembuat').formSelect();
			 $.ajax({
				type: 'POST',
				data: $('#formdisposisi').serialize(),
				url: '<?= base_url()."Register/submit_disposisi";?>',
				dataType: 'JSON',
				success: function(data){
					
					if(data.type == 'success' && data.pimkel != '' && data.manager == null){
						swal({
							type: data.type,
							text: data.pesan,
							showConfirmButton: true,
							allowOutsideClick: false,
						}).then(function(){
							$('#modal_disposisi').modal('close')
							//$('.ddpimkel').show();
							//$('#d_disposisi_pimkel').text(data.pimkel);
							$('#table').DataTable().ajax.reload();
							//$('#dpembuat').html('');
							update_modal(id);
						})
					}else if(data.type == 'success' && data.manager != '' && data.pimkel != '' && data.pembuat == null){
						swal({
							type: data.type,
							text: data.pesan,
							showConfirmButton: true,
							allowOutsideClick: false,
						}).then(function(){

							$('#modal_disposisi').modal('close')
							//$('#d_disposisi_pimkel').text(data.pimkel)
							$('.ddmanager').show();
							//$('#d_disposisi_manager').text(data.manager);
							$('#table').DataTable().ajax.reload();
							update_modal(id);
						})
						//	$('#btn-disposisi').hide();
						
					}else if(data.type == 'success' && data.manager != '' && data.pimkel != '' && data.pembuat != ''){
						swal({
							type: data.type,
							text: data.pesan,
							showConfirmButton: true,
							allowOutsideClick: false,
						}).then(function(){
							$('#modal_disposisi').modal('close')
							//$('#d_disposisi_pimkel').text(data.pimkel);
							$('.ddmanager').show();
							//$('#d_disposisi_manager').text(data.manager);
							$('.ddpembuat').show();
							//$('#d_pembuat').text(data.pembuat);
							$('#table').DataTable().ajax.reload();
							$('#btn-disposisi').hide();

							if(cek_similar(data.unamepembuat, '<?= $_SESSION['username'];?>')){
								//$('#d_unamepembuat').text(data.unamepembuat);
								$('#btn-jenis').show();
								update_modal(id);
							}else{
								
								$('#btn-jenis').hide();
								update_modal(id);
							}

							//$('#btn-proses').show();
						})

					}else if(data.type == 'success' && data.pimkel == '' && data.pembuat == null && data.manager != ''){
						swal({
							type: data.type,
							text: data.pesan,
							showConfirmButton: true,
							allowOutsideClick: false, //nihhh
						}).then(function(){
							$('#modal_disposisi').modal('close');
							$('.ddmanager').show();
							//$('#d_disposisi_manager').text(data.manager);
							$('#table').DataTable().ajax.reload();
							update_modal(id);
						})
					}else if(data.type == 'error'){
						swal({
							type: data.type,
							text: data.pesan,
							showConfirmButton: true,
							allowOutsideClick: false,
						}).then(function(){
							update_modal(id);
						})
					}
				} //end
			})
		})

		$('#btn-jenis').on('click', function(e){
			$('#modal_jenis').modal('open');
			$('#row-jenis').addClass('hide')
			$('#jenis_pengadaan').find('option[value=""]').prop('selected', true)
			$("#tempat_pengadaan").on('change', function(e){
				let value = this.value;
				if(value == 'BSK'){
					$('#row-jenis').removeClass('hide');
				}else if(value == "PFA"){
					$('#jenis_pengadaan').find('option[value=""]').prop('selected', true)
					$('#row-jenis').addClass('hide');
					$("#jenis_pengadaan").formSelect();
				}else{
					$('#jenis_pengadaan').find('option[value=""]').prop('selected', true)
					$('#row-jenis').addClass('hide')
					$("#jenis_pengadaan").formSelect();
				}
			})
		})

		$('#proses_jenis').on('click', function(e){
			$.ajax({
				type: 'POST',
				url : '<?= base_url()."Register/submit_jenis";?>',
				data: $('#formjenis').serialize(),
				success : function(result){
					let data = JSON.parse(result);
					swal({
						type: data.type,
						text: data.pesan,
						showConfirmButton: true,
					}).then(function(){
						$('#modal_jenis').modal('close');
						$('#btn-jenis').hide();
						$('#formjenis input').val('');
						
					})
					if(data.type == 'success'){
						$('#d_jenis_pengadaan').parent().show();
						$('#d_jenis_pengadaan').text(data.jenis);
						if(data.jenis == 'Pembelian Langsung'){
							$('#btn-aanwijzing').hide();
							
							if(cek_similar($('#d_unamepembuat').text(), '<?= $_SESSION['username'];?>')){

								$('#btn-proses').show();
							}else{

								$('#btn-proses').hide();
							}

						}else{
							$('#btn-aanwijzing').show();
							
						}
					}
					$('#table').DataTable().ajax.reload();
				}

			})
		})

		$('#btn-proses').on('click', function(e){
			$('#modal_prosesSPK').modal('open');
		})


		$('#proses_spk').on('click', function(e){
			let id = $(this).attr('data-id');
			$.ajax({
				type: 'POST',
				data: $('#formprosesSPK').serialize(),
				url: '<?= base_url()."Register/submit_spk";?>',
				success: function(result){
					let data = JSON.parse(result);
					if(data.type == 'success'){
						swal({
							type: data.type,
							text: data.pesan,
							showConfirmButton: true,
							allowOutsideClick: false,
						}).then(function(){
							//$('.spk').show();
							$('#modal_prosesSPK').modal('close');
							update_modal(id);
							
							$('#table').DataTable().ajax.reload();
						})
					
					}else{
						swal({
							type: data.type,
							text: data.pesan,
							showConfirmButton: true,
							allowOutsideClick: false,
						}).then(function(){
							$('#table').DataTable().ajax.reload();
						})
					}
					

				}
			})
		})
		$('#btntmbhitem').on('click', function(e){
			e.preventDefault()
			let html = '<div class="input-field col l4 s12">'+
						 '<input name="no_spk[]" type="text">'+
						 '<label>Item</label>'+
						 '</div>'+
						 '<div class="input-field col l2 s12">'+
					   	 '<input name="no_spk[]" type="text">'+
						 '<label>qty</label>'+
						 '</div>'+
						 '<div class="input-field col l2 s12">'+
						 '<input name="no_spk[]" type="text">'+
						 '<label>hps</label>'+
						 '</div>'+
						 '<div class="input-field col l2 s12">'+
						 '<input name="no_spk[]" type="text">'+
						 '<label>penawaran</label>'+
						 '</div>'+
						 '<div class="input-field col l2 s12">'+
						 '<input name="no_spk[]" type="text">'+
						 '<label>nego</label>'+
						 '</div>';
			$('#ddetail').append(html);
		})
		var no = 0;
		$('#btntmbhvendor').on('click', function(e){
			no++;
			let html = 	'<div class="input-field col l4 s12">'+
						'<select name="id_vendor[]" type="text" class="select2" id="selectvendor'+no+'" style="">'+
						'<option value="">--select--</option>'+
						'</select>'+
						'<label class="active" style="top: -14px;">Nama Vendor</label>'+
						'</div>'+
						'<div class="input-field col l4 s12">'+
						'<input class="datepicker" name="tgl_spk[]" type="text"  id="tglspk'+no+'">'+
						'<label>Tgl. SPK</label>'+
						'</div>'+
						'<div class="input-field col l4 s12">'+
						'<input name="no_spk[]" type="text">'+
						'<label>No. SPK</label>'+
						'</div>';
			$('#dspk').append(html);
			$('.datepicker').datepicker({
				container: 'body',
				format: 'dd-mm-yyyy',
				autoClose: true,
				disableWeekends:true,
				firstDay:1
			});
			$.post("<?= base_url()."tdr/get_tdr";?>", function(result){
		        let idoption = '#selectvendor'+no;
		        var options = $(idoption);
		        $.each(JSON.parse(result), function() {
		              options.append($("<option />").val(this.id_vendor).text(this.nm_vendor));
		        });
	        $(".select2").select2({
				placeholder: 'Select an option',
			},$('select').css('width','100%'));
	      	});
		})


		$('#btn-aanwijzing').on('click', function(e){
			e.preventDefault();
			let id = $(this).attr('data-id');
			$('#modal_aanwijzing').modal('open');
		})

		$('#proses_aanwijzing').on('click', function(e){
			e.preventDefault();
			console.log($('#formanwijzing').serialize())
		})
	})
	function update_modal(id){
		$.ajax({
			type:'GET',
			url: '<?= base_url()."Register/get_detail_masuk/";	?>'+id,       
			success: function(response){
				
				let data = JSON.parse(response);
				$('#d_divisi').text(strip(data.divisi));
				$('#d_kelompok').text(strip(data.kelompok));
				$('#d_user').text(strip(data.user));
				$('#d_email').text(strip(data.email));
				$('#d_tgl_email').text(tanggal_indo(data.tgl_email));
				$('#d_tgl_t_email').text(tanggal_indo(data.tgl_terima_email));
				$('#d_jenis_surat').html(data.jenis_surat);
				$('#d_no_surat').text(strip(data.no_surat));
				$('#d_perihal').text(strip(data.perihal));
				$('#d_tgl_surat').text(tanggal_indo(data.tgl_surat));
				$('#d_terima_surat').text(tanggal_indo(data.tgl_terima_surat));
				$('#d_unamepembuat').text(data.username);
				if(data.tempat_pengadaan === null){
					
					$('.d_tempat').hide();
				}else{
					$('#d_tempat_pengadaan').text(strip(data.tempat_pengadaan));
					$('.d_tempat').show();
				}
				
				if(data.email != '' && data.no_surat == ''){
					$('.row-email').show();
					$('.row-surat').hide();
					$('#update_surat').show();
				}else if(data.email == '' && data.no_surat != ''){
					$('.row-email').hide();
					$('.row-surat').show();
					$('#update_surat').hide();
				}else{
					$('.row-surat').hide();
					$('.row-email').hide();
				}
				if(data.tgl_disposisi_pimkel != '0000-00-00'){
					$('#d_disposisi_pimkel').text(tanggal(data.tgl_disposisi_pimkel));
					$('.ddpimkel').show();
				}
				
				if(data.tgl_disposisi_manajer != '0000-00-00'){
					$('#d_disposisi_manager').text(tanggal(data.tgl_disposisi_manajer));
					$('.ddmanager').show();
				}
				if(data.jenis_pengadaan != null){
					$('#d_jenis_pengadaan').parent().show();
					$('#d_jenis_pengadaan').text(data.jenis_pengadaan);
				}else{
					$('#d_jenis_pengadaan').parent().hide();
				}
				if(data.jenis_pengadaan == 'Pembelian Langsung'){
					$('.spk').show()
					let nospk = data.no_spk.split("<br>");
					let idnospk = data.id_detail_register.split(",");
					let i;
					let no_spk = '';
					for(i = 0;i<nospk.length;i++){
						if(i == nospk.length - 1){ 
						 	no_spk += "<a href='#' data-id='"+idnospk[i]+"' class='idspk' aria-label='Klik untuk memasukkan item' data-balloon-pos='up'>"+nospk[i]+"</a>";
						}else{
						 	no_spk += "<a href='#' data-id='"+idnospk[i]+"' class='idspk' aria-label='Klik untuk memasukkan item' data-balloon-pos='up'>"+nospk[i]+"</a><br>";
						}
					}
				if(cek_similar($('#d_unamepembuat').text(), '<?= $_SESSION['username'];?>')){
					$('#d_no_spk').html(strip(no_spk));
				}else{
					$('#d_no_spk').html(strip(data.no_spk));
				}

					$('#d_tgl_spk').html(strip(data.tgl_spk));
					$('#ds_vendor').html(strip(data.nm_vendor))
				}else{
					$('.spk').hide()
					
				}
				if((strip(data.status_data) == 'Done' && '<?= $_SESSION['role'];?>' == 'user') || (strip(data.status_data) == 'On Process' && '<?= $_SESSION['role'];?>' == 'user')){
					$('#d_status_data').text(strip(data.status_data)).css({'color':'green'});
					$('#btn-ubah, #btn-disposisi,#btn-jenis, #btn-aanwijzing, #btn-hapus, #btn-return, #btn-proses').hide();
					
				}else{ // jika status masih on proses
					$('#btn-ubah, #btn-disposisi,#btn-jenis, #btn-aanwijzing, #btn-hapus, #btn-return, #btn-proses').show();
					$('#d_status_data').text(strip(data.status_data)).css({'color':'red'});
					
					if(data.nama != null){ //jika pembuat ada dan bukan user yang mengakses
						$('.ddpembuat').show();
						$('#d_pembuat').html(data.nama);
						$('#btn-disposisi, #btn-jenis, #btn-aanwijzing, #btn-proses').hide();
						//$('#btn-disposisi').hide();
						if(cek_similar(data.username, '<?= $_SESSION['username'];?>'))
						{
							$('#btn-ubah, #btn-hapus, #btn-return').show();
							if(data.tempat_pengadaan !== null){ //jika tempat pengadaan sudah diisi
								
								if(data.tempat_pengadaan == 'BSK'){
									$('#btn-jenis').hide();	
									
									if(data.jenis_pengadaan == null){
										$('#btn-proses').hide();
									}else	if(data.jenis_pengadaan == 'Pembelian Langsung'){

										$('#btn-proses').show();
										$('#btn-aanwijzing').hide();
									}else if(data.jenis_pengadaan == 'Penunjukan Langsung')
									{
										$('#btn-aanwijzing').show();
										$('#btn-proses').hide();
									}else if(data.jenis_pengadaan == 'Pemilihan Langsung')
									{
										$('#btn-aanwijzing').show();
										$('#btn-proses').hide();
									}else if(data.jenis_pengadaan == 'Pelelangan')
									{
										$('#btn-aanwijzing').show();
										$('#btn-proses').hide();
									}

								}else{ // jika pengadaan nya di pfa
									//tambahin btn memo ke pfa
									$('#btn-proses').hide();
								}
							}else{ //jika tempat pengadaannya tidak diisi
								
								$('#btn-jenis').show();
								$('#btn-aanwijzing').hide();
								$('#btn-proses').hide();
							}

						}else{
							
							$('#btn-aanwijzing').hide();
							$('#btn-jenis').hide();
							$('#btn-proses').hide();
						}
						
					}else{
						$('#btn-aanwijzing, #btn-proses, #btn-jenis').hide();
					}
				}

			}
		})
	}

</script>