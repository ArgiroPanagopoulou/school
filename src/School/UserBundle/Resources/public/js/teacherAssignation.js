$(document).ready(function() {

    var $schoolyear = $('#teacher_assignation_schoolyear');

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
                $('#teacher_assignation_courses').replaceWith(
                    // ... with the returned one from the AJAX response.
                    $(html).find('#teacher_assignation_courses')
                );
                $('#teacher_assignation_schoolClasses').replaceWith(
                    $(html).find('#teacher_assignation_schoolClasses')
                );
          
            }
        });
      
    });

});