<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>


<script>
function showAlert( message, alerttype ) {

$('#alert_placeholder').append( $('#alert_placeholder').append(
  '<div id="alertdiv" class="alert ' +  alerttype + '">' +
      '<a class="close" data-dismiss="alert" aria-label="close" >×</a>' +
      '<span>' + message + '</span>' + 
  '</div>' )
);

// close it in 3 secs
setTimeout( function() {
    $("#alertdiv").remove();
}, 5000 );

}
</script>