
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
     
            
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                             Add City
                          </header>
                         <?php 
                           $chargetype=$setting[0]->type;
                           ?> 
                                         <?php if ($this->session->flashdata('msg1')!='') { ?>
                                <div class="alert alert-danger alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php
                                echo $this->session->flashdata('msg1'); 
                                ?>
                                </div>
                                <?php } ?>
                                       <?php if ($this->session->flashdata('msg2')!='') { ?>
                                <div class="alert alert-danger alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php
                                echo $this->session->flashdata('msg2'); 
                                ?>
                                </div>
                                <?php } ?>
                                 <?php if ($this->session->flashdata('msg3')!='') { ?>
                                <div class="alert alert-danger alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php
                                echo $this->session->flashdata('msg3'); 
                                ?>
                                </div>
                                <?php } ?>
                                      <?php if ($this->session->flashdata('msg4')!='') { ?>
                                <div class="alert alert-danger alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php
                                echo $this->session->flashdata('msg4'); 
                                ?>
                                </div> 
                                <?php } ?>

                          <div class="panel-body">
                          <a class="btn btn-info" href="<?php echo base_url("Dashboard/excelgenerate")?>"  type="submit">Download excel Format</a>
                           <form class="cmxform form-horizontal tasi-form type_box_lab" method="post" action="<?php echo base_url("Dashboard/addcity")?>" enctype="multipart/form-data" >
                        

                          <input class="form-control auto" name="csv_file" type="file" required="" />
                 
                             <button class="btn btn-success submit"   type="submit">Upload Excel</button>

                            </form>

                              <div class="form align">

                                  <form class="cmxform form-horizontal tasi-form type_box_lab" id="signupForm" method="post" action="<?php echo base_url("Dashboard/addcity")?>" enctype="multipart/form-data" >
                            
<div class="ui-widget form-group">
<label for="city">Set cities name </label>
<input id="city" class="form-control auto" name="title" type="text" placeholder="Enter city name" autocomplete="on" required="" />  
</div> 

<!-- <div class="ui-widget form-group">
<label for="city">Upload  Excel </label>
<input class="form-control auto" name="csv_file" type="file" placeholder="Enter city name"/>  
</div>  --> 



                                       <div class="form-group">
                                              <button class="btn btn-success submit" name="city"  type="submit">Submit</button>
                                          
                                      </div>


                                  </form>
                              </div>
                          </div>






                      </section>
                  </div>
              </div>
              <!-- page end-->
          </section>
      </section>
      <!--main content end-->
      <!--footer start-->
      <?php 
      $this->load->view('templete/footer');
      ?>
      <!--footer end-->


    <!-- js placed at the end of the document so the pages load faster -->


    <!--script for this page-->
    <script src="<?php echo base_url("public/js/form-validation-script.js")?>"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.js"></script>

  
</script>  </body>
</html>

<script type="text/javascript">
  $(function() {
    $( "#city" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
          url: "http://gd.geobytes.com/AutoCompleteCity",
          dataType: "jsonp",
          data: {
            q: request.term
          },
          success: function( data ) {  
            console.log(data);
            response( data );
          }
        });
      },
      minLength: 3,
    });
  });
</script>
<!-- <script type="text/javascript">
  $('#city').autocomplete({
    source: function (request, response) {
      
        $.getJSON("http://autocomplete.geocoder.cit.api.here.com/6.2/suggest.json?app_id=785ZPZ1ILOC9YjtehMbo&app_code=i4F0kHXCbhHk3DUR_N4JHw&query=" + request.term, function (data) {
            response($.map(data.dealers, function (value, key) {
                    console.log(data);
            response( data );
                return {
                    label: value,
                    value: key
                };
            }));

            //            console.log(data);
            // response( data );
        });
    },
    minLength: 2
});
</script> -->

<!-- <script type="text/javascript">
  $(function() {
    $( "#city" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
          url: "http://www.geonames.org/search.html?q=chandigarh&country=",
          dataType: "jsonp",
          data: {
            q: request.term
          },
          success: function( data ) {  
            console.log(data);
            response( data );
          }
        });
      },
      minLength: 3,
    });
  });
</script> -->



<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACSueOTI5iEZBVIu-G7ROeW2DiQn8tVGw&libraries=places"></script>

