<?php
    $CI =& get_instance();
    $CI->load->model('Web_settings');
    $Web_settings = $CI->Web_settings->retrieve_setting_editdata();
?>
<footer class="main-footer">
    <strong>
    	<?php if (isset($Web_settings[0]['footer_text'])) { echo $Web_settings[0]['footer_text']; }?>
   	</strong><i class="fa fa-heart color-green"></i>
</footer>

<script>
    $( function() {
        $( ".datepicker" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            maxDate: "+20Y",
            minDate: "-100Y",
            yearRange: "-100:+20"
        });
    });
    
    
    function disableSubmitButton(button) {
        button.disabled = true;
    }

    // This function is called when the form is submitted.
    function onSubmitForm(event) {
        const form = event.target;
        const submitButton = form.querySelector('[type="submit"]');
        disableSubmitButton(submitButton);

        $('#DownloadGSTRIIBtn').removeAttr('disabled');
    }

    // Attach the onSubmitForm function to all forms on the page.
    document.addEventListener('submit', function(event) {
        const form = event.target;
        onSubmitForm(event);
    });

  </script>