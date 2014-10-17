var $collectionHolder;

// setup an "add an exam" link
var $addSchoolClassLink = $('<a href="#" class="add_school_class_link">Add a school class</a>');
var $newLinkLi = $('<li></li>').append($addSchoolClassLink);

jQuery(document).ready(function() {
    // Get the ul that holds the collection of exams
    $collectionHolder = $('ul.schoolClasses');
    
    // add a delete link to all of the existing tag form li elements
    // $collectionHolder.find('li').each(function() {
        // addSchoolClassFormDeleteLink($(this));
    // });
    
    // add the "add an exam" anchor and li to the exams ul
    $collectionHolder.append($newLinkLi);
    


    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addSchoolClassLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see next code block)
        addSchoolClassForm($collectionHolder, $newLinkLi);
    });
    
    function addSchoolClassForm($collectionHolder, $newLinkLi) {
        // Get the data-prototype explained earlier
        var prototype = $collectionHolder.data('prototype');

        // get the new index
        var index = $collectionHolder.data('index');

        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        var newForm = prototype.replace(/__name__/g, index);

        // increase the index with one for the next item
        $collectionHolder.data('index', index + 1);

        // Display the form in the page in an li, before the "Add a tag" link li
        var $newFormLi = $('<li></li>').append(newForm);
        $newLinkLi.before($newFormLi);
        
        // add a delete link to the new form
        //addSchoolClassFormDeleteLink($newFormLi);
    }
    
    // function addSchoolClassFormDeleteLink($schoolClassFormLi) {
        // var $removeFormA = $('<a href="#">delete this tag</a>');
        // $schoolClassFormLi.append($removeFormA);

        // $removeFormA.on('click', function(e) {
            // // prevent the link from creating a "#" on the URL
            // e.preventDefault();

            // // remove the li for the tag form
            // $schoolClassFormLi.remove();
        // });
    // }
});