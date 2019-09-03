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
.cke_dialog .cke_dialog_contents {
     margin-bottom: 0; }
.cke_dialog .select-dropdown ~ select.cke_dialog_ui_input_select {
display: none; }
   .cke_dialog div.cke_dialog_ui_input_select, .cke_dialog select.cke_dialog_ui_input_select, .cke_dialog_ui_button a {
     display: block; }
     .cke_dialog_contents {
     margin-bottom: 0;
   }  
</style>
<div class="row first">
  <!-- <div class="col s12"> -->
  <div class="col push-l3 l9" style="left: 333.25px;">
    <form action="[URL]" method="post">
      <div class="input-field col s12 l12">
        <input type="text">
        <label>insert your title here</label>
      </div>
      <div class="input-field col s12 l12">
        <textarea name="content" id="editor">
            This is some sample content.&lt;/p&gt;
        </textarea>
      </div>
      <div class="input-field col s12 l12">
        <input type="submit" value="Submit">
      </div>
    </form>
  </div>
</div>


<script>

  $(document).ready(function(){
    
    CKEDITOR.replace('editor');
    /*ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );*/

  })
</script>