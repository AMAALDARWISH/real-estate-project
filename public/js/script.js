
let forecastChart = null, pieChart = null, barChart = null;
let map = null;

// دالة تحديث الداشبورد من الـ APIs
window.updateDashboard = async function() {
    const selCity = document.getElementById('cityFilter')?.value || 'all';
    const selYear = document.getElementById('yearFilter')?.value || '';

    // تجهيز الـ URL بناءً على الـ API Routes
    const baseUrl = '/api/v1/analytics/charts';
    const params = `?city=${selCity === 'all' ? '' : selCity}&year=${selYear}`;

    try {
        // 1. جلب بيانات الـ Market Share
        const shareRes = await fetch(`${baseUrl}/market-share`);
        const shareData = await shareRes.json();

        // 2. جلب بيانات التوقعات Forecast
        const forecastRes = await fetch(`${baseUrl}/forecast${params}`);
        const forecastData = await forecastRes.json();

        // 3. جلب بيانات العقارات لكل مدينة (الرسم البياني المفقود)
        const barRes = await fetch(`${baseUrl}/properties-per-city${params}`);
        const barData = await barRes.json();

        // 4. تحديث العدادات من الـ Overview Report
        const reportRes = await fetch(`/api/v1/analytics/reports/overview${params}`);
        const reportData = await reportRes.json();

        if (reportData.status === 'success') {
            if(document.getElementById('avgPrice')) document.getElementById('avgPrice').innerText = reportData.summary.overall_avg.toLocaleString() + " ج";
            if(document.getElementById('totalTx')) document.getElementById('totalTx').innerText = reportData.summary.total_properties || reportData.summary.total_cities;
            
            // تحديث الرسم البياني للتوقعات (Forecast)
            if(forecastData.status === 'success') renderForecastChart(forecastData);
            
            // تحديث رسمة الاستحواذ (Market Share)
            if(shareData.status === 'success') renderPieChart(shareData);

            // تحديث الرسم البياني للأعمدة (Transactions per City)
            if(barData.status === 'success') renderBarChart(barData);
        }
    } catch (error) {
        console.error("Integration Error:", error);
    }
};

// رسم التوقعات
function renderForecastChart(apiData) {
    const ctx = document.getElementById('forecastChart');
    if (!ctx || !apiData.labels) return;

    if (forecastChart) forecastChart.destroy();
    forecastChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: apiData.labels,
            datasets: [{
                label: 'متوسط السعر المتوقع (جنية)',
                data: apiData.data,
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { title: { display: true, text: apiData.insight } }
        }
    });
}

// رسم نصيب السوق (Market Share)
function renderPieChart(apiData) {
    const ctx = document.getElementById('pieChart');
    if (!ctx || !apiData.labels) return;

    if (pieChart) pieChart.destroy();
    pieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: apiData.labels,
            datasets: [{
                data: apiData.data,
                backgroundColor: ['#0d6efd', '#20c997', '#ffc107', '#dc3545', '#6610f2']
            }]
        },
        options: {
            responsive: true,
            plugins: { title: { display: true, text: apiData.insight } }
        }
    });
}

// رسم عدد العقارات لكل مدينة (Bar Chart)
function renderBarChart(apiData) {
    const ctx = document.getElementById('barChart');
    if (!ctx || !apiData.labels) return;

    if (barChart) barChart.destroy();
    barChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: apiData.labels,
            datasets: [{
                label: 'عدد العقارات',
                data: apiData.data,
                backgroundColor: '#20c997'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { title: { display: true, text: apiData.insight } }
        }
    });
}

// تشغيل عند التحميل وربط الفلاتر
document.addEventListener('DOMContentLoaded', () => {
    // ربط فلتر السنة
    if(document.getElementById('yearFilter')) {
        document.getElementById('yearFilter').addEventListener('change', window.updateDashboard);
    }
    
    // ربط فلتر المحافظات (الدروب داون)
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('city-item')) {
            const cityAttr = e.target.dataset.city;
            if (!cityAttr && e.target.href && e.target.href.includes('?city=')) {
                return;
            }
            
            e.preventDefault();
            const city = cityAttr || 'all';
            if(document.getElementById('cityFilter')) document.getElementById('cityFilter').value = city;
            if(document.getElementById('cityDropdown')) document.getElementById('cityDropdown').innerText = e.target.innerText;
            window.updateDashboard();
        }
    });

    window.updateDashboard();
});
