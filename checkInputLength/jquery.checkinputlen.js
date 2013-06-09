/*
 * inputObj -- the inputbox jquery object need to check
 * txtObj   -- the Oop text tips jquery object
 * ctrlObj  -- the hidden control inputbox jquery object
 * limitLen -- the limit length
 */
;(function($){
	$.extend({
		"checkInputLen": function(inputObj, txtObj, ctrlObj, limitLen) {
			inputObj.keydown(function(){
				chkLength();
			});
			inputObj.keyup(function(){
				chkLength();
			});
			function chkLength(){
				if(inputObj.val().length < limitLen){
					txtObj.html('Less than '+limitLen+' words');
					ctrlObj.val(0);
				} else {
					txtObj.html('');
					ctrlObj.val(1);
				}
			}
		}
	});
})(jQuery)