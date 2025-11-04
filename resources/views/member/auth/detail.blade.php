@extends('front.layout.app')
@section('content')



<!-- <section class="team-section">
    <div class="container">
        <div class="row text-center mb-4">
            <h2 class="fw-bold">Meet Our Team</h2>
            <p class="">Our dedicated professionals who make everything possible</p>
        </div>
      
    </div>

    <div class="container py-5">
    <div class="row">

        <div class="col-md-4">
            <div class="team-member">
                <figure>
                    <img src="http://www.mauritiusdsilva.com/themes/hallooou/assets/images/lauren-cox.jpg" alt="Lauren Cox" class="img-fluid">
                    <figcaption>
                        <p class="text-white">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        <ul>
                            <li><a href="#"><i class="fab fa-facebook-f text-white"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter text-white"></i></a></li>
                            <li><a href="#"><i class="fab fa-linkedin-in text-white"></i></a></li>
                        </ul>
                    </figcaption>
                </figure>
                <h4>Lauren Cox</h4>
                <p>Creative Director</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="team-member">
                <figure>
                    <img src="http://www.mauritiusdsilva.com/themes/hallooou/assets/images/jessie-barnett.jpg" alt="Jessie Barnett" class="img-fluid">
                    <figcaption>
                        <p class="text-white">Neque minima ea, a praesentium saepe nihil maxime.</p>
                        <ul>
                            <li><a href="#"><i class="fab fa-facebook-f text-white"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter text-white"></i></a></li>
                            <li><a href="#"><i class="fab fa-linkedin-in text-white"></i></a></li>
                        </ul>
                    </figcaption>
                </figure>
                <h4>Jessie Barnett</h4>
                <p>UI/UX Designer</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="team-member">
                <figure>
                    <img src="http://www.mauritiusdsilva.com/themes/hallooou/assets/images/terry-fletcher.jpg" alt="Terry Fletcher" class="img-fluid">
                    <figcaption>
                        <p class="text-white">Temporibus dolor, quisquam consectetur molestias.</p>
                        <ul>
                            <li><a href="#"><i class="fab fa-facebook-f text-white"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter text-white"></i></a></li>
                            <li><a href="#"><i class="fab fa-linkedin-in text-white"></i></a></li>
                        </ul>
                    </figcaption>
                </figure>
                <h4>Terry Fletcher</h4>
                <p>Web Developer</p>
            </div>
        </div>

    </div>
</div>
</section> -->

<div class="container my-5">
        <div class="row">
            <!-- Image on the Left -->
            <div class="col-md-6">
                <img src="../front/images/detail.jpg" alt="" >
            </div>
            <!-- Content on the Right -->
            <div class="col-md-5">
                <h2>Informations</h2>
                <h4>John Doe</h4>
                <p><strong>Position:</strong> Senior Developer</p>
                <p><strong>Biography:</strong> John is an experienced software engineer with a passion for coding. He has worked on several major projects and is always eager to learn new technologies. When he's not coding, he enjoys hiking and playing video games.</p>
                <p class="mb-0"><strong>Skills:</strong></p>
                <ul>
                    <li>JavaScript</li>
                    <li>React</li>
                    <li>Node.js</li>
                    <li>Python</li>
                </ul>
                <p class="mb-0"><strong>Contact:</strong></p>
                <ul>
                    <li>Email: johndoe@example.com</li>
                    <li>Phone: 123-456-7890</li>
                </ul>
            </div>
        </div>
    </div>


@endsection

@push('js')



@endpush