<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Movers</title>
    <!-- style -->
    <link href="<?php echo base_url();?>/public/css/custom.css" rel="stylesheet">
    <link href="<?php echo base_url();?>/public/css/bootstrap.min.css" rel="stylesheet">
    <!-- fonts -->
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <meta name="google-signin-client_id" content="977212213737-0hetk3ndbhcllss7qjp1hi1o9gj734mi.apps.googleusercontent.com"> 
    
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,200i,300,400,500,500i,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="icon" href="<?php echo base_url('public/images/fav32.png'); ?>" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/bootstrap-material-datetimepicker.css" />
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('/public/js/myscript.js'); ?>"></script>
<style type="text/css">
	.overlay2 {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.9);
    transition: opacity 300ms;
    visibility: visible;
    opacity: 1;
}
</style>
</head>
<body>


<div class="overlay2">
  <div class="popup">
<?php if ($this->session->flashdata('msg1')!='') { ?>
<div class="alert alert-danger alert-dismissable">
<a href="#" class="close" data-dismiss="alert" >&times;</a>
<?php
echo $this->session->flashdata('msg1'); 
?>
</div>
<?php } ?>
    <h2 class="text-center">Enter Password</h2>
    <div class="content">
    <div class="formon_popup SIgn_form">
      <form action="" method="POST">
        <div class="form-group">
          <input type="password" name="pasCode" id="pasCode" class="form-control" placeholder="">
        </div>
        <div class="SIghIn">
          <input type="submit" name="subPass" id="subpass" value="submit">
        </div>
      </form>
    </div>
    </div>
  </div>
  </div>



</body>
</html>