var $collectionHolder;

// setup an "add a lecture" link
var $addLectureLink = $('<a href="#" class="add_lecture_link">Add a lecture</a>');
var $newLinkLi = $('<tr></tr>').append($addLectureLink);

jQuery(document).ready(function() {
    // Get the ul that holds the collection of lectures
    $collectionHolder = $('table.lectures');
    
    // add a delete link to all of the existing lecture form li elements
    $collectionHolder.find('tr').each(function() {
        addLectureFormDeleteLink($(this));
    });
    
    // add the "add a lecture" anchor and li to the lectures ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addLectureLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new lecture form (see next code block)
        addLectureForm($collectionHolder, $newLinkLi);       
         
    });
 
    
    function addLectureForm($collectionHolder, $newLinkLi) {
        // Get the data-prototype explained earlier
        var tpl = $collectionHolder.data('prototype');

        // get the new index
        var index = $collectionHolder.data('index');

        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        var newForm = tpl.replace(/__name__/g, index);

        // increase the index with one for the next item
        $collectionHolder.data('index', index + 1);

        // Display the form in the page in an li, before the "Add a lecture" link li
        var $newFormLi = $('<tr></tr>').append(newForm);
        $newLinkLi.before($newFormLi);
        
        // add a delete link to the new form
        addLectureFormDeleteLink($newFormLi);
    }
    
    function addLectureFormDeleteLink($table_row) {
        var $remove_link= $('<a />');
        $remove_link.attr('href', '#');
        $remove_link.text('delete');
        
        $table_row.find('.delete-link-wrapper').append($remove_link);

        $remove_link.on('click', function(e) {
            // prevent the link from creating a "#" on the URL
            e.preventDefault();

            // remove the li for the lecture form
            $table_row.remove();
        });
    }
});