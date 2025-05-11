<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary" background= #EFEEEA;>
    <div class="container">
    <a class="navbar-brand" href="#">
      <img src="/docs/5.3/assets/brand/bootstrap-logo.svg" alt="Bootstrap" width="30" height="24">
    </a>
  </div>
            <ul class="nav justify-content-end">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Diagnosa</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Berita</a>
        </li>
        </ul>
    </nav>
    <section id="hero" class="hero section">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="fade-up">
            <h1>Selamat Datang</h1>
            <p>Mulai mendiagnosa sepeda listrik anda</p>
            <div class="d-flex">
              <a href="" class="btn-get-started">Mulai diagnosa</a>
            </div>
          </div>
          <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="100">
            <img src="asset/sepedalistrik.png" class="img-fluid animated" alt="">
          </div>
        </div>
      </div>
    </section>
</body>
<style>
     .hero {
    width: 100%;
    min-height: 70vh;
    position: relative;
    padding: 120px 0 60px 0;
    display: flex;
    align-items: center;
  }
  
  .hero h1 {
    margin: 0;
    font-size: 48px;
    font-weight: 700;
    line-height: 56px;
  }
  
  .hero p {
    color: color-mix(in srgb, var(--default-color), transparent 30%);
    margin: 5px 0 30px 0;
    font-size: 20px;
    font-weight: 400;
  }
  
  .hero .btn-get-started {
    color: var(--contrast-color);
    background: #1DCD9F;
    font-family: var(--heading-font);
    font-weight: 400;
    font-size: 15px;
    letter-spacing: 1px;
    display: inline-block;
    padding: 10px 28px 12px 28px;
    border-radius: 50px;
    transition: 0.5s;
    box-shadow: 0 8px 28px rgba(0, 0, 0, 0.1);
  }
  
  .hero .btn-get-started:hover {
    color: var(--contrast-color);
    background: color-mix(in srgb, var(--accent-color), transparent 15%);
    box-shadow: 0 8px 28px rgba(0, 0, 0, 0.1);
  }
  
  .hero .btn-watch-video {
    font-size: 16px;
    transition: 0.5s;
    margin-left: 25px;
    color: var(--default-color);
    font-weight: 600;
  }
  
  .hero .btn-watch-video i {
    color: var(--accent-color);
    font-size: 32px;
    transition: 0.3s;
    line-height: 0;
    margin-right: 8px;
  }
  
  .hero .btn-watch-video:hover {
    color: var(--accent-color);
  }
  
  .hero .btn-watch-video:hover i {
    color: color-mix(in srgb, var(--accent-color), transparent 15%);
  }
  
  .hero .animated {
    animation: up-down 2s ease-in-out infinite alternate-reverse both;
  }
  
  @media (max-width: 640px) {
    .hero h1 {
      font-size: 28px;
      line-height: 36px;
    }
  
    .hero p {
      font-size: 18px;
      line-height: 24px;
      margin-bottom: 30px;
    }
  
    .hero .btn-get-started,
    .hero .btn-watch-video {
      font-size: 13px;
    }
  }   
</style>
</html>