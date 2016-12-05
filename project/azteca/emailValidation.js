$(function(){


	$.validator.addMethod('rightemail',function(value,element){
		return this.optional(element) || /^[a-zA-Z0-9\._\-]+[@][a-zA-Z]*[\.](com|gov|edu|org|mil|net)$/g.test(value);
	},'Not a valid email address format')

	 $("#form1").validate({
          rules:{
          	email:{
          		required:true,
          		rightemail:true
          	}
          },
          messages:{
          	email:{
          		required:'Please enter a email address.',
          		email: 'Please enter valid email address format'
          	}
          }



	 });

});