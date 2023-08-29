"use strict";

// Class definition
var KTSigninGeneral = function() {
    // Elements
    var form;
    var submitButton;
    var validator;

    // Handle form
    var handleValidation = function(e) {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validator = FormValidation.formValidation(
			form,
			{
				fields: {					
					'email': {
                        validators: {
                            regexp: {
                                regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                                message: 'The value is not a valid email address',
                            },
							notEmpty: {
								message: 'Email address is required'
							}
						}
					},
                    'password': {
                        validators: {
                            notEmpty: {
                                message: 'The password is required'
                            }
                        }
                    },

                    'firstname': {
                        validators: {
                            notEmpty: {
                                message: 'Your firstname is required'
                            }
                        }
                    },
                'lastname': {
                        validators: {
                            notEmpty: {
                                message: 'Your lastname is required'
                            }
                        }
                    },
                'phone': {
                        validators: {
                            regexp: {
                                regexp: /^(?:(?:\+|0{0,2})91(\s*[\-]\s*)?|[0]?)?[789]\d{9}$/,
                                message: 'The value is not a valid phone number',
                            },
                            notEmpty: {
                                message: 'Phone number is required'
                            }
                        }
                    } 
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.possible-error-indicator',
                        eleInvalidClass: '',  // comment to enable invalid state icons
                        eleValidClass: '' // comment to enable valid state icons
                    })
				}
			}
		);	
    }





    // Public functions
    return {
        // Initialization
        init: function() {
            form = document.querySelector('#app_hosting_account_creation_form');
            submitButton = document.querySelector('#ap_create_an_account_btn');
            handleValidation();
           
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTSigninGeneral.init();
});
