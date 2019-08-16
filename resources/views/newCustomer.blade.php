<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{env('APP_NAME')}} New Customer</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('new_customer/vendor/bootstrap/css/bootstrap.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('new_customer/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('new_customer/fonts/Linearicons-Free-v1.0.0/icon-font.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('new_customer/vendor/animate/animate.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('new_customer/vendor/css-hamburgers/hamburgers.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('new_customer/vendor/animsition/css/animsition.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('new_customer/vendor/select2/select2.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('new_customer/css/util.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('new_customer/css/main.css')}}">
    <!--===============================================================================================-->
</head>
<body>


<div class="container-contact100">
    <div class="wrap-contact100">
        <form class="contact100-form validate-form" method="POST">
            <span class="contact100-form-title">
                Tell us more about you
            </span>

            @csrf

            @if(!empty($errors->all()))
                <div style="border: 1px solid red;width: 100%;padding: 10px;font-size: 11pt;color: red;">
                    @foreach($errors->all() as $error)
                        {{$error}} <br />
                    @endforeach
                </div>
            @endif

            <label class="label-input100" for="first-name">Your name *</label>
            <div class="wrap-input100 rs1-wrap-input100 validate-input" data-validate="Enter first name">
                <input id="first-name" class="input100" type="text" name="first-name" value="{{old('first-name')}}" placeholder="First name">
                <span class="focus-input100"></span>
            </div>
            <div class="wrap-input100 rs2-wrap-input100 validate-input" data-validate="Enter last name">
                <input class="input100" type="text" name="last-name" value="{{old('last-name')}}" placeholder="Last name">
                <span class="focus-input100"></span>
            </div>

            <label class="label-input100" for="dob-day">Date of Birth (DD/MM/YYYY)</label>
            <div class="wrap-input100 rss1-wrap-input100 validate-input" data-validate="Enter day of birth">
                <input id="dob-day" class="input100" type="tel" value="{{old('dob-day')}}" name="dob-day" placeholder="Day">
                <span class="focus-input100"></span>
            </div>
            <div class="wrap-input100 rss2-wrap-input100 validate-input" data-validate="Enter month of birth">
                <input class="input100" type="tel" name="dob-month" value="{{old('dob-month')}}" placeholder="Month">
                <span class="focus-input100"></span>
            </div>
            <div class="wrap-input100 rss2-wrap-input100 validate-input" data-validate="Enter year of birth">
                <input class="input100" type="tel" name="dob-year" value="{{old('dob-year')}}" placeholder="Year">
                <span class="focus-input100"></span>
            </div>

            <label class="label-input100" for="tel">Phone number *</label>
            <div class="wrap-input100 validate-input" data-validate = "Phone is required">
                <input id="tel" class="input100" type="tel" name="tel" value="{{old('tel')}}" placeholder="Eg. 01601234567">
                <span class="focus-input100"></span>
            </div>

            <label class="label-input100" for="occupation">Occupation</label>
            <div class="wrap-input100">
                <input id="occupation" class="input100" type="text" name="occupation" value="{{old('occupation')}}" placeholder="Optional">
                <span class="focus-input100"></span>
            </div>

            <label class="label-input100" for="stylist">Stylist</label>
            <div class="wrap-input100 validate-input" data-validate="Enter year of birth">
                <select id="stylist" class="input100" name="stylist">
                    <option value="">Select your stylist</option>
                    @foreach($stylists as $id=>$stylist)
                        <option value="{{$id}}" {{old('stylist') == $id ? 'checked' : ''}}>{{$stylist}}</option>
                    @endforeach
                </select>
                <span class="focus-input100"></span>
            </div>

            <label class="label-input100" for="remark">Remark</label>
            <div class="wrap-input100">
                <textarea id="remark" class="input100" name="remark" placeholder="Optional">{{old('remark')}}</textarea>
                <span class="focus-input100"></span>
            </div>

            <div class="container-contact100-form-btn">
                <button class="contact100-form-btn">
                    Submit
                </button>
            </div>
        </form>

        <div class="contact100-more flex-col-c-m" style="background-image: url('/new_customer/images/bg-01.jpg');">
            <div class="flex-w size1 p-b-47">
                <div class="txt1 p-r-25">
                    <span class="lnr lnr-earth"></span>
                </div>

                <div class="flex-col size2">
						<span class="txt1 p-b-20">
							Visit our website
						</span>

                    <span class="txt2">
							alphstudio.com.my
						</span>
                </div>
            </div>

        </div>
    </div>
</div>



<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
<script src="{{asset('new_customer/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('new_customer/vendor/animsition/js/animsition.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('new_customer/vendor/bootstrap/js/popper.js')}}"></script>
<script src="{{asset('new_customer/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('new_customer/vendor/select2/select2.min.js')}}"></script>
<script>
    $(".selection-2").select2({
        minimumResultsForSearch: 20,
        dropdownParent: $('#dropDownSelect1')
    });
</script>
<script src="{{asset('new_customer/js/main.js')}}"></script>
</body>
</html>
