var Scanner = {
    camera: null,
    scanner: null,
    SelectCameras: function(){
        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
                oMessage = $("<div><p>Selecteer een camera</p><select class='form-control'></select></div>");

                $.each(cameras, function (i, camera) {
                    oMessage.find("select").append("<option value='"+i+"'>"+camera.name+"</option>");
                });
                Modals.Custom({
                    Title: "Camera",
                    Message: oMessage,
                    onConfirm: function (oModal) {
                        Scanner.camera = cameras[parseInt(oModal.find("select").val())];
                        Scanner.scanner.start(Scanner.camera);
                    }
                });

            } else {
                endPageLoad();
                addErrorMessage("Geen camera gevonden.");
            }
        }).catch(function (e) {
            console.log(e)
        });
    },
    StartCamera : function () {
        this.scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
        this.scanner.addListener('scan', function (content) {
            console.log(content)
            // Scanner.VerifyTicket(content);
        });
        this.SelectCameras();
    },
    VerifyTicket: function (sHash) {
        $.ajax({
            url: ARURA_API_DIR + '/shop/event-validate.php?type=verify-ticket',
            type: 'post',
            dataType: 'json',
            data: {
              Hash: sHash
            },
            statusCode: {
                404: function() {
                    Modals.Warning({
                        Title : "Niet juist",
                        Message: "Ticket is niet legitiem"
                    })
                },
                500: function () {
                    Modals.Error({
                        Title: "Mislukt",
                        Message: "Er is een fout opgetreden"
                    })
                },
                409: function () {
                    Modals.Warning({
                        Title: "Al gescand",
                        Message: "Dit ticket is al eerder gescand in de afgelopen 24 uur. Echter dit ticket is wel legitiem"
                    })
                }
            },
            success:function(response){
                // addSuccessMessage("Ticket is juist");
                Scanner.AddTicketToTable(response.data);
                // endPageLoad();
            },
            error: function () {
                endPageLoad();
            }
        });
    },
    AddTicketToTable: function (aData) {
        // $(".ticket-table").find("tbody").append("<tr><td>"+aData.Ticket.OrderedTicket_Hash+"</td><td>"+aData.Ticket.Ticket_Description+"</td><td>"+aData.Event.Event_Name+"</td></tr>")
    }
};

$(document).ready(function () {
Scanner.StartCamera();
});