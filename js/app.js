// Treeview Initialization
$(document).ready(function() {
  $('.treeview-animated').mdbTreeview();
  var toastElList = [].slice.call(document.querySelectorAll('.toast'))
  toastElList.show()
});