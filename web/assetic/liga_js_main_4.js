function startSelectMultiples() {
    $('.js-select-multiple-liga').select2({
        placeholder: "Selecciona un jugador",
        allowClear: true,
        debug: true
    });
}

function checkPhoneNumber(element) {
    var tagPhone = element;
    var phoneValue = tagPhone.val();
    phoneValue = phoneValue.replace(/[^\d\-]/g, '').replace(/--/g, '-');
    tagPhone.val(phoneValue);

    var validPositions = [3, 6, 9];
    var limitLength = 12;
    var badLetter = true;

    while (badLetter) {
        var letters = phoneValue.split('');
        badLetter = false;
        if (phoneValue.length) {
            $.each(letters, function (index, letter) {
                if (!badLetter && letter == '-' && $.inArray(index, validPositions) === -1) {
                    if (index + 1 === phoneValue.length) {
                        phoneValue = phoneValue.slice(0, index);
                    }
                    else {
                        phoneValue = phoneValue.slice(0, index) + phoneValue.slice(index + 1, phoneValue.length);
                    }

                    badLetter = true;
                }
            });
        }
    }

    tagPhone.val(phoneValue);

    if ($.inArray(phoneValue.length, validPositions) !== -1) {
        phoneValue = phoneValue + '-';
    }

    tagPhone.val(phoneValue);

    if (phoneValue.length > limitLength) {
        phoneValue = phoneValue.slice(0, phoneValue.length - 1);
        tagPhone.val(phoneValue);
    }
}

function startPhoneValidation() {

    $(document).on('keypress', '.js-validate-phone' , function(){
        var key = event.keyCode || event.charCode;
        if(key === 8 ) {
            return;
        }

        checkPhoneNumber($(this));
    });

    $(document).on('keyup', '.js-validate-phone' , function(){
        var key = event.keyCode || event.charCode;
        if(key === 8 ) {
            return;
        }

        checkPhoneNumber($(this));
    });

    $(document).on('keydown', '.js-validate-phone' , function(){
        var key = event.keyCode || event.charCode;
        if(key === 8 ) {
            return;
        }

        checkPhoneNumber($(this));
    });
}



