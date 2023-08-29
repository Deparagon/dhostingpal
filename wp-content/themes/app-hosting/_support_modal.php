
<!--begin::Modal - Create App-->
<div class="modal fade" id="kt_modal_load_ticket_form" tabindex="-1" aria-hidden="true">
<!--begin::Modal dialog-->
<div class="modal-dialog modal-dialog-centered mw-650px">
<!--begin::Modal content-->
<div class="modal-content">
<!--begin::Modal header-->
<div class="modal-header">
<!--begin::Modal title-->
<h2>Open New Ticket</h2>
<!--end::Modal title-->
<!--begin::Close-->
<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
<span class="svg-icon svg-icon-1">
<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
</svg>
</span>
<!--end::Svg Icon-->
</div>
<!--end::Close-->
</div>
<!--end::Modal header-->
<!--begin::Modal body-->
<div class="modal-body py-lg-8 px-lg-8">
<!--begin::Stepper-->

<!-- START NEW PAGE FORM -->

<form id="ap_create_ticket_form" method="post" class="form" enctype="multipart/form-data">
								<!--begin::Scroll-->
<div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
																

<div class="d-block">
									

			<!--begin::Subject-->
			<div class="border-bottom">
				<input class="form-control form-control-transparent border-0 px-8 min-h-45px" name="subject" placeholder="Subject" />
			</div>
			<!--end::Subject-->

			<input type="hidden" name="action" value="internalActions">
			<input type="hidden" name="request_token" value="APRBDAPGLPOMQWHQPTHGIAEKKQUOWRTOJXEQRCTSQZHWGOSWJURYYOKGOQFAKAZG">
			
            <div class="form-group">
            <label class="" for="message">Message</label>
			<textarea class="form-control" rows="10" name="message" id="actual_textkeeper"></textarea>
		    </div>
			<!--end::Message-->
			<!--begin::Attachments-->
		   <!-- <input style="display:none;" type="file" id="support_attachment" name="attachment"> -->
			<!--end::Attachments-->

		<div class="fv-row mb-7">
		<!--begin::Label-->
		<label class="d-block fw-semibold fs-6 mb-5"> Upload Attachment</label>
		<!--end::Label-->
		<!--begin::Image placeholder-->
		<style>.image-input-placeholder { background-image: url('/assets/media/svg/files/blank-image.svg'); } [data-bs-theme="dark"] .image-input-placeholder { background-image: url('/assets/media/svg/files/blank-image-dark.svg'); }</style>
		<!--end::Image placeholder-->
		<!--begin::Image input-->
		<div class="image-input image-input-outline image-input-placeholder" data-kt-image-input="true">
			<!--begin::Preview existing avatar-->
			<div class="image-input-wrapper w-125px h-125px" style="background-image: url(/images/upload.png);"></div>
			<!--end::Preview existing avatar-->
			<!--begin::Label-->
			<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change attachment">
				<i class="bi bi-pencil-fill fs-7"></i>
				<!--begin::Inputs-->
				<input type="file" name="attachment" accept=".png, .jpg, .jpeg" />
				<input type="hidden" name="image_remove" />
				<!--end::Inputs-->
			</label>
			<!--end::Label-->
			<!--begin::Cancel-->
			<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel attachment">
				<i class="bi bi-x fs-2"></i>
			</span>
			<!--end::Cancel-->
			<!--begin::Remove-->
			<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove attachment">
				<i class="bi bi-x fs-2"></i>
			</span>
			<!--end::Remove-->
		</div>
		<!--end::Image input-->
		<!--begin::Hint-->
		<div class="form-text">Allowed file types: png, jpg, jpeg.</div>
		<!--end::Hint-->
	</div>


</div>
		<!--end::Body-->
	<!--end::Input group-->
</div>
								<!--end::Scroll-->
								<!--begin::Actions-->
								<div class="text-center pt-15">
									
									<button id="save_support_fresh_ticket" type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
										<span class="indicator-label">Submit</span>
										<span class="indicator-progress">Please wait...
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
									</button>
								</div>
								<!--end::Actions-->
							</form>



<!-- END NEW PAGE FORM -->


<!--end::Stepper-->
</div>
<!--end::Modal body-->
</div>
<!--end::Modal content-->
</div>
<!--end::Modal dialog-->
</div>
<!--end::Modal - Create App-->