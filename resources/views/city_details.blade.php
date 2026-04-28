<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>تفاصيل المحافظة</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css"
    rel="stylesheet"
  />

  <style>
    body {
      font-family: Tahoma, Arial, sans-serif;
      background: #f3f6fb;
      color: #1f2937;
    }

    .page-wrap {
      display: grid;
      grid-template-columns: 290px 1fr;
      gap: 22px;
      padding: 24px 0;
    }

    .sidebar-panel,
    .content-panel,
    .topbar-panel {
      background: #fff;
      border: 1px solid #e6eef9;
      box-shadow: 0 8px 28px rgba(15, 23, 42, 0.05);
    }

    .sidebar-panel {
      border-radius: 20px;
      padding: 16px;
      position: sticky;
      top: 20px;
      align-self: start;
    }

    .main-col {
      min-width: 0;
    }

    .topbar-panel {
      border-radius: 18px;
      padding: 14px 16px;
      margin-bottom: 16px;
    }

    .search-line {
      display: flex;
      gap: 10px;
      align-items: center;
    }

    .search-line input {
      min-height: 44px;
      border-radius: 999px;
      border: 1px solid #dbe6f6;
      box-shadow: none;
    }

    .hero-panel {
      background: linear-gradient(180deg, #ffffff 0%, #f7fbff 100%);
      border: 1px solid #e6eef9;
      border-radius: 24px;
      padding: 22px;
      margin-bottom: 18px;
      position: relative;
      overflow: hidden;
    }

    .hero-panel::after {
      content: "";
      position: absolute;
      left: 20px;
      top: 20px;
      width: 160px;
      height: 160px;
      background: rgba(13, 110, 253, 0.05);
      border-radius: 50%;
    }

    .hero-title {
      font-size: 1.9rem;
      font-weight: 800;
      color: #24344c;
      margin-bottom: 4px;
      position: relative;
      z-index: 2;
    }

    .hero-sub {
      color: #66768d;
      margin-bottom: 16px;
      position: relative;
      z-index: 2;
    }

    .chips {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
      position: relative;
      z-index: 2;
    }

    .chip-btn {
      border: 1px solid #dbe6f6;
      background: #fff;
      color: #39506d;
      border-radius: 999px;
      padding: 9px 14px;
      font-size: 13px;
      font-weight: 700;
      cursor: pointer;
      transition: 0.2s ease;
    }

    .chip-btn.active,
    .chip-btn:hover {
      background: #eef5ff;
      color: #0d6efd;
      border-color: #bfd6fb;
    }

    .btn-filter {
      min-height: 50px;
      border-radius: 14px;
      font-weight: 700;
      background: #0d6efd;
      color: #fff;
      border: none;
      margin-bottom: 18px;
    }

    .btn-filter:hover {
      background: #0b5ed7;
      color: #fff;
    }

    .filter-block {
      background: #f8fbff;
      border: 1px solid #e6eef8;
      border-radius: 16px;
      padding: 12px;
      margin-bottom: 14px;
    }

    .filter-label {
      display: block;
      font-size: 13px;
      font-weight: 700;
      color: #5c6b81;
      margin-bottom: 8px;
    }

    .custom-input {
      min-height: 44px;
      border-radius: 12px;
      border: 1px solid #dbe6f6;
      box-shadow: none !important;
    }

    .range-row {
      display: flex;
      justify-content: space-between;
      color: #6d7c91;
      font-size: 12px;
      margin-top: 8px;
    }

    .demand-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
      font-size: 14px;
      color: #40536e;
      font-weight: 600;
    }

    .apply-btn {
      min-height: 50px;
      border-radius: 14px;
      font-weight: 800;
      background: #25a65a;
      color: #fff;
      border: none;
      width: 100%;
    }

    .apply-btn:hover {
      background: #20914f;
      color: #fff;
    }

    .summary-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 10px;
      margin-bottom: 14px;
    }

    .summary-badge {
      font-weight: 800;
      color: #2b3d57;
    }

    .summary-badge span {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-width: 30px;
      height: 30px;
      border-radius: 50%;
      background: #0d6efd;
      color: #fff;
      margin-right: 8px;
      font-size: 13px;
    }

    .gov-meta {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
    }

    .meta-pill {
      background: #eef5ff;
      color: #0d6efd;
      border-radius: 999px;
      padding: 8px 12px;
      font-size: 12px;
      font-weight: 700;
    }

    .properties-grid {
      display: grid;
      grid-template-columns: repeat(4, minmax(0, 1fr));
      gap: 16px;
    }

    .property-card {
      background: #fff;
      border: 1px solid #e6eef8;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 8px 18px rgba(15, 23, 42, 0.04);
      transition: 0.2s ease;
    }

    .property-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 14px 26px rgba(15, 23, 42, 0.08);
    }

    .property-image {
      width: 100%;
      height: 140px;
      object-fit: cover;
      display: block;
      background: #eef4ff;
    }

    .property-body {
      padding: 12px;
    }

    .property-title {
      font-size: 1.05rem;
      font-weight: 800;
      color: #25354d;
      margin-bottom: 3px;
      line-height: 1.4;
    }

    .property-city {
      font-size: 13px;
      color: #617089;
      margin-bottom: 8px;
    }

    .property-price {
      font-size: 1rem;
      font-weight: 800;
      color: #23344d;
      margin-bottom: 8px;
    }

    .badge-demand {
      display: inline-block;
      padding: 5px 10px;
      border-radius: 999px;
      font-size: 11px;
      font-weight: 800;
      color: #fff;
      margin-bottom: 8px;
    }

    .demand-high {
      background: #1fa64f;
    }

    .demand-very-high {
      background: #0f8b41;
    }

    .demand-medium {
      background: #f5a623;
    }

    .demand-low {
      background: #9ca3af;
    }

    .property-specs {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
      color: #6d7c91;
      font-size: 12px;
      margin-top: 8px;
    }

    .property-specs span {
      background: #f8fbff;
      border: 1px solid #e6eef8;
      border-radius: 999px;
      padding: 5px 8px;
    }

    .property-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 8px;
      margin-top: 10px;
      font-size: 12px;
      color: #708095;
    }

    .top-actions {
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
    }

    .btn-link-main {
      border-radius: 12px;
      font-weight: 700;
    }

    .empty-box {
      background: #fff;
      border: 1px dashed #cdd9eb;
      border-radius: 20px;
      padding: 40px 20px;
      text-align: center;
      color: #667589;
      grid-column: 1 / -1;
    }

    @media (max-width: 1399px) {
      .properties-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
      }
    }

    @media (max-width: 1199px) {
      .page-wrap {
        grid-template-columns: 1fr;
      }

      .sidebar-panel {
        position: static;
      }
    }

    @media (max-width: 767px) {
      .properties-grid {
        grid-template-columns: repeat(1, minmax(0, 1fr));
      }

      .hero-title {
        font-size: 1.45rem;
      }
    }
  </style>
