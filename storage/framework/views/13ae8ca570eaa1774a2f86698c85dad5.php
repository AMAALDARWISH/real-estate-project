<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Egypt Real Estate Dashboard 2021-2030</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
<style>
  #map { height: 400px; border-radius: 15px; z-index: 1; }
  .chart-card { min-height: 350px; }
  /* ستايل أداة التنبؤ الجديدة */
  .forecast-box { background: linear-gradient(135deg, #1e1e2f, #2d2d44); color: white; border-radius: 15px; padding: 20px; margin-top: 20px; border: 1px solid #3d3d5c; }
  .prediction-value { font-size: 2rem; color: #00ff88; font-weight: bold; text-shadow: 0 0 10px rgba(0,255,136,0.3); }
  input[type=range] { accent-color: #00ff88; }
</style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
  <a class="navbar-brand" href="#">🏢 Egypt Real Estate</a>
  <div class="ms-auto d-flex gap-2 align-items-center">
    
    <div class="dropdown">
      <button class="btn btn-secondary dropdown-toggle" type="button" id="cityDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <?php echo e(request('city') ? ucfirst(request('city')) : 'All Cities'); ?>

      </button>
      <ul class="dropdown-menu" aria-labelledby="cityDropdown" id="cityMenu">
        <li><a class="dropdown-item city-item" href="<?php echo e(route('projects.index')); ?>">All Cities</a></li>
        <?php $__currentLoopData = \App\Models\Project::select('city')->distinct()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <li><a class="dropdown-item city-item" href="?city=<?php echo e($p->city); ?>" data-city="<?php echo e($p->city); ?>"><?php echo e(ucfirst($p->city)); ?></a></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
    
    <input type="hidden" id="cityFilter" value="<?php echo e(request('city', 'all')); ?>">
    <a href="<?php echo e(route('cities.index')); ?>" class="btn btn-primary">المحافظات</a>

    <form action="/" method="GET" class="d-flex align-items-center m-0">
      <select name="sort" class="form-select w-auto" onchange="this.form.submit()" style="height: 38px;">
        <option value="">ترتيب حسب </option>
        <option value="newest"<?php echo e(request('sort') == 'newest' ? 'selected' : ''); ?>>الأحدث</option>
        <option value="oldest"<?php echo e(request('sort') == 'oldest' ? 'selected' : ''); ?>>الأقدم</option>
        <option value="alphabetical"<?php echo e(request('sort') == 'alphabetical' ? 'selected' : ''); ?>>أبجديا(A-Z)</option>
      </select>
    </form> 

    <select id="yearFilter" class="form-select w-auto">
      <option value="all">All Years</option>
      <?php for($y=2021; $y<=2030; $y++): ?>
        <option value="<?php echo e($y); ?>"><?php echo e($y); ?></option>
      <?php endfor; ?>
    </select>
    
  </div>
</nav>

<div class="container-fluid mt-4">

  <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="fas fa-check-circle me-2"></i> <?php echo e(session('success')); ?>

      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  
  <div class="row mb-4">
    <div class="col-12">
      <div class="card p-4 shadow-sm border-0">
        <h5 class="mb-3 text-end"><i class="fas fa-plus-circle text-primary me-2"></i>إضافة عقار جديد</h5>
        <form action="<?php echo e(route('projects.store')); ?>" method="POST" enctype="multipart/form-data" class="row g-3" style="direction: rtl;">
          <?php echo csrf_field(); ?>
          <div class="col-md-3"><input type="text" name="name" class="form-control" placeholder="اسم المشروع" required></div>
          <div class="col-md-2"><input type="text" name="city" class="form-control" placeholder="المحافظة (مثلاً: Cairo)" required></div>
          <div class="col-md-2">
            <select name="type" class="form-select" required>
              <option value="" selected disabled>النوع</option>
              <option value="سكني">سكني</option>
              <option value="تجاري">تجاري</option>
              <option value="إداري">إداري</option>
            </select>
          </div>
          <div class="col-md-2"><input type="number" name="price" class="form-control" placeholder="السعر" required></div>
          <div class="col-md-2"><input type="file" name="image" class="form-control" accept="image/*" required></div>
          <div class="col-md-1"><button type="submit" class="btn btn-primary w-100">حفظ</button></div>
        </form>
      </div>
    </div>
  </div>

  
      <div class="forecast-box shadow mb-4">
        <h5 class="mb-4"><i class="fas fa-magic me-2 text-info"></i> التنبؤ بالأسعار (2026 - 2030)</h5>
        <div class="row align-items-center">
            <div class="col-md-6">
                <label for="futureYearRange" class="form-label">اختار السنة المستقبلية: <span id="displayYear" class="badge bg-primary">2026</span></label>
                <input type="range" class="form-range" min="2026" max="2031" step="1" id="futureYearRange" value="2026">
                <div class="d-flex justify-content-between mt-2 small text-muted">
                    <span>اليوم</span>
                    <span>بعد 5 سنوات</span>
                </div>
            </div>
            <div class="col-md-6 text-center border-start border-secondary">
                <p class="mb-1 text-muted">السعر المتوقع بناءً على متوسط السوق:</p>
                <div id="predictedPrice" class="prediction-value"><?php echo e(number_format($averagePrice, 0)); ?> ج.م</div>
                <small class="text-info" style="direction:rtl; display: inline-block;">* بافتراض نمو سنوي مركب بنسبة 5%</small>
            </div>
        </div>
      </div>

  
  <div class="row g-3 mb-4 text-center" id="overview">
    <div class="col-md-3 col-6"><div class="card p-3 shadow-sm border-0"><h6>Avg Price</h6><h3 id="avgPrice" class="text-primary fw-bold"><?php echo e(number_format($averagePrice, 0)); ?> ج</h3></div></div>
    <div class="col-md-3 col-6"><div class="card p-3 shadow-sm border-0"><h6>Total Projects</h6><h3 id="totalTx" class="text-success fw-bold"><?php echo e($totalProjects); ?></h3></div></div>
    <div class="col-md-3 col-6"><div class="card p-3 shadow-sm border-0"><h6>Growth %</h6><h3 id="growth" class="text-info fw-bold">15%</h3></div></div>
    <div class="col-md-3 col-6"><div class="card p-3 shadow-sm border-0"><h6>Market Share</h6><h3 id="mShare" class="text-warning fw-bold">Live</h3></div></div>
  </div>

  <div class="row g-3 mb-4" id="analytics">
    <div class="col-lg-6">
      <div class="card p-3 chart-card">
        <h6>Price Forecast 2021-2030</h6>
        <canvas id="forecastChart"></canvas>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card p-3 chart-card">
        <h6>Market Share</h6>
        <canvas id="pieChart"></canvas>
      </div>
    </div>
    <div class="col-lg-12 mt-3">
      <div class="card p-3 chart-card">
        <h6>Transactions per City</h6>
        <canvas id="barChart"></canvas>
      </div>
    </div>
  </div>

  <div class="row g-3">
    <div class="col-lg-12">
      <div class="card p-3 mb-4">
        <h6>City Map</h6>
        <div id="map"></div>
      </div>
      
      <div class="card p-3 shadow-sm border-0" style="max-height: 400px; overflow-y: auto;">
  <h6 class="fw-bold mb-3">قائمة العقارات</h6>
  <div class="table-responsive">
    <table class="table table-sm align-middle">
      <thead>
        <tr>
          <th>الصورة</th> 
          <th>المشروع</th>
          <th>السعر</th>
          <th>حذف</th>
        </tr>
      </thead>
      <tbody>
        <?php $__currentLoopData = $properties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $property): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td>
              
              <?php if($property->image): ?>
                <img src="<?php echo e(asset($property->image)); ?>" alt="Project Image" style="width: 60px; height: 45px; object-fit: cover; border-radius: 5px; border: 1px solid #ddd;">
              <?php else: ?>
                <div style="width: 60px; height: 45px; background: #eee; border-radius: 5px; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #999;">لا توجد صورة</div>
              <?php endif; ?>
            </td>
            <td><strong><?php echo e($property->name); ?></strong><br><small class="text-muted"><?php echo e(ucfirst($property->city)); ?></small></td>
            <td class="text-primary fw-bold"><?php echo e(number_format($property->price)); ?> ج</td>
            <td>
              <form action="<?php echo e(route('projects.destroy', $property->id)); ?>" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                  <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                  <button class="btn btn-link text-danger p-0"><i class="fas fa-trash-alt"></i></button>
              </form>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
    </table>
  </div>
</div>


<style>
  .footer-section {
    background: linear-gradient(135deg, #081224, #0d1b3a, #10264d);
    position: relative;
    overflow: hidden;
  }

  .footer-bg {
    position: absolute;
    inset: 0;
    background:
      radial-gradient(circle at 20% 20%, rgba(13, 202, 240, 0.12), transparent 25%),
      radial-gradient(circle at 80% 30%, rgba(13, 110, 253, 0.12), transparent 25%),
      radial-gradient(circle at 50% 100%, rgba(255, 255, 255, 0.05), transparent 30%);
    animation: bgMove 10s ease-in-out infinite alternate;
  }

  .footer-glow {
    position: absolute;
    border-radius: 50%;
    filter: blur(70px);
    opacity: 0.35;
    animation: floatGlow 8s ease-in-out infinite;
  }

  .footer-glow-1 {
    width: 220px;
    height: 220px;
    background: #0dcaf0;
    top: -60px;
    left: -60px;
  }

  .footer-glow-2 {
    width: 260px;
    height: 260px;
    background: #0d6efd;
    bottom: -100px;
    right: -80px;
    animation-delay: 2s;
  }

  .footer-brand {
    font-size: 2rem;
    letter-spacing: 0.5px;
    position: relative;
    display: inline-block;
  }

  .footer-brand::after {
    content: "";
    display: block;
    width: 65%;
    height: 3px;
    margin-top: 10px;
    border-radius: 10px;
    background: linear-gradient(90deg, #0dcaf0, transparent);
    animation: linePulse 2s infinite ease-in-out;
  }

  .footer-text {
    color: rgba(255, 255, 255, 0.78);
    line-height: 1.9;
    max-width: 95%;
  }

  .footer-title {
    font-weight: 700;
    font-size: 1.2rem;
    position: relative;
    display: inline-block;
    margin-bottom: 1rem;
  }

  .footer-title::after {
    content: "";
    position: absolute;
    right: 0;
    bottom: -8px;
    width: 45px;
    height: 3px;
    border-radius: 20px;
    background: #0dcaf0;
    transition: 0.4s ease;
  }

  .footer-title:hover::after {
    width: 70px;
  }

  .footer-links li {
    margin-bottom: 12px;
  }

  .footer-links a {
    color: rgba(255, 255, 255, 0.78);
    text-decoration: none;
    transition: all 0.35s ease;
    position: relative;
  }

  .footer-links a::before {
    content: "";
    position: absolute;
    right: -12px;
    top: 50%;
    transform: translateY(-50%);
    width: 0;
    height: 2px;
    background: #0dcaf0;
    transition: 0.35s ease;
  }

  .footer-links a:hover {
    color: #fff;
    padding-right: 12px;
    text-shadow: 0 0 10px rgba(13, 202, 240, 0.5);
  }

  .footer-links a:hover::before {
    width: 8px;
  }

  .footer-contact li {
    color: rgba(255, 255, 255, 0.82);
    transition: 0.3s ease;
  }

  .footer-contact li:hover {
    transform: translateX(-4px);
    color: #fff;
  }

  .footer-social .social-icon {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    color: #fff;
    font-size: 18px;
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.12);
    backdrop-filter: blur(8px);
    transition: all 0.35s ease;
  }

  .footer-social .social-icon:hover {
    transform: translateY(-8px) scale(1.08);
    background: linear-gradient(135deg, #0dcaf0, #0d6efd);
    color: #fff;
    box-shadow: 0 12px 25px rgba(13, 202, 240, 0.35);
  }

  .footer-line {
    border-color: rgba(255, 255, 255, 0.12) !important;
  }

  @keyframes floatGlow {
    0% {
      transform: translateY(0) translateX(0) scale(1);
    }
    50% {
      transform: translateY(-20px) translateX(15px) scale(1.08);
    }
    100% {
      transform: translateY(10px) translateX(-10px) scale(0.96);
    }
  }

  @keyframes bgMove {
    0% {
      transform: scale(1) translateY(0);
    }
    100% {
      transform: scale(1.05) translateY(-10px);
    }
  }

  @keyframes linePulse {
    0%, 100% {
      opacity: 0.7;
      width: 65%;
    }
    50% {
      opacity: 1;
      width: 80%;
    }
  }

</style>

<footer class="footer-section text-white position-relative pt-5 pb-3 mt-5">
  <div class="footer-bg"></div>
  <div class="footer-glow footer-glow-1"></div>
  <div class="footer-glow footer-glow-2"></div>

  <div class="container position-relative" style="z-index: 2;">
    <div class="row g-4 align-items-start">

      <div class="col-lg-4 col-md-6">
        <h2 class="fw-bold mb-3 footer-brand">
          Aqari <span class="text-info">مصر</span>
        </h2>
        <p class="footer-text mb-4">
          منصة ذكية لتحليل وعرض العقارات في مصر، تساعدك على اكتشاف الأسعار،
          مقارنة المناطق، واتخاذ قرارات عقارية أفضل بثقة ووضوح.
        </p>

        <div class="d-flex gap-3 footer-social">
          <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
          <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
          <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
          <a href="#" class="social-icon"><i class="fab fa-x-twitter"></i></a>
        </div>
      </div>

      <div class="col-lg-2 col-md-6 col-6">
        <h4 class="footer-title mb-3">روابط سريعة</h4>
        <ul class="list-unstyled footer-links">
          <li><a href="#">الرئيسية</a></li>
          <li><a href="#">العقارات</a></li>
          <li><a href="#">تحليل الأسعار</a></li>
          <li><a href="#">المناطق</a></li>
          <li><a href="#">تواصل معنا</a></li>
        </ul>
      </div>

      <div class="col-lg-3 col-md-6 col-6">
        <h4 class="footer-title mb-3">أنواع العقارات</h4>
        <ul class="list-unstyled footer-links">
          <li><a href="#">شقق للبيع</a></li>
          <li><a href="#">شقق للإيجار</a></li>
          <li><a href="#">فيلات</a></li>
          <li><a href="#">محلات تجارية</a></li>
          <li><a href="#">أراضي</a></li>
        </ul>
      </div>

      <div class="col-lg-3 col-md-6">
        <h4 class="footer-title mb-3">تواصل معنا</h4>
        <ul class="list-unstyled footer-contact m-0">
          <li class="mb-3 d-flex align-items-center gap-2">
            <i class="fas fa-map-marker-alt text-info"></i>
            <span>القاهرة، مصر</span>
          </li>
          <li class="mb-3 d-flex align-items-center gap-2">
            <i class="fas fa-phone text-info"></i>
            <span>+20 100 123 4567</span>
          </li>
          <li class="mb-3 d-flex align-items-center gap-2">
            <i class="fas fa-envelope text-info"></i>
            <span>info@aqari-eg.com</span>
          </li>
          <li class="mb-3 d-flex align-items-center gap-2">
            <i class="fas fa-clock text-info"></i>
            <span>يوميًا من 9 ص إلى 10 م</span>
          </li>
        </ul>
      </div>
    </div>

    <hr class="footer-line my-4">

    <div class="row align-items-center text-center text-md-start">
      <div class="col-md-6 mb-2 mb-md-0">
        <p class="mb-0 small text-light">
          © 2026 Aqari مصر - جميع الحقوق محفوظة
        </p>
      </div>
      <div class="col-md-6 text-center text-md-end">
        <a href="#" class="small text-decoration-none text-light ms-3">سياسة الخصوصية</a>
        <a href="#" class="small text-decoration-none text-light ms-3">الشروط والأحكام</a>
      </div>
    </div>
  </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="<?php echo e(asset('js/script.js')); ?>"></script>


<script>
document.getElementById('futureYearRange').addEventListener('input', function() {
    const selectedYear = parseInt(this.value);
    const currentYear = 2026;
    const yearsDiff = selectedYear - currentYear;
    
    // هنجيب السعر الحالي من الكارت اللي فوق
    let basePrice = parseFloat(document.getElementById('avgPrice').innerText.replace(/,/g, ''));
    
    // معادلة النمو المركب 5% (Compound Interest)
    // FuturePrice = CurrentPrice * (1 + 0.05)^n
    let predicted = basePrice * Math.pow(1.05, yearsDiff);
    
    // تحديث الأرقام في الصفحة
    document.getElementById('displayYear').innerText = selectedYear;
    document.getElementById('predictedPrice').innerText = Math.round(predicted).toLocaleString() + ' ج.م';
});
</script>

</body>
</html>
<?php /**PATH C:\Users\mohamed\Downloads\ecommerce_full_fixed (2)\resources\views/index.blade.php ENDPATH**/ ?>