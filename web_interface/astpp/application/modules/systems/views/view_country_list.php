<? extend('master.php') ?>
<? startblock('extra_head') ?>


<script type="text/javascript" language="javascript">
    $(document).ready(function() {
      
        build_grid("country_grid","",<? echo $grid_fields; ?>,<? echo $grid_buttons; ?>);
        $('.checkall').click(function () {
            $('.chkRefNos').attr('checked', this.checked); //if you want to select/deselect checkboxes use this
        });
        $("#country_search_btn").click(function(){
            post_request_for_search("country_grid","","country_search");
        });        
        $("#id_reset").click(function(){ 
            clear_search_request("country_grid","");
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

<section class="slice color-three padding-b-20">
	<div class="w-section inverse no-padding">
    	<div class="container">
        	<div class="row">
                <div class="col-md-12">      
                        <form method="POST" action="del/0/" enctype="multipart/form-data" id="ListForm">
                            <table id="country_grid" align="left" style="display:none;"></table>
                        </form>
                </div>  
            </div>
        </div>
    </div><!--
<br/><div class="pull-right padding-r-20">
      <a class="btn-tw btn" href="/systems/country_export_xls/"><i class="fa fa-file-excel-o fa-lg"></i>Export CSV</a>
      
</div><br/><br/>  -->
</section>


<? endblock() ?>	

<? end_extend() ?>  
 
