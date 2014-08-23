var $collectionHolder;

// setup an "add an exam" link
var $addQuestionLink = $('<a href="#" class="add_question_link">Add a Question</a>');
var $newLinkLi = $('<li></li>').append($addQuestionLink);

jQuery(document).ready(function() {
    // Get the ul that holds the collection of exams
    $collectionHolder = $('ol.questions');
    
    // add a delete link to all of the existing tag form li elements
    $collectionHolder.find('li').each(function() {
        addQuestionFormDeleteLink($(this));
    });
    
    // add the "add an exam" anchor and li to the exams ul
    $collectionHolder.append($newLinkLi);
    


    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addQuestionLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see next code block)
        addQuestionForm($collectionHolder, $newLinkLi);
    });
    
    function addQuestionForm($collectionHolder, $newLinkLi) {
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
        addQuestionFormDeleteLink($newFormLi);
    }
    
    function addQuestionFormDeleteLink($questionFormLi) {
        var $removeFormA = $('<a />');

        $removeFormA.attr('href', '#');
        $removeFormA.text('delete this question');
        
        $questionFormLi.find('.delete-link-wrapper').append($removeFormA);
        
        $removeFormA.on('click', function(e) {
            // prevent the link from creating a "#" on the URL
            e.preventDefault();

            // remove the li for the tag form
            $questionFormLi.remove();
        });
    }
});