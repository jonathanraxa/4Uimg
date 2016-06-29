/* 
    AJAX CALL FOR ON PURCHASE OF AN ARTWORK ALLOWING FOR DISPLAY OF PRICE
    AND LICENSE TYPE
*/

function submitPurchase(mediaId) {
    var licenseInfo = $('.pricing-option-' + mediaId + ':checked').val().split(':');
    var requestObject = {
        action: 'submitPurchase',
        mediaId: mediaId,
        title: $('#title-' + mediaId).html().replace("Title: ", "").trim(),
        description: $('#description-' + mediaId).html(),
        user: $('#user-' + mediaId).html(),
        artist: $('#artist-' + mediaId).html(),
        license: licenseInfo[0],
        price: licenseInfo[1]
    }
    $.ajax({
        type: 'POST',
        url: 'ajax/submitPurchase.php',
        dataType: 'JSON',
        data: requestObject,
        success: function(data) {
            $('#license-type-' + mediaId).html(licenseInfo[0] + ' | $' + licenseInfo[1]);
        }
    })
}





