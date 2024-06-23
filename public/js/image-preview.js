$(document).on("click", ".browse", function () {
  var file = $(this).parents(":eq(1)").siblings(".file");
  file.trigger("click");
});
$(document).on("change", 'input.image-input[type="file"]', function (e) {
  var fileName = e.target.files[0].name;
  var thisInputName = $(this).attr("name");
  $(
    "#file" + thisInputName.charAt(0).toUpperCase() + thisInputName.slice(1)
  ).val(fileName);

  var reader = new FileReader();
  reader.onload = function (e) {
    // get loaded data and render thumbnail.
    document.getElementById(
      "preview" + thisInputName.charAt(0).toUpperCase() + thisInputName.slice(1)
    ).src = e.target.result;
  };
  // read the image file as a data URL.
  reader.readAsDataURL(this.files[0]);
});
