
<style type="text/css">
  .tgh {
    text-align: center;
  }
  .red
  {
    color: red;
  }
  .blue
  {
    color: blue;
  }
</style>
<div class="tgh">
<?php

  $temp ="";
  for($i = 0;$i < 20;$i++){
    
    for($a = 0 ;$a < $i;$a++){
      if($i % 2){

        echo "<span class='red'>".str_repeat("*",$a)."<br></span>";  
      }else{
        echo "<span class='blue'>".str_repeat("*",$a)."<br></span>";  
      }
    }
  }
      

?>
</div>