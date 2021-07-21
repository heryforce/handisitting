// AJAX call for autocomplete
$(document).ready(function () {
  $("#city").keyup(function () {
    $.ajax({
      type: "POST",
      url: "frmSearch.php",
      data: "keyword=" + $(this).val(),
      beforeSend: function () {
        $("#city").css(
          "background",
          "#FFF url(LoaderIcon.gif) no-repeat 165px"
        );
      },
      success: function (data) {
        $("#suggestion-box").show();
        $("#suggestion-box").html(data);
        $("#city").css("background", "#FFF");
      },
    });
  });
});
//To select country name
function selectCity(val) {
  $("#city").val(val);
  $("#suggestion-box").hide();
}
