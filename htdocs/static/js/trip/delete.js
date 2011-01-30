var Delete = {
    
    deleteTrip: function() {
        var postData = {
            tripid: tripid
        }
        
        if(tripid){
            $.ajax({
               type: 'POST',
               url: baseUrl + 'trip/delete',
               data: postData,
               success: function() {
                   window.location.href = baseUrl;
               }
            });
        }
    }
    
};