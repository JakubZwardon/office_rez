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
});