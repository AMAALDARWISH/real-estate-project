<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تعديل المشروع</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow p-4 mx-auto" style="max-width: 600px;">
            <h4 class="mb-4">تعديل بيانات المشروع</h4>
            <form action="{{ route('projects.update', $project->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label>اسم المشروع</label>
                    <input type="text" name="name" class="form-control" value="{{ $project->name }}" required>
                </div>
                <div class="mb-3">
                    <label>المدينة</label>
                    <input type="text" name="city" class="form-control" value="{{ $project->city }}" required>
                </div>
                <div class="mb-3">
                    <label>النوع</label>
                    <input type="text" name="type" class="form-control" value="{{ $project->type }}" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">حفظ التغييرات</button>
                <a href="{{ route('projects.index') }}" class="btn btn-link w-100 mt-2 text-secondary">إلغاء</a>
            </form>
        </div>
    </div>
</body>
</html>
