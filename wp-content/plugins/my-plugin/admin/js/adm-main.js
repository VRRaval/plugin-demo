jQuery(document).ready(function($){
    let searchForm = $('#my-search-form');

    searchForm.submit(function(event){
        event.preventDefault();

        let searchTerm = $('#my-search-term').val();
        let formData = new FormData();
        formData.append('action','my_serach_res');
        formData.append('searchTerm',searchTerm);
        
        $.ajax({
            url: ajaxurl,
            type: 'post',
            data: formData,
            processData: false,
            contentType: false,
            success: function(responce){
                $('#my-tbl-result').html(responce);
            },
            error: function(){
                console.log('error');
            }
        });
    });
});