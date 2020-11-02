@extends('Template')
@section('Title')
About Us
@endsection
@section('Content')
<div style="background-image: url(Bg-2.jpg);width: 100%; height: 100%;background-size:cover;">
    @include('Navbar')
    <div style="text-align: center;">
        <br>
        <br>
        <br>
        <main role="main" class="container">
            <div class="jumbotron" style="opacity: 77%;">
              <h1 class="display-1">About Us</h1>
              <br>
              <img src="{{url('Logo/Logo(title).png')}}" style="width:15%;height:15%;">
              <br><br>
              <p class="lead">Cassy is brand that build for casual style that suit to be in the 20'th century style.
                  Cassy is build with heart and presition that we hope our customer will love our brands. Our vision
                  for finesse in style are big and very optimistic and we hope that people wear our brand is be more
                  stylist and more cassual.
              </p>
            <br>
            <hr>
            </div>
          </main>
          <br>
          <br>
  </div>
  <div id="trav" style="background-color:snow;text-align:center;">
    <br>
    <br>
    <h1 class="display-3">Company Profile</h1>
    <br>
    <img src="{{url('Logo/store2.jpg')}}" class="shadow-lg p-3 mb-5 bg-white rounded" style="width: 48%;height: 48%;">
    <br>
    <p style="color: gray;"> Cassy is one of the biggest international fashion companies, and it belongs to Inditex, <br>
         one of the world’s largest distribution groups.
        <br>
        The customer is at the heart of our unique business model, which includes design, production, distribution, <br>
         and sales, through our extensive retail network.</p>
    <br>
    <hr>
    <br><br>
  </div>

  <div id="food" style="background-color:lavender;text-align:center;">
    <br>
    <br>
    <h1 class="display-3">Our Info</h1>
    <br>
    <img src="{{url('Logo/Logo(title).png')}}" style="width: 5%;height: 5%;">
    <br>
    <h4 style="color: gray;">Our Office are located in west Surabaya Indonesia. and we have operational hours at</h4>
    <br>
    <br>
    <table style="margin: 0 auto;">
        <tr>
          <td style="text-align: right;"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-calendar-day" fill="currentColor" xmlns="http://www.w3.org/2000/svg" style="width: 55%;height:55%;">
            <path fill-rule="evenodd" d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
            <path d="M4.684 11.523v-2.3h2.261v-.61H4.684V6.801h2.464v-.61H4v5.332h.684zm3.296 0h.676V8.98c0-.554.227-1.007.953-1.007.125 0 .258.004.329.015v-.613a1.806 1.806 0 0 0-.254-.02c-.582 0-.891.32-1.012.567h-.02v-.504H7.98v4.105zm2.805-5.093c0 .238.192.425.43.425a.428.428 0 1 0 0-.855.426.426 0 0 0-.43.43zm.094 5.093h.672V7.418h-.672v4.105z"/>
          </svg></td>
          <td style="text-align: left;"><h1 class="display-4">Monday - Friday</h1></td>
        </tr>
        <tr>
          <td style="text-align: right;"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-clock" fill="currentColor" xmlns="http://www.w3.org/2000/svg" style="width: 55%;height:55%;">
            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm8-7A8 8 0 1 1 0 8a8 8 0 0 1 16 0z"/>
            <path fill-rule="evenodd" d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z"/>
          </svg></td>
          <td style="text-align: left;"><h1 class="display-4">08.00 am - 17.00 pm</h1></td>
        </tr>
      </table>
    <br>
    <br>
    <h4 style="color: gray;">Our Info :</h4>
    <br>
    <div id="carouselExampleCaptions1" class="carousel slide shadow-lg p-3 mb-5 bg-white rounded" data-ride="carousel"  style="width: 58%;height: 58%;margin: 0 auto;">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleCaptions1" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleCaptions1" data-slide-to="1"></li>
          <li data-target="#carouselExampleCaptions1" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <a href="#trav"><img src="Logo/store1.jpg" class="d-block w-100" alt="..."></a>
            <div class="carousel-caption d-none d-md-block">
              <h5 style="color:white;">Modern</h5>
              <p style="color: white;">Modern Store was one of our best intention</p>
            </div>
          </div>
          <div class="carousel-item">
            <a href="#food"><img src="Logo/store2.jpg" class="d-block w-100" alt="..."></a>
            <div class="carousel-caption d-none d-md-block">
              <h5 style="color: white;">Comfort</h5>
              <p style="color: white;">Comfort Play huge part in this brand</p>
            </div>
          </div>
          <div class="carousel-item">
            <a href="#f&f"><img src="Logo/store3.jpg" class="d-block w-100" alt="..."></a>
            <div class="carousel-caption d-none d-md-block">
              <h5 style="color: white;">Stylish</h5>
              <p style="color: white;">Always stay stylish</p>
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleCaptions1" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleCaptions1" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    <br>
    <div style="margin: 0 auto;">
        <table>
            <tr>
              <td style="text-align: right;">
                <img src="{{url('Logo/gmail_logo.png')}}" style="width: 10%;height:10%;">
              </td>
              <td style="text-align: left;"><h4>cassy.onlineshopistts@gmail.com</h4></td>
            </tr>
            <tr>
              <td style="text-align: right;">
                <img src="{{url('Logo/wa_logo.png')}}" style="width: 12%;height:15%;">
              </td>
              <td style="text-align: left;"><h1 class="display-4">+628982960838</h1></td>
            </tr>
          </table>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-4" style="text-align: right;"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-geo-alt" fill="currentColor" xmlns="http://www.w3.org/2000/svg" style="width: 20%;height:20%;">
            <path fill-rule="evenodd" d="M12.166 8.94C12.696 7.867 13 6.862 13 6A5 5 0 0 0 3 6c0 .862.305 1.867.834 2.94.524 1.062 1.234 2.12 1.96 3.07A31.481 31.481 0 0 0 8 14.58l.208-.22a31.493 31.493 0 0 0 1.998-2.35c.726-.95 1.436-2.008 1.96-3.07zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
            <path fill-rule="evenodd" d="M8 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
          </svg></div>
        <div class="col-4" style="text-align: left"><h4 style="text-align: right;">Jl. Darmo Permai Selatan I No.10, <br> Pradahkalikendal, Kec. Dukuhpakis, Kota SBY, <br> Jawa Timur 60226</h4></div>
        <div class="col-4" style="text-align: left"><img src="{{url('Logo/Map.png')}}" style="width: 70%;height: 100%;"></div>
    </div>
    <br>
    <hr>
    <br><br>
  </div>

  <div id="f&f" style="background-color:lightblue;text-align:center;">
    <br>
    <br>
    <h1 class="display-3">Website accessibility statement</h1>
    <br>
    <img src="{{url('Logo/Logo(title invert).png')}}" style="width: 15%;height: 15%;">
    <br>
    <p style="color: gray;">Cassy has an ongoing commitment to its customers around the world in providing an excellent costumer experience to all. As part of these efforts,
        <br> we are committed to providing a website that is accessible to the widest possible audience, regardless of technology or ability. <br>
         Cassy is committed to aligning its website and its operations in substantial conformance with generally-recognized and accepted guidelines <br>
         and/or standards for website accessibility (as these may change from time to time). To assist in these efforts, Zara has partnered with experienced internationally <br>
          reputable consultants and is working to increase the accessibility and usability of our website.
        <br>
        As these efforts are ongoing, if at any time you have any questions or if you encounter an accessibility issue, please contact our <br>
         Customer Service team for assistance 1-888 501 2708. We will make all reasonable efforts to address your concerns. Thank you for choosing to shop with us!</p>
    <br>
    <hr>
    <br><br>
  </div>

  @include('footer')
@endsection
