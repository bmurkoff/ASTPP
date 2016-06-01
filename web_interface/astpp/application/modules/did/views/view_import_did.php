<? extend('master.php') ?>
<? startblock('extra_head') ?>
<? endblock() ?>
<? startblock('page-title') ?>
    DID Import Process <?//= isset($pricelistid)?$this->common->get_field_name('name', 'pricelists',$pricelistid):"";?><? //= $page_title ?><br/>
<? endblock() ?>
<? startblock('content') ?>  
<?php if(!isset($csv_tmp_data)){ ?>

<section class="slice color-three padding-t-20">
	<div class="w-section inverse no-padding">
    	<div class="container">
        	<div class="row">
        	<form method="post" action="<?= base_url()?>did/did_priview_file/" enctype="multipart/form-data" id="did_rates">
              <div class="col-md-12">
            	<div class="w-box">
            	 <span  style="margin-left:10px; text-align: center;background-color: none;color:#DD191D;">
                    <? if(isset($error) && !empty($error)) {
                        echo $error;
                    }?>
                 </span>
                   <h3 class="padding-t-10 padding-l-16">File must be in the following format(.csv):</h3>
            <p>DID,Account,Call Type,Destination,Country,Increments,Cost,Setup Fee,Monthly Fee,Included Seconds.</p>
                 </div>
               </div>
               <div class="col-md-12  no-padding">
               	  <div class="col-md-6">
                     <div class="w-box">
                       <h3 class="padding-t-10 padding-l-16 padding-b-10">Import DIDs:</h3>
                           <div class="col-md-12 no-padding">
                               <label class="col-md-3">Provider:</label>
                               <div>
                               <? $provider_id = form_dropdown('provider_id', $this->db_model->build_concat_select_dropdown("id,first_name,number", " accounts", "where_arr", array("type" => "3","status"=>"0","deleted" => "0")), '');
                            echo $provider_id;
                              ?> </div>
                           </div>
                           <div class="col-md-12 no-padding" >
                            <input type="hidden" name="mode" value="Import DID" />
                            <input type="hidden" name="logintype" value="<?= $this->session->userdata('logintype') ?>" />
                            <input type="hidden" name="username" value="<?= $this->session->userdata('username') ?>" />
                            <label class="col-md-3">Select the file:</label>
                            <div class="col-md-5" ><span class="no-padding form-control"  style="margin-left:-15px;overflow-x:hidden;width:260px;">
				<input  class="text field large" type="file" name="didimport"  size="80" id="didimport" style="height:33px;"/></div></span>
                           </div>
                           <label class="col-md-3">Check Header:</label>
                                <div class="col-md-1"><input type='checkbox' name='check_header'/></div>
                     </div>
                   </div>
                   <div class="col-md-6">
                     <div class="w-box padding-b-10">
                       
                       <div class="col-md-12 padding-t-20">
                               <label class="col-md-4" style="font-size:14px;text-transform:none !important;">Download sample file:</label>
                               <div><a href="<?= base_url(); ?>did/did_download_sample_file/did_sample" class="btn btn-success">Click Here</a></div>
                           </div>
                    
                     </div>
                   </div>
               </div>
               <div class="col-md-12 padding-b-10">
                   <div class="pull-right">
			  <input class="btn btn-line-parrot" id="impoddrt_termination1" type="submit" name="action" value="Import" />
                        <a href="<?= base_url().'did/did_list/'?>"><input class="btn btn-line-sky margin-x-10" id="ok" type="button" name="action" value="Cancel"/></a>
                                        
                   </div>
               </div></form>
            </div>
        </div>
    </div>
</section>

<?}?>    
        
<?php
    if(isset($csv_tmp_data) && !empty($csv_tmp_data)){ ?>
 <section class="slice color-three">
	<div class="w-section inverse no-padding">
           <div class="container">
	<div class="row">
             
        <div class="col-md-12">        
            <form id="import_form" name="import_form" action="<?=base_url()?>did/did_import_file/<?= $provider_id?>/<?=$check_header;?>/" method="POST">
            <table width="100%" border="1"  class="details_table">
                <?  $cnt =0;
                    foreach($csv_tmp_data as $csv_key => $csv_value){
                        if($csv_key <  15){
                            echo "<tr>";
                            foreach($csv_value as $field_name => $field_val){
                                if($csv_key == 0){
                                    echo "<th>".ucfirst($field_name)."</th>";
                                }else{
                                    echo "<td class='portlet-content'>".$field_val."</td>";   
                                }
                            }
                            echo "</tr>";
                        }
                    }
                    
                    echo "<tr><td colspan='".$cnt."'>
                        <a href='".base_url()."did/did_import/'><input type='button' class='btn btn-line-sky pull-right  margin-x-10'  value='Back'/></a>
                        <input type='submit' class='btn btn-line-parrot pull-right' id='Process' value='Process'/></td></tr>";
        ?> </table></form>  
        </div>
</div></div></div>
    </section>    
    <?} ?>
<? endblock() ?>	
<? end_extend() ?>   
