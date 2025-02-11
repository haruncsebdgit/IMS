$(document).ready(function() {

    let app = jQuery.parseJSON(app_data);
    //console.log(selectedId);
    
    if ($('.treeview-animated').length > 0) {
        $('.treeview-animated').mdbTreeview();
    }
    

    if(isShowCheckbox) {
        $('.organogram-jstree').jstree({
            "plugins" : [ "checkbox" ]
          });
    } else {
        $('.organogram-jstree').jstree();
    }
    //console.log($_javascript_data);
    if(selectedId && typeof selectedId != 'undefined') {
        $('.organogram-jstree').jstree('select_node', selectedId);
    }
      $('.organogram-jstree')
        // listen for event
        .on('changed.jstree', function (e, data) {
            var i, j, r = [];
            //alert(data.selected.length);
            if(data.selected.length == 1) {
                //$.whatever();
                //alert(data.instance.get_node(data.selected[0]).text);
                getOrganogramId(data.instance.get_node(data.selected[0]).id, data.instance.get_node(data.selected[0]).text);
            } 
            $('#organogram-ids').html('');
            for(i = 0, j = data.selected.length; i < j; i++) {
                //alert(data.instance.get_node(data.selected[i]).text);
                var organogramId = data.instance.get_node(data.selected[i]).id;
                //alert($(".organogram-id-"+organogramId).length);
                if ($(".organogram-id-"+organogramId).length <= 0) {
                    //checkbox exists
                    $('#organogram-ids').append('<input type="hidden" name="organogram_ids[]" value="' + organogramId + '">')
                }
                //r.push(data.instance.get_node(data.selected[i]).text);
            }
            
           // $('#event_result').html('Selected: ' + r.join(', '));
        });

    $('.nested-parent').addClass('active');
    $('.nested-parent').show();

    /**
     * Display the Header item as active.
     */
    $('body').on('click', '.treeview-animated-items > .treeview-animated-items-header', function() {
        $('.treeview-animated-items-header').removeClass('active-header');
        $('.treeview-animated-element').removeClass('opened');
        $(this).addClass('active-header');
    });
    $('body').on('click', '.treeview-animated-element', function() {
        $('.treeview-animated-items-header').removeClass('active-header');
    });

    $('body').on('click', '.checkbox-header', function() {
        var organogramId = $(this).attr('data-id');
        if ($(this).is(':checked')) {
            $('.child-organogram-' + organogramId).prop('checked', true);
        } else {
            $('.child-organogram-' + organogramId).prop('checked', false);
        }
        //alert(organogramId);
    });
});

var appOrg = jQuery.parseJSON(app_data);
function createForm(event)
{
    var organogramId = event.target.getAttribute('organogram-id');
    var mode = event.target.getAttribute('mode');
    // alert(organogramId);

    var url = appOrg.app_url + 'admin/training/training-category/' + mode + "/" + organogramId;
    var myModal = $('#myModal');
    var modalBody = myModal.find('.content');
    if(organogramId){
        modalBody.load(url);
        myModal.modal('show');
    }
}

function deleteOrganogramItem(event)
{
    var organogramId = event.target.getAttribute('organogram-id');
    //alert(organogramId);

    var url = appOrg.app_url + 'admin/organograms/' + mode + "/" + organogramId;
    var myModal = $('#myModal');
    var modalBody = myModal.find('.content');
    if(organogramId){
        modalBody.load(url);
        myModal.modal('show');
    }
}

$(".modal").on("hidden.bs.modal", function(){
    $(".content").html("");
});

getOrganogramId = function(organogramId, organogramName){
    //alert(organogramName);
}


