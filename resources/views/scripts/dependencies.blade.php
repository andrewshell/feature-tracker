<script type="text/javascript">
    var path = "{{ route('tasks.autocomplete') }}";
    var $dependency = jQuery('#dependency');
    var $add_dependency = jQuery('#add-dependency');
    $dependency.typeahead({
        source: function (query, process) {
            return jQuery.get(path, { query: query }, function (data) {
                return process(data);
            });
        }
    });
    $dependency.blur(function() {
        var current = $dependency.typeahead("getActive");

        if (!current) {
            $dependency.val('');
        }
    });
    function removeDependency() {
        jQuery(this).parent().remove();
        return false;
    }
    $add_dependency.click(function() {
        var current = $dependency.typeahead("getActive");

        if (current) {
            var id = 'dependency-' + current.id;

            jQuery('#' + id).remove();

            jQuery('<li>').attr({
                id: id,
                class: 'dependency'
            }).appendTo('#dependencies');

            jQuery('<input>').attr({
                type: 'hidden',
                name: 'depends_on[' + current.id + ']',
                value: current.id
            }).appendTo('#' + id);

            jQuery('<button>').attr({
                class: 'btn btn-link'
            }).append(
                jQuery('<span>').attr({
                    class: 'glyphicon glyphicon-remove'
                })
            ).click(removeDependency).appendTo('#' + id);

            jQuery('<span>').text(current.name).appendTo('#' + id);
        }

        jQuery('#dependency').val('');

        return false;
    });
    jQuery('.dependency button').click(removeDependency);
</script>
