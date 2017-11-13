$(function() {
    // NOTE: $.tablesorter.theme.bootstrap is ALREADY INCLUDED in the jquery.tablesorter.widgets.js
    // file; it is included here to show how you can modify the default classes
    $.tablesorter.themes.bootstrap = {
        // these classes are added to the table. To see other table classes available,
        // look here: http://getbootstrap.com/css/#tables
        table        : 'table table-bordered table-striped',
        caption      : 'caption',
        // header class names
        header       : 'bootstrap-header', // give the header a gradient background (theme.bootstrap_2.css)
        sortNone     : '',
        sortAsc      : '',
        sortDesc     : '',
        active       : '', // applied when column is sorted
        hover        : '', // custom css required - a defined bootstrap style may not override other classes
        // icon class names
        icons        : '', // add "bootstrap-icon-white" to make them white; this icon class is added to the <i> in the header
        iconSortNone : 'bootstrap-icon-unsorted', // class name added to icon when column is not sorted
        iconSortAsc  : 'glyphicon glyphicon-chevron-up', // class name added to icon when column has ascending sort
        iconSortDesc : 'glyphicon glyphicon-chevron-down', // class name added to icon when column has descending sort
        filterRow    : '', // filter row class; use widgetOptions.filter_cssFilter for the input/select element
        footerRow    : '',
        footerCells  : '',
        even         : '', // even row zebra striping
        odd          : ''  // odd row zebra striping
    };

    $('tr:not(:has(th))').each(function(index, linha) {
        $(linha).on('click', function() {
            window.location.href = $(linha).find('td a').attr('href');
        });
    });

    $('.tablesorter').tablesorter({
        theme : "bootstrap",
        widgets : [ "uitheme", "filter", "zebra", "column" ],
        headerTemplate : '{content} {icon}',
        widgetOptions : {
            zebra : ["even", "odd"],
            columns: [ "primary", "secondary", "tertiary" ],
            // filter_anyMatch replaced! Instead use the filter_external option
            // Set to use a jQuery selector (or jQuery object) pointing to the
            // external filter (column specific or any match)
            filter_external : '.search',
            // add a default type search to the first name column
            filter_defaultFilter: { 1 : '~{query}' },
            // include column filters
            filter_columnFilters: true,
            filter_placeholder: { search : 'Procurar ...' },
            filter_saveFilters : true,
            filter_reset: '.reset',
            filter_cssFilter: "form-control",
        }
    });
});