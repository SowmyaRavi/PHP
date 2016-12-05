$(function(){

    $.validator.addMethod('rightemail',function(value,element){
        return this.optional(element) || /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[com|gov|edu|org|mil|net|in]{2,4}$/g.test(value);
    },'Not a valid email address format')
    { 
            $("#register").validate({
                rules: {
                    fname: "required",
                    lname: "required",
                    dob:"required",
                   
                    email: {
                        required:true,
                        rightemail: true,
                    },
                    password1: {
                        required:true,
                        minlength: 6
                    },
                    
                },
                messages: {
                    fname: "Please enter your firstname",
                    lname: "Please enter your lastname",
                    dob: "Please enter date of birth",
                
                    email:{
                        required:"Please enter email address",
                        rightemail: 'Please enter valid email address format',
                    },

                    password1:{
                        required:"Please enter password",
                        minlength: 'Atleast it should be 6 characters'
                    },
                },
            }); 
} 

});