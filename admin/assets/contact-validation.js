var FormValidation = function () {

    var handleValidation1 = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form1 = $('#contactForm');
            var error1 = $('.alert-error', form1);
            var success1 = $('.alert-success', form1);

            form1.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-inline', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                rules: {

                    fname: {
                        minlength: 2,
                        required: true
                    },
                    lname: {
                        minlength: 2,
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },

                    number: {
                        required: true,
                        minlength: 8,
                        number: true
                    },
                    address: {
                        required: true,
                         minlength: 2,
                    },
                    state: {
                        required: true,
                         minlength: 2,
                    },
                    city: {
                        required: true,
                         minlength: 2,
                    },
                     zip: {
                        required: true,
                         minlength: 4,
                        number: true
                    }
                
                },

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success1.hide();
                    error1.show();
                    FormValidation.scrollTo(error1, -200);
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.help-inline').removeClass('ok'); // display OK icon
                    $(element)
                        .closest('.control-group').removeClass('success').addClass('error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.control-group').removeClass('error'); // set error class to the control group
                },

                success: function (label) {
                    label
                    .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
                    
                   .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
                },

                submitHandler: function (form) {
                    form.submit();
                }
            });
    }

    return {
        //main function to initiate the module
        init: function () {
            alert("hiiii");
            handleValidation1();

        },

	// wrapper function to scroll to an element
        scrollTo: function (el, offeset) {
            pos = el ? el.offset().top : 0;
            jQuery('html,body').animate({
                    scrollTop: pos + (offeset ? offeset : 0)
                }, 'slow');
        }

    };

}();