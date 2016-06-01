<? extend('master.php') ?>
<? startblock('extra_head') ?>
<script type="text/javascript" language="javascript">
    $(document).ready(function() {
	
	/*$("#updatebar").click(function(){
             $("#update_bar").toggle();
      	});   */   

        build_grid("inbound_rates_grid","",<? echo $grid_fields; ?>,<? echo $grid_buttons; ?>);
        $('.checkall').click(function () {
            $('.chkRefNos').attr('checked', this.checked); //if you want to select/deselect checkboxes use this
        });
        $("#inbound_search_btn").click(function(){
            post_request_for_search("inbound_rates_grid","","inbound_search");
        });        
        $("#id_reset").click(function(){
            clear_search_request("inbound_rates_grid","");
        });

         $("#batch_update").click(function(){
            submit_form("inbound_batch_update");
        })
        $("#id_batch_reset").click(function(){ 
            $(".update_drp").each(function(){
                var inputid = this.name.split("[");
                $('#'+inputid[0]).hide();
            });
        });
        
       $(".update_drp").change(function(){
           var inputid = this.name.split("[");
           if(this.value != "1"){
               $('#'+inputid[0]).show();
           }else{
               $('#'+inputid[0]).hide();
           }
       }).each(function(){
            var inputid = this.name.split("[");
            if(this.value != "1"){
                $('#'+inputid[0]).show();
            }else{
                $('#'+inputid[0]).hide();
            }
        });

    });
</script>

<? endblock() ?>

<? startblock('page-title') ?>
<?= $page_title ?><br/>
<? endblock() ?>

<? startblock('content') ?>



<section class="slice color-three">
	<div class="w-section inverse no-padding">
    	<div class="container">
   	    <div class="row">
            	<div class="portlet-content"  id="search_bar" style="cursor:pointer; display:none">
                    	<?php echo $form_search; ?>
    	        </div>
            </div>
        </div>
    </div>
</section>
<section class="slice color-three">
	<div class="w-section inverse no-padding">
    	<div class="container">
   	    <div class="row">
        <span id="error_msg" class=" success"></span>
            	<div class="portlet-content"  id="update_bar" style="cursor:pointer; display:none">
                    	<?php echo $form_batch_update; ?>
    	        </div>
            </div>
        </div>
    </div>
</section>
<section class="slice color-three padding-b-20">
	<div class="w-section inverse no-padding">
    	<div class="container">
        	<div class="row">
                <div class="col-md-12">      
                        <form method="POST" action="del/0/" enctype="multipart/form-data" id="ListForm">
                            <table id="inbound_rates_grid" align="left" style="display:none;"></table>
                        </form>
                </div>  
            </div>
        </div>
    </div>
</section>

<? endblock() ?>	
<? end_extend() ?>  
