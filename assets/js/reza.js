
  function cektgl(tgl){
    if(tgl == '0000-00-00')
      return '';
    else
      return tgl;
  }
  function formatNumber(num){
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g,'$1.');
  }

  function cek_data(data){
    if(data == '0000-00-00' || data == '')
      return 'none';
    else
      return 'block';
  }
function strip(value){
    if(value == '' || value == null){
      return '-';
    }else{
      return value;
    }
}

function tanggal(value){
  if(value == '0000-00-00'){
    return '-';
  }else{
    let d = new Date(value); 
    let bulan = (d.getMonth()+1).toString().length == '1' ? '0'+(d.getMonth()+1).toString() : (d.getMonth()+1).toString();
    let tanggal = d.getDate().toString().length == '1' ? '0'+d.getDate().toString() : d.getDate().toString();
    //return tanggal+' '+get_month(bulan)+' '+d.getFullYear();
    return tanggal+'-'+bulan+'-'+d.getFullYear();
  }  
}

function tanggal_indo(value){
  if(value == '0000-00-00'){
    return '-';
  }else{
    let d = new Date(value); 
    let bulan = (d.getMonth()+1).toString().length == '1' ? '0'+(d.getMonth()+1).toString() : (d.getMonth()+1).toString();
    let tanggal = d.getDate().toString().length == '1' ? '0'+d.getDate().toString() : d.getDate().toString();
    return tanggal+' '+get_month(bulan)+' '+d.getFullYear();
    //return tanggal+'-'+get_month(bulan)+'-'+d.getFullYear();
  }  
}
function get_month($month){
  switch ($month) {
    case '01':
        month = "Januari";
        break;
    case '02':
        day = "Februari";
        break;
    case '03':
        day = "Maret";
        break;
    case '04':
        day = "April";
        break;
    case '05':
        day = "Mei";
        break;
    case '06':
        day = "Juni";
        break;
    case '07':
        day = "Juli";
        break;
    case '08':
        day = "Agustus";
        break;
    case '09':
        month = "September";
        break;
    case '10':
        day = "Oktober";
        break;
    case '11':
        day = "November";
        break;
    case '12':
        day = "Desember";
  }
  return day; 
}
function tanggal_r(value){
  if(value == '-' || value ==''){
    return '';
  }else{
    let tgl = value.split('-');
    return tgl[2]+'-'+tgl[1]+'-'+tgl[0];

  }

}

function cek_similar(words, find){
  if (words.indexOf(find) > -1) {
    return true;
  } else {
    return false;
  }
}
