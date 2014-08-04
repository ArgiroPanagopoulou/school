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
    
    var data = {};     
        data['select'] = selected_students
        data['studentAction'] =  student_action;  

});