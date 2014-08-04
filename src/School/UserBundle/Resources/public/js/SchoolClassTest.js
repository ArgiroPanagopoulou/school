$(document).ready(function() {

    var $form = $('form')

    // Create 2 hidden inputs named as the parameters expected by
    // the dispatcher at admin/assign_students/selectedAction/
    
    var selected_students = $('#schoolClassTest_select').val();
    var $selected_students = $('<input/>')
        .attr('type', 'hidden')
        .attr('name', 'select')
        .val(selected_students);
    $selected_students.appendTo($form)
    
    var student_action = $('#schoolClassTest_studentAction').val();
    var $student_action = $('<input/>')
        .attr('type', 'hidden')
        .attr('name', 'studentAction')
        .val(student_action);
    $student_action.appendTo($form)
      
    var $schoolyear = $('#schoolClassTest_schoolYear');
     
    $schoolyear.on('change', function() {
  
        window.console.info('I hav changed to ' + $schoolyear.val())
  
        // ... retrieve the corresponding form.
        var $form = $schoolyear.closest('form');
        
        // Simulate form data, but only include the selected school-year value.
  
        var data = {};     
        data[$schoolyear.attr('name')] = $schoolyear.val();
        data['select'] = selected_students
        data['studentAction'] =  student_action;   

        window.console.info('About to send data: ' + JSON.stringify(data));            
             
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