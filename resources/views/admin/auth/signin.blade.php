@extends('admin.app')

@section('content')
    <div class="container">
        <div class="card card-login mx-auto mt-5">
            <div class="card-header">Login</div>
            <div class="card-body">
            <form id="signin">
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button> You have some errors in the form. Please check below. 
                </div>
                <div class="alert alert-success display-hide">
                    <button class="close" data-close="alert"></button> Information is valid, please wait! 
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input class="form-control" name="email" type="email" placeholder="Email"  />
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input class="form-control"  name="password" type="password" placeholder="Password"  />
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <label class="form-check-label">
                        <input class="form-check-input" type="checkbox"> Remember Password</label>
                    </div>
                </div>
                <button class="btn btn-primary btn-block" style="submit">Login</a>
            </form>
        </div>
    </div>
@endsection

@push('app-scripts')
    <script>
        
        var FormValidation = function () {
            var handleValidation = function() {
                var form = $('#signin');
                var error = $('.alert-danger', form);
                var success = $('.alert-success', form);

                form.validate({
                    errorElement: 'span', 
                    errorClass: 'help-block help-block-error',
                    focusInvalid: false,
                    ignore: "",
                    rules: {
                        email : {
                            required: true,
                            email : true
                        },
                        password : {
                            required: true,
                        }
                    },
                    invalidHandler: function (event, validator) {
                        success.hide();
                        error.show();
                    },
                    highlight: function (element) {
                       $(element).removeClass("is-valid").addClass('is-invalid');
                    },
                    unhighlight: function (element) {

                    },
                    success: function (label, element) {
                       $(element).removeClass('is-invalid').addClass('is-valid');
                    },
                    submitHandler: function (form) {
                        success.show();
                        error.hide();
                        signin();
                    }
                });
            }

            return {
                init: function () {
                    handleValidation();
                }
            };
        }();

        function signin()
        {
            $.ajax({
                method : "POST",
                url: "/admin/signin",
                data: {
                    email : $("[name=email]").val(),
                    password : $("[name=password]").val()
                }
            }).done(function(response) {
                if (response.data)
                {
                    setTimeout(function() {
                        window.location.href = "/admin/";
                    }, 2000);
                }
            });

        }

        $(document).ready(function(){
            FormValidation.init();
        })
    </script>
@endpush