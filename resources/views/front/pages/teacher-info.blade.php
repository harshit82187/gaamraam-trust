@extends('front.layout.app')
@section('content')
<style>
    .instructor-section {
        background-color: #f4f0ff;
        padding: 60px 20px;
    }


    .left {
        flex: 1 1 60%;
    }

    .right {
        flex: 1 1 30%;
        /* display: flex; */
        justify-content: center;
    }

    .label {
        text-transform: uppercase;
        font-weight: bold;
        color: #666;
        font-size: 14px;
        margin-bottom: 0;

    }

    .name {
        font-size: 36px;
        font-weight: bold;
    }

    .subtitle {
        font-size: 18px;
        color: #555;
        margin-bottom: 5px;
    }

    .stats {
        display: flex;
        gap: 40px;
        margin-bottom: 10px;
    }

    .stat h2 {
        margin-bottom: 10px;
        font-size: 24px;
        font-weight: bold;
    }

    .stat p {
        margin: 0;
        color: #555;
    }

    .about h3 {
        font-size: 20px;
        margin-bottom: 10px;
    }

    .about p {
        margin-bottom: 15px;
        color: #444;
        line-height: 1.6;
    }



    .profile-card {
        background-color: #fff;
        border-radius: 5px;
        padding: 30px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        text-align: center;
    }

    .avatar {
        width: 150px;
        height: 150px;
        border-radius: 100%;
        object-fit: cover;
        margin-bottom: 20px;
    }

    .social-icons {
        display: flex;
        justify-content: center;
        gap: 15px;
    }

    .icon {
        display: inline-block;
        padding: 10px 12px;
        border: 1px solid #6d28d9;
        color: #6d28d9;
        border-radius: 8px;
        font-size: 20px;
        transition: all 0.3s ease;
    }

    .icon:hover {
        background-color: #6d28d9;
        color: white;
    }

    .teacher_card {
        margin: 20px 0;
    }

    .stats .stat {
        width: 50%;
    }

    .stat h2 span {
        font-size: 16px;
        font-weight: 600;
        line-height: 22px;
    }

    .box.border {
    border: 1px solid #ffffff !important;
}
.box-title {
    justify-content: space-between;
}
.dropdown-list-image .status-indicator {
    background-color: #eaecf4;
    height: .75rem;
    width: .75rem;
    border-radius: 100%;
    position: absolute;
    bottom: 0;
    right: 0;
    border: .125rem solid #fff;
}
.dropdown-list-image img {
    height: 2.5rem;
    width: 2.5rem;
}
.dropdown-list-image {
    position: relative;
    height: 2.5rem;
    width: 2.5rem;
}
.people-list .font-weight-bold div {
    text-overflow: ellipsis;
    overflow: hidden;
}
.people-list .font-weight-bold {
    font-weight: 500 !important;
    word-break: break-all;
    overflow: hidden;
    white-space: nowrap;
}
.dropdown-list-image .status-indicator {
    background-color: #eaecf4;
    height: .75rem;
    width: .75rem;
    border-radius: 100%;
    position: absolute;
    bottom: 0;
    right: 0;
    border: .125rem solid #fff;
}
.gallery-box {
    align-items: center;
    display: flex;
    margin-bottom: 10px;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
}
.gallery-box-main {
    border-radius: 10px;
    overflow: hidden;
}
.gallery-box img {
    width: 80px;
    height: 80px;
    border: 1px solid #ddd;
    object-fit: cover;
    border-radius: 50%
}
.stats .stat ul li {
    list-style: auto;
}
</style>
<section class="instructor-section">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="right">
                    <div class="profile-card">
                        <img src="{{asset($teacher->image)}}" alt="Instructor" class="avatar" />
                        
                    </div>
                </div>
                <div class="right d-none">
                    <div class="box shadow-sm border rounded bg-white my-3">
                        <div class="box-title border-bottom p-3 d-flex align-items-center">
                            <h6 class="m-0">Photos</h6>
                            <a class="ml-auto" href="#">See All <i class="feather-chevron-right"></i></a>
                        </div>
                        <div class="box-body p-3">
                            <div class="gallery-box-main">
                                <div class="gallery-box">
                                    <img class="img-fluid" src="https://www.gaamraam.ngo/public/app/teacher/2025/Jul/1751631041.png" alt="">
                                    <img class="img-fluid" src="https://www.gaamraam.ngo/public/app/teacher/2025/Jul/1751631041.png" alt="">
                                    <img class="img-fluid" src="https://www.gaamraam.ngo/public/app/teacher/2025/Jul/1751631041.png" alt="">
                                    <img class="img-fluid" src="https://www.gaamraam.ngo/public/app/teacher/2025/Jul/1751631041.png" alt="">
                                    <img class="img-fluid" src="https://www.gaamraam.ngo/public/app/teacher/2025/Jul/1751631041.png" alt="">
                                    <img class="img-fluid" src="https://www.gaamraam.ngo/public/app/teacher/2025/Jul/1751631041.png" alt="">
                                    <img class="img-fluid" src="https://www.gaamraam.ngo/public/app/teacher/2025/Jul/1751631041.png" alt="">
                                    <img class="img-fluid" src="https://www.gaamraam.ngo/public/app/teacher/2025/Jul/1751631041.png" alt="">
                                    <img class="img-fluid" src="https://www.gaamraam.ngo/public/app/teacher/2025/Jul/1751631041.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="left">
                    <p class="label">Teacher</p>
                    <h1 class="name">{{$teacher->name}}</h1>
                    <div class="about">
                        <p>{!!$teacher->about!!}</p>
                    </div>
                    <div class="stats">
                        <div class="stat">
                            <h2>{{$teacher->experience}} <span> Years of Teaching Experience</span> </h2>
                            <p>{{$teacher->education}}</p>
                        </div>
                        <div class="stats d-none">
                            <div class="stat w-100">
                                <h2>Achievements </h2>
                                <ul class="" style="list-style:none;">
                                    <li>
                                        <p>GOLD MEDALIST, IIMC</p>
                                    </li>
                                    <li>
                                        <p>MENTORED MORE THAN 1000 SUCCESSFUL SELECTIONS </p>
                                    </li>
                                    <li>
                                        <p>10 YEARS EXPERIENCE WITH NATIONAL NEWS CHANNELS including SANSAD TV</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="stat d-none">
                        <h2>13,293</h2>
                        <p>Reviews</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="bg-very-light-gray py-5">
    <div class="container">
        <div class="section-heading py-4 mb-0">
            <h2 class="membrr-all">Our Teachers</h2>
        </div>
        <div class="swiper member-swiper">
            <div class="swiper-wrapper">
                 @if(!empty($teachers))
                     @foreach($teachers as $teacher)
                        <div class="swiper-slide">
                            <a href="{{route('teacher-info',encrypt($teacher->id))}}">
                                <div class="member-cardss teacher_card" style="height:100%;">
                                    <div class="student-image-block mb-1">
                                        <img src="{{asset($teacher->image) }}" alt="Instructor" class="avatar">
                                    </div>
                                    <h3 class="pt-1">{{$teacher->name}}</h3>
                                    <p class="mb-0">Total Experience :- {{  $teacher->experience }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Optional controls -->
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</section>

@endsection
@push('js')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        new Swiper(".member-swiper", {
            spaceBetween: 20,
            loop: true,
            slidesPerView: 1,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
                1280: {
                    slidesPerView: 4,
                },
            },
        });
    });
</script>
@endpush