</head>
<body>
  <main class="container">
    <div class="page-wrap">
      <aside class="sidebar-panel">
        <button class="btn btn-filter w-100">تصفية النتائج</button>

        <div class="filter-block">
          <label class="filter-label">اختر المحافظة</label>
          <select id="governorateSelect" class="form-select custom-input"></select>
        </div>

        <div class="filter-block">
          <label class="filter-label">نوع العقار</label>
          <select id="typeFilter" class="form-select custom-input">
            <option value="all">كل الأنواع</option>
            <option value="شقة">شقة</option>
            <option value="فيلا">فيلا</option>
            <option value="دوبلكس">دوبلكس</option>
            <option value="تاون هاوس">تاون هاوس</option>
            <option value="بنتهاوس">بنتهاوس</option>
          </select>
        </div>

        <div class="filter-block">
          <label class="filter-label">نطاق السعر</label>
          <input
            id="priceRange"
            type="range"
            class="form-range"
            min="1000000"
            max="25000000"
            step="250000"
            value="25000000"
          />
          <div class="range-row">
            <span>1,000,000 ج</span>
            <span id="priceRangeValue">25,000,000 ج</span>
          </div>
        </div>

        <div class="filter-block">
          <label class="filter-label">معدل الطلب</label>

          <div class="demand-item">
            <span>كل الطلبات</span>
            <input class="form-check-input demand-check" type="checkbox" value="all" checked />
          </div>

          <div class="demand-item">
            <span>مرتفع جدًا</span>
            <input class="form-check-input demand-check" type="checkbox" value="مرتفع جدًا" checked />
          </div>

          <div class="demand-item">
            <span>مرتفع</span>
            <input class="form-check-input demand-check" type="checkbox" value="مرتفع" checked />
          </div>

          <div class="demand-item">
            <span>متوسط</span>
            <input class="form-check-input demand-check" type="checkbox" value="متوسط" checked />
          </div>

          <div class="demand-item mb-0">
            <span>منخفض</span>
            <input class="form-check-input demand-check" type="checkbox" value="منخفض" checked />
          </div>
        </div>

        <button id="applyFiltersBtn" class="btn apply-btn">تطبيق</button>
      </aside>

      <section class="main-col">
        <div class="topbar-panel">
          <div class="search-line">
            <input
              id="globalSearchInput"
              class="form-control"
              placeholder="ابحث باسم المحافظة أو المشروع أو المدينة..."
            />
          </div>
        </div>

        <div class="hero-panel">
          <h1 id="heroTitle" class="hero-title"></h1>
          <div id="heroSubtitle" class="hero-sub"></div>

          <div class="chips">
            <button class="chip-btn active" data-sort="default">الأبرز</button>
            <button class="chip-btn" data-sort="low">الأقل سعرًا</button>
            <button class="chip-btn" data-sort="mid">متوسطة السعر</button>
            <button class="chip-btn" data-sort="high">الأعلى سعرًا</button>
          </div>
        </div>

        <div class="summary-bar">
          <div class="summary-badge">عدد النتائج: <span id="resultsCount">0</span></div>

          <div id="govMeta" class="gov-meta"></div>

          <div class="top-actions">
            <a href="index1.html" class="btn btn-outline-secondary btn-link-main">كل المحافظات</a>
          </div>
        </div>

        <div id="propertiesGrid" class="properties-grid"></div>
      </section>
    </div>
  </main>
 <script type="module" src="{{ asset('js/details.js') }}"></script>
</body>
</html>