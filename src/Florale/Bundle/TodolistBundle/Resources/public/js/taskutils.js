function addCollectionItem(container) {
    var _container = $('#'+container);
    var _prototype = _container.attr('data-prototype');
    var _row = _prototype.replace(/__name__/g, _container.find('tr:gt(0)').length);

    _container.append(_row);
    _container.find('tr:last select').select2();

    if (_container.find('tr:last').find('text').length > 0) {
        _container.find('tr:last textarea').autosize();
    }

    return false;
}

function removeCollectionRow(element, container) {
    $(element).closest('tr').remove();
    updateCollectionOrder(container);
}

function updateCollectionOrder(container) {
    var _container = $('#' + container);

    if (_container.find('tr').length > 1) {
        _container.find('tr:gt(0)').each(function(index) {
            $(this).find('input, select, textarea').each(function() {
                if ($(this).attr('name') !== undefined) {
                    _attr_name = $(this).attr('name').replace(/\]\[(\d+)/g, '][' + index);
                    $(this).attr('name', _attr_name);
                }
                if ($(this).attr('id') !== undefined) {
                    _attr_id = $(this).attr('id').replace(/_(\d+)/g, '_' + index);
                    $(this).attr('id', _attr_id);
                }
            });
        })
    }
}