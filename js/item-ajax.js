$( document ).ready(function() {

var page = 1;
var current_page = 1;
var total_page = 0;
var is_ajax_fire = 0;

manageData();

/* manage data list */
function manageData() {
    $.ajax({
        dataType: 'json',
        url: url+'api/getData.php',
        data: {page:page}
    }).done(function(data){
    	total_page = Math.ceil(data.total/10);
    	current_page = page;

    	$('#pagination').twbsPagination({
	        totalPages: total_page,
	        visiblePages: current_page,
	        onPageClick: function (event, pageL) {
	        	page = pageL;
                if(is_ajax_fire != 0){
	        	  getPageData();
                }
	        }
	    });

    	manageRow(data.data);
        is_ajax_fire = 1;

    });

}

/* Get Page Data*/
function getPageData() {
	$.ajax({
    	dataType: 'json',
    	url: url+'api/getData.php',
    	data: {page:page}
	}).done(function(data){
		manageRow(data.data);
	});
}


/* Add new Item table row */
function manageRow(data) {
	var	rows = '';
	$.each( data, function( key, value ) {
	  	rows = rows + '<tr>';
	  	rows = rows + '<td>'+value.id_order+'</td>';
	  	rows = rows + '<td>'+value.username+'</td>';
        rows = rows + '<td>'+value.create_at+'</td>';
        rows = rows + '<td>'+value.toko+'</td>';
        rows = rows + '<td>'+value.barang+'</td>';
        rows = rows + '<td>'+value.lokasi_antar+'</td>';
        rows = rows + '<td>'+value.nama_penerima+'</td>';
	  	rows = rows + '<td data-id="'+value.id+'">';
        // rows = rows + '<button data-toggle="modal" data-target="#edit-item" class="btn btn-primary edit-item">Detail</button> ';
        // rows = rows + '<button class="btn btn-danger remove-item">Tolak</button>';
        rows = rows + '</td>';
	  	rows = rows + '</tr>';
	});

	$("tbody").html(rows);
}

/* Create new Item */
$(".crud-submit").click(function(e){
    e.preventDefault();
    var form_action = $("#create-item").find("form").attr("action");
    var title = $("#create-item").find("input[name='title']").val();
    var description = $("#create-item").find("textarea[name='description']").val();

    if(title != '' && description != ''){
        $.ajax({
            dataType: 'json',
            type:'POST',
            url: url + form_action,
            data:{title:title, description:description}
        }).done(function(data){
            $("#create-item").find("input[name='title']").val('');
            $("#create-item").find("textarea[name='description']").val('');
            getPageData();
            $(".modal").modal('hide');
            toastr.success('Item Created Successfully.', 'Success Alert', {timeOut: 5000});
        });
    }else{
        alert('You are missing title or description.')
    }


});

/* Remove Item */
$("body").on("click",".remove-item",function(){
    var id = $(this).parent("td").data('id');
    var c_obj = $(this).parents("tr");

    $.ajax({
        dataType: 'json',
        type:'POST',
        url: url + 'api/delete.php',
        data:{id:id}
    }).done(function(data){
        c_obj.remove();
        toastr.success('Item Deleted Successfully.', 'Success Alert', {timeOut: 5000});
        getPageData();
    });

});


/* Edit Item */
// $("body").on("click",".edit-item",function(){

//     var id_order = $(this).parent("td").prev("td").prev("td").prev("td").text();
//     var username = $(this).parent("td").prev("td").prev("td").text();
//     var create_at = $(this).parent("td").prev("td").text();
//     var toko = $(this).parent("td").text();
//     var barang = $(this).parent("td").prev("td").text();
//     var lokasi_antar= $(this).parent("td").prev("td").text();
//     var nama_penerima = $(this).parent("td").prev("td").text();

//     $("#edit-item").find("input[name='id_order']").val(id_order);
//     $("#edit-item").find("textarea[name='nama_pemesan']").val(username);
//     $("#edit-item").find("textarea[name='waktu_pesan']").val(create_at);
//     $("#edit-item").find("textarea[name='toko']").val(toko);
//     $("#edit-item").find("textarea[name='barang']").val(barang);
//     $("#edit-item").find("textarea[name='alamat_antar']").val(lokasi_antar);
//     $("#edit-item").find("textarea[name='nama_penerima']").val(nama_penerima);
//     $("#edit-item").find(".edit-id").val(id);

// });


/* Updated new Item */
$(".crud-submit-edit").click(function(e){

    e.preventDefault();
    var form_action = $("#edit-item").find("form").attr("action");
    var title = $("#edit-item").find("input[name='title']").val();

    var description = $("#edit-item").find("textarea[name='description']").val();
    var id = $("#edit-item").find(".edit-id").val();

    if(title != '' && description != ''){
        $.ajax({
            dataType: 'json',
            type:'POST',
            url: url + form_action,
            data:{title:title, description:description,id:id}
        }).done(function(data){
            getPageData();
            $(".modal").modal('hide');
            toastr.success('Item Updated Successfully.', 'Success Alert', {timeOut: 5000});
        });
    }else{
        alert('You are missing title or description.')
    }

});
});