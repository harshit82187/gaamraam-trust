@extends('front.layout.app')
@section('content')

  <style>
    .hero {
    background: #05893e;
    color: #fff;
    padding: 50px 0;
    text-align: center;
}
    
    .hero h1 {
         font-size: 44px;
    margin-bottom: 20px;
    font-weight: 700;
    color: #fff;
    }
    
    .hero p {
          font-size: 18px;
    max-width: 600px;
    margin: 20px auto;
    line-height: 22px;
    text-align: center;
    }
    
    .cta-btn {
      background: #cc5c2e;
      color: white;
      padding: 1rem 2rem;
      border: none;
      border-radius: 5px;
      font-size: 1.1rem;
      cursor: pointer;
      transition: transform 0.2s;
      text-decoration: none;
      display: inline-block;
    }
    
    .cta-btn:hover { transform: translateY(-2px); }

    /* Trust Details */
    .trust-details {
      padding: 4rem 0;
      background: var(--light);
    }
    
    .section-title {
      text-align: center;
      font-size: 2.5rem;
      margin-bottom: 3rem;
      color: #2fbfa7;
    }
    
    .mission-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 2rem;
      margin-bottom: 3rem;
    }
    
    .mission-card {
      background: white;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 4px 0px 15px rgba(0,0,0,0.1);
      text-align: center;
    }
    
    .mission-icon {
      width: 60px;
      height: 60px;
      background: var(--accent);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1rem;
      font-size: 1.5rem;
    }

    /* City Presence */
    .cities {
      padding: 4rem 0;
    }
    
    .city-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 1.5rem;
    }
    
    .city-card {
         background: white;
    padding: 1.5rem;
    border-radius: 8px;
    border-left: 4px solid #cc5c2e;
    box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .city-name {
      font-size: 1.2rem;
      font-weight: bold;
      color: #111;
      margin-bottom: 0.5rem;
    }

    /* Image Gallery */
    .gallery {
      padding: 4rem 0;
      background: var(--light);
    }
    
    .gallery-container {
      position: relative;
      overflow: hidden;
      border-radius: 10px;
    }
    
    .gallery-track {
      display: flex;
      transition: transform 0.3s ease;
    }
    
    .gallery-item {
      min-width: 100%;
      height: 400px;
      background: var(--primary);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 1.2rem;
    }
    
    .gallery-nav {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(0,0,0,0.5);
      color: white;
      border: none;
      padding: 15px 25px;
      cursor: pointer;
      border-radius: 50%;
    }
    
    .gallery-prev { left: 1rem; }
    .gallery-next { right: 1rem; }

    /* Member Slider */
    .members {
      padding: 4rem 0;
    }
    
    .member-slider {
      position: relative;
      overflow: hidden;
    }
    
    .member-track {
      display: flex;
      transition: transform 0.3s ease;
    }
    
    .member-card {
      min-width: 300px;
      margin-right: 2rem;
      background: white;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      text-align: center;
    }
    
    .member-photo {
      width: 80px;
      height: 80px;
      background: var(--primary);
      border-radius: 50%;
      margin: 0 auto 1rem;
    }
    
    .member-name {
      font-size: 1.2rem;
      font-weight: bold;
      margin-bottom: 0.5rem;
    }
    
    .member-role {
      color: var(--muted);
      font-size: 0.9rem;
    }



    .nw-cta-section {
  background: #05893e;       
  color: #ffffff;          
  padding: 64px 20px;        
  text-align: center;
}

.nw-cta-container {
  max-width: 800px;        
  margin: 0 auto;
  padding: 0 16px;
}

.nw-cta-title {
  font-size: 32px;          
  font-weight: bold;
  margin-bottom: 16px;
  color: #fff;
}

@media (min-width: 768px) {
  .nw-cta-title {
    font-size: 40px;       
  }
}

.nw-cta-subtitle {
  font-size: 20px;        
  margin-bottom: 32px;
  color: rgba(255, 255, 255, 0.9); 
  line-height: 1.5;
}

.nw-cta-buttons {
  display: flex;
  flex-direction: column;
  gap: 16px;
  justify-content: center;
}

@media (min-width: 640px) {
  .nw-cta-buttons {
    flex-direction: row;
  }
}

.nw-btn-donate {
  background: #cc5c2e;     
  color: #ffffff;
  padding: 16px 32px;
  border-radius: 8px;
  font-size: 18px;
  font-weight: 600;
  cursor: pointer;
  border: none;
  transition: background 0.3s;
}

.nw-btn-donate:hover {
  background: #e48012;      
}

.nw-btn-volunteer {
  background: transparent;
  border: 2px solid #ffffff;
  color: #ffffff;
  padding: 16px 32px;
  border-radius: 8px;
  font-size: 18px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s;
}

.nw-btn-volunteer:hover {
  background: #ffffff;      
  color: #00878e;           
}

    /* Responsive */
    @media (max-width: 768px) {
      .nav-links { display: none; }
      .hero { padding: 2rem 0; }
      .section-title { font-size: 2rem; }
      .member-card { min-width: 250px; }
    }
  </style>


  <section class="hero">
    <div class="container">
      <h1>Building Hope, Changing Lives</h1>
      <p>Empowering communities through education, healthcare, and sustainable development initiatives across multiple cities.</p>
      <a href="#about" class="cta-btn">Learn More</a>
    </div>
  </section>

  <section id="about" class="trust-details">
    <div class="container">
      <h2 class="section-title">Our Mission</h2>
      <div class="mission-grid">
        <div class="mission-card">
          <div class="mission-icon">🎓</div>
          <h3>Education</h3>
          <p>Providing quality education and learning opportunities to underprivileged children and adults.</p>
        </div>
        <div class="mission-card">
          <div class="mission-icon">🏥</div>
          <h3>Healthcare</h3>
          <p>Delivering essential healthcare services and medical support to rural and urban communities.</p>
        </div>
        <div class="mission-card">
          <div class="mission-icon">🌱</div>
          <h3>Environment</h3>
          <p>Promoting sustainable practices and environmental conservation for future generations.</p>
        </div>
      </div>
    </div>
  </section>

  <section id="cities" class="cities">
    <div class="container">
      <h2 class="section-title">Our Presence</h2>
      <div class="city-grid">
        <div class="city-card">
          <div class="city-name">Mumbai</div>
          <p>Serving 15,000+ beneficiaries through education and healthcare programs.</p>
        </div>
        <div class="city-card">
          <div class="city-name">Delhi</div>
          <p>Operating 8 community centers with focus on skill development.</p>
        </div>
        <div class="city-card">
          <div class="city-name">Bangalore</div>
          <p>Environmental conservation projects reaching 25+ villages.</p>
        </div>
        <div class="city-card">
          <div class="city-name">Chennai</div>
          <p>Healthcare initiatives serving coastal communities.</p>
        </div>
      </div>
    </div>
  </section>

  <section id="gallery" class="gallery">
    <div class="container">
      <h2 class="section-title">Our Impact</h2>
      <div class="gallery-container">
        <div class="gallery-track" id="galleryTrack">
          <div class="gallery-item"><img alt="Gallery image" class="w-full h-full object-cover" src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/attachments/gen-images/public/community-garden-volunteers-QJsHwyVQ9QKS0qabI21WHpLAmRTVVe.png"></div>
          <div class="gallery-item"><img alt="Gallery image" class="w-full h-full object-cover" src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/attachments/gen-images/public/community-garden-volunteers-QJsHwyVQ9QKS0qabI21WHpLAmRTVVe.png"></div>
          <div class="gallery-item"><img alt="Gallery image" class="w-full h-full object-cover" src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/attachments/gen-images/public/community-garden-volunteers-QJsHwyVQ9QKS0qabI21WHpLAmRTVVe.png"></div>
          <div class="gallery-item"><img alt="Gallery image" class="w-full h-full object-cover" src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/attachments/gen-images/public/community-garden-volunteers-QJsHwyVQ9QKS0qabI21WHpLAmRTVVe.png"></div>
        </div>
        <button class="gallery-nav gallery-prev" onclick="moveGallery(-1)">‹</button>
        <button class="gallery-nav gallery-next" onclick="moveGallery(1)">›</button>
      </div>
    </div>
  </section>

  <section id="team" class="members">
    <div class="container">
      <h2 class="section-title">Our Team</h2>
      <div class="member-slider">
        <div class="member-track" id="memberTrack">
          <div class="member-card">
            <div class="member-photo"></div>
            <div class="member-name">Dr. Priya Sharma</div>
            <div class="member-role">Founder & Director</div>
          </div>
          <div class="member-card">
            <div class="member-photo"></div>
            <div class="member-name">Rajesh Kumar</div>
            <div class="member-role">Program Manager</div>
          </div>
          <div class="member-card">
            <div class="member-photo"></div>
            <div class="member-name">Anita Desai</div>
            <div class="member-role">Community Outreach</div>
          </div>
          <div class="member-card">
            <div class="member-photo"></div>
            <div class="member-name">Vikram Singh</div>
            <div class="member-role">Finance Head</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="nw-cta-section">
    <div class="nw-cta-container">
      <h3 class="nw-cta-title">Join Us in Making a Difference</h3>
      <p class="nw-cta-subtitle">
        Your support can help us reach more communities and create lasting positive change.
      </p>
      <div class="nw-cta-buttons">
        <button class="nw-btn-donate">Make a Donation</button>
        <button class="nw-btn-volunteer">Become a Volunteer</button>
      </div>
    </div>
  </section>



  <script>
    let galleryIndex = 0;
    let memberIndex = 0;
    
    function moveGallery(direction) {
      const track = document.getElementById('galleryTrack');
      const items = track.children.length;
      galleryIndex = (galleryIndex + direction + items) % items;
      track.style.transform = `translateX(-${galleryIndex * 100}%)`;
    }
    
    function moveMember(direction) {
      const track = document.getElementById('memberTrack');
      const items = track.children.length;
      memberIndex = (memberIndex + direction + items) % items;
      track.style.transform = `translateX(-${memberIndex * 320}px)`;
    }
    
    // Auto-advance member slider
    setInterval(() => moveMember(1), 4000);
  </script>





@endsection