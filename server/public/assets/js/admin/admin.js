$(document).ready(function() {
   if($('.list_check_all').length > 0){
    $('.list_check_all').on('change',function(){
        $(`input[name="id[]"]`).prop('checked',$(this).prop('checked'))
    })
   }
});
