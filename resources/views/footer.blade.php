<div class="row" style="margin:0px 10px">
    <div class="col-4">
        <div class="col-3">
            <img src="{{url('Logo/Logo(no title).png')}}" style="width: 100%">
        </div>
        <br>
        <div class="row">
            <div class="col-1">
                <img src="{{url('Logo/ig_logo.png')}}" style="width: 250%">
            </div>
            <div class="col-1">
                <img src="{{url('Logo/fb_logo.png')}}" style="width: 250%">
            </div>
            <div class="col-1">
                <img src="{{url('Logo/gmail_logo.png')}}" style="width: 250%">
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="row">
            <div class="col-2">
                <p>Shop</p>
                <div class="col-1" style="color: grey;">Men</div>
                <div class="col-1" style="color: grey;">Woman</div>
            </div>
            <div class="col-2">
                <p>Explore</p>
                <div class="col-1" style="color: grey;"><a href='/aboutUs' style="text-decoration: none">About Us</a></div>
            </div>
            <div class="col-2">
                <p>Support</p>
                <div class="col-1" style="color: grey;">Contact Us</div>
                <div class="col-1" style="color: grey;">Customer Service</div>
            </div>
        </div>
        <br>
    </div>
    <div class="col-4" style="text-align: left">
            <p>Keep In Touch</p>
            What do You think About This Website ?<br>
            <div class="col-auto">
                <label class="sr-only" for="inlineFormInputGroup">Username</label>
                <div class="input-group mb-2">
                  <input type="text" class="form-control" id="feedbackfooter">
                  <button class="btn btn-primary" id='btnSendFeedback'>Send To Us</button>
                </div>
            </div>
        <br>
    </div>
</div>
<br>
</div>
<br>
<div style="background-color:black;text-align: center;color:white;">
    <br>
    <img src="{{url('Logo/cSimbol.png')}}" style="width: 1%;height: 1%;"> Cassy Store Copyright 2020
    <br><br>
</div>

<script>
    $(document).ready(function(){
        $(document).on("click","#btnSendFeedback",function(){
            if ($("#feedbackfooter").val() == "") {
                Swal.fire(
                    'Submit Failed',
                    'Messsage Box tidak Boleh Kosong',
                    'error'
                )
            } else {
                var msg = $("#feedbackfooter").val();
                if(msg.trim().length > 0){
                    $.get('{{ url("/AddFeedbackFromFooter") }}',{msg : msg}, function(response) {
                        if(response == "Feedback"){
                            Swal.fire({
                                text: 'Thank you for your feedback',
                                icon: 'success',
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            })
                        }
                    });
                }else{
                    Swal.fire(
                    'Submit Failed',
                    'Messsage Box tidak Boleh Kosong',
                    'error'
                )
                }
            }
        })
    })
</script>
