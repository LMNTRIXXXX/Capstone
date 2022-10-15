var x = setInterval(function () {
  var today = new Date();
  var time =
    today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
  if (time === "0:0:0") {
    window.location.href = "journalnotif.php";
  }
}, 1000);