<!-- <script type="text/javascript">
   function initialize() {


 //    var options = {
 //  types: ['(cities)']
 // };
//  var options = {

//   types: ['(cities)'],
//    componentRestrictions: {country: "in"}
// };

 // var options = {
 //  types: ['(cities)'],
 //  componentRestrictions: {country: "in"}
 // };
   var options = {
     // bounds: cityBounds,
     // types: ['establishment'],
      types: ['(cities)'],
        componentRestrictions: {
        // types: 'cities'
        }
     };

 var input = document.getElementById('searchTextField');
 var autocomplete = new google.maps.places.Autocomplete(input, options);




// autocomplete.bindTo('bounds', map);

      // var input = document.getElementById('searchTextField');
      // var autocomplete = new google.maps.places.Autocomplete(input);
   }
   google.maps.event.addDomListener(window, 'load', initialize);
</script> -->


<script type="text/javascript">
   function initialize() {


 //    var options = {
 //  types: ['(cities)']
 // };
//  var options = {

//   types: ['(cities)'],
//    componentRestrictions: {country: "in"}
// };

 // var options = {
 //  types: ['(cities)'],
 //  componentRestrictions: {country: "in"}
 // };
   var options = {
     // bounds: cityBounds,
     // types: ['establishment'],
      types: ['(cities)'],
        componentRestrictions: {
        // types: 'cities'
        }
     };

 var input = document.getElementById('searchTextField');
 var autocomplete = new google.maps.places.Autocomplete(input, options);




// autocomplete.bindTo('bounds', map);

      // var input = document.getElementById('searchTextField');
      // var autocomplete = new google.maps.places.Autocomplete(input);
   }
   google.maps.event.addDomListener(window, 'load', initialize);
</script>






<!-- <script type="text/javascript">
  $( document ).ready(function() {
$.support.cors = true;
$.ajaxSetup({ cache: false });
var city = '';
var hascity = 0;
var hassub = 0;
var state = '';
var nbhd = '';
var subloc = '';
$('#zip_code').keyup(function() {
$zval = $('#zip_code').val();
if($zval.length == 5){
$jCSval = getCityState($zval, true); 
}
});
function getCityState($zip, $blnUSA) {
var date = new Date();
$.getJSON('https://maps.googleapis.com/maps/api/geocode/json?address=' + $zip + '&key=AIzaSyACSueOTI5iEZBVIu-G7ROeW2DiQn8tVGw&type=json', function(response){
//find the city and state
var address_components = response.results[0].address_components;
$.each(address_components, function(index, component){
var types = component.types;
$.each(types, function(index, type){
if(type == 'locality') {
city = component.long_name;
hascity = 1;
}
if(type == 'administrative_area_level_1') {
state = component.short_name;
}
if(type == 'administrative_area_level_2') {
nbhd = component.long_name;
}
if(type == 'country') {
subloc = component.long_name;
hassub = 1;
}
});
});
//pre-fill the city and state
if(hascity == 1){
$('#city1').val(city);
} else if(hassub == 1) {
$('#city1').val(subloc);
} else {
$('#city1').val(nbhd);
}
$('#state1').val(state);
//reset
var hascity = 0;
var hassub = 0;
});
}
});
</script> -->


<!-- <script type="text/javascript">
  $( document ).ready(function() {
$.support.cors = true;
$.ajaxSetup({ cache: false });
var city = '';
var hascity = 0;
var hassub = 0;
var state = '';
var nbhd = '';
var subloc = '';
$('#zip_code').keyup(function() {
$zval = $('#zip_code').val();
if($zval.length == 5){
$jCSval = getCityState($zval, true); 
}
});
function getCityState($zip, $blnUSA) {
var date = new Date();
$.getJSON('https://maps.googleapis.com/maps/api/geocode/json?address=' + $zip + '&key=AIzaSyACSueOTI5iEZBVIu-G7ROeW2DiQn8tVGw&type=json', function(response){
//find the city and state
var address_components = response.results[0].address_components;
$.each(address_components, function(index, component){
var types = component.types;
$.each(types, function(index, type){
if(type == 'locality') {
city = component.long_name;
hascity = 1;
}
if(type == 'administrative_area_level_1') {
state = component.short_name;
}
if(type == 'administrative_area_level_2') {
nbhd = component.long_name;
}
if(type == 'country') {
subloc = component.long_name;
hassub = 1;
}
});
});
//pre-fill the city and state
if(hascity == 1){
$('#city1').val(city);
} else if(hassub == 1) {
$('#city1').val(subloc);
} else {
$('#city1').val(nbhd);
}
$('#state1').val(state);
//reset
var hascity = 0;
var hassub = 0;
});
}
});
</script>
 -->
