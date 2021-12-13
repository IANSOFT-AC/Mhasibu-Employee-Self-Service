$(function () {
  $(document).on("click", ".showModalButton", function () {
    if ($("#modal").hasClass("in")) {
      $("#modal").find(".modal-body").load($(this).attr("value"));
      document.getElementById("myModalLabel").innerHTML =
        "<h4>" + $(this).attr("title") + "</h4>";
    } else {
      $("#modal")
        .modal("show")
        .find(".modal-body")
        .load($(this).attr("value"));
      document.getElementById("myModalLabel").innerHTML =
        "<h4>" + $(this).attr("title") + "</h4>";
    }
  });

  $('#modal').on('hidden.bs.modal',function(){
    var reld = location.reload(true);
    setTimeout(reld,1000);
}); 


});
