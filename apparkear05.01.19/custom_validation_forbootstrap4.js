$(document).ready(function(){
    
    $("#forget_form").on("submit",function(){ //alert("xdgfjdfhg");exit;
        var user_pass = $("#user_pass").val();
        var cnf_password = $("#cnf_password").val();
        var is_valid_pass = validate_password(user_pass);
        var is_valid_cnf_pass = validate_password(cnf_password);
        
        var valid = true;

        if(is_valid_pass == 0){
            $(".error-div-pass").html("this field can not be empty"); 
            $(".error-div-pass").css('display','block');
            setTimeout(function(){ 

             $(".error-div-pass").fadeOut();
             },1500);
             $("#user_pass").focus();
             valid = false;
          
        }else if(is_valid_pass == 2){
            $(".error-div-pass").html("Password must be 8 characters with one uppercase, one lowercase, one number value & one special charecter"); 
            $(".error-div-pass").css('display','block');
            setTimeout(function(){ 

             $(".error-div-pass").fadeOut();
             },1500);
             $("#user_pass").focus();
             valid = false;
          
        }
        if(is_valid_cnf_pass == 0){
            $(".error-div-cnfpass").html("this field can not be empty");
            $(".error-div-cnfpass").css('display','block');
             setTimeout(function(){ 

             $(".error-div-cnfpass").fadeOut();
             },1500);
             $("#cnf_password").focus();
            valid = false;
        }
        else if(is_valid_cnf_pass == 2){
            $(".error-div-cnfpass").html("Confirm Password must be 8 characters with one uppercase, one lowercase, one number value & one special charecter");
            $(".error-div-cnfpass").css('display','block');
             setTimeout(function(){ 

             $(".error-div-cnfpass").fadeOut();
             },1500);
             $("#cnf_password").focus();
            valid = false;
        }

        if(is_valid_pass == 1 && is_valid_cnf_pass == 1){
           
            var is_same = check_password_validation(user_pass,cnf_password);
            if(is_same == 0){
                
                $(".error-div-cnfpass").html("The password and its confirm password are not the same"); 
                $(".error-div-cnfpass").css('display','block');
                 setTimeout(function(){ 

             $(".error-div-cnfpass").fadeOut();
             },1500);
            $("#user_pass").focus();
             valid = false;
             
            }
        }
        
        if(valid) {
            return true;
        } else {
            if (is_valid_pass == 0 || is_valid_pass == 2) {
                $('#user_pass').focus();
            } else if (is_valid_cnf_pass == 0 || is_valid_cnf_pass == 2) {
                $('#cnf_password').focus();
            } else if (is_valid_pass == 1 || is_valid_pass == 1) {
                $('#user_pass').focus();
            } 
            return false;
        }
        
       });
       
       $("#renter_edit_form").on("submit",function(){ //alert("xdgfjdfhg");return false;
            var first_name = $("#first_name").val();
            var last_name = $("#last_name").val();
            var country_list = $("#country_list").val();
            var states_list = $("#states_list").val();
            var city_list = $("#city_list").val();
            var datetimepicker1 = $("#datetimepicker1").val();
            var user_pass = $("#user_pass").val();
            var confirm_phone_id = validate_phone($("#confirm_phone_id").val());
            var is_valid_pass = validate_password(user_pass);
            var is_valid_fname = validate_name(first_name);
            var is_valid_lname = validate_name(last_name);
            var valid = true;
            //alert(confirm_phone_id);return false;
            if(is_valid_fname == 0){
                $(".error-div-fname").html("this field can not be empty"); 
                $(".error-div-fname").css('display','block');
                setTimeout(function(){ 

                 $(".error-div-fname").fadeOut();
                 },1500);
                  valid = false;
                  
            }else if(is_valid_fname == 2){
                $(".error-div-fname").html("It should contain only alphabates"); 
                $(".error-div-fname").css('display','block');
                setTimeout(function(){ 

                 $(".error-div-fname").fadeOut();
                 },1500);
                  valid = false;
                  
            }
            if(is_valid_lname == 0){
                $(".error-div-lname").html("this field can not be empty"); 
                $(".error-div-lname").css('display','block');
                setTimeout(function(){ 

                 $(".error-div-lname").fadeOut();
                 },1500);
                  valid = false;
                  
            }else if(is_valid_lname == 2){
                //$(".error-div-lname").html("It should contain '+' then countrycode then number"); 
                $(".error-div-lname").html("It should contain only alphabates"); 
                $(".error-div-lname").css('display','block');
                setTimeout(function(){ 

                 $(".error-div-lname").fadeOut();
                 },1500);
                  valid = false;
                  
            }
            if(confirm_phone_id == 0){
                $(".error-div-phone").html("this field can not be empty"); 
                $(".error-div-phone").css('display','block');
                setTimeout(function(){ 

                 $(".error-div-phone").fadeOut();
                 },1500);
                 valid = false;
            }else if(confirm_phone_id == 2){
                $(".error-div-phone").html("It should contain '+' then countrycode then number"); 
                $(".error-div-phone").css('display','block');
                setTimeout(function(){ 

                 $(".error-div-phone").fadeOut();
                 },1500);
                 valid = false;
            }
            if(country_list == ""){
                $(".error-div-country").html("Country must be selected"); 
                $(".error-div-country").css('display','block');
                setTimeout(function(){ 

                 $(".error-div-country").fadeOut();
                 },1500);
                 valid = false;

            }
            if(states_list == ""){
                $(".error-div-state").html("State must be selected"); 
                $(".error-div-state").css('display','block');
                setTimeout(function(){ 

                 $(".error-div-state").fadeOut();
                 },1500);
                 valid = false;

            }
            if(city_list == ""){
                $(".error-div-city").html("City must be selected"); 
                $(".error-div-city").css('display','block');
                setTimeout(function(){ 

                 $(".error-div-city").fadeOut();
                 },1500);
                 valid = false;

            }
            if(datetimepicker1 == ""){
                $(".error-div-dob").html("Date of Birth is required"); 
                $(".error-div-dob").css('display','block');
                setTimeout(function(){ 

                 $(".error-div-dob").fadeOut();
                 },1500);
                 valid = false;

            }
//            else 
                if(is_valid_pass == 2){
                $(".error-div-pass").html("Password must be 8 characters with one uppercase, one lowercase, one number value & one special charecter"); 
                $(".error-div-pass").css('display','block');
                setTimeout(function(){ 

                 $(".error-div-pass").fadeOut();
                 },1500);
                 valid = false;

            }
            
            if(valid) {
                return true;
            } else {
                if (is_valid_fname == 0 || is_valid_fname == 2) {
                    $('#first_name').focus();
                } else if (is_valid_lname == 0 || is_valid_lname == 2) {
                    $('#last_name').focus();
                } else if (confirm_phone_id == 0 || confirm_phone_id == 2) {
                    $('#confirm_phone_id').focus();
                } else if (country_list == '') {
                    $('#country_list').focus();
                } else if (states_list == '') {
                    $('#states_list').focus();
                } else if (city_list == '') {
                    $('#city_list').focus();
                } else if (datetimepicker1 == '') {
                    $('#datetimepicker1').focus();
                } else if (is_valid_pass == 2) {
                    $('#user_pass').focus();
                }
                return false;
            }
            
            
        }); 
    
    $("#rent_step1").on("submit",function(){
        var first_name = $("#first_name").val();
        var last_name = $("#last_name").val();
        var email = $("#email").val();
        var phone = $("#phone1").val();
        var mobile = $("#mobile").val();
        var is_valid_fname = validate_name(first_name);
        var is_valid_lname = validate_name(last_name);
        var is_valid_mail = validate_mail(email);
        var is_valid_phone = validate_phone(phone);
        var is_valid_mobile = validate_phone(mobile); 
        
        
        var valid = true;   
        
        if(is_valid_fname == 0){
            $(".error-div-fname").html("this field can not be empty"); 
            $(".error-div-fname").css('display','block');
            setTimeout(function(){ 

            $(".error-div-fname").fadeOut();
            },1500);
              valid = false;
        }else if(is_valid_fname == 2){
            $(".error-div-fname").html("It should contain only alphabates"); 
            $(".error-div-fname").css('display','block');
            setTimeout(function(){ 

             $(".error-div-fname").fadeOut();
             },1500);
              valid = false;
        }
        
            if(is_valid_lname == 0){
                $(".error-div-lname").html("this field can not be empty"); 
                $(".error-div-lname").css('display','block');
                setTimeout(function(){ 

                 $(".error-div-lname").fadeOut();
                 },1500);
                  valid = false;
            }else if(is_valid_lname == 2){
                //$(".error-div-lname").html("It should contain '+' then countrycode then number"); 
                $(".error-div-lname").html("It should contain only alphabates"); 
                $(".error-div-lname").css('display','block');
                setTimeout(function(){ 

                 $(".error-div-lname").fadeOut();
                 },1500);
                  valid = false;
            }
            
            if(is_valid_mail == 0){
            $(".error-div-email").html("this field can not be empty");
            $(".error-div-email").css('display','block');
             setTimeout(function(){ 

             $(".error-div-email").fadeOut();
             },1500);
            valid = false;
        }
        else if(is_valid_mail == 2){
            $(".error-div-email").html("Please Enter a valid email");
            $(".error-div-email").css('display','block');
             setTimeout(function(){ 

             $(".error-div-email").fadeOut();
             },1500);
            valid = false;
        }
        
        if(is_valid_phone == 0){
            $(".error-div-telephone").html("this field can not be empty");
            $(".error-div-telephone").css('display','block');
             setTimeout(function(){ 

             $(".error-div-telephone").fadeOut();
             },1500);
            valid = false;
        }
        else if(is_valid_phone == 2){
            $(".error-div-telephone").html("phone number must contain with country code");
            $(".error-div-telephone").css('display','block');
             setTimeout(function(){ 

             $(".error-div-telephone").fadeOut();
             },1500);
            valid = false;
        }
        
        
        if(is_valid_mobile == 0){
            $(".error-div-mobile").html("this field can not be empty");
            $(".error-div-mobile").css('display','block');
             setTimeout(function(){ 

             $(".error-div-mobile").fadeOut();
             },1500);
            valid = false;
        }
        else if(is_valid_mobile == 2){
            $(".error-div-mobile").html("mobile number must contain with country code");
            $(".error-div-mobile").css('display','block');
             setTimeout(function(){ 

             $(".error-div-mobile").fadeOut();
             },1500);
            valid = false;
        }
        
        if(valid) {
          
            return true;
        } else {
            if (is_valid_fname == 0 || is_valid_fname == 2) {
                $('#first_name').focus();
            } else if (is_valid_lname == 0 || is_valid_lname == 2) {
                $('#last_name').focus();
            } else if (is_valid_mail == 0 || is_valid_mail == 2) {
                $('#email').focus();
            } else if (is_valid_phone == 0 || is_valid_phone == 2) {
                $('#phone1').focus();
            } else if (is_valid_mobile == 0 || is_valid_mobile == 2) {
                $('#mobile').focus();
            }
            return false;
        }
    });   
       
    $("#passchngForm").on("submit",function(){ //alert("xdgfjdfhg");exit;
        var user_pass = $("#user_pass").val();
        var cnf_password = $("#cnf_password").val();
        var old_pass = $("#old_pass").val();
        var is_valid_pass = validate_password(user_pass);
        var is_valid_cnf_pass = validate_password(cnf_password);
        var is_valid_old_pass = validate_password(old_pass);
        
        var valid = true;

        if(is_valid_old_pass == 0){
            $(".error-div-crntpass").html("this field can not be empty"); 
            $(".error-div-crntpass").css('display','block');
            setTimeout(function(){ 

             $(".error-div-crntpass").fadeOut();
             },1500); 
             valid = false;
          
        }else if(is_valid_old_pass == 2){
            $(".error-div-crntpass").html("Current Password must be 8 characters with one uppercase, one lowercase, one number value & one special charecter"); 
            $(".error-div-crntpass").css('display','block');
            setTimeout(function(){ 

             $(".error-div-crntpass").fadeOut();
             },1500); 
             valid = false;
          
        }
        if(is_valid_pass == 0){
            $(".error-div-pass").html("this field can not be empty"); 
            $(".error-div-pass").css('display','block');
            setTimeout(function(){ 

             $(".error-div-pass").fadeOut();
             },1500);
             valid = false;
          
        }else if(is_valid_pass == 2){
            $(".error-div-pass").html("Password must be 8 characters with one uppercase, one lowercase, one number value & one special charecter"); 
            $(".error-div-pass").css('display','block');
            setTimeout(function(){ 

             $(".error-div-pass").fadeOut();
             },1500); 
             valid = false;
          
        }
        if(is_valid_cnf_pass == 0){
            $(".error-div-cnfpass").html("this field can not be empty");
            $(".error-div-cnfpass").css('display','block');
             setTimeout(function(){ 

             $(".error-div-cnfpass").fadeOut();
             },1500);
            valid = false;
        }
        else if(is_valid_cnf_pass == 2){
            $(".error-div-cnfpass").html("Confirm Password must be 8 characters with one uppercase, one lowercase, one number value & one special charecter");
            $(".error-div-cnfpass").css('display','block');
             setTimeout(function(){ 

             $(".error-div-cnfpass").fadeOut();
             },1500);
            valid = false;
        }

        if(is_valid_pass == 1 && is_valid_cnf_pass == 1){
           
            var is_same = check_password_validation(user_pass,cnf_password);
            if(is_same == 0){
                
                $(".error-div-cnfpass").html("The password and its confirm password are not the same"); 
                $(".error-div-cnfpass").css('display','block');
                 setTimeout(function(){ 

             $(".error-div-cnfpass").fadeOut();
             },1500);
            $("#user_pass").focus();
             valid = false;
            }
        }
        
        if(valid) {
            return true;
        } else {
            if (is_valid_old_pass == 0 || is_valid_old_pass == 2) {
                $('#old_pass').focus();
            } else if (is_valid_pass == 0 || is_valid_pass == 2) {
                $('#user_pass').focus();
            } else if (is_valid_cnf_pass == 0 || is_valid_cnf_pass == 2) {
                $('#cnf_password').focus();
            }  else if (is_valid_pass == 1 || is_valid_cnf_pass == 1) {
                $('#user_pass').focus();
            }
            return false;
        }
        
       });
    $("#booking_step2").on("submit",function(){ //alert("xdgfjdfhg");return false;
        var holder_name = $("#holder_name").val();
        var card_number = $("#card_number").val();
        var exp_month = $("#exp_month").val();
        var exp_year = $("#exp_year").val();
        var cvv = $("#cvv").val();
        //alert(cvv.length);
        //alert(exp_month); return false;
        //var is_valid_pass = validate_password(user_pass);
        //var is_valid_cnf_pass = validate_password(cnf_password);
       // var is_valid_old_pass = validate_password(old_pass);
        
        var valid = true;

        if(holder_name == ""){
            $(".error-div-holdername").html("this field can not be empty"); 
            $(".error-div-holdername").css('display','block');
            setTimeout(function(){ 

             $(".error-div-holdername").fadeOut();
             },1500);
             
             valid = false;
          
        } if(card_number == ""){
            $(".error-div-cardnumber").html("this field can not be empty"); 
            $(".error-div-cardnumber").css('display','block');
            setTimeout(function(){ 

             $(".error-div-cardnumber").fadeOut();
             },1500);
             
             valid = false;
          
        }
        if(card_number.length >16){
            $(".error-div-cardnumber").html("Maximum 16 digit allows"); 
            $(".error-div-cardnumber").css('display','block');
            setTimeout(function(){ 

             $(".error-div-cardnumber").fadeOut();
             },1500);
             
             valid = false;
        }
        if(exp_month == ''){
            $(".error-div-expmonth").html("this field can not be empty"); 
            $(".error-div-expmonth").css('display','block');
            setTimeout(function(){ 

             $(".error-div-expmonth").fadeOut();
             },1500);
             
             valid = false;
          
        } if(exp_year == ""){
            $(".error-div-expyear").html("this field can not be empty"); 
            $(".error-div-expyear").css('display','block');
            setTimeout(function(){ 

             $(".error-div-expyear").fadeOut();
             },1500);
             
             valid = false;
          
        }
        if(cvv == ""){
            $(".error-div-cvv").html("this field can not be empty");
            $(".error-div-cvv").css('display','block');
             setTimeout(function(){ 

             $(".error-div-cvv").fadeOut();
             },1500);
            valid = false;
        }
        if(cvv.length > 3){
            $(".error-div-cvv").html("Must be three number");
            $(".error-div-cvv").css('display','block');
             setTimeout(function(){ 

             $(".error-div-cvv").fadeOut();
             },1500);
            valid = false;
        }
        

        if(holder_name != '' && card_number != '' && exp_month != '' && exp_year != '' && cvv !=''){
           
           valid = true;
            
        }
        
        if(valid) {
            return true;
        } else {
            return false;
        }
        
       });
       
    $("#general_info").on("submit",function(){
        var car_type = $("#car_type").val();
        var country = $("#country_list").val();
        var state = $("#states_list").val();
        var city = $("#city_list").val();
        //alert(state);
        var valid = true;

        if(car_type == ""){
            $(".error-div-car_type").html("this field can not be empty"); 
            $(".error-div-car_type").css('display','block');
            setTimeout(function(){ 

             $(".error-div-car_type").fadeOut();
             },1500); 
             valid = false;
          
        } 
        if(country == ""){
            $(".error-div-country").html("this field can not be empty"); 
            $(".error-div-country").css('display','block');
            setTimeout(function(){ 

             $(".error-div-country").fadeOut();
             },1500); 
             valid = false;
          
        } 
        if(state == ""){
            $(".error-div-state").html("this field can not be empty"); 
            $(".error-div-state").css('display','block');
            setTimeout(function(){ 

             $(".error-div-state").fadeOut();
             },1500);
             valid = false;
          
        } 
        if(city == ""){
            $(".error-div-city").html("this field can not be empty"); 
            $(".error-div-city").css('display','block');
            setTimeout(function(){ 

             $(".error-div-city").fadeOut();
             },1500); 
             valid = false;
          
        } 
        
        
        if(valid) {
            return true;
        } else {
            if (car_type == '') {
                $('#car_type').focus();
            } else if (country == '') {
                $('#country_list').focus();
            } else if (state == '') {
                $('#states_list').focus();
            } else if (city == '') {
                $('#city_list').focus();
            }
            return false;
        }
        
        
        
    });
       
       
        
    $("#payment_step1").on("submit",function(){ //alert("xdgfjdfhg");return false;
        var first_name = $("#first_name").val();
        var last_name = $("#last_name").val();
        var email = $("#email").val();
        var telephone = $("#telephone").val();
        var gender = $("#gender").val();
        var dob_day = $("#dob_day").val();
        var dob_month = $("#dob_month").val();
        var dob_year = $("#dob_year").val();
        var about_you = $("textarea").val();
        var terms_n_cond1 = $("#terms_n_cond1:checked").length;
        var terms_n_cond2 = $("#terms_n_cond2:checked").length;
        
        var is_valid_mail = validate_mail(email);
        var is_valid_phone = validate_phone(telephone);
      // alert($("textarea").val()); return false;
        //var is_valid_pass = validate_password(user_pass);
        //var is_valid_cnf_pass = validate_password(cnf_password);
       // var is_valid_old_pass = validate_password(old_pass);
        
        var valid = true;

        if (terms_n_cond2 < 1) {
            $(".error-div-terms_n_cond").html("this field can not be empty");
            $(".error-div-terms_n_cond").css('display', 'block');
            setTimeout(function () {

                $(".error-div-terms_n_cond").fadeOut();
            }, 1500);

            valid = false;
        }

        if (terms_n_cond1 < 1) {
            $(".error-div-tnc1").html("this field can not be empty");
            $(".error-div-tnc1").css('display', 'block');
            setTimeout(function () {

                $(".error-div-tnc1").fadeOut();
            }, 1500);

            valid = false;
        }

        if(first_name == ""){
            $(".error-div-first_name").html("this field can not be empty"); 
            $(".error-div-first_name").css('display','block');
            setTimeout(function(){ 

             $(".error-div-first_name").fadeOut();
             },1500);
             
             valid = false;
          
        } 
        if(last_name == ""){
            $(".error-div-last_name").html("this field can not be empty"); 
            $(".error-div-last_name").css('display','block');
            setTimeout(function(){ 

             $(".error-div-last_name").fadeOut();
             },1500);
             
             valid = false;
          
        } 
        
        if(is_valid_mail == 0){
            $(".error-div-email").html("this field can not be empty");
            $(".error-div-email").css('display','block');
             setTimeout(function(){ 

             $(".error-div-email").fadeOut();
             },1500);
            valid = false;
        }
        else if(is_valid_mail == 2){
            $(".error-div-email").html("Please Enter a valid email");
            $(".error-div-email").css('display','block');
             setTimeout(function(){ 

             $(".error-div-email").fadeOut();
             },1500);
            valid = false;
        }
        
        if(is_valid_phone == 0){
            $(".error-div-telephone").html("this field can not be empty");
            $(".error-div-telephone").css('display','block');
             setTimeout(function(){ 

             $(".error-div-telephone").fadeOut();
             },1500);
            valid = false;
        }
        else if(is_valid_phone == 2){
            $(".error-div-telephone").html("phone number must contain with country code");
            $(".error-div-telephone").css('display','block');
             setTimeout(function(){ 

             $(".error-div-telephone").fadeOut();
             },1500);
            valid = false;
        }
        
        
        if(gender == ""){
            $(".error-div-gender").html("this field can not be empty"); 
            $(".error-div-gender").css('display','block');
            setTimeout(function(){ 

             $(".error-div-gender").fadeOut();
             },1500);
             
             valid = false;
          
        }
        if(dob_day == ''){
            $(".error-div-dob_day").html("this field can not be empty"); 
            $(".error-div-dob_day").css('display','block');
            setTimeout(function(){ 

             $(".error-div-dob_day").fadeOut();
             },1500);
             
             valid = false;
          
        } if(dob_month == ""){
            $(".error-div-dob_month").html("this field can not be empty"); 
            $(".error-div-dob_month").css('display','block');
            setTimeout(function(){ 

             $(".error-div-dob_month").fadeOut();
             },1500);
             
             valid = false;
          
        }
        if(dob_year == ""){
            $(".error-div-dob_year").html("this field can not be empty");
            $(".error-div-dob_year").css('display','block');
             setTimeout(function(){ 

             $(".error-div-dob_year").fadeOut();
             },1500);
            valid = false;
        }
        if(about_you == ""){
            $(".error-div-about_you").html("this field can not be empty");
            $(".error-div-about_you").css('display','block');
             setTimeout(function(){ 

             $(".error-div-about_you").fadeOut();
             },1500);
            valid = false;
        }
        

        if( is_valid_mail == 1 && is_valid_phone == 1 && first_name != '' && last_name != '' && gender != '' && dob_day != '' && dob_month != '' && dob_year != '' && about_you !=''){
           
           valid = true;
            
        }
        
        if(valid) {
            return true;
        } else {
            if (first_name == '') {
                $('#first_name').focus();
            } else if (last_name == '') {
                $('#last_name').focus();
            } else if (is_valid_mail == 0 || is_valid_mail == 2) {
                $('#email').focus();
            } else if (is_valid_phone == 0 || is_valid_phone == 2) {
                $('#telephone').focus();
            } else if (gender == '') {
                $('#gender').focus();
            } else if (dob_day == '') {
                $('#dob_day').focus();
            } else if (dob_month == '') {
                $('#dob_month').focus();
            } else if (dob_year == '') {
                $('#dob_year').focus();
            } else if (about_you == '') {
                $('#textarea').focus();
            }
            return false;
        }
        
       });
   });
