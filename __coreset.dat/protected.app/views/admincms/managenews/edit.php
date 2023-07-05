<?php 
$attributes             = array("method"        => "post",
                                "name"          => "form_users",
                                "enctype"       => "multipart/form-data");
$unique_form            = array("unique_formid" => set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( $_directory . "controls/save" ), $attributes, $unique_form);
?>    

    <table class="table table_form">
        <tr>
          <td class="td_bg fieldKey">Name <?php echo required_field(); ?></td>
          <td class="td_bg fieldValue" colspan="2">
          <div class="input-group">
            <?php
            $specdata       = array("name"          => "name",
                                    "id"            => "name",
                                    "size"          => 50,
                                    "class"         => "form-control",
                                     "value"            => set_value("name", $name));   

            echo form_input($specdata);
            ?>
            </div>
            </td>
          </tr>
       <tr>
          <td class="td_bg fieldKey"> Date <?php  required_field(); ?></td>
              <td class="td_bg fieldValue" colspan="2">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-clock-o"></i>
                        </div>
                        
                        <?php
                        $specdata       = array("name"      => "date",
                                                "id"        => "date",
                                                "size"      => 45,
                                                "class"     => "form-control datepicker",
                                                "value"     => set_value("date", $date));  
                        
                        echo form_input($specdata);
                        ?>
                    </div>
                </div>
              </td>
          </tr>
           <!-- multiple -->
           <tr>
            <td class="td_bg">Upload File (.pdf)</td>
            <td class="td_bg">
                <div class="input-group">
                <input type="file" class="btn btn-default" name="file_pdf_news">
                <input type="hidden" value="<?php //echo set_value("pressrelease_pdf_one", $pressrelease_pdf);?>" name="files_news_pdf">  
               <?php if(isset($pdf)) foreach($pdf->result_array() as $row){?>
                <small> <a href="<?php echo site_url().$row['news_pdf'];?>"><?php echo $row['news_pdf'];?></a>
                <a class="label label-danger" data-pdfurl="<?php echo $row['news_pdf'];?>" href="javascript:;" onclick="remPdf(this);"> Remove Pdf</a>
                </small>
                <?php } ?>
                
                </div>

            </td>
          </tr>

           <tr>
            <td class="td_bg">Upload Files (.mp4|avi|mov)</td>
            <td class="td_bg">
                <div class="input-group">
                <input type="file" class="btn btn-default" name="file_video_news[]" multiple>
                <input type="hidden" value="<?php// echo set_value("pressrelease_pdf_one", $pressrelease_pdf);?>" name="files_news_video">  
               
               <?php  if(isset($videos)) foreach($videos->result_array() as $re){ ?> 
               <small>
               <a href="<?php echo site_url().$re['news_videos']; ?>"><?php echo $re['news_videos']; ?></a>
               <a class="label label-danger" href="javascript:;" data-videourl="<?php echo $re['news_videos']; ?>" onclick="remVideo(this);">Remove Video </a>
               </small>
               <?php } ?>
                </div>
            </td>
          </tr>

        <tr>
          <td class="td_bg">Short Description</td>
          <td class="td_bg">
          <div class="input-group">
            <?php
            $specdata       = array("name"          => "description",
                                    "id"            => "description",
                                    "rows"          => 10,
                                    "cols"          => 70,
                                    "class"         => "ckeditor1 form-control",
                                    "value"         => set_value("description", $description ) );   

            echo form_textarea($specdata);
            ?>
            </div>
        </td>
      </tr>

    <tr>
            <td class="td_bg">&nbsp;</td>
            <td class="td_bg" colspan="2">
                <input type="hidden" value="<?php echo set_value("id", $id);?>" name="hdn_id" />
            </td>
        </tr>
        
        
  </table>
<input type="hidden" name="id" value="<?php echo set_value('id', $id); ?>" />
  <input type="hidden" name="options" value="<?php echo set_value('options', $options); ?>" />
    
    <div class="crud_controls">
  <button type="submit" data-operationid="managenewssave" class="btn btn-warning btn-flat"><?php echo lang_line("text_save");?></button>
        <a class="btn btn-danger btn-flat" data-operationid="managenewsview" href="<?php echo site_url( $_directory . "controls/view");?>">
            <?php echo lang_line("text_cancel");?>
        </a>
    </div>

</form>

<script>
$("form[name='form_users'] input[type='text']").attr("disabled", false);
$("form[name='form_users'] select").attr("disabled", false);
</script>