<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>محافظات مصر</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css"
    rel="stylesheet"
  />

  <style>
    body {
      font-family: Tahoma, Arial, sans-serif;
      background:
        radial-gradient(circle at top right, rgba(13, 110, 253, 0.08), transparent 28%),
        linear-gradient(180deg, #f6f9ff 0%, #eef4ff 100%);
      color: #1f2937;
      min-height: 100vh;
    }

    a {
      text-decoration: none;
    }

    .hero {
      background: linear-gradient(135deg, #eef5ff 0%, #ffffff 100%);
      border: 1px solid #e6eef9;
      border-radius: 28px;
      padding: 28px;
      margin: 28px 0 20px;
      position: relative;
      overflow: hidden;
      box-shadow: 0 14px 34px rgba(15, 23, 42, 0.06);
    }

    .hero::before,
    .hero::after {
      content: "";
      position: absolute;
      border-radius: 50%;
      background: rgba(13, 110, 253, 0.07);
      animation: floatBubble 9s ease-in-out infinite;
    }

    .hero::before {
      left: -60px;
      top: -60px;
      width: 220px;
      height: 220px;
    }

    .hero::after {
      right: 30px;
      bottom: -70px;
      width: 180px;
      height: 180px;
      animation-delay: 1.5s;
    }

    .hero h1 {
      font-size: 2rem;
      font-weight: 800;
      margin-bottom: 8px;
      color: #23344d;
      position: relative;
      z-index: 2;
    }

    .hero p {
      color: #5f6b7d;
      margin: 0;
      position: relative;
      z-index: 2;
      line-height: 1.9;
      max-width: 900px;
    }

    .filter-box {
      background: rgba(255, 255, 255, 0.88);
      backdrop-filter: blur(8px);
      border: 1px solid #e6eef9;
      border-radius: 22px;
      padding: 20px;
      box-shadow: 0 10px 28px rgba(15, 23, 42, 0.05);
      margin-bottom: 18px;
    }

    .custom-input {
      min-height: 48px;
      border-radius: 14px;
      border: 1px solid #dbe6f6;
      transition: 0.25s ease;
    }

    .custom-input:focus {
      box-shadow: 0 0 0 0.18rem rgba(13, 110, 253, 0.12);
      border-color: #0d6efd;
    }

    .btn-main {
      min-height: 48px;
      border: none;
      border-radius: 14px;
      background: linear-gradient(135deg, #0d6efd 0%, #3385ff 100%);
      color: #fff;
      font-weight: 700;
      transition: 0.25s ease;
      box-shadow: 0 10px 22px rgba(13, 110, 253, 0.18);
    }

    .btn-main:hover {
      background: linear-gradient(135deg, #0b5ed7 0%, #2577f2 100%);
      color: #fff;
      transform: translateY(-2px);
    }

    .section-head {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 12px;
      margin-bottom: 18px;
      flex-wrap: wrap;
    }

    .section-head h2 {
      margin: 0;
      font-size: 1.8rem;
      font-weight: 800;
      color: #23344d;
    }

    .result-pill {
      background: rgba(255, 255, 255, 0.9);
      border: 1px solid #e6eef9;
      border-radius: 999px;
      padding: 10px 16px;
      font-weight: 700;
      color: #23344d;
      box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
    }

    .result-pill span {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 28px;
      height: 28px;
      border-radius: 50%;
      background: #0d6efd;
      color: #fff;
      margin-right: 8px;
      font-size: 13px;
    }

    .gov-card {
      background: rgba(255, 255, 255, 0.96);
      border: 1px solid #e7eef8;
      border-radius: 24px;
      overflow: hidden;
      box-shadow: 0 14px 32px rgba(15, 23, 42, 0.07);
      height: 100%;
      transition: transform 0.35s ease, box-shadow 0.35s ease, border-color 0.35s ease;
      opacity: 0;
      transform: translateY(24px) scale(0.98);
      animation: cardReveal 0.75s ease forwards;
      position: relative;
      isolation: isolate;
    }

    .gov-card::after {
      content: "";
      position: absolute;
      inset: 0;
      border-radius: 24px;
      padding: 1px;
      background: linear-gradient(135deg, rgba(13, 110, 253, 0.18), rgba(77, 163, 255, 0));
      -webkit-mask:
        linear-gradient(#fff 0 0) content-box,
        linear-gradient(#fff 0 0);
      -webkit-mask-composite: xor;
      mask-composite: exclude;
      pointer-events: none;
      opacity: 0;
      transition: 0.3s ease;
    }

    .gov-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 22px 44px rgba(15, 23, 42, 0.13);
      border-color: #d6e6ff;
    }

    .gov-card:hover::after {
      opacity: 1;
    }

    .gov-media {
      position: relative;
      overflow: hidden;
      height: 230px;
      background: #eef4ff;
    }

    .gov-image {
      height: 100%;
      width: 100%;
      object-fit: cover;
      display: block;
      transform: scale(1);
      transition: transform 0.6s ease, filter 0.4s ease;
    }

    .gov-card:hover .gov-image {
      transform: scale(1.08);
      filter: saturate(1.05) contrast(1.03);
    }

    .gov-overlay {
      position: absolute;
      inset: 0;
      background:
        linear-gradient(180deg, rgba(8, 23, 52, 0.04) 0%, rgba(8, 23, 52, 0.18) 45%, rgba(8, 23, 52, 0.75) 100%);
    }

    .gov-quick {
      position: absolute;
      right: 14px;
      left: 14px;
      bottom: 14px;
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
      z-index: 2;
    }

    .gov-chip {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 7px 12px;
      border-radius: 999px;
      background: rgba(255, 255, 255, 0.94);
      color: #123255;
      font-size: 12px;
      font-weight: 700;
      box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
    }

    .gov-chip-dark {
      background: rgba(13, 110, 253, 0.9);
      color: #fff;
    }

    .gov-body {
      padding: 18px;
      display: flex;
      flex-direction: column;
      height: calc(100% - 230px);
    }

    .region-badge {
      display: inline-block;
      padding: 7px 12px;
      border-radius: 999px;
      background: #edf5ff;
      color: #0d6efd;
      font-size: 12px;
      font-weight: 700;
      margin-bottom: 12px;
      align-self: flex-start;
    }

    .gov-title {
      font-size: 1.35rem;
      font-weight: 800;
      color: #20324b;
      margin-bottom: 3px;
    }

    .gov-en {
      font-size: 13px;
      color: #7b8798;
      margin-bottom: 12px;
    }

    .gov-desc {
      font-size: 14px;
      color: #4f5d72;
      line-height: 1.8;
      min-height: 74px;
      margin-bottom: 12px;
    }

    .mini-pills {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
      margin-bottom: 14px;
    }

    .mini-pill {
      background: #f8fbff;
      border: 1px solid #e6eef8;
      border-radius: 999px;
      padding: 7px 10px;
      font-size: 12px;
      color: #385173;
      font-weight: 700;
      transition: 0.25s ease;
    }

    .gov-card:hover .mini-pill {
      background: #eef5ff;
      border-color: #d6e6ff;
    }

    .featured-tags {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
      margin-bottom: 14px;
    }

    .featured-tag {
      background: linear-gradient(135deg, #f4f8ff 0%, #edf5ff 100%);
      color: #37557d;
      border: 1px solid #dde9fb;
      border-radius: 999px;
      padding: 7px 11px;
      font-size: 12px;
      font-weight: 700;
    }

    .gov-btn {
      margin-top: auto;
      min-height: 48px;
      border-radius: 14px;
      font-weight: 700;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      transition: 0.25s ease;
      background: linear-gradient(135deg, #0d6efd 0%, #3385ff 100%);
      border: none;
      box-shadow: 0 12px 22px rgba(13, 110, 253, 0.16);
    }

    .gov-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 16px 28px rgba(13, 110, 253, 0.24);
      background: linear-gradient(135deg, #0b5ed7 0%, #2577f2 100%);
    }

    .empty-box {
      background: #fff;
      border: 1px dashed #ccd9ee;
      border-radius: 22px;
      padding: 40px 20px;
      text-align: center;
      color: #667589;
      box-shadow: 0 10px 24px rgba(15, 23, 42, 0.04);
    }

    @keyframes cardReveal {
      from {
        opacity: 0;
        transform: translateY(24px) scale(0.98);
      }
      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    @keyframes floatBubble {
      0%, 100% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(14px);
      }
    }

    @media (max-width: 767px) {
      .hero h1 {
        font-size: 1.6rem;
      }

      .gov-media {
        height: 200px;
      }

      .gov-body {
        height: auto;
      }
    }
  </style>
</head>
<body>
  <main class="container py-3">
    <section class="hero">
      <h1>استكشف محافظات مصر</h1>
      <p>
        اختَر أي محافظة، وبعدها هتدخل على صفحة بنفس أسلوب المنصة العقارية، وفيها
        مشروعات وعقارات من مدن مختلفة داخل المحافظة مع البحث والفلترة.
      </p>
    </section>

    <section class="filter-box">
      <div class="row g-3 align-items-end">
        <div class="col-lg-5">
          <label class="form-label fw-bold">ابحث عن محافظة</label>
          <input
            id="searchInput"
            class="form-control custom-input"
            placeholder="اكتب اسم المحافظة أو العاصمة..."
          />
        </div>

        <div class="col-lg-4">
          <label class="form-label fw-bold">اختر الإقليم</label>
          <select id="regionFilter" class="form-select custom-input">
            <option value="all">كل الأقاليم</option>
            <option value="القاهرة الكبرى">القاهرة الكبرى</option>
            <option value="الوجه البحري">الوجه البحري</option>
            <option value="القناة">القناة</option>
            <option value="شمال الصعيد">شمال الصعيد</option>
            <option value="جنوب الصعيد">جنوب الصعيد</option>
            <option value="المحافظات الحدودية">المحافظات الحدودية</option>
            <option value="سيناء">سيناء</option>
          </select>
        </div>

        <div class="col-lg-3">
          <button id="resetBtn" class="btn btn-main w-100">إعادة تعيين</button>
        </div>
      </div>
    </section>

    <div class="section-head">
      <h2>المحافظات</h2>
      <div class="result-pill">عدد النتائج: <span id="resultsCount">27</span></div>
    </div>

    <div class="row g-4" id="governoratesContainer"></div>
  </main>

  <script src="{{ asset('js/data.js') }}"></script>
  <script src="{{ asset('js/app_v2.js') }}"></script>
</body>
</html>