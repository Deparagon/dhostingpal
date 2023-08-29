"use strict";

// Class definition
var KTCreateAccount = function () {
	// Elements
	var modal;	
	var modalEl;

	var stepper; 
	var form;
	var formSubmitButton;
	var formContinueButton;

	// Variables
	var stepperObj;
	var validations = [];

	// Private Functions
	var initStepper = function () {
		// Initialize Stepper
		stepperObj = new KTStepper(stepper);

		// Stepper change event
		stepperObj.on('kt.stepper.changed', function (stepper) {
			if (stepperObj.getCurrentStepIndex() === 4) {
				formSubmitButton.classList.remove('d-none');
				formSubmitButton.classList.add('d-inline-block');
				formContinueButton.classList.add('d-none');
				//call
				getShowPriceDetails();

			}
			 else if (stepperObj.getCurrentStepIndex() ===3) {
			 	 console.log('sorting the step three');
								showFormByDomainType();
				  // some function here 
				       
			}

			 else if (stepperObj.getCurrentStepIndex() === 5) {
				formSubmitButton.classList.add('d-none');
				formContinueButton.classList.add('d-none');
				  // some function here 
				       
			} else {
				formSubmitButton.classList.remove('d-inline-block');
				formSubmitButton.classList.remove('d-none');
				formContinueButton.classList.remove('d-none');
			}
		});

		// Validation before going to next page
		stepperObj.on('kt.stepper.next', function (stepper) {
			console.log('stepper.next');

			// Validate form before change stepper step
			console.log(stepper.getCurrentStepIndex() + ' is the current step');
			if(stepper.getCurrentStepIndex() < 3){
				var validator = validations[stepper.getCurrentStepIndex() - 1];
			}
			else{
				var domainType = $('.domain_type_change:checked').val();
				var hasAddress = $('#user_has_address').val();

				var adminCheck = $('#user_reg_for_admin').val();
				var techCheck = $('#user_reg_for_tech').val();
				var billCheck = $('#user_reg_for_billing').val();
				
				if( domainType =='Existing' && hasAddress=='No'){
				var validator = validations[2];
				}
				else if(domainType=='Transfer' && hasAddress =='No'){
                 var validator = validations[3];
				}

				else if(domainType=='Register' && hasAddress =='No'){
					 if(adminCheck !=1){
					 	// include admin fields
					 	var validator = validations[4];
					 }
					
				}
				
			 // get validator for currnt step
			}

			if (validator) {
				validator.validate().then(function (status) {
					console.log('validated!');

					if (status == 'Valid') {
						stepper.goNext();

						KTUtil.scrollTop();
					} else {
						Swal.fire({
							text: 'Error occurred in the fields',
							icon: "error",
							buttonsStyling: false,
							confirmButtonText: 'Close',
							customClass: {
								confirmButton: "btn btn-light"
							}
						}).then(function () {
							KTUtil.scrollTop();
						});
					}
				});
			} else {
				stepper.goNext();

				KTUtil.scrollTop();
			}
		});

		// Prev event
		stepperObj.on('kt.stepper.previous', function (stepper) {
			console.log('stepper.previous');

			stepper.goPrevious();
			KTUtil.scrollTop();
		});
	}

	var handleForm = function() {

		formSubmitButton.addEventListener('click', function (e) {
			// Validate form before change stepper step
			 console.log('we are about to submit form');
			var validator = validations[8]; // get validator for last form

			console.log(validator);


			validator.validate().then(function (status) {
				console.log('validated!');

				if (status == 'Valid') {
					// Prevent default button action
					e.preventDefault();

					// Disable button to avoid multiple click 
					formSubmitButton.disabled = true;

					// Show loading indication
					formSubmitButton.setAttribute('data-kt-indicator', 'on');

					// Simulate form submission
					let deform = document.getElementById("ap_create_order_form");
                    let fdata = new FormData(deform );

					 $.ajax({
					 	 url:frontAjax,
					 	 type:'post',
					 	 'data': form,
					 	  dataType:'json',
					 	   data: fdata,
     					   processData: false,
                           contentType: false,
					 	  success:function(report){
                               if(report.status =='OK'){
                               	if(report.url !=''){
                               		 window.location = report.url;
                               	}
                               	else{
                               	formSubmitButton.removeAttribute('data-kt-indicator');
                               	formSubmitButton.disabled = false;
                                   stepperObj.goNext();
                               	}
                               	
                               }
                               else{
                                popNotification(report.message, 'error', 'OK');
                                formSubmitButton.removeAttribute('data-kt-indicator');
                               	formSubmitButton.disabled = false;
                               }
					 	  },
					 	  error:function(report){
					         
					           	popNotification(report.responseText, 'error', 'OK');
                                formSubmitButton.removeAttribute('data-kt-indicator');
                               	formSubmitButton.disabled = false;


                                
					 	  }
					 });
					





				} else {
					Swal.fire({
						text: 'Error occurred in the fields',
						icon: "error",
						buttonsStyling: false,
						confirmButtonText: 'Close',
						customClass: {
							confirmButton: "btn btn-light"
						}
					}).then(function () {
						KTUtil.scrollTop();
					});
				}
			});
		});

		

		

		// Expiry year. For more info, plase visit the official plugin site: https://select2.org/
      
	}

	var initValidation = function () {
		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		// Step 1
		validations.push(FormValidation.formValidation(
			form,
			{
				fields: {
					domain_name: {
						validators: {
							notEmpty: {
								message: 'Domain name is required'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap5({
						rowSelector: '.possible_error_line',
                        eleInvalidClass: 'error_form_line',
                        eleValidClass: 'success_form_line'
					})
				}
			}
		));

		// Step 2
		validations.push(FormValidation.formValidation(
			form,
			{
				fields: {
					hosting_plan: {
						validators: {
							notEmpty: {
								message: 'Select a hosting plan, select one out of the listed hosting plans'
							}
						}
					}
					
					

				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap5({
						rowSelector: '.possible_error_line',
                        eleInvalidClass: 'error_form_line',
                        eleValidClass: 'success_form_line'
					})
				}
			}
		));

		// Step 3 || 2
			validations.push(FormValidation.formValidation(
			form,
			{
				fields: {
					default_firstname: {
						validators: {
							notEmpty: {
								message: 'billing firstname is required'
							}
						}
					},
					default_lastname: {
						validators: {
							notEmpty: {
								message: 'Last Name is required'
							}
						}
					},
					default_address: {
						validators: {
							notEmpty: {
								message: 'Address is required'
							}
						}
					},

					default_address: {
						validators: {
							notEmpty: {
								message: 'Address is required'
							}
						}
					},


					default_city: {
						validators: {
							notEmpty: {
								message: 'Address City is required'
							}
						}
					},

					default_postal_code: {
						validators: {
							notEmpty: {
								message: 'Postal code is required'
							}
						}
					},


					default_province_or_state: {
						validators: {
							notEmpty: {
								message: 'Fill in your province or state.'
							}
						}
					},

					default_id_country: {
						validators: {
							notEmpty: {
								message: 'Select your country from the dropdown list'
							}
						}
					},
					default_address_name: {
						validators: {
							notEmpty: {
								message: 'Give this address a name, you will use this name to identify this address in the future'
							}
						}
					}
				

				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap5({
						rowSelector: '.possible_error_line',
                        eleInvalidClass: 'error_form_line',
                        eleValidClass: 'success_form_line'
					})
				}
			}
		));
		
		

		// Step 4  || 3
		validations.push(FormValidation.formValidation(
			form,
			{
				fields: {
					default_firstname: {
						validators: {
							notEmpty: {
								message: 'billing firstname is required'
							}
						}
					},
					default_lastname: {
						validators: {
							notEmpty: {
								message: 'Last Name is required'
							}
						}
					},
					default_address: {
						validators: {
							notEmpty: {
								message: 'Address is required'
							}
						}
					},

					default_city: {
						validators: {
							notEmpty: {
								message: 'Address City is required'
							}
						}
					},

					default_postal_code: {
						validators: {
							notEmpty: {
								message: 'Postal code is required'
							}
						}
					},


					default_province_or_state: {
						validators: {
							notEmpty: {
								message: 'Fill in your province or state.'
							}
						}
					},

					default_id_country: {
						validators: {
							notEmpty: {
								message: 'Select your country from the dropdown list'
							}
						}
					},
					default_address_name: {
						validators: {
							notEmpty: {
								message: 'Give this address a name, you will use this name to identify this address in the future'
							}
						}
					},

					transfer_code: {
						validators: {
							notEmpty: {
								message: 'Domain Transfer code / Epp Code is required'
							}
						}
					},
				

				},

				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap5({
						rowSelector: '.possible_error_line',
                        eleInvalidClass: 'error_form_line',
                        eleValidClass: 'success_form_line'
					})
				}
			}
		));



		// Step 4  || 4
		validations.push(FormValidation.formValidation(
			form,
			{
				fields: {
					registrant_email: {
						validators: {
							emailAddress: {
					            message: "The value is not a valid email address"
					            },
							notEmpty: {
								message: 'Registrant email address is required'
							}
						}
					},

					registrant_firstname: {
						validators: {
							notEmpty: {
								message: 'billing firstname is required'
							}
						}
					},


					registrant_lastname: {
						validators: {
							notEmpty: {
								message: 'Last Name is required'
							}
						}
					},
					registrant_address: {
						validators: {
							notEmpty: {
								message: 'Address is required'
							}
						}
					},

					registrant_city: {
						validators: {
							notEmpty: {
								message: 'Address City is required'
							}
						}
					},

					registrant_postal_code: {
						validators: {
							notEmpty: {
								message: 'Postal code is required'
							}
						}
					},


					registrant_province_or_state: {
						validators: {
							notEmpty: {
								message: 'Fill in your province or state.'
							}
						}
					},

					registrant_id_country: {
						validators: {
							notEmpty: {
								message: 'Select your country from the dropdown list'
							}
						}
					},
					registrant_address_name: {
						validators: {
							notEmpty: {
								message: 'Give this address a name, you will use this name to identify this address in the future'
							}
						}
					},

					user_reg_for_admin: {
						validators: {
							notEmpty: {
								message: 'Use registrant address as same as administrator checkbox is required'
							}
						}
					},

					user_reg_for_billing: {
						validators: {
							notEmpty: {
								message: 'User registrant information also for billing field is required.'
							}
						}
					},

					user_reg_for_tech: {
						validators: {
							notEmpty: {
								message: 'Use registrant contact information for technical contact information checkbox is required.'
							}
						}
					}



					
				

				},

				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap5({
						rowSelector: '.possible_error_line',
                        eleInvalidClass: 'error_form_line',
                        eleValidClass: 'success_form_line'
					})
				}
			}
		));




		// Step 4  || 5
		validations.push(FormValidation.formValidation(
			form,
			{
				fields: {

					registrant_email: {
						validators: {
							emailAddress: {
					            message: "The value is not a valid email address"
					            },
							notEmpty: {
								message: 'Registrant email address is required'
							}
						}
					},

					registrant_firstname: {
						validators: {
							notEmpty: {
								message: 'billing firstname is required'
							}
						}
					},


					registrant_lastname: {
						validators: {
							notEmpty: {
								message: 'Last Name is required'
							}
						}
					},
					registrant_address: {
						validators: {
							notEmpty: {
								message: 'Address is required'
							}
						}
					},

					registrant_city: {
						validators: {
							notEmpty: {
								message: 'Address City is required'
							}
						}
					},



					registrant_postal_code: {
						validators: {
							notEmpty: {
								message: 'Postal code is required'
							}
						}
					},


					registrant_province_or_state: {
						validators: {
							notEmpty: {
								message: 'Fill in your province or state.'
							}
						}
					},

					registrant_id_country: {
						validators: {
							notEmpty: {
								message: 'Select your country from the dropdown list'
							}
						}
					},
					registrant_address_name: {
						validators: {
							notEmpty: {
								message: 'Give this address a name, you will use this name to identify this address in the future'
							}
						}
					},

					admin_firstname: {
						validators: {
							notEmpty: {
								message: 'billing firstname is required'
							}
						}
					},
					admin_lastname: {
						validators: {
							notEmpty: {
								message: 'Last Name is required'
							}
						}
					},
					admin_address: {
						validators: {
							notEmpty: {
								message: 'Address is required'
							}
						}
					},

					admin_city: {
						validators: {
							notEmpty: {
								message: 'Address City is required'
							}
						}
					},



					admin_postal_code: {
						validators: {
							notEmpty: {
								message: 'Postal code is required'
							}
						}
					},


					admin_province_or_state: {
						validators: {
							notEmpty: {
								message: 'Fill in your province or state.'
							}
						}
					},

					admin_id_country: {
						validators: {
							notEmpty: {
								message: 'Select your country from the dropdown list'
							}
						}
					},
					admin_address_name: {
						validators: {
							notEmpty: {
								message: 'Give this address a name, you will use this name to identify this address in the future'
							}
						}
					},

					transfer_code: {
						validators: {
							notEmpty: {
								message: 'Domain Transfer code / Epp Code is required'
							}
						}
					},
				

				},

				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap5({
						rowSelector: '.possible_error_line',
                        eleInvalidClass: 'error_form_line',
                        eleValidClass: 'success_form_line'
					})
				}
			}
		));




		// Step 4  || 6
		validations.push(FormValidation.formValidation(
			form,
			{
				fields: {
					default_firstname: {
						validators: {
							notEmpty: {
								message: 'billing firstname is required'
							}
						}
					},
					default_lastname: {
						validators: {
							notEmpty: {
								message: 'Last Name is required'
							}
						}
					},
					default_address: {
						validators: {
							notEmpty: {
								message: 'Address is required'
							}
						}
					},

					default_city: {
						validators: {
							notEmpty: {
								message: 'Address City is required'
							}
						}
					},



					default_postal_code: {
						validators: {
							notEmpty: {
								message: 'Postal code is required'
							}
						}
					},


					default_province_or_state: {
						validators: {
							notEmpty: {
								message: 'Fill in your province or state.'
							}
						}
					},

					default_id_country: {
						validators: {
							notEmpty: {
								message: 'Select your country from the dropdown list'
							}
						}
					},
					default_address_name: {
						validators: {
							notEmpty: {
								message: 'Give this address a name, you will use this name to identify this address in the future'
							}
						}
					},

					transfer_code: {
						validators: {
							notEmpty: {
								message: 'Domain Transfer code / Epp Code is required'
							}
						}
					},
				

				},

				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap5({
						rowSelector: '.possible_error_line',
                        eleInvalidClass: 'error_form_line',
                        eleValidClass: 'success_form_line'
					})
				}
			}
		));



		// Step 4  || 7
		validations.push(FormValidation.formValidation(
			form,
			{
				fields: {
					default_firstname: {
						validators: {
							notEmpty: {
								message: 'billing firstname is required'
							}
						}
					},
					default_lastname: {
						validators: {
							notEmpty: {
								message: 'Last Name is required'
							}
						}
					},
					default_address: {
						validators: {
							notEmpty: {
								message: 'Address is required'
							}
						}
					},

					default_city: {
						validators: {
							notEmpty: {
								message: 'Address City is required'
							}
						}
					},



					default_postal_code: {
						validators: {
							notEmpty: {
								message: 'Postal code is required'
							}
						}
					},


					default_province_or_state: {
						validators: {
							notEmpty: {
								message: 'Fill in your province or state.'
							}
						}
					},

					default_id_country: {
						validators: {
							notEmpty: {
								message: 'Select your country from the dropdown list'
							}
						}
					},
					default_address_name: {
						validators: {
							notEmpty: {
								message: 'Give this address a name, you will use this name to identify this address in the future'
							}
						}
					},

					transfer_code: {
						validators: {
							notEmpty: {
								message: 'Domain Transfer code / Epp Code is required'
							}
						}
					},
				

				},

				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap5({
						rowSelector: '.possible_error_line',
                        eleInvalidClass: 'error_form_line',
                        eleValidClass: 'success_form_line'
					})
				}
			}
		));



			// Step 4  || 8
		validations.push(FormValidation.formValidation(
			form,
			{
				fields: {
					payment_option_checkout: {
						validators: {
							notEmpty: {
								message: 'Select payment option'
							}
						}
					},
					number_of_domain_years: {
						validators: {
							notEmpty: {
								message: 'Domain years has to be between 1 to 10 years'
							}
						}
					},

				

				},

				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap5({
						rowSelector: '.possible_error_line',
                        eleInvalidClass: 'error_form_line',
                        eleValidClass: 'success_form_line'
					})
				}
			}
		));


		// las las
	}

	return {
		// Public Functions
		init: function () {
			// Elements
			modalEl = document.querySelector('#kt_modal_create_account');

			if ( modalEl ) {
				modal = new bootstrap.Modal(modalEl);	
			}					

			stepper = document.querySelector('#ap_domain_host_order_process');

			if ( !stepper ) {
				return;
			}

			form = stepper.querySelector('#ap_create_order_form');
			//formSubmitButton = stepper.querySelector('[data-kt-stepper-action="submit"]');
			formSubmitButton = stepper.querySelector('#ap_save_submit_get_started_btn');
			formContinueButton = stepper.querySelector('[data-kt-stepper-action="next"]');

			console.log(formSubmitButton);



			initStepper();
			initValidation();
			handleForm();
		}
	};
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTCreateAccount.init();
});


 (function($) {
    "use strict";


$('body').on('click', '.domain_type_change', function(){
	   $('.holding_domain_input_box').removeClass('display_none');
	     console.log( $(this).val());
	   if( $(this).val() =='Register'){
          $('.domain_check_report_group').removeClass('display_none');
          $('.the_forward_continue_btn').addClass('disabled').prop('disabled', true);
	   }
	   else{
          $('.domain_check_report_group').addClass('display_none');
          $('.the_forward_continue_btn').removeClass('disabled').prop('disabled', false);
	   }
});


	$('body').on('click', '#domain_availability_checker_btn',function(ev){
                   ev.preventDefault();
   
		if( $('#domain_name').val().length < 1){
             return false;
		}

	  let ajbtn = $(this);
      let btn_text = ajbtn.html();
       ajbtn.html( btn_text+'..........').prop('disabled', true);

		$('.the_forward_continue_btn').addClass('disabled').prop('disabled', true);
		$.ajax({
			url:frontAjax,
			type:'post',
			data:{'domain_name':$('#domain_name').val(), 'action':'frontActionsBaseField', 'request_token':'APYJFRBCIYIBUOKHTYCLEYRSFFZSQIPLNQEJJLMERQOSUYNBVZTGYUZYVRURUMDU'}, 
			dataType:'json',
			success:function(report){
				ajbtn.html(btn_text).prop('disabled', false);
				if(report.status=='OK'){
					
					$('.show_relevant_makeshere').html(report.contents);
					if(report.available =='Yes'){
						popNotification(report.message, 'success');
						$('.the_forward_continue_btn').removeClass('disabled').prop('disabled', false);
					}
					else{
						popNotification(report.message, 'error');
						$('.the_forward_continue_btn').addClass('disabled').prop('disabled', true);
					}
				}
				else{
					popNotification(report.message, 'error');
				}

			},
			error:function(report){
				ajbtn.html(btn_text).prop('disabled', false);
				popNotification(report.responseText, 'error');
			}
		});

	});


$('body').on('click', '.hosting_option_filter', function(){
        $('.the_list_of_hosting_plan').addClass('display_none');
          console.log($(this).find('input[name="hosting_filter_checkbox"]').val());

       $('.'+$(this).find('input[name="hosting_filter_checkbox"]').val()).removeClass('display_none');

});

$('body').on('click', '.go_to_partner_url', function(ev){
	 window.location = $(this).data('url');
});













    

})(jQuery);//ready


