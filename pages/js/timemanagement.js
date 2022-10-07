function timemanagement(logintime) {
  var countDownDate = new Date(logintime).getTime();
  // Update the count down every 1 second
  var x = setInterval(function () {
    // Get today's date and time
    var today = new Date();
    var time =
      today.getFullYear() +
      "-" +
      (today.getMonth() + 1) +
      "-" +
      today.getDate() +
      " " +
      today.getHours() +
      ":" +
      today.getMinutes() +
      ":" +
      today.getSeconds();
    var newtime = new Date(time).getTime();
    // Find the distance between now and the count down date
    var distance = newtime - countDownDate;
    // Time calculations for days, hours, minutes and seconds
    var hours = Math.floor(
      (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
    );
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Output the result in an element with id="demo"
    document.getElementById("demo").value =
      hours + ":" + minutes + ":" + seconds;
  }, 1000);
}
var logintime = document.getElementById("logintime").innerHTML;
timemanagement(logintime);
