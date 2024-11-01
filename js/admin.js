jQuery(function($){
   
  $('.moreval').on('click', function(e){

	 var $table = $(this).attr('rel');
	 var $targetItem = $('#' + $table + ' tr:last');
	 var $lastItem = $targetItem.clone().insertAfter($targetItem);
	 $('input', $lastItem).val('');
	 $('option:first', $lastItem).attr('selected', 'selected');
	 loadActionRemove();

	 return false;

  });
  

  function loadActionRemove() {

	$('.lesskeyval').off().on('click', function(e){
		
	   var $table = $(this).closest('table').attr('id');
		
	   if ( $('#' + $table + ' tr').length > 2 ) {
	     $(this).closest('tr').remove();
	   } else {
		 $('#' + $table + ' tr td input').val(''); 
		 $('#' + $table + ' tr td select option:first').attr('selected', 'selected'); 
	   }

	   return false;

	});

  } 


  loadActionRemove();

});