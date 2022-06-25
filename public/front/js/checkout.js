// window.intlTelInputGlobals.loadUtils("uyuytujyuytrftghjnm,mnhbghnjmknbvcxutils.js");

var mobile = document.querySelector("#shipping_phone"),
    errorMsg = document.querySelector("#error-msg"),
    validMsg = document.querySelector("#valid-msg");
// errorMsgH = document.querySelector("#error-msgh"),
// validMsgH = document.querySelector("#valid-msgh"),
// errorMsgO = document.querySelector("#error-msgo"),
// validMsgO = document.querySelector("#valid-msgo"),
// homePhone = document.querySelector("#home_phone"),
// officePhone = document.querySelector("#office_phone");

// here, the index maps to the error code returned from getValidationError - see readme
var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

// initialise plugin
iti = window.intlTelInput(mobile, {
    initialCountry: 'us',
    nummberType: 'mobile',
    preferredCountries: ["us"],
    separateDialCode: true
});

// itih = window.intlTelInput(homePhone, {
//   initialCountry: 'pk',
//   placeholderNumberType: 'FIXED_LINE',
//   preferredCountries: ["pk"],
//   separateDialCode: true
// });

// itio = window.intlTelInput(officePhone, {
//   initialCountry: 'pk',
//   placeholderNumberType: 'FIXED_LINE',
//   preferredCountries: ["pk"],
//   separateDialCode: true
// });

var reset = function () {
    mobile.classList.remove("error");
    // homePhone.classList.remove("error");
    // officePhone.classList.remove("error");
    errorMsg.innerHTML = "Error";
    errorMsg.classList.add("hide");
    validMsg.classList.add("hide");
    // errorMsgH.innerHTML = "Error";
    // errorMsgH.classList.add("hide");
    // validMsgH.classList.add("hide");
    // errorMsgO.innerHTML = "Error";
    // errorMsgO.classList.add("hide");
    // validMsgO.classList.add("hide");
};

// on blur: validate
mobile.addEventListener('blur', function () {
    getOnBlur(mobile, iti, validMsg, errorMsg);
});

// homePhone.addEventListener('blur', function () {
//     getOnBlur(homePhone, itih , validMsgH , errorMsgH);
// });

// officePhone.addEventListener('blur', function () {
//     getOnBlur(officePhone, itio , validMsgO , errorMsgO);
// });

function getOnBlur(obj, iniObj, validObj, errorObj) {
    reset();
    if (obj.value.trim()) {
        if (iniObj.isValidNumber()) {
            validObj.classList.remove("hide");
        } else {
            obj.classList.add("error");
            var errorCode = iniObj.getValidationError();
            errorObj.innerHTML = errorMap[errorCode];
            errorObj.classList.remove("hide");
        }
    }
}
// on keyup / change flag: reset
mobile.addEventListener('change', reset);
mobile.addEventListener('keyup', reset);
// homePhone.addEventListener('change', reset);
// homePhone.addEventListener('keyup', reset);
// officePhone.addEventListener('change', reset);
// officePhone.addEventListener('keyup', reset);

$(function () {
    $("#shipping_state").select2();
    getZipCodeTax($('#shipping_postcode'));
    $('#shipping_state').change(function () {
        getZipCodeTax($('#shipping_postcode'));
    });
});

function getZipCodeTax(obj) {
    // event.preventDefault();
    zip_value = $(obj).val();
    var data = {};
    if (zip_value.length >= 3 && zip_value.length <= 5 && $('#shipping_state').val() != '') {
        data.zip_code = $(obj).val();
        data.shipping_state = $('#shipping_state').val();
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: base_url + "/get-tax",
            method: "POST",
            data: data,
            success: function (res) {
                var result = JSON.parse(res);

                if (result.status == 200) {
                    $('.cart_total_value').html(result.cart_total_tax);
                    $('#taxt_value').html('$' + result.tax);
                    $('#taxt_value_hidden').val(result.tax);
                    $('#shipping_value').html('$' + result.shipping);
                } else if (result.status == 404) {
                    $('#taxt_value').html(result.error);
                    $('#shipping_value').html('Pleaser enter correct zip code');
                }

            }
        });
    } else {
        $('#taxt_value').html('Need Correct Zip Code & Select the Regin or State');
    }

}

// $(function () {



//     paypal.Buttons({
//         createOrder: function (data, actions) {
//             // This function sets up the details of the transaction, including the amount and line item details.
//             return actions.order.create({
//                 redirect_urls: {
//                     return_url: "https://example.com/return",
//                     cancel_url: "https://example.com/cancel"
//                 },
//                 purchase_units: [{
//                     amount: {
//                         value: '2.0'
//                     }
//                 }]
//             });
//         },
//         onApprove: function (data, actions) {
//             // This function captures the funds from the transaction.
//             return actions.order.capture().then(function (details) {
//                 // This function shows a transaction success message to your buyer.
//                 // alert('Transaction completed by ' + details.payer.name.given_name);
//             });
//         },
//         style: {
//             label: 'checkout',
//             tagline: false
//         },
//         funding: {
//             paylater: false
//         }
//     }).render('#paypal-button-container');

// })
