import { governoratesData } from './data.js';
const urlParams = new URLSearchParams(window.location.search);
const initialGovernorateId = window.location.pathname.split('/').pop() || "cairo";

const governorateSelect = document.getElementById("governorateSelect");
const typeFilter = document.getElementById("typeFilter");
const priceRange = document.getElementById("priceRange");
const priceRangeValue = document.getElementById("priceRangeValue");
const applyFiltersBtn = document.getElementById("applyFiltersBtn");
const globalSearchInput = document.getElementById("globalSearchInput");
const heroTitle = document.getElementById("heroTitle");
const heroSubtitle = document.getElementById("heroSubtitle");
const govMeta = document.getElementById("govMeta");
const propertiesGrid = document.getElementById("propertiesGrid");
const resultsCount = document.getElementById("resultsCount");
const demandChecks = Array.from(document.querySelectorAll(".demand-check"));
const sortButtons = Array.from(document.querySelectorAll(".chip-btn"));

const state = {
  governorateId: initialGovernorateId,
  search: "",
  type: "all",
  maxPrice: Number(priceRange.value),
  sort: "default"
};

// --- دالة الربط الأساسية مع الـ API بتاعك ---
async function fetchProjectsFromLaravel() {
    try {
        // بنبعت الطلب للسيرفر بتاعك مع الفلاتر المختارة
       const response = await fetch(`/api/projects-data?city=${state.governorateId}&search=${state.search}&type=${state.type}&max_price=${state.maxPrice}`);
        const text = await response.text(); 
        
        // السطر ده هو "السر" عشان يمسح علامة < لو ظهرت غلط من السيرفر
        const cleanText = text.substring(text.indexOf('[')); 
        const data = JSON.parse(cleanText);
        
        console.log("البيانات وصلت سليمة:", data);
        return data;
    } catch (error) {
        console.error("خطأ في الاتصال بالباك-إند:", error);
        return [];
     }
}

function normalizeText(text) {
  return (text || "").toString().trim().toLowerCase();
}

function propertyFallback(label) {
  const svg = `
    <svg xmlns="http://www.w3.org/2000/svg" width="700" height="450">
      <defs>
        <linearGradient id="g" x1="0" y1="0" x2="1" y2="1">
          <stop offset="0%" stop-color="#eaf3ff"/>
          <stop offset="100%" stop-color="#cfe2ff"/>
        </linearGradient>
      </defs>
      <rect width="100%" height="100%" fill="url(#g)"/>
      <text x="50%" y="75%" text-anchor="middle" fill="#0d6efd" font-size="28" font-family="Tahoma, Arial" font-weight="700">${label}</text>
    </svg>
  `;
  return "data:image/svg+xml;charset=UTF-8," + encodeURIComponent(svg);
}

window.handlePropertyImgError = function (img, label) {
  img.onerror = null;
  img.src = propertyFallback(label);
};

// هنجيب بيانات المحافظة من ملف data.js الأصلي للهيدر فقط
function getCurrentGovernorate() {
  return governoratesData.find((g) => g.id === state.governorateId) || governoratesData[0];
}

function populateGovernorateSelect() {
  governorateSelect.innerHTML = governoratesData.map((g) => `
    <option value="${g.id}" ${g.id === state.governorateId ? "selected" : ""}>${g.name}</option>
  `).join("");
}

function formatCurrencyArabic(value) {
  return new Intl.NumberFormat("en-US").format(value) + " ج";
}

function renderPropertyCard(item) {
  let statusText = "";
let statusColor = ""; // هنستخدم اللون مباشرة بدل الكلاس

// نستخدم السعر المتوقع للحالة والسعر الأصلي للعرض
const price = item.predicted_price;

if (price >= 25000000) {
    statusText = "مرتفع جداً";
    statusColor = "#2D5A27"; // أخضر غامق
} else if (price >= 13000000) {
    statusText = "مرتفع";
    statusColor = "#5BAE55"; // أخضر فاتح
} else if (price >= 7000000) {
    statusText = "متوسط";
    statusColor = "#E29E37"; // برتقالي
} else {
    statusText = "منخفض";
    statusColor = "#5B7DAE"; // أزرق
}
  // ملاحظة: بنستخدم اسم الحقل كما هو في الداتابيز (name, price, city, image)
 return `
    <div class="property-card">
        <img class="property-image" src="${item.image}" alt="${item.name}" onerror="this.src='/default-home.jpg'" />
        <div class="property-body">
            <div class="property-title">${item.name}</div>
            <div class="property-city">${item.city}</div>
            <div class="property-price" style="font-size: 0.8em; color: #777; text-decoration: line-through;">السعر الأساسي: ${formatCurrencyArabic(item.original_price)}</div>
            <div class="property-price" style="color: #28a745; font-weight: bold;">السعر المحدث: ${formatCurrencyArabic(item.predicted_price)} 📈</div>
            <span style="background-color: ${statusColor}; color: white; padding: 4px 12px; border-radius: 12px; font-weight: bold; display: inline-block;">${statusText}</span>
            <div class="property-specs">
                <span>${item.type}</span>
                <span>عقار حقيقي</span>
            </div>
            <div class="property-footer">
                <button class="btn btn-sm btn-primary w-100 mt-2">عرض التفاصيل</button>
            </div>
        </div>
    </div>`;
}

function renderGovernorateHeader(governorate) {
  
  const heroTitle = document.getElementById('heroTitle');
  if (heroTitle) heroTitle.textContent = `استكشاف المشروعات العقارية في ${governorate.name}`;

  const heroSubtitle = document.getElementById('heroSubtitle');
  if (heroSubtitle) heroSubtitle.textContent = governorate.description;

  if (govMeta) {
  govMeta.innerHTML = `
    <span class="meta-pill">الإقليم: ${governorate.region}</span>
    <span class="meta-pill">العاصمة: ${governorate.capital}</span>
    <span class="meta-pill">عدد المدن: ${governorate.cities.length}</span>
  `;
  }
}

// الدالة الأساسية اللي اتعدلت عشان تبقى Async
async function renderPage() {
  const governorate = getCurrentGovernorate();
  renderGovernorateHeader(governorate);

  // سحب البيانات الحقيقية من السيرفر بتاعك
  const items = await fetchProjectsFromLaravel();
  resultsCount.textContent = items.length;

  if (!items.length) {
    propertiesGrid.innerHTML = `
      <div class="empty-box">
        <h3 class="mb-2">لا توجد نتائج حقيقية</h3>
        <p class="mb-0">تأكد من إضافة مشاريع لهذه المحافظة من لوحة التحكم.</p>
      </div>
    `;
    return;
  }

  propertiesGrid.innerHTML = items.map(renderPropertyCard).join("");
}

// المستمعات (Event Listeners)
governorateSelect.addEventListener("change", function () {
  window.location.href =`/city-details/${this.value}`;
});

priceRange.addEventListener("input", function () {
  priceRangeValue.textContent = formatCurrencyArabic(Number(this.value));
});

applyFiltersBtn.addEventListener("click", function () {
  state.search = globalSearchInput.value.trim();
  state.type = typeFilter.value;
  state.maxPrice = Number(priceRange.value);
  renderPage();
});

sortButtons.forEach((btn) => {
  btn.addEventListener("click", function () {
    state.sort = this.dataset.sort;
    renderPage();
  });
});

// التشغيل الابتدائي
populateGovernorateSelect();
priceRangeValue.textContent = formatCurrencyArabic(Number(priceRange.value));
renderPage();
