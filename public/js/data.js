function formatPrice(num) {
  return new Intl.NumberFormat("en-US").format(num);
}

function hashCode(str) {
  let h = 0;
  for (let i = 0; i < str.length; i++) {
    h = (h << 5) - h + str.charCodeAt(i);
    h |= 0;
  }
  return Math.abs(h);
}

function seededNumber(seed, min, max) {
  const h = hashCode(seed);
  return min + (h % (max - min + 1));
}

const propertyImagePool = [
  "https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=1200&q=80",
  "https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=1200&q=80",
  "https://images.unsplash.com/photo-1605146769289-440113cc3d00?auto=format&fit=crop&w=1200&q=80",
  "https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1200&q=80",
  "https://images.unsplash.com/photo-1600585154526-990dced4db0d?auto=format&fit=crop&w=1200&q=80",
  "https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1200&q=80",
  "https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?auto=format&fit=crop&w=1200&q=80",
  "https://images.unsplash.com/photo-1600566752355-35792bedcfea?auto=format&fit=crop&w=1200&q=80",
  "https://images.unsplash.com/photo-1600047509358-9dc75507daeb?auto=format&fit=crop&w=1200&q=80",
  "https://images.unsplash.com/photo-1600607687644-c7171b42498f?auto=format&fit=crop&w=1200&q=80",
  "https://images.unsplash.com/photo-1600607687126-8a3414349a51?auto=format&fit=crop&w=1200&q=80",
  "https://images.unsplash.com/photo-1600573472591-ee6b68d14c68?auto=format&fit=crop&w=1200&q=80",
  "https://images.unsplash.com/photo-1494526585095-c41746248156?auto=format&fit=crop&w=1200&q=80",
  "https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1200&q=80",
  "https://images.unsplash.com/photo-1501183638710-841dd1904471?auto=format&fit=crop&w=1200&q=80",
  "https://images.unsplash.com/photo-1460317442991-0ec209397118?auto=format&fit=crop&w=1200&q=80",
  "https://images.unsplash.com/photo-1484154218962-a197022b5858?auto=format&fit=crop&w=1200&q=80",
  "https://images.unsplash.com/photo-1448630360428-65456885c650?auto=format&fit=crop&w=1200&q=80",
  "https://images.unsplash.com/photo-1505692952047-1a78307da8f2?auto=format&fit=crop&w=1200&q=80",
  "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=1200&q=80"
];

function getPropertyImage(governorateId, city, index) {
  const imageIndex = hashCode(`${governorateId}-${city}-${index}`) % propertyImagePool.length;
  return propertyImagePool[imageIndex];
}

