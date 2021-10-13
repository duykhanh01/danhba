// Treeview Initialization
$(document).ready(function() {
  $('.treeview-animated').mdbTreeview();
  
  
  // Ajax upload images
  $("#upload").click(function(){
    var file_data = $('#fileUpload')[0].files[0];
    var type = file_data.type;
    console.log(type)
        //Xét kiểu file được upload
    var match = ["image/gif", "image/png", "image/jpeg",];
    if(type == match[0] || type == match[1] || type == match[2]){

      var dataform = new FormData();
      var id = $('#userid').val();
      dataform.append('file', file_data);
      dataform.append('id', id);
      $.ajax({
        type: 'POST',
        url: "core/uploadfile.php",
        data: dataform,
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        success: function(res) {
        
          if(res != 0){
            $('#status-success').removeClass('d-none').addClass('d-block')
            $('#status-fail').removeClass('d-block').addClass('d-none')
            $('#status-success').text('Upload thành công');
            $('#img-file').attr('src', res)
            $('#file').val('');
          }
          else{
              // $('#status-fail').removeClass('d-none').addClass('d-block')
              // $('#status-success').removeClass('d-block').addClass('d-none')
              // $('#status-fail').text('Vui lòng chọn ảnh)');
          }
        }
      })
    } else {
      $('#status-fail').removeClass('d-none').addClass('d-block')
      $('#status-success').removeClass('d-block').addClass('d-none')

      $('#status-fail').text('Vui lòng upload file ảnh (.png / .jpg / .gif)');
    }


  })


  // Ajax seach users
  $('#search_users').keyup(function(){
    var search_users = $('#search_users').val();
    // var dataform = new FormData();
    // dataform.append('search_users', search_users);
    $.ajax({
      url: 'core/search-users.php',
      method: 'POST',
      
      // data: dataform,
      data: {search_users:search_users},
      
      success: function(response){
        $('#table_users').html(response);
      }
    })
  })

});