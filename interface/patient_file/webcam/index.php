
<?php
include_once("../../globals.php");
require_once("$srcdir/patient.inc");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <title></title>
    <link href="_vendor/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/examples/jumbotron-narrow/jumbotron-narrow.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->




  </head>

  <body>
    <?php 
    //$pid = query("SELECT pid FROM patient_data");
    $res = sqlStatement("SELECT fname,mname,lname,ss,street,city,state,postal_code,phone_home,DOB, patient_data.pid,
      snapshot.Image FROM patient_data
      left join snapshot on snapshot.pid=patient_data.pid WHERE patient_data.pid = $pid");
    $result = SqlFetchArray($res); 
    ?>



<div class="row">
<div class="col-lg-12">
<div class="panel-panel btn-white" style="max-width: 80rem;">
  <div class="card-header">Taken Picture for <?php echo $result['fname'] . '&nbsp' . $result['mname'] . '&nbsp;' . $result['lname'] .'&nbsp;' . $result['pid'];?>
  
                      </div>
                    </div>
                  </div>
                  
 
          <div class="col-lg-7">
            
            <div class="text-center">
        <div id="camera_info"></div><br>
    <div id="camera"></div><br>
    <button id="take_snapshots" class="btn btn-success btn-lg">Take Snapshots</button>
    
      </div>
    </div>

           
<div class="col-lg-3">
   
       
            <table class="table table-bordered">
            <thead><br>
                <tr>
                    <th>Patient Image</th>
                </tr>
            </thead>
            <tbody>
              <tr><td><img src="<?php echo($result['Image'])?>" style="width: 13em;height: 10em;border-radius: 5%;"></td></tr>

            </tbody>

        </table>
        </div>
      </div> <!-- /container -->
      <hr>
  </body>
</html>
<style>
#camera {
  width: 30%;
  height: 150px;
  margin-left: 250px;
}

</style>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="jpeg_camera/jpeg_camera_with_dependencies.min.js" type="text/javascript"></script>
<script>
    var options = {
      shutter_ogg_url: "jpeg_camera/shutter.ogg",
      shutter_mp3_url: "jpeg_camera/shutter.mp3",
      swf_url: "jpeg_camera/jpeg_camera.swf",
    };
    var camera = new JpegCamera("#camera", options);
  
  $('#take_snapshots').click(function(){
    var snapshot = camera.capture();
    snapshot.show();
    
    snapshot.upload({api_url: "action.php"}).done(function(response) {
$('#imagelist').prepend("<tr><td><img src='"+response+"' width='100px' height='100px'></td><td>"+response+"</td></tr>");
}).fail(function(response) {
  alert("Upload failed with status " + response);
});
})

function done(){
    $('#snapshots').html("uploaded");
}
</script>