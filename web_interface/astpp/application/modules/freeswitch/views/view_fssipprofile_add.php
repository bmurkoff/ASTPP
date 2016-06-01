<? extend('master.php') ?>
<?php error_reporting(E_ERROR); ?>
<? startblock('extra_head') ?>


<?php endblock() ?>
<?php startblock('page-title') ?>
<?= $page_title ?>
<br/>
<?php endblock() ?>
<?php startblock('content') ?>
<script type="text/javascript">
    
    $("#submit").click(function(){
        submit_form("fssipprofile_form");
    })
</script>
<script>
$(document).ready(function(){
  $("#sip_name").change(function(){
    $('#error_msg_sip').text('');
    return false;
  });
  $("#sip_ip").change(function(){
    $('#error_msg_ip').text('');
    return false;
  });
  $("#sip_port").change(function(){
    $('#error_msg_port').text('');
    return false;
  });
  
});
</script>
<script type="text/javascript">
function validateForm(){
	//           ^(([1-9]?\d|1\d\d|2[0-5][0-5]|2[0-4]\d)\.){3}([1-9]?\d|1\d\d|2[0-5][0-5]|2[0-4]\d)$;
      //var Pattern=/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;
//       var portno = /^\d{4}$/;  
      var ipaddress = document.getElementById("sip_ip").value;
      var pattern =/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/; 
      var match = ipaddress.match(pattern);
      var val=document.getElementById('sip_port').value;
      var length1=val.length;
       var numbers  = isNaN(val);
      if(document.getElementById('sip_name').value == "")
      {
//           
	  $('#error_msg_sip').text( "Please Enter sip profile Name" );
	  document.getElementById('sip_name').focus();
	  return false;
      }
      if(document.getElementById('sip_ip').value == "")
      {
//           
	  $('#error_msg_ip').text( "Please Enter sip IP" );
	  document.getElementById('sip_ip').focus();
	  return false;
      }
//       if(match == null)
//       {
// //           
// 	  $('#error_msg_ip').text( "Please Enter Valid sip IP" );
// 	  document.getElementById('sip_ip').focus();
// 	  return false;
//       }
      if(document.getElementById('sip_port').value == "")
      {
//           
	  $('#error_msg_port').text( "Please Enter sip port" );
	  document.getElementById('sip_port').focus();
	  return false;
      }
      if(numbers == true)
      {
//           
	  $('#error_msg_port').text( "Please Enter Only Numeric value" );
	  document.getElementById('sip_port').focus();
	  return false;
      }
      if(length1 > 5)
      {
         $('#error_msg_port').text( "Please Enter port not exceed 5 number" );
	  document.getElementById('sip_port').focus();
	  return false;
      }
      $('#myForm1').submit();
       
}     
     
    
</script>



<div>
  <div>
    <section class="slice color-three no-margin">
	<div class="w-section inverse no-padding">
            <div style="color:red;margin-left: 60px;">
                <?php if (isset($validation_errors)) echo $validation_errors; ?> 
            </div>
            <?php echo $form; ?>
        </div>      
    </section>
  </div>
</div>
<div>
  <div>
    <section class="slice color-three">
	<div class="w-section inverse no-padding">
	  <div class="container">
        	<div class="row">
                  <div class="col-md-12" align=center style='margin-top:15px;' > 
		    <div style="color:red;margin-left: 60px;">
			<?php if (isset($validation_errors)) echo $validation_errors; ?> 
		    </div>
		  <form method="post" action="<?= base_url() ?>freeswitch/fssipprofile_add/add/" enctype="multipart/form-data" name='form1' id ="myForm1" >
			
			<div class='col-md-12'><div style="width:565px;" ><label style="text-align:right;" class="col-md-4">Sip Profile Name :   </label><input class="col-md-5 form-control " id="sip_name" name="name" size="20" type="text"></div>
			<span style="color:red;margin-left: 10px;float:left;" id="error_msg_sip"></span>
			</div>
<!-- 			<div><label>Status  : </label> -->
		<!--	<select name="status" id="status" style="width:155px;" class="select field medium">
			  <option> Active </option>
			  <option> In-active </option>
			</select>-->
		<div class='col-md-12'>	  
		<div style="width:550px;" ><label style="text-align:right;" class="col-md-4">Sip IP :  </label><input class="col-md-5 form-control " value="" id="sip_ip" name="sip_ip" size="20" type="text"></div>
		<span style="color:red;margin-left: 10px;float:left;" id="error_msg_ip"></span>
		</div>
		<div class='col-md-12'>
			<div style="width:550px;"><label style="text-align:right;" class="col-md-4">Sip Port :</label><input class="col-md-5 form-control " value="" id="sip_port" name="sip_port" size="20" type="text"></div>
			<span style="color:red;margin-left: 10px;float:left;" id="error_msg_port"></span>
		</div>
		<div class='col-md-12'>
			<div style="width:550px;"><label style="text-align:right;" class="col-md-4">Status :</label>
			<select name="sipstatus" class="col-md-5 form-control">
			    
			    <option value="0">Active</option>
			    <option value="1">Inactive</option>
			  </select>
                       </div>
		</div>
		<div class='col-md-12'>
			<div class='col-lg-12 padding-t-10 padding-b-10'>
			  <input class="btn btn-line-parrot" name="action" value="Save" type="button" onclick="validateForm();">
			<input class="btn btn-line-sky  margin-x-10" onclick="javascript:window.location ='<?= base_url() ?>/freeswitch/fssipprofile/'" name="action" value="Cancel" type="button"></div>
			</div>
		    </form>
        </div>      
    </section>
 </div></div></div>  
    </section>
  </div>
</div>

<? endblock() ?>
<? startblock('sidebar') ?>
<? endblock() ?>
<? end_extend() ?>
