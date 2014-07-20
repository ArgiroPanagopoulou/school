$(document).ready(function() {

    var $schoolyear = $('#schoolClassTest_schoolYear');

    $schoolyear.on('change', function() {
  
        window.console.info('I hav changed to ' + $schoolyear.val())
  
        // ... retrieve the corresponding form.
        var $form = $schoolyear.closest('form');
        
        // Simulate form data, but only include the selected school-year value.
  
        var data = {};
        
        data[$schoolyear.attr('name')] = $schoolyear.val();
      
        // Submit data via AJAX to the form's action path.
        $.ajax({
            url : $form.attr('action'),
            type: $form.attr('method'),
            data: data,
            success: function(html) {
                // Replace current school-class field ...
                window.console.info('Fetched response from ' + $form.attr('action'))
                $('#schoolClassTest_name').replaceWith(
                    // ... with the returned one from the AJAX response.
                    $(html).find('#schoolClassTest_name')
                );
          
            }
        });
      
    });

});