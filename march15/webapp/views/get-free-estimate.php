<?php
    $user = json_decode(file_get_contents('http://movers.com.au/Admin/api/User/getVehicleMove'));
    $VehicleData = $user->Response->vehicledata;
    // echo "<pre>";print_r($user);die;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Movers</title>
    <!-- style -->
    <link href="<?php echo base_url();?>/public/css/custom.css" rel="stylesheet">
    <link href="<?php echo base_url();?>/public/css/bootstrap.min.css" rel="stylesheet">
    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,200i,300,400,500,500i,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="<?php echo base_url('public/images/fav32.png'); ?>" type="image/x-icon" />
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('/public/js/myscript.js'); ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- <script src="https://apis.google.com/js/platform.js" async defer></script> -->
    <!-- <meta name="google-signin-client_id" content="977212213737-0hetk3ndbhcllss7qjp1hi1o9gj734mi.apps.googleusercontent.com">   -->
    <script>
      function initAutocomplete() {
        var map = new google.maps.Map(document.getElementById('map'), {
          position: {lat: 30.7262141,lng: 76.8451191},
          zoom: 13,
          mapTypeId: 'roadmap'
        });        
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();
        
          places.forEach(function(place) {
            bindDataToForm(place.formatted_address,place.geometry.location.lat(),place.geometry.location.lng());
          });
        });

        var input1 = document.getElementById('pac-input1');
        var searchBox1 = new google.maps.places.SearchBox(input1);    
        searchBox1.addListener('places_changed', function() {
          var places = searchBox1.getPlaces();    
          places.forEach(function(place) {
            bindDataToForm1(place.formatted_address,place.geometry.location.lat(),place.geometry.location.lng());
          });
        });

      }
      function bindDataToForm(address,lat,lng){
        document.getElementById('lat').value = lat;
        document.getElementById('lng').value = lng;
      }
      function bindDataToForm1(address1,lat1,lng1){
        document.getElementById('lat1').value = lat1;
        document.getElementById('lng1').value = lng1;
      } 
    </script>  
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACSueOTI5iEZBVIu-G7ROeW2DiQn8tVGw&libraries=places&callback=initAutocomplete" async defer>
    </script>  			
</head>
<style>
.displaynone{display: none;}
</style>

