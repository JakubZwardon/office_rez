<?php
include("includes/header.php");
include("includes/classes/workspace.php");

?>

<div class="main_column column">
    <div class="management_area">
		<input type="submit" class="btn btn-primary" data-toggle="modal" data-target="#workspace_modal" value="Dodaj Stanowisko pracy">
        <input type="submit" class="btn btn-primary" data-toggle="modal" data-target="#equipment_modal" value="Dodaj sprzęt">
    </div>

	<div class="workplace_area"></div>
    <img id="loading" style="height: 40px" src="assets/images/icons/loading.gif" />
</div>

<!-- Add workspace modal Modal -->
<div class="modal fade" id="workspace_modal" tabindex="-1" role="dialog" aria-labelledby="postModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Podaj dane nowego stanowiska pracy</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
	  </div>
	  
      <div class="modal-body">		  
		  <form action="" class="new_workstation_date_form" id="modal_form" method="POST">
			  <div class="form-group">
				  <input class="form-control" type="text" name="add_ws_name" placeholder="Nazwa własna stanowiska pracy" required>
				  <textarea class="form-control" name="add_ws_description" placeholder="Opis" required></textarea>		
			  </div>			
		  </form>
	  </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="add_workstation_button" id="add_workstation" form="modal_form">Dodaj</button>
      </div>
    </div>
  </div>
</div>

<!-- Add equipment modal Modal -->
<div class="modal fade" id="equipment_modal" tabindex="-1" role="dialog" aria-labelledby="postModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Podaj dane nowege sprzętu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
	  </div>
	  
      <div class="modal-body">		  
		  <form action="" class="new_equipment_date_form" id="add_equipment_modal_form" method="POST">
			  <div class="form-group">
				  <input class="form-control" type="text" name="add_equip_name" placeholder="Nazwa własna" required>
				  <input class="form-control" type="text" name="add_equip_type" placeholder="Rodzaj" required>
				  <input class="form-control" type="text" name="add_equip_model" placeholder="Model" required>
				  <input class="form-control" type="number" name="add_equip_value" placeholder="Wartość pln" required>
				  <label for="add_equip_date">Data zakupu</label>
				  <input class="form-control" type="date" name="add_equip_date" id="add_equip_date" placeholder="Data zakupu" required>
				  <input class="form-control" type="text" name="add_equip_ws_name" placeholder="Nazwa stanowiska do którego ma być przypisany sprzęt" required>
				  <div class="invalid-input" id="add_equip_ws_name_invalid"></div>
				  <textarea class="form-control" name="add_equip_description" placeholder="Opis" required></textarea>		
			  </div>			
		  </form>
	  </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="add_equipment_button" id="add_equipment" form="add_equipment_modal_form">Dodaj</button>
      </div>
    </div>
  </div>
</div>

<script>

$(document).ready(function() {
	$('#loading').show();

	//Original Ajax request for loading first reservations
	$.ajax({
		url: "includes/handlers/ajax_load_workspaces.php", 
		type: "POST",
		data: "page=1",
		cache: false,

		success: function(data) {
			$('#loading').hide();
			$('.workplace_area').html(data);			
		}
	});

	$(window).scroll(function() {
		let height = $('.workplace_area').height();
		let scrollTop = $(this).scrollTop();
		let page = $('.workplace_area').find('.next_page').val();
		let noMoreWorkspaces = $('.workplace_area').find('.no_more_workplaces').val();

		if((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && (noMoreWorkspaces == 'false')) {
			$('#loading').show();

			let ajaxReq = $.ajax({
				url: "includes/handlers/ajax_load_workspaces.php",
				type: "POST",
				data: "page=" + page,
				cache: false,

				success: function(response) {
					$('.workplace_area').find('.next_page').remove();	//removes current next page
					$('.workplace_area').find('.no_more_workplaces').remove();

					$('#loading').hide();
					$('.workplace_area').append(response);					
				}
			});
		}	//end if

		return false;
	});		//end $(window).scroll(function()

});

</script>

<!-- closing div from header file -->
</div>
</body>

</html>