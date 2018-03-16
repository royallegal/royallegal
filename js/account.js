function accounts(tables) {
    toggleForm(tables);
}


function toggleForm(tables) {
    $('.trigger').click(function(e) {
        var action = $(this).attr('data-action');
        var name = $(this).attr('name');
        var tags = $('.tags.section');

        if (action == 'form-trigger') {
            if ($(this).val() == "Delete" || $(this).val() == "Clear") {
                deleteEntry();
            }
            else {
                showForm($(this), tables[name], tags);
            }
        }

        // Hide form
        if (action == 'back') {
            hideForm(tags);
        }
    });
}


function deleteEntry() {
    if (!confirm('Are you sure?')) {
        e.preventDefault();
        return false;
    }
    return true;
}

function showForm(elem, tables, tags) {
    var name = $(elem).attr('name');
    var form = $('form[name='+name+']');
    var save = $('form[name='+name+']').find('input[value="Save"]');
    var id   = $(elem).attr('data-id');

    // Toggles form / tag visibility
    form.removeClass('hidden');
    tags.addClass('hidden');

    // Populates form data when necessary (ie when updating)
    if ($(elem).attr('data-id')) {
        populateForm(id, form, tables);
    }
    else {
        form[0].reset();
    }

    //alert(id);

    // Sets form method
    if (elem.val() == 'Edit') {
        $('[name=data-id]').val(id);
        $(save).attr('name', 'update_' + name).attr('data-id', id);
    }
    else {
        $(save).attr('name', 'add_' + name);
    }
}


function hideForm(tags) {
    $('form:not([name="delete"])').addClass('hidden');
    tags.removeClass('hidden');
}


function populateForm(id, form, tables) {
    var rows = $(form).find('.gray.row');
    var keys = Object.keys(tables[0]);
    var values;

    tables.forEach(function(table,i) {
        if (table['id'] == id) {
            values = table;
        }
    });

    // Matches table columns (keys) with HTML fields (rows)
    $(keys).each(function(k,key) {
        $(rows).each(function(r,row) {
            if (key == $(row).attr('id')) {
                // Get each field by column name
                var input = $(row).find('[name='+key+']');

                // Choose the correct <select> option
                if (input.is('select') && input.attr('name') == key) {
                    var options = $(input).find('option:not(.placeholder)');
                    populateSelect(values, key, options);
                }

                // Choose the correct radio button
                else if (input.attr('type') == 'radio') {
                    populateRadio(values, key, input);
                }

                // Choose the correct checkbox button
                else if (input.attr('type') == 'checkbox') {
                    populateCheckbox(values, key, input);
                }

                // Add the correct birthday
                else if ($(row).attr('id') == 'birthday') {
                    populateBirthday(values, key, row);
                }

                // Add the correct address
                else if ($(row).attr('id') == 'address') {
                    $('.ship-address').each(function(i,field) {
                        $(field).val(values[$(field).attr('name')]);
                    });
                }

                // Enter text
                else {
                    input.val(values[key]);
                }

                var input2 = $(row).find('.check-group');
                if (input2.attr('type') == 'checkbox') {
                    populateCheckbox(values, key, input2);
                }

            }

            // Add the correct names
            else if (key == 'first_name' || key == 'last_name') {
                if ($(row).attr('id') == 'full_name'){
                    $(row).find('[name='+key+']').val(values[key]);
                }
            }

            // Add input values for "other" fields
            else if (key == 'protection_txt' || key == 'investment_txt') {
                var input = $(row).find('[name='+key+']');
                if (key == $(input).attr('name')) {
                    $(input).val(values[key]);
                }
            }
        });
    });
}


function populateSelect(values, key, options) {
    $(options).each(function(i,option) {
        if ($(option).val() == values[key]) {
            $(option).prop('selected',true);
        }
    });
}


function populateRadio(values, key, input) {
    $(input).each(function(i,radio) {
        if ($(radio).val() == values[key]) {
            $(radio).prop('checked',true);
        }
    });
}


function populateCheckbox(values, key, input) {
    var array = (values[key]).split(',');
    $(input).each(function(i,check) {
        $(array).each(function(a,val) {
            if ($(check).val() == val) {
                $(check).prop('checked',true);
            }
        })
    });
}


function populateBirthday(values, key, row) {
    var dob = values[key].split(/\s*\-\s*/g).reverse();
    var fields = $(row).find('input');
    $(fields).each(function(i,field) {
        $(field).val(dob[i]);
    });
}
