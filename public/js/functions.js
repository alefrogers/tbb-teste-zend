
function isDate(txtDate) {
    var now = new Date;
    var currVal = txtDate.split('/');

    if (currVal == '')
        return false;


    //Checks for mm/dd/yyyy format.
    dtDay = currVal[0];
    dtMonth = currVal[1];
    dtYear = currVal[2];

    if (dtMonth < 1 || dtMonth > 12)
        return false;
    else if (dtDay < 1 || dtDay > 31)
        return false;
    else if ((dtMonth == 4 || dtMonth == 6 || dtMonth == 9 || dtMonth == 11) && dtDay == 31)
        return false;
    else if (dtMonth == 2)
    {
        var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
        if (dtDay > 29 || (dtDay == 29 && !isleap))
            return false;
    }


    if (now.getFullYear() <= dtYear) {
        if ((now.getMonth() + 1) == dtMonth && now.getDate() < dtDay || (now.getMonth() + 1) < dtMonth || now.getFullYear() < dtYear) {
            return false;
        }
    }


    return true;
}


function newRow() {
    var html = '<div class="row item">\n\
                    <div class="col-md-2 val-div">\n\
                        <label>Aplicação</label>\n\
                        <div class="input-group-md">\n\
                            <input class="val_application form-control money" type="text">\n\
                        </div>\n\
                        <span class="help-block val-help"></span>\n\
                    </div>\n\
                    <div class="col-md-2 date-div">\n\
                        <label>Data</label>\n\
                        <div class="input-group-md">\n\
                            <input class="date_application form-control date" type="text">\n\
                        </div>\n\
                        <span class="help-block date-help"></span>\n\
                    </div>\n\
                </div>';

    $('.aplications-group').append(html);
    $('.money').mask('000.000.000.000.000,00', {reverse: true});
    $('.date').mask('00/00/0000');
}

function saveSimulation() {
    var items = [];
    var id_aux, val, date;
    var success = true;

    $('.aplications-group .help-block').html('');
    $('.aplications-group .has-error').removeClass('has-error');

    $('.aplications-group .item').each(function () {
        val = $(this).find('.val_application').val();
        date = $(this).find('.date_application').val();
        id_aux = null;


        if ($(this).find('.id-application').val() > 0) {
            id_aux = $(this).find('.id-application').val();
        }

        if (val === '' || val <= 0) {
            $(this).find('.val-help').html('Valor inválido.');
            $(this).find('.val-div').addClass('has-error');
            success = false;
            return false;
        }

        if (date === '' || !isDate(date)) {
            $(this).find('.date-help').html('Data inválida.');
            $(this).find('.date-div').addClass('has-error');
            success = false;
            return false;
        }

        items.push({
            'id': id_aux,
            'val_application': val,
            'date_application': date
        });
    });

    if (success === true) {
        $('input[name="json_items"]').val(JSON.stringify(items));
        $('form').submit();
    }
}


function saveTypes() {
    var name = $('.name input').val();
    var profitability = $('.profitability input').val();
    var rate = $('.rate input').val();
    var application_days = $('.application_days input').val();

    var error = false;

    $('.has-error').removeClass('has-error');
    $('.help-block').html('');

    if (name.length < 4) {
        $('.name').addClass('has-error');
        $('.name .help-block').html('Campo nome inválido.');
        error = true;
    }


    if (profitability === '' || parseFloat(profitability) <= 0 || parseFloat(profitability) > 99) {
        var msg = 'Campo rentabilidade inválido.';
        if (parseFloat(profitability) > 99) {
            msg = 'Digite um valor menor que 100.';
        }
        $('.profitability').addClass('has-error');
        $('.profitability .help-block').html(msg);
        error = true;
    }

    if (rate === '' || parseFloat(rate) <= 0 || parseFloat(rate) > 99) {
        var msg = 'Campo taxa inválido.';
        
        if (parseFloat(rate) > 99) {            
            msg = 'Digite um valor menor que 100.';
        }
        
        $('.rate').addClass('has-error');
        $('.rate .help-block').html(msg);
        error = true;
    }

    if (application_days === '' || parseInt(application_days) <= 0) {
        $('.application_days').addClass('has-error');
        $('.application_days .help-block').html('Campo período de aplicação inválido.');
        error = true;
    }

    if (!error) {
        $('form').submit();
    }

}


$('document').ready(function () {
    $('.money').mask('000.000.000.000.000,00', {reverse: true});
    $('.date').mask('00/00/0000');
});