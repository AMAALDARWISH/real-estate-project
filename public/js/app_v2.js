const container = document.getElementById("governoratesContainer");
const searchInput = document.getElementById("searchInput");
const regionFilter = document.getElementById("regionFilter");
const resetBtn = document.getElementById("resetBtn");
const resultsCount = document.getElementById("resultsCount");

const state = {
  search: "",
  region: "all"
};

function escapeHtml(value) {
  return String(value ?? "")
    .replace(/&/g, "&amp;")
    .replace(/"/g, "&quot;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;");
}

function normalizeText(text) {
  return (text || "").toString().trim().toLowerCase();
}

function getGovernorateTheme(gov) {
  const themes = {
    cairo: {
      icon: "🏙️",
      line1: "العاصمة والنبض الحضري",
      line2: "مشروعات حديثة ومراكز أعمال",
      c1: "#0d6efd",
      c2: "#7db4ff",
      c3: "#dbe9ff"
    },
    giza: {
      icon: "🏛️",
      line1: "الأهرامات والامتداد العمراني",
      line2: "مدن جديدة ومناطق راقية",
      c1: "#d97706",
      c2: "#f2b463",
      c3: "#fff1d7"
    },
    alexandria: {
      icon: "🌊",
      line1: "البحر والكورنيش",
      line2: "طابع ساحلي وسكني مميز",
      c1: "#0284c7",
      c2: "#67c3ee",
      c3: "#dff5ff"
    },
    "red-sea": {
      icon: "🏖️",
      line1: "سياحة وشواطئ ومنتجعات",
      line2: "سوق عقاري بحري متنامي",
      c1: "#0ea5a4",
      c2: "#69dbd8",
      c3: "#dbfbfa"
    },
    fayoum: {
      icon: "🏞️",
      line1: "واحات وبحيرات",
      line2: "طابع طبيعي هادئ",
      c1: "#16a34a",
      c2: "#86efac",
      c3: "#e6ffef"
    },
    aswan: {
      icon: "⛵",
      line1: "النيل والتراث الجنوبي",
      line2: "سياحة وثقافة ومشروعات",
      c1: "#7c3aed",
      c2: "#b794f6",
      c3: "#f1e9ff"
    },
    luxor: {
      icon: "🕌",
      line1: "الآثار والهوية التاريخية",
      line2: "وجهة عالمية مميزة",
      c1: "#b45309",
      c2: "#fbbf24",
      c3: "#fff5d8"
    },
    suez: {
      icon: "🚢",
      line1: "ميناء وخليج ومشروعات",
      line2: "موقع استراتيجي قوي",
      c1: "#2563eb",
      c2: "#7aa7ff",
      c3: "#e5efff"
    },
    ismailia: {
      icon: "🌴",
      line1: "قناة وبحيرات ونخيل",
      line2: "مدن هادئة وتوسعات حديثة",
      c1: "#14b8a6",
      c2: "#79ece0",
      c3: "#e4fffb"
    },
    "south-sinai": {
      icon: "🏔️",
      line1: "جبال وبحر وسياحة",
      line2: "شرم ودهب وطابع عالمي",
      c1: "#0891b2",
      c2: "#67d4ef",
      c3: "#dff8ff"
    },
    "north-sinai": {
      icon: "🌅",
      line1: "ساحل وحدود وهوية خاصة",
      line2: "العريش ومناطق ساحلية",
      c1: "#2563eb",
      c2: "#93c5fd",
      c3: "#ebf5ff"
    },
    matrouh: {
      icon: "🏝️",
      line1: "سواحل المتوسط",
      line2: "العلمين وسيوة ورأس الحكمة",
      c1: "#0284c7",
      c2: "#7dd3fc",
      c3: "#e0f7ff"
    }
  };

  const regionFallbacks = {
    "القاهرة الكبرى": {
      icon: "🏙️",
      line1: "قلب الحركة العمرانية",
      line2: "خدمات ومدن ومشروعات",
      c1: "#0d6efd",
      c2: "#8dbbff",
      c3: "#eaf2ff"
    },
    "الوجه البحري": {
      icon: "🌾",
      line1: "الدلتا والمدن الحيوية",
      line2: "سوق متوازن ومتنوّع",
      c1: "#0f9d58",
      c2: "#7edba7",
      c3: "#e8fff1"
    },
    "القناة": {
      icon: "🚢",
      line1: "محور لوجستي واستراتيجي",
      line2: "موانئ ومدن متنامية",
      c1: "#2563eb",
      c2: "#7aa7ff",
      c3: "#e6efff"
    },
    "شمال الصعيد": {
      icon: "🏘️",
      line1: "مدن صاعدة وتوسعات",
      line2: "فرص سكنية متنوعة",
      c1: "#9333ea",
      c2: "#c084fc",
      c3: "#f4e9ff"
    },
    "جنوب الصعيد": {
      icon: "🕌",
      line1: "تراث وسياحة وعمران",
      line2: "هوية جنوبية مميزة",
      c1: "#c2410c",
      c2: "#fdba74",
      c3: "#fff0e3"
    },
    "المحافظات الحدودية": {
      icon: "🌄",
      line1: "مساحات واسعة واستثمار",
      line2: "مناطق طبيعية وسياحية",
      c1: "#0891b2",
      c2: "#67e8f9",
      c3: "#e7fcff"
    },
    "سيناء": {
      icon: "🏔️",
      line1: "جبال وبحار وهوية فريدة",
      line2: "مدن ساحلية وسياحية",
      c1: "#0ea5e9",
      c2: "#7dd3fc",
      c3: "#e7f8ff"
    }
  };

  return themes[gov.id] || regionFallbacks[gov.region] || {
    icon: "📍",
    line1: gov.name,
    line2: gov.region,
    c1: "#0d6efd",
    c2: "#8dbbff",
    c3: "#eaf2ff"
  };
}

function buildGovernorateIllustration(gov) {
  const theme = getGovernorateTheme(gov);

  const svg = `
    <svg xmlns="http://www.w3.org/2000/svg" width="1200" height="700" viewBox="0 0 1200 700">
      <defs>
        <linearGradient id="bg" x1="0" y1="0" x2="1" y2="1">
          <stop offset="0%" stop-color="${theme.c3}"/>
          <stop offset="55%" stop-color="${theme.c2}"/>
          <stop offset="100%" stop-color="${theme.c1}"/>
        </linearGradient>
        <linearGradient id="glass" x1="0" y1="0" x2="0" y2="1">
          <stop offset="0%" stop-color="rgba(255,255,255,0.42)"/>
          <stop offset="100%" stop-color="rgba(255,255,255,0.06)"/>
        </linearGradient>
      </defs>

      <rect width="1200" height="700" fill="url(#bg)"/>
      <circle cx="1040" cy="100" r="120" fill="rgba(255,255,255,0.16)"/>
      <circle cx="170" cy="110" r="90" fill="rgba(255,255,255,0.12)"/>
      <circle cx="980" cy="580" r="180" fill="rgba(255,255,255,0.08)"/>

      <path d="M0 560 C200 500, 330 630, 540 560 C700 506, 850 600, 1200 520 L1200 700 L0 700 Z" fill="rgba(255,255,255,0.16)"/>
      <path d="M0 610 C240 560, 380 660, 620 610 C800 572, 960 650, 1200 595 L1200 700 L0 700 Z" fill="rgba(10,30,55,0.10)"/>

      <rect x="95" y="380" width="120" height="170" rx="20" fill="rgba(10,30,55,0.18)"/>
      <rect x="235" y="330" width="120" height="220" rx="20" fill="rgba(10,30,55,0.12)"/>
      <rect x="380" y="280" width="120" height="270" rx="20" fill="rgba(10,30,55,0.18)"/>
      <rect x="525" y="345" width="120" height="205" rx="20" fill="rgba(10,30,55,0.12)"/>
      <rect x="670" y="305" width="120" height="245" rx="20" fill="rgba(10,30,55,0.18)"/>

      <rect x="70" y="60" width="460" height="120" rx="28" fill="url(#glass)" stroke="rgba(255,255,255,0.28)" />
      <text x="110" y="136" fill="#0f2744" font-size="64" font-family="Tahoma, Arial" font-weight="700">${escapeHtml(gov.name)}</text>

      <rect x="70" y="200" width="560" height="76" rx="22" fill="rgba(255,255,255,0.22)" stroke="rgba(255,255,255,0.18)" />
      <text x="105" y="250" fill="#14304d" font-size="34" font-family="Tahoma, Arial" font-weight="700">${escapeHtml(theme.line1)}</text>

      <rect x="70" y="294" width="620" height="72" rx="20" fill="rgba(255,255,255,0.16)" />
      <text x="105" y="340" fill="#1d456e" font-size="30" font-family="Tahoma, Arial">${escapeHtml(theme.line2)}</text>

      <circle cx="980" cy="250" r="110" fill="rgba(255,255,255,0.18)" />
      <text x="980" y="282" text-anchor="middle" fill="#103253" font-size="120">${theme.icon}</text>
    </svg>
  `;

  return `data:image/svg+xml;charset=UTF-8,${encodeURIComponent(svg)}`;
}

function getGovernorateCover(gov) {
  if (gov.coverImage && typeof gov.coverImage === "string") {
    return gov.coverImage;
  }

  return buildGovernorateIllustration(gov);
}

function getFilteredGovernorates() {
  let filtered = [...governoratesData];

  if (state.region !== "all") {
    filtered = filtered.filter((g) => g.region === state.region);
  }

  if (state.search) {
    const q = normalizeText(state.search);

    filtered = filtered.filter((g) => {
      const content = [
        g.name,
        g.englishName,
        g.capital,
        g.region,
        g.description,
        ...g.cities,
        ...g.featured
      ].join(" ").toLowerCase();

      return content.includes(q);
    });
  }

  return filtered;
}

function createFeaturedTags(gov) {
  return gov.featured
    .slice(0, 3)
    .map((item) => `<span class="featured-tag">${escapeHtml(item)}</span>`)
    .join("");
}

function createCard(gov, index) {
  const delay = `${index * 0.06}s`;

  return `
    <div class="col-xl-4 col-md-6">
      <div class="gov-card" style="animation-delay: ${delay};">
        <div class="gov-media">
          <img
            class="gov-image"
            src="${getGovernorateCover(gov)}"
            alt="${escapeHtml(gov.name)}"
            loading="lazy"
          />
          <div class="gov-overlay"></div>

          <div class="gov-quick">
            <span class="gov-chip">${escapeHtml(gov.capital)}</span>
            <span class="gov-chip gov-chip-dark">${escapeHtml(gov.region)}</span>
          </div>
        </div>

        <div class="gov-body">
          <span class="region-badge">${escapeHtml(gov.region)}</span>
          <div class="gov-title">${escapeHtml(gov.name)}</div>
          <div class="gov-en">${escapeHtml(gov.englishName)}</div>

          <p class="gov-desc">${escapeHtml(gov.description)}</p>

          <div class="featured-tags">
            ${createFeaturedTags(gov)}
          </div>

          <div class="mini-pills">
            <span class="mini-pill">العاصمة: ${escapeHtml(gov.capital)}</span>
            <span class="mini-pill">عدد المدن: ${gov.cities.length}</span>
            <span class="mini-pill">عدد المشروعات: ${gov.properties.length}</span>
          </div>

          <a href="/city-details/${encodeURIComponent(gov.id)}" class="btn btn-primary gov-btn w-100">
            استكشاف المحافظة
          </a>
        </div>
      </div>
    </div>
  `;
}

function renderGovernorates() {
  const filtered = getFilteredGovernorates();
  resultsCount.textContent = filtered.length;

  if (!filtered.length) {
    container.innerHTML = `
      <div class="col-12">
        <div class="empty-box">
          <h3 class="mb-2">لا توجد نتائج</h3>
          <p class="mb-0">جرّب تغيير اسم المحافظة أو الإقليم.</p>
        </div>
      </div>
    `;
    return;
  }

  container.innerHTML = filtered.map((gov, index) => createCard(gov, index)).join("");
}

searchInput.addEventListener("input", function () {
  state.search = this.value;
  renderGovernorates();
});

regionFilter.addEventListener("change", function () {
  state.region = this.value;
  renderGovernorates();
});

resetBtn.addEventListener("click", function () {
  state.search = "";
  state.region = "all";
  searchInput.value = "";
  regionFilter.value = "all";
  renderGovernorates();
});

renderGovernorates();