$(document).ready(function() {
    //Submit add workspace
    $('#modal_form').submit(function() {
        $.ajax({
            method: "POST",
            url: "includes/handlers/ajax_add_new_workspace.php",
            data: $('form.new_workstation_date_form').serialize(),
            success: function() {
                $("#workspace_modal").modal('hide');
                location.reload();
            },
            error: function() {
                alert('failure');
            }
        });
        return false;
    });
    
    //submit add equipment
    $('#add_equipment_modal_form').submit(function() {
        $.ajax({
            method: "POST",
            url: "includes/handlers/ajax_add_new_equipment.php",
            data: $('form.new_equipment_date_form').serialize(),
            success: function(msg) {
                if(msg == "BadWsName") {
                    $('#add_equip_ws_name_invalid').html("Proszę wprowadź poprawną nazwę stanowiska!");
                } else {
                    $("#equipment_modal").modal('hide');
                    location.reload();
                }
            },
            error: function() {
                alert('failure');
            }
        });
        return false;
    });

    //submit add reservation button
    $('#new_reservation_modal_form').submit(function() {
        debugger;
        $.ajax({
            method: "POST",
            url: "includes/handlers/ajax_add_new_reservation.php",
            data: $('form.new_reservation_date_form').serialize(),
            success: function(msg) {
                if(msg == "BadWsName") {
                    debugger;
                    $('#add_res_ws_name_invalid').html("Proszę wprowadź poprawną nazwę stanowiska!");
                } else if(msg == "DateTaken") {
                    debugger;
                    $('#add_res_date_invalid').html("Podany termin jest zajęty!");
                } else {
                    debugger;
                    $("#new_reservation_modal").modal('hide');
                    location.reload();
                }
            },
            error: function() {
                alert('failure');
            }
        });
        return false;
    });
});