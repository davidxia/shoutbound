var Delete = {
    
    deleteTrip: function() {
        var postData = {
            tripId: tripId
        };
        
        if(tripId){
            $.ajax({
               type: 'POST',
               url: baseUrl+'trips/delete',
               data: postData,
               success: function() {
                   window.location.href = baseUrl;
               }
            });
        }
    }
    
};