<head>

</head>
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->


              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                             Time Management
                          </header>


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
                              <div class="form align">
                                  <form class="cmxform form-horizontal tasi-form type_box_lab" id="form" method="post" action="<?php echo base_url("Dashboard/addtime_management")?>" enctype="multipart/form-data" >

                                    <label for="lastname" class="control-label"></label>



                                   <!--    <div class="form-group ">
                                      <label>SELECT DAY OPTION
                                      <select name="fooby" required="">
                                      <option value="">Select Day</option>
                                      <option value="1">Monday</option>
                                      <option value="2">Tuesday</option>
                                      <option value="3">Wednesday</option>
                                      <option value="4">Thursday</option>
                                      <option value="5">Friday</option>
                                      <option value="6">Saturday</option>
                                      <option value="7">Sunday</option>

                                      </select>
                                        </div> -->



<input type="hidden" name="fooby" value="<?php echo $abd; ?>" >
                                        <div class="form-group">
                                        <p id="basicExample" class="myInput">


                                        <label>Start Time
                                        <input  type="text" class="time basicExample1256 number" name="start_time" value="" id="start_time12" required="" />
                                        <label>

                                        </label>
                                        <label>End Time
                                        <input  type="text" class="time basicExample1256 number" name="end_time" id="end_time12" required="" />
                                        </label>

                                        </p>
                                         <p id="vehicle1" class="error-message" style="display: none;">End Time must be greater then start time</p>
                                         <p id="vehicle11" class="error-message" style="display: none;">Start Time and End time can not be equal.</p>
                                           <p id="vehicle111" class="error-message" style="display: none;">Only One Hour time slot to be taken.</p>

                                        </div>


                                      <div class="form-group">
                                              <button class="btn btn-success submit" id="sub" type="submit">Submit</button>

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


      <?php
      $this->load->view('templete/footer');
      ?>

    <script src="<?php echo base_url("public/js/form-validation-script.js")?>"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.js"></script>




  </body>
</html>
<script>
$(function() {
  $('.panel-body').on('keydown', '.number', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||(/65|67|86|88/.test(e.keyCode)&&(e.ctrlKey===true||e.metaKey===true))&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
})
</script>
<script type="text/javascript">
  $("input:checkbox").on('click', function() {
  var $box = $(this);
  if ($box.is(":checked")) {
    var group = "input:checkbox[name='" + $box.attr("name") + "']";
    $(group).prop("checked", false);
    $box.prop("checked", true);
  } else {
    $box.prop("checked", false);
  }
});
</script>
<script type="text/javascript">
   $("#abcdef").hide();
   $("#daysoption").hide();
   $("#timeslots").hide();
</script>
<script type="text/javascript">
  function withincurrentday() {
    document.getElementById("withincurrentday1").checked = true;
    $("#abcdef").hide();
       $("#daysoption").hide();
   $("#timeslots").hide();
}
function within1hour() {
    document.getElementById("within1hour1").checked = true;
    $("#abcdef").hide();
       $("#daysoption").hide();
   $("#timeslots").hide();
}
function allcheck() {
    document.getElementById("allcheck12").checked = true;
    $("#abcdef").show();
    $("#daysoption").show();
    $("#timeslots").show();
    document.getElementsByName("fooby").checked = true;
        var id = $('#no_of_days').val();
        if (id>0) {
          return true;

        }
        else{
          return false;
        }






}
</script>


      <script>


                   $('#basicExample .time').timepicker({
                     // 'showDuration': true,
                        timeFormat: 'g:i A',
                      dropdown: true,
                      dynamic:false,
                      interval: 60,
                      scrollbar: true
                      // 'timeformat': 'g:i A'  // 24:59:59
                });





            </script>
            <script type="text/javascript">


        $("#form").submit(function(){
      var abc=ConvertTimeformat1("24", $("#start_time12").val());
      var end=ConvertTimeformat2("24", $("#end_time12").val());
      var add =  new Date(end) - new Date(abc);
    var dtStart = new Date("7/20/2015 " + abc);
    var dtEnd = new Date("7/20/2015 " + end);



var diff = dtEnd - dtStart;
    var diffSeconds = diff/1000;
var HH = Math.floor(diffSeconds/3600);
var MM = Math.floor(diffSeconds%3600)/60;

var formatted = ((HH < 10)?("0" + HH):HH) + ":" + ((MM < 10)?("0" + MM):MM);





      // return false;




      if (abc > end) {
      $("#vehicle1").show();
      return false;
      }
      else if(abc==end){
        $("#vehicle11").show();
        return false;

      }
      else if(formatted > ("01:00")){
        $("#vehicle111").show();
        return false;
      }

      else{
      return true;
      }
    });





function ConvertTimeformat1(format, str) {
    var time = $("#start_time12").val();
    var hours = Number(time.match(/^(\d+)/)[1]);
    var minutes = Number(time.match(/:(\d+)/)[1]);
    var AMPM = time.match(/\s(.*)$/)[1];
    if (AMPM == "PM" && hours < 12) hours = hours + 12;
    if (AMPM == "AM" && hours == 12) hours = hours - 12;
    var sHours = hours.toString();
    var sMinutes = minutes.toString();
    if (hours < 10) sHours = "0" + sHours;
    if (minutes < 10) sMinutes = "0" + sMinutes;
    return  (sHours + ":" + sMinutes);
}
function ConvertTimeformat2(format, str) {
    var time = $("#end_time12").val();
    var hours = Number(time.match(/^(\d+)/)[1]);
    var minutes = Number(time.match(/:(\d+)/)[1]);
    var AMPM = time.match(/\s(.*)$/)[1];
    if (AMPM == "PM" && hours < 12) hours = hours + 12;
    if (AMPM == "AM" && hours == 12) hours = hours - 12;
    var sHours = hours.toString();
    var sMinutes = minutes.toString();
    if (hours < 10) sHours = "0" + sHours;
    if (minutes < 10) sMinutes = "0" + sMinutes;
    return  (sHours + ":" + sMinutes);
}



            </script>
 <script type="text/javascript">
               var message="This function is not allowed here.";
               function clickIE4(){

                             if (event.button==2){
                             alert(message);
                             return false;
                             }
               }

               function clickNS4(e){
                             if (document.layers||document.getElementById&&!document.all){
                                            if (e.which==2||e.which==3){
                                                      alert(message);
                                                      return false;
                                            }
                                    }
               }

               if (document.layers){
                             document.captureEvents(Event.MOUSEDOWN);
                             document.onmousedown=clickNS4;
               }

               else if (document.all&&!document.getElementById){
                             document.onmousedown=clickIE4;
               }

               document.oncontextmenu=new Function("alert(message);return false;")

               function newPopup(url) {
              popupWindow = window.open(
                url,'popUpWindow','height=350,width=810,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes');
            }
</script>
<script>

jQuery(document).ready(function($) {
    var max = 6;
    $('.number').keypress(function(e) {
        if (e.which < 0x20) {
            // e.which < 0x20, then it's not a printable character
            // e.which === 0 - Not a character
            return;     // Do nothing
        }
        if (this.value.length == max) {
            e.preventDefault();
        } else if (this.value.length > max) {
            // Maximum exceeded
            this.value = this.value.substring(0, max);
        }
    });
}); //end if ready(fn)
</script>