function check_password_validation(pass, cnfpass){
    if(pass && cnfpass){
        if(pass == cnfpass){
            return 1;
        }else{
            return 0;
        }

    }else{
        return 0;
    }
}
       
function validate_password(get_pass){
    //alert(get_pass);
     var regex = "^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,20}$";
     
     if(get_pass != ""){
        if (get_pass.match(regex)) {

            return 1;
        }else{
            return 2;
        }
    }else{
        return 0;
    }
}

function validate_mail(get_email){
    var regex = "^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$";
    
    if(get_email != ""){
        if(get_email.match(regex)){
            return 1;
        }else{
            return 2;
        }
    }else{
        return 0;
    }
    
}

function validate_phone(get_telephone){
    //var regex = "^([0|\+[0-9]{1,5})?([7-9][0-9]{9})$";
    var regex = "^([0|\+[0-9]{1,5})?([7-9][0-9])$";
    
    if(get_telephone != ""){
        if(get_telephone.match(regex)){
            return 1;
        }else{
            return 2;
        }
    }else{
        return 0;
    }
}

function validate_name(get_name){
    var regex = "^[a-zA-Z ]*$";
    
    if(get_name != ""){
        if(get_name.match(regex)){
            return 1;
        }else{
            return 2;
        }
    }else{
        return 0;
    }
}