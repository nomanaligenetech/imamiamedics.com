<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( $_directory . "controls/save" ), $attributes, $unique_form);
?>  
<?php if ( isset($csv_ajax_data) ){


   $file_count = $csv_ajax_data['file_count'];
   $output_file = $csv_ajax_data['output_file'];
   $user_relations = $csv_ajax_data['user_relations'];
   $documents_data = $csv_ajax_data['documents_data'];
   $incomes_data = $csv_ajax_data['incomes_data'];
   $TMP_csv_memberdata_WITH_IMI = $csv_ajax_data['TMP_csv_memberdata_WITH_IMI'];
   $IMI_FAMILY_ONLY_MEMBERS = $csv_ajax_data['IMI_FAMILY_ONLY_MEMBERS'];

   ?>
   <style>
    .progress-wrap{
        height: 20px;
        width: 800px;
        position: relative;
    }
    progress {
        text-align: center;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        height: 100%;
        width: 600px;
        float: right;
    }
    progress#members-progress[value]::-webkit-progress-bar,
    progress#members-progress[value] {
        background: #eee;
    }
    progress + span {
        position: absolute;
        display: block;
        margin:auto;
        top: 0;
        color: #007f00;
        left: calc(100% - 640px);
    }
   </style>
<div class="progress-wrap" data-started=""> <b>Import Progress:</b> <progress id="members-progress" value="0" max="<?php echo $file_count;?>"></progress><span id="progress-value">0%</span></div>
<?php }?>

	<table class="table table_form">

          <tr>
            <td class="td_bg">Upload Member Data (.csv)</td>
            <td class="td_bg">
                <div class="input-group">
                <input type="file" class="btn btn-default" name="file_csv_memberdata"/>
                <input type="hidden" value="<?php echo set_value("csv_memberdata", $csv_memberdata);?>" name="csv_memberdata" />  
                <small><?php echo image_link("csv_memberdata", $csv_memberdata);?></small>
                </div>
            </td>
        </tr>
        
        
        
        <tr>
            <td class="td_bg">Upload Events Summary (.csv)</td>
            <td class="td_bg">
                <div class="input-group">
                <input type="file" class="btn btn-default" name="file_csv_eventssummary"/>
                <input type="hidden" value="<?php echo set_value("csv_eventssummary", $csv_eventssummary);?>" name="csv_eventssummary" />  
                <small><?php echo image_link("csv_eventssummary", $csv_eventssummary);?></small>
                </div>
            </td>
        </tr>
        
        
        <tr>
            <td class="td_bg">Upload Documents (.csv)</td>
            <td class="td_bg">
                <div class="input-group">
                <input type="file" class="btn btn-default" name="file_csv_documents"/>
                <input type="hidden" value="<?php echo set_value("csv_documents", $csv_documents);?>" name="csv_documents" />  
                <small><?php echo image_link("csv_documents", $csv_documents);?></small>
                </div>
            </td>
        </tr>
        
        
        <tr>
            <td class="td_bg">Upload Income (.csv)</td>
            <td class="td_bg">
                <div class="input-group">
                <input type="file" class="btn btn-default" name="file_csv_income"/>
                <input type="hidden" value="<?php echo set_value("csv_income", $csv_income);?>" name="csv_income" />  
                <small><?php echo image_link("csv_income", $csv_income);?></small>
                </div>
            </td>
        </tr>
      
		
  </table>
<input type="hidden" name="id" value="<?php echo set_value('id', $id); ?>" />
  <input type="hidden" name="options" value="<?php echo set_value('options', $options); ?>" />
    
    <div class="crud_controls">
        <button type="submit" data-operationid="csvmemberdatasave" class="btn btn-warning btn-flat"><?php echo lang_line("text_save");?></button>
        <a class="btn btn-danger btn-flat" href="<?php echo site_url( $_directory . "controls/view");?>">
            <?php echo lang_line("text_cancel");?>
        </a>
        
        <a class="btn btn-info btn-flat" data-operationid="csvmemberdatatruncate" href="<?php echo site_url( $_directory . "controls/truncate");?>">
            <?php echo "Truncate";?>
        </a>
    </div>

</form>

<?php 
if ( isset($csv_ajax_data) ){

   ?>
   <script>

    var file_count = '<?php echo $file_count ?>';
    var output_file = '<?php echo $output_file ?>';
    var user_relations = '<?php echo $user_relations ?>';
    var IMI_FAMILY_ONLY_MEMBERS = '<?php echo $IMI_FAMILY_ONLY_MEMBERS ?>';
    var documents_data = '<?php echo $documents_data ?>';
    var incomes_data = '<?php echo $incomes_data ?>';
    var TMP_csv_memberdata_WITH_IMI = '<?php echo $TMP_csv_memberdata_WITH_IMI ?>';

    var d = new Date();
    var full_d = 'H:'+d.getHours()+' M:'+d.getMinutes()+' S:'+d.getSeconds();
    $('.progress-wrap').attr('data-started',full_d);

    var promise1 = new Promise(function(resolve) {

        for(var a=1;a<=file_count;a++){
(()=>{
    var b = a;
            setTimeout(() => {

                var file = output_file+b+".csv";

                jQuery.ajax({
                    type: "POST",
                    url: '<?php echo site_url("admincms/csvmemberdata/controls/save"); ?>',
                    data: {file_path:file,documents_data:documents_data,incomes_data:incomes_data,TMP_csv_memberdata_WITH_IMI:TMP_csv_memberdata_WITH_IMI},
                    async: true,
                    success: function(html){
                    },
                    complete: function(xhr){
                        try{
                            var res = JSON.parse(xhr.responseText);
                            if (xhr.status == 200 && res.status == 'complete'){
                                $('#members-progress').val($('#members-progress').val()+1);
                                
                                normalizeProgressBars();

                                if ( parseInt(file_count) == $('#members-progress').val() ){
                                    resolve('Success!');
                                }

                            }
                        }
                        catch(e){
                            console.log(e.message);
                        }
                    }
                });
    

            }, b*3000);
})();
                
        }
    });

    promise1.then(function(value) {
        jQuery.ajax({
            type: "POST",
            url: '<?php echo site_url("admincms/csvmemberdata/controls/save"); ?>',
            data: {update_family_only_member:true,user_relations:user_relations,IMI_FAMILY_ONLY_MEMBERS:IMI_FAMILY_ONLY_MEMBERS,TMP_csv_memberdata_WITH_IMI:TMP_csv_memberdata_WITH_IMI},
            async: false,
            success: function(html){
            },
            complete: function(xhr){
                try{
                    var res = JSON.parse(xhr.responseText);
                    if (xhr.status == 200 && res.status == 'complete'){
                        $('#members-progress').val($('#members-progress').val()+1);
                        
                        normalizeProgressBars();
                        window.location.href = site_url+controller+'controls/view';
                    }
                }
                catch(e){
                    console.log(e.message);
                }
            }
        });
    });

    

    function normalizeProgressBars() {
        var progressBar = document.getElementById('members-progress');
        var span = document.getElementById('progress-value');
        var value = parseFloat(progressBar.value || 100, 10);
        var max = parseFloat(progressBar.max || 100, 10);
        var percent = Math.round(100 * value / max);
        span.innerText = percent + '%';

    }
    </script>
   
   <?php
}