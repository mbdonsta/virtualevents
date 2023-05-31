<!--begin::Radio button-->
<label
    class="layout-placeholder btn btn-outline btn-outline-dashed btn-active-light-primary d-block p-6 mb-5">
    <!--end::Description-->
    <div class="d-block">
        <!--begin::Radio-->
        <div
            class="form-check form-check-custom form-check-solid form-check-primary mx-auto d-block">
            <input class="form-check-input" type="radio" name="layout_style"
                   value="{{ $value }}" {{ old('layout_style', $current) == $value ? 'checked' : '' }}>
        </div>
        <!--end::Radio-->

        <!--begin::Info-->
        <div class="layout-box layout-style-2">
            <div class="box box-1">
                <div>1</div>
            </div>
            <div class="box box-1">
                <div>2</div>
            </div>
        </div>
        <!--end::Info-->
    </div>
    <!--end::Description-->
</label>
<!--end::Radio button-->
