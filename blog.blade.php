@extends('layouts.app')

@section('content')
  @include('layouts.navbar')
  <main id="main" data-aos="fade-in">

<!-- ======= Breadcrumbs ======= -->
<div class="breadcrumbs">
  <div class="container">
    <h2>Blog</h2>
    <p>Blog from our students </p>
  </div>
</div><!-- End Breadcrumbs -->

<!-- ======= Courses Section ======= -->
<section id="courses" class="courses">
  <div class="container" data-aos="fade-up">

    <div class="row" data-aos="zoom-in" data-aos-delay="100">

      @foreach($posts as $post)
      <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
        <div class="course-item">
          <img src="{{asset('portal/images/posts/'.$post->image)}}" class="img-fluid" alt="...">
          <div class="course-content">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h4>{{$post->user->sir_name}}</h4>
            </div>

            <h3><a href="course-details.html">{{ $post->title}}</a></h3>
            <p>{{$post->message}}</p>
            <div class="trainer d-flex justify-content-between align-items-center">
              <div class="trainer-profile d-flex align-items-center">
                <img src="{{asset('portal/images/posts/'.$post->image)}}" class="img-fluid" alt="">
                <span>Antonio</span>
              </div>
              <div class="trainer-rank d-flex align-items-center">
                <i class="bx bx-user"></i>&nbsp;{{$post->created_at->diffForHumans()}}
              
              </div>
            </div>
          </div>
        </div>
      </div> <!-- End Course Item-->
      @endforeach
    </div>

  </div>
</section><!-- End Courses Section -->

</main><!-- End #main -->
  @endsection  