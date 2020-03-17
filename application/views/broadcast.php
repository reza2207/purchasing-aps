
  <!-- Page Layout here -->
    <div class="row first">
      <div class="col s12 offset-l3 l9">
        <div class="row">
          <div class="input-field col s6">
            <label class="active">Send To:</label>
            <select id="sendto" class="select-m" multiple>
              <option value="all">all</option>
              <?php foreach($sendto as $u):?>
              <option data-icon="<?= $this->Setting_model->dir_foto()->row('defaultnya').$u->profil_pict;?>" value="<?= $u->username;?>" class="circle"><?= $u->nama;?></option>
              <?php endforeach;?>
            </select>
          </div>
          <div class="input-field col s6">
            <label>Message:</label>
            <input type="text" class="validate" id="message" placeholder="press enter to send">
            <input type="text" class="validate" id="nama" hidden="true" value="<?= $_SESSION['nama'];?>">
          </div>
          
        </div>
        <div class="row">
          <div class="col s6">
            <ul class="collection with-header">
              <li class="collection-header blue"><b>To All</b></li>
              <div style="overflow-y: scroll;max-height: 250px;min-height: 150px" id="list-all">
                <?php foreach($list_all AS $c){?>
                <li class="collection-item"><div><?= $c->chat;?><br><a>from <?= $c->nama;?> @<?= $c->created_at;?></a></div></li>
                <?php };?>
              </div>
            </ul>
          </div>
          <div class="col s6">
            <ul class="collection with-header">
              <li class="collection-header green"><b>Private</b></li>
              <div style="overflow-y: scroll;max-height: 250px;min-height: 150px">                    
              </div>
            </ul>
          </div>
        </div>
          
      </div>

    </div>

<script src="<?= base_url().'assets/js/jquery.uploadPreview.min.js';?>"></script>
<script>
  $(document).ready(function(){
    
    $('.select-m').formSelect();
    let chatHistorys = document.getElementById("list-all");
        chatHistorys.scrollTop = chatHistorys.scrollHeight;
    
    $('#message').on('keydown', function(e){
      
      if(e.which == 13){
        let msg = $('#message').val();
        let nama = $('#nama').val();
        let sendto = $('#sendto').val();
        let gambar = "<?= $this->Setting_model->dir_foto()->row('defaultnya').$this->User_model->get_user($_SESSION['username'])->profil_pict;?>";
        let data = { nama: nama, msg: msg, sendto: sendto, gambar: gambar };

        
        if(msg.length > 0 && sendto !== null){
          
          $('#message').val('');
          $.ajax({
            type: 'POST',
            url : '<?= base_url()."setting/send_broadcast";?>',
            data: data,
            dataType: 'JSON',
            success : function(data){
              if(data.status == 'success'){
                socket.emit('broadcast', data);

              }
            }
          })
          
        }else if(msg.length > 0 && sendto === null){
          let toastHTML = 'please select receiver at least one';
          M.toast({
            html: toastHTML
          });
        }
      }
    })
    
    

  });
</script>