const governoratesSeed = [
  {
    id: "cairo",
    name: "القاهرة",
    englishName: "Cairo",
    capital: "القاهرة",
    region: "القاهرة الكبرى",
    description: "العاصمة السياسية والإدارية وأكبر سوق عمراني وخدمي في مصر.",
    cities: ["القاهرة الجديدة", "العاصمة الإدارية", "مدينة نصر", "المعادي", "الشروق", "بدر"],
    featured: ["وسط البلد", "مصر القديمة", "المعادي"],
    minPrice: 2600000,
    maxPrice: 14000000
  },
  {
    id: "giza",
    name: "الجيزة",
    englishName: "Giza",
    capital: "الجيزة",
    region: "القاهرة الكبرى",
    description: "محافظة كبيرة تجمع بين الامتداد العمراني والمشروعات السكنية الراقية.",
    cities: ["6 أكتوبر", "الشيخ زايد", "حدائق أكتوبر", "المهندسين", "الدقي", "الهرم"],
    featured: ["الأهرامات", "6 أكتوبر", "الشيخ زايد"],
    minPrice: 2200000,
    maxPrice: 16000000
  },
  {
    id: "alexandria",
    name: "الإسكندرية",
    englishName: "Alexandria",
    capital: "الإسكندرية",
    region: "الوجه البحري",
    description: "مدينة ساحلية رئيسية تضم مناطق سكنية متنوعة ومشروعات جديدة.",
    cities: ["سموحة", "كفر عبده", "العجمي", "ميامي", "برج العرب الجديدة", "سيدي جابر"],
    featured: ["الكورنيش", "مكتبة الإسكندرية", "قلعة قايتباي"],
    minPrice: 1800000,
    maxPrice: 9500000
  },
  {
    id: "dakahlia",
    name: "الدقهلية",
    englishName: "Dakahlia",
    capital: "المنصورة",
    region: "الوجه البحري",
    description: "محافظة مهمة في الدلتا وتضم المنصورة الجديدة وعدة مناطق عمرانية نشطة.",
    cities: ["المنصورة", "المنصورة الجديدة", "طلخا", "جمصة", "ميت غمر", "بلقاس"],
    featured: ["المنصورة", "جمصة", "المنصورة الجديدة"],
    minPrice: 1400000,
    maxPrice: 6200000
  },
  {
    id: "red-sea",
    name: "البحر الأحمر",
    englishName: "Red Sea",
    capital: "الغردقة",
    region: "المحافظات الحدودية",
    description: "محافظة ساحلية وسياحية تضم وحدات فندقية وسكنية ومشروعات بحرية.",
    cities: ["الغردقة", "الجونة", "سهل حشيش", "مرسى علم", "سفاجا", "القصير"],
    featured: ["الغردقة", "الجونة", "مرسى علم"],
    minPrice: 3000000,
    maxPrice: 18000000
  },
  {
    id: "beheira",
    name: "البحيرة",
    englishName: "Beheira",
    capital: "دمنهور",
    region: "الوجه البحري",
    description: "محافظة كبيرة في غرب الدلتا وتضم مدنًا عمرانية وزراعية متنوعة.",
    cities: ["دمنهور", "كفر الدوار", "رشيد", "إدكو", "النوبارية الجديدة", "أبو حمص"],
    featured: ["دمنهور", "رشيد", "كفر الدوار"],
    minPrice: 1100000,
    maxPrice: 4500000
  },
  {
    id: "fayoum",
    name: "الفيوم",
    englishName: "Fayoum",
    capital: "الفيوم",
    region: "شمال الصعيد",
    description: "محافظة ذات طابع محلي وسوق عقاري مناسب مع توسعات عمرانية متدرجة.",
    cities: ["الفيوم", "الفيوم الجديدة", "سنورس", "طامية", "إبشواي", "يوسف الصديق"],
    featured: ["بحيرة قارون", "وادي الريان", "الفيوم الجديدة"],
    minPrice: 950000,
    maxPrice: 3800000
  },
  {
    id: "gharbia",
    name: "الغربية",
    englishName: "Gharbia",
    capital: "طنطا",
    region: "الوجه البحري",
    description: "محافظة مركزية في الدلتا وتضم مدنًا صناعية وتجارية وسكنية قوية.",
    cities: ["طنطا", "المحلة الكبرى", "زفتى", "كفر الزيات", "بسيون", "قطور"],
    featured: ["طنطا", "المحلة الكبرى", "زفتى"],
    minPrice: 1300000,
    maxPrice: 5200000
  },
  {
    id: "ismailia",
    name: "الإسماعيلية",
    englishName: "Ismailia",
    capital: "الإسماعيلية",
    region: "القناة",
    description: "محافظة مرتبطة بقناة السويس وتضم مناطق سكنية وخدمية ومشروعات حديثة.",
    cities: ["الإسماعيلية", "فايد", "القنطرة غرب", "القنطرة شرق", "التل الكبير", "مدينة المستقبل"],
    featured: ["بحيرة التمساح", "فايد", "القنطرة"],
    minPrice: 1500000,
    maxPrice: 7000000
  },
  {
    id: "monufia",
    name: "المنوفية",
    englishName: "Monufia",
    capital: "شبين الكوم",
    region: "الوجه البحري",
    description: "محافظة حيوية في الدلتا وتضم مدنًا خدمية وصناعية مثل السادات.",
    cities: ["شبين الكوم", "السادات", "منوف", "أشمون", "قويسنا", "بركة السبع"],
    featured: ["السادات", "شبين الكوم", "منوف"],
    minPrice: 1250000,
    maxPrice: 5000000
  },
  {
    id: "minya",
    name: "المنيا",
    englishName: "Minya",
    capital: "المنيا",
    region: "شمال الصعيد",
    description: "من المحافظات الكبرى في الصعيد وتضم مناطق عمرانية قديمة وجديدة.",
    cities: ["المنيا", "المنيا الجديدة", "ملوي", "مغاغة", "بني مزار", "سمالوط"],
    featured: ["تل العمارنة", "بني حسن", "المنيا الجديدة"],
    minPrice: 1000000,
    maxPrice: 4600000
  },
  {
    id: "qalyubia",
    name: "القليوبية",
    englishName: "Qalyubia",
    capital: "بنها",
    region: "القاهرة الكبرى",
    description: "محافظة قريبة جدًا من القاهرة وتضم مناطق سكنية وخدمية متصلة بالعاصمة.",
    cities: ["بنها", "شبرا الخيمة", "العبور", "القناطر الخيرية", "طوخ", "قليوب"],
    featured: ["بنها", "شبرا الخيمة", "العبور"],
    minPrice: 1700000,
    maxPrice: 8000000
  },
  {
    id: "new-valley",
    name: "الوادي الجديد",
    englishName: "New Valley",
    capital: "الخارجة",
    region: "المحافظات الحدودية",
    description: "أكبر محافظات مصر مساحة وتتميز بالواحات والمناطق الصحراوية الواسعة.",
    cities: ["الخارجة", "الداخلة", "الفرافرة", "باريس", "بلاط", "موط"],
    featured: ["الخارجة", "الداخلة", "الفرافرة"],
    minPrice: 850000,
    maxPrice: 3200000
  },
  {
    id: "suez",
    name: "السويس",
    englishName: "Suez",
    capital: "السويس",
    region: "القناة",
    description: "محافظة استراتيجية على خليج السويس وتضم مشروعات عمرانية وساحلية.",
    cities: ["السويس", "عتاقة", "العين السخنة", "فيصل", "الأربعين", "الجناين"],
    featured: ["العين السخنة", "عتاقة", "السويس"],
    minPrice: 1800000,
    maxPrice: 12000000
  },
  {
    id: "aswan",
    name: "أسوان",
    englishName: "Aswan",
    capital: "أسوان",
    region: "جنوب الصعيد",
    description: "محافظة جنوبية ذات طابع سياحي وثقافي وتضم مشروعات سكنية جديدة.",
    cities: ["أسوان", "أسوان الجديدة", "كوم أمبو", "إدفو", "دراو", "أبو سمبل"],
    featured: ["السد العالي", "فيلة", "أبو سمبل"],
    minPrice: 1300000,
    maxPrice: 5500000
  },
  {
    id: "assiut",
    name: "أسيوط",
    englishName: "Assiut",
    capital: "أسيوط",
    region: "شمال الصعيد",
    description: "محافظة مهمة في الصعيد وتضم مركزًا حضريًا وتعليميًا ومشروعات حديثة.",
    cities: ["أسيوط", "أسيوط الجديدة", "ديروط", "القوصية", "أبنوب", "منفلوط"],
    featured: ["جامعة أسيوط", "أسيوط الجديدة", "ديروط"],
    minPrice: 1200000,
    maxPrice: 5200000
  },
  {
    id: "beni-suef",
    name: "بني سويف",
    englishName: "Beni Suef",
    capital: "بني سويف",
    region: "شمال الصعيد",
    description: "محافظة قريبة من القاهرة وتضم توسعات عمرانية وصناعية واضحة.",
    cities: ["بني سويف", "بني سويف الجديدة", "الواسطى", "ناصر", "إهناسيا", "الفشن"],
    featured: ["بني سويف الجديدة", "ناصر", "الواسطى"],
    minPrice: 1000000,
    maxPrice: 4300000
  },
  {
    id: "port-said",
    name: "بورسعيد",
    englishName: "Port Said",
    capital: "بورسعيد",
    region: "القناة",
    description: "مدينة ساحلية مهمة عند مدخل قناة السويس وتضم مناطق سكنية مميزة.",
    cities: ["بورسعيد", "بورفؤاد", "حي الشرق", "حي الزهور", "الضواحي", "غرب بورسعيد"],
    featured: ["بورفؤاد", "الميناء", "الواجهة البحرية"],
    minPrice: 1700000,
    maxPrice: 6200000
  },
  {
    id: "damietta",
    name: "دمياط",
    englishName: "Damietta",
    capital: "دمياط",
    region: "الوجه البحري",
    description: "محافظة ساحلية وصناعية معروفة بالأثاث والمناطق الجديدة.",
    cities: ["دمياط", "دمياط الجديدة", "رأس البر", "شطا", "كفر سعد", "الزرقا"],
    featured: ["رأس البر", "دمياط الجديدة", "صناعة الأثاث"],
    minPrice: 1500000,
    maxPrice: 7500000
  },
  {
    id: "sharqia",
    name: "الشرقية",
    englishName: "Sharqia",
    capital: "الزقازيق",
    region: "الوجه البحري",
    description: "من أكبر محافظات الدلتا وتضم مدنًا صناعية وسكنية مهمة.",
    cities: ["الزقازيق", "العاشر من رمضان", "بلبيس", "أبو حماد", "منيا القمح", "الصالحية الجديدة"],
    featured: ["الزقازيق", "العاشر من رمضان", "بلبيس"],
    minPrice: 1400000,
    maxPrice: 6500000
  },
  {
    id: "south-sinai",
    name: "جنوب سيناء",
    englishName: "South Sinai",
    capital: "الطور",
    region: "سيناء",
    description: "محافظة سياحية عالمية تضم وجهات بحرية وجبلية ذات قيمة كبيرة.",
    cities: ["الطور", "شرم الشيخ", "دهب", "نويبع", "طابا", "رأس سدر"],
    featured: ["شرم الشيخ", "دهب", "سانت كاترين"],
    minPrice: 2800000,
    maxPrice: 20000000
  },
  {
    id: "kafr-el-sheikh",
    name: "كفر الشيخ",
    englishName: "Kafr El Sheikh",
    capital: "كفر الشيخ",
    region: "الوجه البحري",
    description: "محافظة زراعية وساحلية في شمال الدلتا وتضم مناطق سمكية معروفة.",
    cities: ["كفر الشيخ", "دسوق", "بلطيم", "مطوبس", "سيدي سالم", "فوه"],
    featured: ["دسوق", "بلطيم", "البرلس"],
    minPrice: 1100000,
    maxPrice: 4200000
  },
  {
    id: "matrouh",
    name: "مطروح",
    englishName: "Matrouh",
    capital: "مرسى مطروح",
    region: "المحافظات الحدودية",
    description: "محافظة ساحلية وحدودية تضم مناطق استثمارية وسياحية قوية.",
    cities: ["مرسى مطروح", "العلمين الجديدة", "رأس الحكمة", "سيدي عبد الرحمن", "سيوة", "الضبعة"],
    featured: ["مرسى مطروح", "سيوة", "العلمين"],
    minPrice: 3200000,
    maxPrice: 22000000
  },
  {
    id: "luxor",
    name: "الأقصر",
    englishName: "Luxor",
    capital: "الأقصر",
    region: "جنوب الصعيد",
    description: "محافظة أثرية عالمية وتضم مناطق عمرانية وخدمية وسياحية.",
    cities: ["الأقصر", "طيبة الجديدة", "البياضية", "القرنة", "إسنا", "أرمنت"],
    featured: ["معبد الكرنك", "وادي الملوك", "معبد الأقصر"],
    minPrice: 1400000,
    maxPrice: 6500000
  },
  {
    id: "qena",
    name: "قنا",
    englishName: "Qena",
    capital: "قنا",
    region: "جنوب الصعيد",
    description: "محافظة صعيدية مهمة وتضم مدنًا ومناطق خدمية وعمرانية متعددة.",
    cities: ["قنا", "قنا الجديدة", "نجع حمادي", "قفط", "أبو تشت", "قوص"],
    featured: ["دندرة", "نجع حمادي", "قفط"],
    minPrice: 1000000,
    maxPrice: 4300000
  },
  {
    id: "north-sinai",
    name: "شمال سيناء",
    englishName: "North Sinai",
    capital: "العريش",
    region: "سيناء",
    description: "محافظة حدودية مطلة على المتوسط وتضم مناطق سكنية وساحلية مهمة.",
    cities: ["العريش", "بئر العبد", "الشيخ زويد", "رفح", "نخل", "الحسنة"],
    featured: ["العريش", "بئر العبد", "الشيخ زويد"],
    minPrice: 1200000,
    maxPrice: 5000000
  },
  {
    id: "sohag",
    name: "سوهاج",
    englishName: "Sohag",
    capital: "سوهاج",
    region: "شمال الصعيد",
    description: "محافظة مركزية في جنوب مصر وتضم مدنًا ومراكز ذات أهمية محلية كبيرة.",
    cities: ["سوهاج", "سوهاج الجديدة", "أخميم", "جرجا", "طهطا", "البلينا"],
    featured: ["أخميم", "جرجا", "سوهاج الجديدة"],
    minPrice: 950000,
    maxPrice: 4000000
  }
];

