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
            Scanner.Verify(content);
        });
        this.SelectCameras();
    },
    Verify: function (sHash) {
        $.ajax({
            url: location.href,
            type: 'post',
            dataType: 'json',
            data: {
              id: sHash
            },
            statusCode: {
                404: function() {
                    Modals.Warning({
                        Title : "Niet juist",
                        Message: "Geen pot gevonden"
                    })
                },
                500: function () {
                    Modals.Error({
                        Title: "Mislukt",
                        Message: "Er is een fout opgetreden"
                    })
                }
            },
            success:function(response){
                location.replace("/pot/"+response.id+"/settings")
            }
        });
    },
};

$(document).ready(function () {
Scanner.StartCamera();
});