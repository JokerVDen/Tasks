jQuery(document).ready(function ($) {
  $('#orderBy').change(function (e) {
    this.form.submit();
    console.log(e);
  });
  $('#direction').change(function (e) {
    this.form.submit();
    console.log(e);
  });
});