const projectNames = [
  "Bosco",
  "Sarai",
  "Cairo Town",
  "El Patio",
  "Kattameya Heights",
  "The Brooks",
  "Uptown",
  "Grand City",
  "Capital Gardens",
  "Madinaty",
  "The Village",
  "De Joya"
];

const propertyTypes = ["شقة", "فيلا", "دوبلكس", "تاون هاوس", "بنتهاوس"];
const demands = ["مرتفع جدًا", "مرتفع", "متوسط", "منخفض"];

function generateProperties(governorate) {
  return Array.from({ length: 12 }, (_, i) => {
    const city = governorate.cities[i % governorate.cities.length];
    const title = `${projectNames[i % projectNames.length]} ${city}`;
    const type = propertyTypes[i % propertyTypes.length];
    const demand = demands[i % demands.length];
    const price = seededNumber(`${governorate.id}-price-${i}`, governorate.minPrice, governorate.maxPrice);
    const size = seededNumber(`${governorate.id}-size-${i}`, 95, 320);
    const beds = seededNumber(`${governorate.id}-beds-${i}`, 2, 5);
    const baths = seededNumber(`${governorate.id}-baths-${i}`, 1, 4);

    return {
      id: `${governorate.id}-property-${i + 1}`,
      title,
      city,
      type,
      demand,
      price,
      size,
      beds,
      baths,
      image: getPropertyImage(governorate.id, city, i)
    };
  });
}

const governoratesData = governoratesSeed.map((gov) => ({
  ...gov,
  properties: generateProperties(gov)
}));

export { governoratesData };