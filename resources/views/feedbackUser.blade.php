@extends('Template')

@section('Title')
    Feedback
@endsection

@section('Content')
@include('Navbar')
@if (Session("Success"))
    <script>
        Swal.fire(
            'Thank You For Your Feedback',
            'Feedback anda telah kami terima Terima Kasih',
            'success'
        )
    </script>
@endif
<br>
<div class="container">
    <div class="card mx-auto mt-6">
        <div class="card-header" align='center'>Your Feedback</div>
        <div class="card-body">
            <form action="/AddCustomerFeedback" method="POST">
                @csrf
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Your Feedback</label>
                    <textarea class="form-control" rows="7" placeholder="Your Message" name='msg' required></textarea>
                  </div>
                <button class="btn btn-primary btn-block" type="submit">Submit</button>
            </form>
        </div>
    </div>
</div>
<br><br><br>
@include('footer')
@endsection
