<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>منصة تحليل الاستثمار العقاري</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; background-color: #f4f7f6; }
        .card { border: none; border-radius: 15px; }
        .stat-card { color: white; transition: 0.3s; }
        .stat-card:hover { transform: translateY(-5px); }
        .project-img-preview { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd; }
        @media print { .no-print { display: none; } body { background-color: white; } .card { shadow: none; border: 1px solid #ddd; } }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold text-dark">🏢 منصة تحليل الاستثمار العقاري</h1>
        <p class="text-muted">نظام إدارة وترتيب المشروعات العقارية</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger shadow-sm">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card stat-card bg-primary p-4 shadow">
                <h4>إجمالي المشاريع</h4>
                <h2 class="display-5 fw-bold">{{ $totalProjects }}</h2>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card stat-card bg-success p-4 shadow">
                <h4>متوسط الأسعار</h4>
                <h2 class="display-5 fw-bold">{{ number_format($averagePrice, 0) }} <small style="font-size: 0.5em">ج.م</small></h2>
            </div>
        </div>
    </div>

    <div class="card shadow p-4 mb-5 no-print">
        <h5 class="mb-4 fw-bold text-primary">➕ إضافة مشروع جديد للمنصة</h5>
        <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small fw-bold">اسم المشروع</label>
                    <input type="text" name="name" class="form-control" placeholder="مثلاً: كمبوند العاصمه" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold">المدينة (ID)</label>
                    <input type="text" name="city" class="form-control" placeholder="cairo, giza, fayoum" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold">النوع</label>
                    <select name="type" class="form-select" required>
                        <option value="">اختر..</option>
                        <option value="سكني">سكني</option>
                        <option value="تجاري">تجاري</option>
                        <option value="إداري">إداري</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold">السعر</label>
                    <input type="number" name="price" class="form-control" placeholder="السعر بالجنيه" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">صورة المشروع</label>
                    <input type="file" name="image" class="form-control" accept="image/*" required>
                </div>
                <div class="col-md-12 mt-3">
                    <button type="submit" class="btn btn-primary px-5">حفظ المشروع</button>
                </div>
            </div>
        </form>
    </div>

    <div class="card shadow p-4">
        <div class="d-flex justify-content-between align-items-center mb-4 no-print">
            <form action="{{ route('projects.index') }}" method="GET" class="d-flex align-items-center gap-2">
                <label class="text-nowrap">ترتيب حسب:</label>
                <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>الأحدث أولاً</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>الأقدم أولاً</option>
                    <option value="alphabetical" {{ request('sort') == 'alphabetical' ? 'selected' : '' }}>أبجدياً (أ-ي)</option>
                </select>
            </form>
            <button onclick="window.print()" class="btn btn-outline-dark">
                🖨️ طباعة التقرير
            </button>
        </div>

        <h5 class="mb-3 fw-bold">📋 قائمة المشروعات الحالية</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>الصورة</th>
                        <th>اسم المشروع</th>
                        <th>المدينة</th>
                        <th>السعر</th>
                        <th>النوع</th>
                        <th class="no-print text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $project)
                    <tr>
                        <td>
                            @if($project->image)
                                <img src="{{ asset($project->image) }}" class="project-img-preview" alt="img">
                            @else
                                <span class="badge bg-secondary">لا توجد</span>
                            @endif
                        </td>
                        <td class="fw-bold">{{ $project->name }}</td>
                        <td><code class="text-primary">{{ $project->city }}</code></td>
                        <td>{{ number_format($project->price) }} ج.م</td>
                        <td><span class="badge bg-info text-dark">{{ $project->type }}</span></td>
                        <td class="no-print text-center">
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning btn-sm">تعديل</a>
                                <form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('حذف المشروع؟')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">لا توجد بيانات متاحة حالياً. ابدأ بإضافة مشروعك الأول!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>