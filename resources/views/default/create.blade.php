@extends('layout.master')
@section('page_title','Create Product')
@section('content')
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        @yield('page_title')</h1>
                    <!--end::Title-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <!--begin::Primary button-->
                    <a href="#" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal"
                       data-bs-target="#kt_modal_create_app">Create</a>
                    <!--end::Primary button-->
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card body-->
                    <div class="card-body p-0">
                        <!--begin::Form-->
                        <div class="card-px py-5 my-5">
                            <!--begin::Row-->
                            <div class="row mb-3">
                                <!--begin::Col-->
                                <div class="col-md-12 pe-lg-10">
                                    <!--begin::Form-->
                                    <form action="" class="form mb-15" method="post">

                                        <!--begin::Row-->
                                        <div class="row g-3 mb-8">
                                            <!--begin::Col-->
                                            <div class="col-md-4 fv-row">
                                                <label class="fs-5 fw-semibold mb-2">
                                                    <span class="required">Name</span>
                                                    <span class="ms-1" data-bs-toggle="tooltip"
                                                          title="Specify a target name for future usage and reference">
                                                            <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                            </i>
                                                        </span>
                                                </label>
                                                <input type="text" class="form-control form-control-solid"
                                                       placeholder="Enter your name" name="name"/>
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-md-4 fv-row">
                                                <label class="fs-5 fw-semibold mb-2">Email</label>
                                                <input type="text" class="form-control form-control-solid"
                                                       placeholder="Enter your email" name="email"/>
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-md-4 fv-row">
                                                <label class="fs-5 fw-semibold mb-2">Pasword</label>
                                                <input type="password" class="form-control form-control-solid"
                                                       placeholder="Enter your password" name="password"/>
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->

                                        <!--begin::Row-->
                                        <div class="row g-3 mb-8">
                                            <!--begin::Col-->
                                            <div class="col-md-4 fv-row">
                                                <label class="required fs-6 fw-semibold mb-2">Choose your role
                                                    (Select2)</label>
                                                <select name="position" data-control="select2"
                                                        data-placeholder="Select a position..."
                                                        class="form-select form-select-solid">
                                                    <option value="Web Developer">Web Developer</option>
                                                    <option value="Web Designer">Web Designer</option>
                                                    <option value="Art Director">Art Director</option>
                                                    <option value="Finance Manager">Finance Manager</option>
                                                    <option value="Project Manager">Project Manager</option>
                                                    <option value="System Administrator">System Administrator</option>
                                                </select>
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-md-4 fv-row">
                                                <label class="required fs-6 fw-semibold mb-2">Assign</label>
                                                <select class="form-select form-select-solid" data-control="select2"
                                                        data-hide-search="true"
                                                        data-placeholder="Select a Team Member"
                                                        name="target_assign">
                                                    <option value="">Select user...</option>
                                                    <option value="1">Karina Clark</option>
                                                    <option value="2">Robert Doe</option>
                                                    <option value="3">Niel Owen</option>
                                                    <option value="4">Olivia Wild</option>
                                                    <option value="5">Sean Bean</option>
                                                </select>
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-md-4 fv-row">
                                                <label class="fs-6 fw-semibold">Adding Users by Team Members</label>
                                                <div class="fs-7 fw-semibold text-muted">If you need more info, please
                                                    check budget planning
                                                </div>
                                                <!--begin::Switch-->
                                                <label
                                                    class="form-check form-switch form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="1"
                                                           checked="checked"/>
                                                    <span class="form-check-label fw-semibold text-muted">Allowed</span>
                                                </label>
                                                <!--end::Switch-->
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-md-4 fv-row">
                                                <label class="fs-6 fw-semibold">custom Radio</label>
                                                <div class="fs-7 fw-semibold text-muted">If Interview Appointment is Booked on this button</div>
                                                <!--begin::Switch-->
                                                <label class="form-check form-switch form-check-custom form-check-solid form-check-custom-color form-check-success">
                                                    <input name="is_interview_appointment" id="is_interview_appointment" class="form-check-input" type="checkbox" value="1"/>
                                                    <span class="form-check-label fw-semibold text-muted"></span>
                                                </label>
                                                <!--end::Switch-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end:::Row-->

                                        <!--begin::Row-->
                                        <div class="row g-3 mb-8">
                                            <!--begin::Col-->
                                            <div class="col-md-4 fv-row">
                                                <label class="required fs-6 fw-semibold mb-2">Datetime
                                                    Picker</label>
                                                <!--begin::Input-->
                                                <div class="position-relative d-flex align-items-center">
                                                    <!--begin::Icon-->
                                                    <i class="ki-duotone ki-calendar-8 fs-2 position-absolute mx-4">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                        <span class="path6"></span>
                                                    </i>
                                                    <!--end::Icon-->
                                                    <!--begin::Datepicker-->
                                                    <input
                                                        class="form-control form-control-solid ps-12 datetime_picker"
                                                        placeholder="Select a date"/>
                                                    <!--end::Datepicker-->
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-md-4 fv-row">
                                                <label class="required fs-6 fw-semibold mb-2">Date Picker</label>
                                                <!--begin::Input-->
                                                <div class="position-relative d-flex align-items-center">
                                                    <!--begin::Icon-->
                                                    <i class="ki-duotone ki-calendar-8 fs-2 position-absolute mx-4">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                        <span class="path6"></span>
                                                    </i>
                                                    <!--end::Icon-->
                                                    <!--begin::Datepicker-->
                                                    <input class="form-control form-control-solid ps-12 date_picker"
                                                           placeholder="Select a date"/>
                                                    <!--end::Datepicker-->
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-md-4 fv-row">
                                                <label class="fs-6">Notifications</label>
                                                <div class="fs-7 text-muted">Allow Notifications by Phone or Email</div>
                                                <!--begin::Checkboxes-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid me-10">
                                                        <input class="form-check-input h-20px w-20px" type="checkbox"
                                                               name="communication[]" value="email" checked="checked"/>
                                                        <span class="form-check-label fw-semibold">Email</span>
                                                    </label>
                                                    <!--end::Checkbox-->
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-custom form-check-solid">
                                                        <input class="form-check-input h-20px w-20px" type="checkbox"
                                                               name="communication[]" value="phone"/>
                                                        <span class="form-check-label fw-semibold">Phone</span>
                                                    </label>
                                                    <!--end::Checkbox-->
                                                </div>
                                                <!--end::Checkboxes-->
                                            </div>
                                            <!--end::Col-->

                                            <!--begin::Col-->
                                            <div class="col-md-4 fv-row">
                                                <label class="fs-5 fw-semibold mb-2">
                                                    <span class="">Tagify</span>
                                                </label>
                                                <input class="form-control form-control-solid" placeholder="Press Tab to enter more" value="eg Dust, Light"
                                                       name="allergies" id="allergies"/>
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end:::Row-->

                                        <!--begin::Row-->
                                        <div class="row g-3 mb-8">
                                            <div class="col-12">
                                                <label class="fs-6 fw-semibold mb-2">Message</label>
                                                <textarea class="form-control form-control-solid" rows="6"
                                                          name="message"
                                                          placeholder="Type your message here..."></textarea>
                                            </div>
                                        </div>
                                        <!--end::Row-->

                                        <!--begin::Row-->
                                        <div class="row mb-8">
                                            <!--begin::Col-->
                                            <div class="col-xl-3">
                                                <div class="fs-6 fw-semibold mt-2 mb-3">Usage Character</div>
                                            </div>
                                            <!--end::Col-->
                                            <!--begin::Col-->
                                            <div class="col-xl-9">
                                                <!--begin::Row-->
                                                <div class="row g-9" data-kt-buttons="true"
                                                     data-kt-buttons-target="[data-kt-button]">
                                                    <!--begin::Col-->
                                                    <div class="col-md-4 col-lg-12 col-xxl-4">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-primary active d-flex text-start p-6"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
																		<input class="form-check-input" type="radio"
                                                                               name="usage" value="1"
                                                                               checked="checked"/>
																	</span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
																		<span class="fs-4 fw-bold mb-1 d-block">Precise Usage</span>
																		<span class="fw-semibold fs-7 text-gray-600">Withdraw money to your bank account per transaction under $50,000 budget</span>
																	</span>
                                                        </label>
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-md-4 col-lg-12 col-xxl-4">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
																		<input class="form-check-input" type="radio"
                                                                               name="usage" value="2"/>
																	</span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
																		<span class="fs-4 fw-bold mb-1 d-block">Normal Usage</span>
																		<span class="fw-semibold fs-7 text-gray-600">Withdraw money to your bank account per transaction under $50,000 budget</span>
																	</span>
                                                        </label>
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-md-4 col-lg-12 col-xxl-4">
                                                        <label
                                                            class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6"
                                                            data-kt-button="true">
                                                            <!--begin::Radio button-->
                                                            <span
                                                                class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
																		<input class="form-check-input" type="radio"
                                                                               name="usage" value="3"/>
																	</span>
                                                            <!--end::Radio button-->
                                                            <span class="ms-5">
																		<span class="fs-4 fw-bold mb-1 d-block">Extreme Usage</span>
																		<span class="fw-semibold fs-7 text-gray-600">Withdraw money to your bank account per transaction under $50,000 budget</span>
																	</span>
                                                        </label>
                                                    </div>
                                                    <!--end::Col-->
                                                </div>
                                                <!--end::Row-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->

                                        <!--begin::Row-->
                                        <div class="row mb-8">
                                            <!--begin::Col-->
                                            <div class="col-md-4">
                                                <label class="fs-6 fw-semibold mt-2 mb-3">Manage Budget</label>
                                                <!--begin::Dialer-->
                                                <div class="position-relative w-md-300px" data-kt-dialer="true"
                                                     data-kt-dialer-min="1000" data-kt-dialer-max="50000"
                                                     data-kt-dialer-step="1000" data-kt-dialer-prefix="$"
                                                     data-kt-dialer-decimals="2">
                                                    <!--begin::Decrease control-->
                                                    <button type="button"
                                                            class="btn btn-icon btn-active-color-gray-700 position-absolute translate-middle-y top-50 start-0"
                                                            data-kt-dialer-control="decrease">
                                                        <i class="ki-duotone ki-minus-square fs-1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </button>
                                                    <!--end::Decrease control-->
                                                    <!--begin::Input control-->
                                                    <input type="text"
                                                           class="form-control form-control-solid border-0 ps-12"
                                                           data-kt-dialer-control="input" placeholder="Amount"
                                                           name="manageBudget" readonly="readonly" value="$36,000.00"/>
                                                    <!--end::Input control-->
                                                    <!--begin::Increase control-->
                                                    <button type="button"
                                                            class="btn btn-icon btn-active-color-gray-700 position-absolute translate-middle-y top-50 end-0"
                                                            data-kt-dialer-control="increase">
                                                        <i class="ki-duotone ki-plus-square fs-1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                        </i>
                                                    </button>
                                                    <!--end::Increase control-->
                                                </div>
                                                <!--end::Dialer-->
                                            </div>
                                            <!--end::Col-->

                                            <!--begin::Col-->
                                            <div class="col-md-4">
                                                <label class="fs-6 fw-semibold mt-2 mb-3">Products must match</label>
                                                <div class="d-flex flex-wrap align-items-center">
                                                    <!--begin::Radio-->
                                                    <div class="form-check form-check-custom form-check-solid mx-2">
                                                        <input class="form-check-input" type="radio"
                                                               name="conditions"
                                                               value="" id="all_conditions" checked="checked"/>
                                                        <label class="form-check-label" for="all_conditions">All
                                                            conditions</label>
                                                    </div>
                                                    <!--end::Radio-->
                                                    <!--begin::Radio-->
                                                    <div class="form-check form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="radio"
                                                               name="conditions"
                                                               value="" id="any_conditions"/>
                                                        <label class="form-check-label" for="any_conditions">Any
                                                            conditions</label>
                                                    </div>
                                                    <!--end::Radio-->
                                                </div>
                                            </div>
                                            <!--end::Col-->

                                            <!--begin::Col-->
                                            <div class="col-md-4">
                                                <!--begin::Label-->
                                                <label class="form-label">Allow Backorders</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <div class="form-check form-check-custom form-check-solid mb-2">
                                                    <input class="form-check-input" type="checkbox" value=""/>
                                                    <label class="form-check-label">Yes</label>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->

                                        <!--begin::Row-->
                                        <div class="row mb-8">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold mb-2">Discount Type
                                                <span class="ms-1" data-bs-toggle="tooltip"
                                                      title="Select a discount type that will be applied to this product">
																		<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
																			<span class="path1"></span>
																			<span class="path2"></span>
																			<span class="path3"></span>
																		</i>
																	</span></label>
                                            <!--End::Label-->
                                            <!--begin::Row-->
                                            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-1 row-cols-xl-3 g-3"
                                                 data-kt-buttons="true"
                                                 data-kt-buttons-target="[data-kt-button='true']">
                                                <!--begin::Col-->
                                                <div class="col">
                                                    <!--begin::Option-->
                                                    <label
                                                        class="btn btn-outline btn-outline-dashed btn-active-light-primary active d-flex text-start p-6"
                                                        data-kt-button="true">
                                                        <!--begin::Radio-->
                                                        <span
                                                            class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
																					<input class="form-check-input"
                                                                                           type="radio"
                                                                                           name="discount_option"
                                                                                           value="1" checked="checked"/>
																				</span>
                                                        <!--end::Radio-->
                                                        <!--begin::Info-->
                                                        <span class="ms-5">
																					<span
                                                                                        class="fs-4 fw-bold text-gray-800 d-block">No Discount</span>
																				</span>
                                                        <!--end::Info-->
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <!--end::Col-->
                                                <!--begin::Col-->
                                                <div class="col">
                                                    <!--begin::Option-->
                                                    <label
                                                        class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6"
                                                        data-kt-button="true">
                                                        <!--begin::Radio-->
                                                        <span
                                                            class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
																					<input class="form-check-input"
                                                                                           type="radio"
                                                                                           name="discount_option"
                                                                                           value="2"/>
																				</span>
                                                        <!--end::Radio-->
                                                        <!--begin::Info-->
                                                        <span class="ms-5">
																					<span
                                                                                        class="fs-4 fw-bold text-gray-800 d-block">Percentage %</span>
																				</span>
                                                        <!--end::Info-->
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <!--end::Col-->
                                                <!--begin::Col-->
                                                <div class="col">
                                                    <!--begin::Option-->
                                                    <label
                                                        class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6"
                                                        data-kt-button="true">
                                                        <!--begin::Radio-->
                                                        <span
                                                            class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
																					<input class="form-check-input"
                                                                                           type="radio"
                                                                                           name="discount_option"
                                                                                           value="3"/>
																				</span>
                                                        <!--end::Radio-->
                                                        <!--begin::Info-->
                                                        <span class="ms-5">
																					<span
                                                                                        class="fs-4 fw-bold text-gray-800 d-block">Fixed Price</span>
																				</span>
                                                        <!--end::Info-->
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <!--end::Col-->
                                            </div>
                                            <!--end::Row-->
                                        </div>
                                        <!--end::Row-->

                                        <!--begin::Row-->
                                        <div class="row mb-8">
                                            <!--begin::Billing toggle-->
                                            <div class="fw-bold fs-3 rotate collapsible mb-7" data-bs-toggle="collapse"
                                                 href="#kt_modal_add_customer_billing_info" role="button"
                                                 aria-expanded="false" aria-controls="kt_customer_view_details">Shipping
                                                Information (Collapseable)
                                                <span class="ms-2 rotate-180">
																<i class="ki-duotone ki-down fs-3"></i>
															</span></div>
                                            <!--end::Billing toggle-->
                                            <!--begin::Billing form-->
                                            <div id="kt_modal_add_customer_billing_info" class="collapse show">
                                                <!--begin::Input group-->
                                                <div class="d-flex flex-column mb-7 fv-row">
                                                    <!--begin::Label-->
                                                    <label class="required fs-6 fw-semibold mb-2">Address Line 1</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input class="form-control form-control-solid" placeholder=""
                                                           name="address1" value="101, Collins Street"/>
                                                    <!--end::Input-->
                                                </div>
                                                <!--end::Input group-->
                                            </div>
                                            <!--end::Billing form-->
                                        </div>
                                        <!--end::Row-->

                                        <!--begin::Row-->
                                        <div class="row mb-8">
                                            <div class="col-12">
                                                <!--begin::Label-->
                                                <label class="form-label">Description</label>
                                                <!--end::Label-->
                                                <!--begin::Editor-->
                                                <div name="desc" class="min-h-200px mb-2 text-editor"></div>
                                                <!--end::Editor-->
                                                <!--begin::Description-->
                                                <div class="text-muted fs-7">Set a description to the category for
                                                    better visibility.
                                                </div>
                                                <!--end::Description-->
                                            </div>
                                        </div>
                                        <!--end::Row-->

                                        <!--begin::Submit-->
                                        <div class="row">
                                            <div class="col-12">
                                                <!--begin::Actions-->
                                                <div class="text-center">
                                                    <button type="reset" id="reset_form"
                                                            class="btn btn-light me-3">Reset
                                                    </button>
                                                    <button type="submit" id="kt_modal_new_target_submit"
                                                            class="btn btn-primary">
                                                        <span class="indicator-label">Submit</span>
                                                        <span class="indicator-progress">Please wait...
									                        <span
                                                                class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                        </span>
                                                    </button>
                                                </div>
                                                <!--end::Actions-->
                                            </div>
                                        </div>
                                        <!--end::Submit-->
                                    </form>
                                    <!--end::Form-->
                                </div>
                                <!--end::Col-->
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->

                        </div>
                        <!--end::Form-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
@endsection

@section('page_level_scripts')
    <script>
        $(document).ready(function () {
            new Tagify($('#allergies')[0]);
        });
    </script>
@endsection

