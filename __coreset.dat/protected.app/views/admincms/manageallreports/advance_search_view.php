
<div class="row">
    <div class="col-sm-3">
      <form method="POST" action="<?php echo site_url( $_directory . 'controls/Advance_search_filter' ); ?>" class="bulk-receipt-download-form">
        <div class="bulk-date-field">
          <label>From Date</label>
          <input type="date" name="bulk_receipt_from_date" class="form-control">
        </div>
        <br>
        <div class="bulk-date-field">
          <label>To Date</label>
          <input type="date" name="bulk_receipt_to_date" class="form-control">
        </div>
      </form>
    </div>
<div class="col-sm-9" style="margin-top: -1px;">
   <form method="POST" action="<?php echo site_url( $_directory . 'controls/Advance_search_filter' ); ?>" class="bulk-receipt-download-form">
  <div class="form-group">
    <div class="row">
      <div class="col-md-6 values">
        <label for="values">Values</label>
        <select name="search_category[]" class="form-control" style="width: 70%;margin-left: -16px;">
          <option value="">Select an option</option>
          <?php 
          $options = $categories['select_options'];

          // echo "<pre>";
          // print_r($categories);

          // die;
          foreach ($options as $value => $name) {
            echo '<option value="' . $value . '">' . $name . '</option>';
          }
          ?>
        </select>
        <div class="invalid-feedback1" style="display: none;">Please select an option.</div>
      </div>
      <div class="col-md-6 parameter">
        <label for="values">Search Parameter</label>
        <input type="text" name="search_value[]" style="margin-left: -158px;width: 531px;" class="form-control" placeholder="Search">
        <div class="input-group-append" style="float: left;width: 514px;">
          <button style="float: right;margin-right: 96px;margin-top: -35px;" class="btn btn-primary add-row-btn" type="button"><i class="fa fa-plus"></i></button>
        </div>
        <div class="invalid-feedback" style="display: none;">This field is required.</div>
      </div>
    </div>
  </div>
  <button class="btn btn-primary" style="float: right;width: 130px;" onclick="validateFields()">Apply</button>
  </div>
  <?php
  if ( count($table_record) > 0 )
  {
    echo $this->load->view( "admincms/manageallreports/include_advance_search_table");
  }
  else
  {
      
  }
?>
  </form>


<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script>
  $(document).ready(function() {
    // Add Row Button Click Event
    $(document).on('click', '.add-row-btn', function() {
      var newRow = $('<div class="row">' +
        '<div class="col-md-6 values">' +
        '<label for="values">Values</label>' +
        '<select class="form-control" name="search_category[]" style="width: 70%;margin-left: -16px;">' +
        '<?php 
          $options = $categories['tr_heading'];
          echo '<option value="">Select an option</option>';
           $options = $categories['select_options'];
          foreach ($options as $value => $name) {
            echo '<option value="' . $value . '">' . $name . '</option>';
          }
        ?>' +
        '</select>' +
        '<div class="invalid-feedback1" style="display: none;">Please select an option.</div>' +
        '</div>' +
        '<div class="col-md-6 parameter">' +
        '<label for="values">Search Parameter</label>' +
        '<div class="input-group" style="width: 78%;">' +
        '<input type="text" class="form-control" name="search_value[]" placeholder="Search" style="margin-left: -158px;width: 531px;">' +
        '<div class="input-group-append" style="float: left;width: 514px;">' +
        '<button style="float: right;margin-right: 97px;margin-top: -35px;" class="btn btn-primary add-row-btn" type="button"><i class="fa fa-plus"></i></button>' +
        '</div>' +
        '</div>' +
        '<div class="invalid-feedback" style="display: none;">This field is required.</div>' +
        '</div>' +
        '</div>');

      // Change plus icon to minus icon for the previous "Add Row" button
      $('.add-row-btn:last').html('<i class="fa fa-minus"></i>');
      $(this).attr('class','btn btn-primary remove-row-btn')

      // Append the new row
      $(this).closest('.row').parent().append(newRow);

      // Add a margin to the new row
      $('.row:last').css('margin-top', '17px');

      // Update the "Add Row" button to plus icon
      $('.add-row-btn:last').html('<i class="fa fa-plus"></i>');
    });

    // Remove Row Button Click Event
    $(document).on('click', '.remove-row-btn', function() {
      $(this).closest('.row').remove();
    });
  });

  function validateFields() {
    var rows = $('.row');
    var formData = [];
    var isValid = true;

    rows.each(function() {
      var row = $(this);
      var selectField = row.find('select');
      var inputField = row.find('input');
      var selectValue = selectField.val();
      var inputValue = inputField.val();

      if (selectValue === '') {
        isValid = false;
        selectField.addClass('is-invalid');
        row.find('.invalid-feedback1').show();
      } else {
        selectField.removeClass('is-invalid');
        row.find('.invalid-feedback1').hide();
        isValid = true;
        
      }

      if (inputValue === '') {
        isValid = false;
        inputField.addClass('is-invalid');
        row.find('.invalid-feedback').show();
      } else {
        inputField.removeClass('is-invalid');
        row.find('.invalid-feedback').hide();
        isValid = true;
      }

    });

    // if (isValid && formData.length > 0) {
    //   // Send the formData array to the controller via AJAX
    
    // } else {
    //   // Display an error message or take appropriate action
    //   console.log('Some fields are empty or not selected. Please fill in all the required fields.');
    // }
  }
</script>