<body class="free-estimate">
    <section class="banner banner-free-estimate">
        <section class="banner-inner">
            <header>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="navigation">
                                <div class="navbar-header">
                                    <button aria-controls="bs-navbar" aria-expanded="false" class="collapsed navbar-toggle" data-target="#bs-navbar" data-toggle="collapse" type="button">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                    <a href="../" class="navbar-brand"><img src="<?php echo base_url();?>/public/images/logo.png" alt="#" class="img-responsive"></a>
                                </div>
                                <nav class="collapse navbar-collapse" id="bs-navbar">
                                    <ul class="nav navbar-nav navbar-right">
                                        <li><a href="#">Home</a></li>
                                        <li><a href="#">About</a></li>
                                        <li><a href="#">Services</a></li>
                                        <li><a href="#">Contact Us</a></li>
                                        <li>
                                            <a href="http://movers.com.au/Driver">
                                                <button type="button">Become a Mover</button>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
        </section>
    </section>

    <section class="estimate-content-section">
        <section class="estimate-content-inner">
            <div class="container">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <span id="span" style="color: #ff0000;display: inline-block;float: none;font-size: 18px;text-align: center;width: 100%;"></span>
                        <div class="pickup-dropoff">
                            <h3 class="estimate-heading">Tell us your pick-up and drop-off location</h3>
                            <div class="input-fields">
                                <div class="row">
                                    <div class="col-sm-6 col-md-6 input-field-line">
                                        <div id="map" style="width:600px;height:400px;display: none;"></div>
                                        <input class="forml1" name="lat" type="hidden" id="lat" value=''>
                                        <input class="forml1" name="lng" type="hidden" id="lng" value=''>
                                        <input class="forml1" name="lat" type="hidden" id="lat1" value=''>
                                        <input class="forml1" name="lng" type="hidden" id="lng1" value=''>
                                        <input type="hidden" id="vehh" value="">
                                        <input type="hidden" id="vmov" value="">
                                        <label>Pickup address</label>
                                        <input type="text" placeholder="Enter Pickup" class="form-control" id="pac-input">
                                    </div>
                                    <div class="col-sm-6 col-md-6 input-field-line input-field-destination">
                                        <label>Destination address</label>
                                        <input type="text" placeholder="Enter Destination" class="form-control" id="pac-input1">
                                    </div>
                                 <!--    <div class="col-sm-2">
                                        <button type="button">Submit</button>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="move-type">
                            <div class="row">  
                                <div class="col-sm-12">
                                    <h3 class="estimate-heading">Vehicle Type</h3>
                                </div>
                                <?php 
                                    $i=1; 
                                    foreach ($VehicleData as $key => $value){
                                    // $static_key = "hj!1%$FcH^&R^&^@^@!@dejewd";
                                    // $veh_ids = $value->id.'_'.$static_key;
                                    // $vid = base64_encode($veh_ids);
                                ?>           
                                    <div class="col-sm-4" id="actiive">
                                        <div class="move-type-vehicle" id="ute<?php echo $i; ?>" onClick="myfunn(<?php echo $value->id; ?>);">
                                            <img src="<?php echo $value->icon; ?>" class="img-responsive"><h3><?php echo $value->name; ?></h3>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                       <!--  <div class="move-type">
                            <div class="row"> 
                                <div class="col-sm-8 col-sm-offset-2">
                                    <div class="row">
                                        <div class="col-sm-6" onClick="myfun(1);">
                                            <div class="move-type-vehicle estimated-price">
                                                <img src="<?php echo base_url();?>/public/images/ic_mover_big.png" class="img-responsive"><div class="mover-count-wrap"><h3 class="mover-count">For <span class="NUmber_Font aw">1</span> Mover</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6" onClick =" myfun(2);">
                                        <div class="move-type-vehicle estimated-price">
                                            <img src="<?php echo base_url();?>/public/images/ic_mover_double_big.png" class="img-responsive">
                                            <div class="mover-count-wrap">
                                                <h3 class="mover-count">For<span class="NUmber_Font aw" >2</span> Movers</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="move-type">
                            <div class="row">  
                                <div class="col-sm-12" >
                                    <h3 class="estimate-heading">Movers required</h3>
                                </div>  
                                <div class="row">  
                                <div class="col-sm-1 col-sm-offset-1"></div>     
                                <div class="col-sm-4" id="moactive">
                                    <div class="move-type-vehicle" onClick="myfun(1);">
                                       <img src="<?php echo base_url();?>/public/images/ic_mover_big.png" class="img-responsive"><div class="mover-count-wrap"><h3 class="mover-count">For <span class="NUmber_Font aw">1</span> Mover</h3>
                                    </div>
                                </div>
                            </div>
                                <div class="col-sm-4" id="moactive">
                                    <div class="move-type-vehicle" onClick="myfun(2);">
                                       <img src="<?php echo base_url();?>/public/images/ic_mover_double_big.png" class="img-responsive"><div class="mover-count-wrap"><h3 class="mover-count">For <span class="NUmber_Font aw">2</span> Mover</h3>
                                    </div>
                                </div>
                            </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 get_quick" id ="prioce">
                            <h4>Price Estimate</h4>
                            <p id="price"></p>  
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <div class="get_quick">
                                <button id="estimate">Get a quick estimate</button>   
                            </div>
                        </div>
                    </div>

<script type="text/javascript">
$('#prioce').addClass('displaynone');

$('#actiive div').click(function() {
    $('#actiive div.active').removeClass('active');
    $(this).closest('div').addClass('active');
});
$('#moactive div').click(function() {
    $('#moactive div.active').removeClass('active');
    $(this).closest('div').addClass('active');
});

function myfunn(e){
   var con = window.btoa(e);
    $('#vehh').val(con);
}
function myfun(e){
    var con = window.btoa(e);
    $('#vmov').val(con);
}
$('#estimate').click(function(){
    var veh = $('#vehh').val();
    var mov = $('#vmov').val();

});
// $(document).bind("contextmenu",function(e) {
//  e.preventDefault();
// });
// $(document).keydown(function(e){
//     if(e.which === 123){
//        return false;
//     }
// });
// document.onkeydown = function(e) {
//   if (e.ctrlKey && 
//       (e.keyCode === 85 )) {
//       return false;
//   }
//   if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
//      return false;
//   }
//   if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
//      return false;
//   }
// };
$('#estimate').click(function(){
    var lat = $('#lat').val();
    var lng = $('#lng').val();
    var lat1 = $('#lat1').val();
    var lng1 = $('#lng1').val();
    var origin = lat+','+lng;
    var Destination = lat1+','+lng1;
    var veh = window.atob($('#vehh').val());
    var mov = window.atob($('#vmov').val());
    if(lat == ''){
        $('#span').html('Please select Pickup Address!');
        return false;
    }else if(lat1 == ''){
        $('#span').html('Please select Destination Address!');
        return false;    
    }else if(veh == ''){
        $('#span').html('Please select Vehcile!');
        return false;
    }else if(mov == ''){
        $('#span').html('Please select Movers!');
        return false;
    }else{
        $('#span').html('');
        $.ajax({
            method: 'POST',
            url: '<?php echo base_url(); ?>App/getfree',
            data: 'origin='+origin+'&destination='+Destination+'&vehc='+veh+'&move='+mov,
            success: function(result){
                $('#prioce').removeClass('displaynone');
                $('#price').html(result);
            }
        });
    }
});
</script>


























</div></div>
            </div>
</section>

        </section>