var app = jQuery.parseJSON(app_data);

function openCigMemberList(event) {

    var url = app.app_url + 'admin/monitoring/pommc/cig-member-picker';
    var myModal = $('#member-modal');
    var modalBody = myModal.find('.content');
    modalBody.load(url);
    myModal.modal('show');
}

$(document).ready(function(){

    $('#farmer-list').change(function () {console.log("tt");
        let app_locale = app.app_locale;
        
        var farmerId = $(this).val();
        if (farmerId) {
            $.get(app.app_url + 'admin/farmers/farmerInfoBuyId/' + farmerId, function (response) {
                if(response.error == 0) {
                    $('#father').val(response.data.father_name);
                    $('#mother').val(response.data.mother_name);
                    $('#dob').val(response.data.date_of_birth);
                    $('#spouse_name').val(response.data.spouse_name);
                    $('#village').val(response.data.village);
                    $('#mobile').val(response.data.mobile_no);
                    $('#gender').val(response.data.gender).trigger('change');
                    $('#nid').val(response.data.nid);
                    $("#is_ethnic-" + response.data.is_ethnic).prop("checked", true); 
                }
            });
        }
    });
});