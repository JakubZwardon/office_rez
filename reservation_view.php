<?php
include("includes/header.php");

?>
<div class="new_reservation column">
	<input type="submit" class="btn btn-primary" data-toggle="modal" data-target="#new_reservation_modal" value="Dokonaj rezerwacji!">
</div>

<div class="main_column column">

    <div class="reservation_area"></div>
    <img id="loading" style="height: 40px" src="assets/images/icons/loading.gif" />
</div>

<!-- make a reservation Modal -->
<div class="modal fade" id="new_reservation_modal" tabindex="-1" role="dialog" aria-labelledby="postModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Podaj dane rezerwacji</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
	  </div>
	  
      <div class="modal-body">		  
		  <form action="" class="new_reservation_date_form" id="new_reservation_modal_form" method="POST">
			  <div class="form-group">
                  <input class="form-control" type="text" name="add_res_fname" placeholder="Imię" required>
                  <input class="form-control" type="text" name="add_res_lname" placeholder="Nazwisko" required>
                  <input class="form-control" type="email" name="add_res_mail" placeholder="E-mail" required>
                  <input class="form-control" type="tel" name="add_res_phone" placeholder="Telefon 123-456-789" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}" required>                  
                  <textarea class="form-control" name="add_res_description" placeholder="Opis" required></textarea>
                  <input class="form-control" type="text" name="add_res_workspace" placeholder="Nazwa stanowiska" required>
                  <div class="invalid-input" id="add_res_ws_name_invalid"></div>
                  <label for="add_res_from_date">Początek rezerwacji</label>
                  <input class="form-control" type="date" name="add_res_from_date" id="add_res_from_date" required>
                  <input class="form-control" type="time" name="add_res_from_time" required>
                  <label for="add_res_to_date">Koniec rezerwacji</label>
                  <input class="form-control" type="date" name="add_res_to_date" id="add_res_to_date" required>
                  <input class="form-control" type="time" name="add_res_to_time" required>
                  <div class="invalid-input" id="add_res_date_invalid"></div>
			  </div>			
		  </form>
	  </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="add_reservation_button" id="add_reservation" form="new_reservation_modal_form">Zarezerwuj</button>
      </div>
    </div>
  </div>
</div>

<script>

$(document).ready(function() {
	$('#loading').show();

	//Original Ajax request for loading first reservations
	$.ajax({
		url: "includes/handlers/ajax_load_reservations.php", 
		type: "POST",
		data: "page=1",
		cache: false,

		success: function(data) {
			$('#loading').hide();
			$('.reservation_area').html(data);			
		}
	});

	$(window).scroll(function() {
		let height = $('.reservation_area').height();
		let scrollTop = $(this).scrollTop();
		let page = $('.reservation_area').find('.next_page').val();
		let noMoreReservations = $('.reservation_area').find('.no_more_workplaces').val();

		if((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && (noMoreReservations == 'false')) {
			$('#loading').show();

			let ajaxReq = $.ajax({
				url: "includes/handlers/ajax_load_reservations.php",
				type: "POST",
				data: "page=" + page,
				cache: false,

				success: function(response) {
					$('.reservation_area').find('.next_page').remove();	//removes current next page
					$('.reservation_area').find('.no_more_reservations').remove();

					$('#loading').hide();
					$('.reservation_area').append(response);					
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