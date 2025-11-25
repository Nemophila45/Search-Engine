@extends('layouts.admin')

@section('title', 'Grafik Penyakit')

@section('content')
    <div class="flex flex-col gap-6">

            {{-- Kontrol Unduh Grafik --}}
        <div class="mt-4 rounded-2xl border border-emerald-100 bg-white/90 px-4 py-3 shadow-sm max-w-5xl w-[85%] mx-auto">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm font-semibold text-emerald-700">
                    Unduh Grafik
                </p>

                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-3">
                    <select
                        id="downloadTarget"
                        class="rounded-xl border border-emerald-200 bg-white/80 px-3 py-2 text-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 transition"
                    >
                        <option value="bar">Grafik Penyakit</option>
                        <option value="pie">Diagram Lingkaran Diagnosa</option>
                        <option value="both">Keduanya</option>
                    </select>

                    <button
                        type="button"
                        id="downloadButton"
                        class="inline-flex items-center justify-center rounded-xl bg-emerald-500 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-300"
                    >
                        Unduh
                    </button>
                </div>
            </div>
        </div>

        {{-- Modal Konfirmasi Unduhan --}}
        <div
            id="downloadConfirmOverlay"
            class="fixed inset-0 z-40 hidden bg-slate-900/60 backdrop-blur-sm"
            role="dialog"
            aria-modal="true"
            aria-labelledby="downloadConfirmTitle"
        >
            <div class="flex min-h-full items-center justify-center px-4">
                <div class="w-full max-w-md rounded-3xl bg-white p-6 shadow-2xl">
                    <div class="space-y-2 text-center">
                        <p id="downloadConfirmTitle" class="text-lg font-semibold text-emerald-800">Konfirmasi Unduhan</p>
                        <p class="text-sm text-slate-600">
                            Anda akan mengunduh
                            <span id="downloadConfirmTarget" class="font-semibold text-emerald-700"></span>.
                            Pastikan rentang waktunya sudah sesuai.
                        </p>
                        <p class="text-sm text-slate-600">
                            Rentang saat ini:
                            <span id="downloadConfirmRange" class="font-semibold text-emerald-700"></span>
                        </p>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <button
                            type="button"
                            id="downloadConfirmCancel"
                            class="rounded-2xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50"
                        >
                            Batal
                        </button>
                        <button
                            type="button"
                            id="downloadConfirmYes"
                            class="rounded-2xl bg-emerald-500 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-300"
                        >
                            Ya, unduh
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card Grafik Batang --}}
        <div id="barChartCard" class="rounded-2xl border border-emerald-100 bg-white/95 p-6 shadow-xl shadow-emerald-100 max-w-5xl w-[85%] mx-auto">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.3em] text-emerald-500">Laporan</p>
                    <h1 class="text-3xl font-bold text-emerald-800 mt-1">Grafik Penyakit</h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Visualisasi jumlah kasus berdasarkan diagnosa pada rentang waktu <span class="font-semibold text-emerald-700">{{ $rangeOptions[$barRange] ?? $rangeOptions['1m'] }}</span>.
                    </p>
                </div>

                {{-- Rentang waktu khusus untuk grafik batang --}}
                <form id="barRangeForm" method="GET" action="{{ route('admin.reports.disease-chart') }}" class="lg:w-64">
                    {{-- pertahankan pilihan pie range saat user ganti bar range --}}
                    <input type="hidden" name="pie_range" value="{{ $pieRange }}">
                    <label for="bar_range" class="text-sm font-semibold text-emerald-700">Rentang Waktu Grafik</label>
                    <select
                        id="bar_range"
                        name="bar_range"
                        class="mt-1 w-full rounded-xl border border-emerald-200 bg-white/80 px-4 py-2.5 text-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 transition"
                        onchange="document.getElementById('barRangeForm').submit()"
                    >
                        @foreach ($rangeOptions as $value => $label)
                            <option value="{{ $value }}" @selected($barRange === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            @if ($barLabels->isNotEmpty())
                <div class="mt-4 rounded-2xl border border-emerald-100 bg-emerald-50/60 px-4 py-3 text-sm text-emerald-900">
                    Total diagnosa penyakit pada rentang waktu
                    <span class="font-semibold text-emerald-700">{{ $rangeOptions[$barRange] ?? $rangeOptions['1m'] }}</span>:
                    <span class="font-bold text-emerald-900">{{ number_format($barTotal) }}</span> kasus.
                </div>
            @endif

            <div class="mt-6">
                @if ($barLabels->isEmpty())
                    <div class="rounded-xl border border-emerald-100 bg-emerald-50/70 px-4 py-3 text-sm text-emerald-800">
                        Belum ada data riwayat medis pada periode ini.
                    </div>
                @else
                    <div class="relative min-h-[280px]">
                        <canvas id="diseaseChart" class="w-full"></canvas>
                    </div>
                @endif
            </div>
        </div>

        {{-- Card Diagram Lingkaran --}}
        <div id="pieChartCard" class="rounded-3xl border border-emerald-100 bg-white/95 p-6 shadow-xl shadow-emerald-100 max-w-5xl w-[85%] mx-auto">
            <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex flex-col gap-1">
                    <p class="text-sm font-semibold uppercase tracking-[0.3em] text-emerald-500">
                        Distribusi Diagnosa
                    </p>
                    <h2 class="text-2xl font-bold text-emerald-800">Diagram Lingkaran Diagnosa</h2>
                    <p class="text-sm text-slate-500">
                        Persentase kontribusi tiap diagnosa terhadap total kasus pada rentang waktu <span class="font-semibold text-emerald-700">{{ $rangeOptions[$pieRange] ?? $rangeOptions['1m'] }}</span>.
                    </p>
                </div>

                {{-- Rentang waktu khusus untuk pie chart --}}
                <form id="pieRangeForm" method="GET" action="{{ route('admin.reports.disease-chart') }}" class="lg:w-64">
                    {{-- pertahankan pilihan bar range saat user ganti pie range --}}
                    <input type="hidden" name="bar_range" value="{{ $barRange }}">
                    <label for="pie_range" class="text-sm font-semibold text-emerald-700">Rentang Waktu Diagram</label>
                    <select
                        id="pie_range"
                        name="pie_range"
                        class="mt-1 w-full rounded-xl border border-emerald-200 bg-white/80 px-4 py-2.5 text-sm focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 transition"
                        onchange="document.getElementById('pieRangeForm').submit()"
                    >
                        @foreach ($rangeOptions as $value => $label)
                            <option value="{{ $value }}" @selected($pieRange === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="mt-6">
                @if ($pieLabels->isEmpty())
                    <div class="rounded-xl border border-emerald-100 bg-emerald-50/70 px-4 py-3 text-sm text-emerald-800">
                        Belum ada data untuk menampilkan diagram lingkaran pada periode ini.
                    </div>
                @else
                    {{-- Pie chart di kiri, legend teks di kanan --}}
                    <div class="flex flex-col items-center gap-4 sm:flex-row sm:justify-center">
                        <div class="relative h-72 w-72 sm:h-80 sm:w-80">
                            <canvas id="diseasePieChart" class="w-full h-full"></canvas>
                        </div>

                        <ul id="diseasePieLegend"
                            class="hidden flex-col gap-2 text-sm text-slate-600 sm:ml-6"
                            aria-hidden="true">
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>


@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const barLabels = @json($barLabels);
            const barData = @json($barData);

            const pieLabels = @json($pieLabels);
            const percentages = @json($percentages);
            const barRangeLabel = @json($rangeOptions[$barRange] ?? $rangeOptions['1m']);
            const pieRangeLabel = @json($rangeOptions[$pieRange] ?? $rangeOptions['1m']);
            const palette = [
                '#FF4B4B', // Merah
                '#FFD93B', // Kuning
                '#4BC0FF', // Biru muda
                '#7ED957', // Hijau muda
                '#A0AEC0', // Abu-abu
                '#FFA500', // Oren
                '#9B59B6', // Ungu
                '#A0522D', // Coklat
                '#FF9AA2', // Merah muda
                '#F6E3B4', // Krem
            ];

            const STORAGE_KEY = 'diagnosisColorMap';
            let colorMap = {};
            let nextPaletteIndex = 0;
            try {
                const persisted = localStorage.getItem(STORAGE_KEY);
                if (persisted) {
                    const parsed = JSON.parse(persisted);
                    colorMap = parsed.map ?? {};
                    nextPaletteIndex = parsed.next ?? 0;
                }
            } catch (e) {
                colorMap = {};
                nextPaletteIndex = 0;
            }

            const persistColorMap = () => {
                try {
                    localStorage.setItem(STORAGE_KEY, JSON.stringify({
                        map: colorMap,
                        next: nextPaletteIndex % palette.length,
                    }));
                } catch (e) {
                    // ignore storage errors
                }
            };

            const getColorForLabel = (label) => {
                if (!label) return palette[0];
                if (colorMap[label]) {
                    return colorMap[label];
                }
                const color = palette[nextPaletteIndex % palette.length];
                colorMap[label] = color;
                nextPaletteIndex += 1;
                persistColorMap();
                return color;
            };

            // === Fitur Unduh Grafik ===
            const downloadTarget = document.getElementById('downloadTarget');
            const downloadButton = document.getElementById('downloadButton');
            const confirmOverlay = document.getElementById('downloadConfirmOverlay');
            const confirmTargetText = document.getElementById('downloadConfirmTarget');
            const confirmRangeText = document.getElementById('downloadConfirmRange');
            const confirmCancelBtn = document.getElementById('downloadConfirmCancel');
            const confirmYesBtn = document.getElementById('downloadConfirmYes');
            let pendingDownloadAction = null;

            function createSelectPlaceholders(card) {
                const replacements = [];
                if (!card) {
                    return () => {};
                }

                const selects = card.querySelectorAll('select');
                selects.forEach(select => {
                    const placeholder = document.createElement('div');
                    placeholder.className = `${select.className} pointer-events-none select-placeholder flex items-center justify-between`;
                    placeholder.style.position = 'relative';
                    placeholder.style.backgroundColor = getComputedStyle(select).backgroundColor || '#ffffff';

                    const textSpan = document.createElement('span');
                    textSpan.textContent = select.options[select.selectedIndex]?.text || '';
                    textSpan.className = 'truncate';

                    const arrowSpan = document.createElement('span');
                    arrowSpan.textContent = '▾';
                    arrowSpan.style.color = '#059669';
                    arrowSpan.style.marginLeft = '12px';

                    placeholder.appendChild(textSpan);
                    placeholder.appendChild(arrowSpan);

                    select.style.display = 'none';
                    select.parentNode.insertBefore(placeholder, select);

                    replacements.push({ select, placeholder });
                });

                return () => {
                    replacements.forEach(({ select, placeholder }) => {
                        placeholder.remove();
                        select.style.display = '';
                    });
                };
            }

            async function captureCard(cardId) {
                const card = document.getElementById(cardId);
                if (!card || !window.html2canvas) {
                    return null;
                }

                const cleanupPlaceholders = createSelectPlaceholders(card);

                try {
                    const canvas = await window.html2canvas(card, {
                        scale: 2,
                        useCORS: true,
                        backgroundColor: '#ffffff',
                    });

                    return {
                        canvas,
                        image: canvas.toDataURL('image/png', 1.0),
                        width: canvas.width,
                        height: canvas.height,
                    };
                } finally {
                    cleanupPlaceholders();
                }
            }

            async function downloadCardPdf(cardId, filename) {
                if (!window.jspdf) {
                    return;
                }

                const result = await captureCard(cardId);
                if (!result) {
                    return;
                }

                const { jsPDF } = window.jspdf;
                const orientation = result.width >= result.height ? 'landscape' : 'portrait';
                const pdf = new jsPDF({
                    orientation,
                    unit: 'px',
                    format: [result.width, result.height],
                });

                pdf.addImage(result.image, 'PNG', 0, 0, result.width, result.height);
                pdf.save(filename);
            }

            async function downloadBothCardsPdf() {
                if (!window.jspdf) {
                    return;
                }

                const [barResult, pieResult] = await Promise.all([
                    captureCard('barChartCard'),
                    captureCard('pieChartCard'),
                ]);

                const validResults = [barResult, pieResult].filter(Boolean);
                if (!validResults.length) {
                    return;
                }

                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF({
                    orientation: 'landscape',
                    unit: 'px',
                    format: 'a4',
                });

                validResults.forEach((result, index) => {
                    if (index > 0) {
                        pdf.addPage();
                    }

                    const pageWidth = pdf.internal.pageSize.getWidth();
                    const pageHeight = pdf.internal.pageSize.getHeight();
                    const margin = 32;
                    const maxWidth = pageWidth - margin * 2;
                    const maxHeight = pageHeight - margin * 2;
                    const ratio = result.height / result.width;

                    let drawWidth = maxWidth;
                    let drawHeight = drawWidth * ratio;

                    if (drawHeight > maxHeight) {
                        drawHeight = maxHeight;
                        drawWidth = drawHeight / ratio;
                    }

                    const startX = (pageWidth - drawWidth) / 2;
                    const startY = (pageHeight - drawHeight) / 2;

                    pdf.addImage(result.image, 'PNG', startX, startY, drawWidth, drawHeight);
                });

                pdf.save('laporan-grafik-penyakit.pdf');
            }

            function getTargetLabel(target) {
                const map = {
                    bar: 'Grafik Penyakit',
                    pie: 'Diagram Lingkaran Diagnosa',
                    both: 'Grafik Penyakit & Diagram Lingkaran',
                };

                return map[target] ?? 'Grafik Penyakit';
            }

            function getRangeSummary(target) {
                if (target === 'both') {
                    return `Grafik: ${barRangeLabel} · Diagram: ${pieRangeLabel}`;
                }

                if (target === 'bar') {
                    return `Grafik: ${barRangeLabel}`;
                }

                if (target === 'pie') {
                    return `Diagram: ${pieRangeLabel}`;
                }

                return `Grafik: ${barRangeLabel}`;
            }

            async function executeDownload(target) {
                if (target === 'bar') {
                    await downloadCardPdf('barChartCard', 'grafik-penyakit.pdf');
                    return;
                }

                if (target === 'pie') {
                    await downloadCardPdf('pieChartCard', 'diagram-lingkaran-diagnosa.pdf');
                    return;
                }

                if (target === 'both') {
                    await downloadBothCardsPdf();
                }
            }

            function openDownloadConfirmation(target) {
                confirmTargetText.textContent = getTargetLabel(target);
                confirmRangeText.textContent = getRangeSummary(target);
                confirmOverlay?.classList.remove('hidden');
                pendingDownloadAction = () => executeDownload(target);
                setTimeout(() => confirmYesBtn?.focus(), 0);
            }

            function closeDownloadConfirmation() {
                confirmOverlay?.classList.add('hidden');
                pendingDownloadAction = null;
            }

            if (downloadTarget && downloadButton) {
                downloadButton.addEventListener('click', event => {
                    event.preventDefault();
                    const target = downloadTarget.value;
                    openDownloadConfirmation(target);
                });
            }

            confirmCancelBtn?.addEventListener('click', () => {
                closeDownloadConfirmation();
            });

            confirmYesBtn?.addEventListener('click', async () => {
                const action = pendingDownloadAction;
                closeDownloadConfirmation();
                if (typeof action === 'function') {
                    await action();
                }
            });

            confirmOverlay?.addEventListener('click', event => {
                if (event.target === confirmOverlay) {
                    closeDownloadConfirmation();
                }
            });

            // === Plugin custom untuk menampilkan label total di atas batang ===
            const barValueLabelsPlugin = {
                id: 'barValueLabels',
                afterDatasetsDraw(chart, args, options) {
                    if (chart.config.type !== 'bar') {
                        return;
                    }

                    const dataset = chart.data.datasets[0];
                    if (!dataset) {
                        return;
                    }

                    const { ctx } = chart;
                    const meta = chart.getDatasetMeta(0);
                    const fontSize = options?.fontSize ?? 12;
                    const fontWeight = options?.fontWeight ?? 600;
                    const color = options?.color ?? '#0f172a';
                    const offset = options?.offset ?? 10;

                    ctx.save();
                    ctx.font = `${fontWeight} ${fontSize}px sans-serif`;
                    ctx.fillStyle = color;
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'bottom';

                    meta.data.forEach((element, index) => {
                        const value = dataset.data[index];
                        if (value == null) {
                            return;
                        }

                        ctx.fillText(value, element.x, element.y - offset);
                    });

                    ctx.restore();
                },
            };

            // === Plugin custom untuk menampilkan % di dalam potongan pie ===
            const piePercentagePlugin = {
                id: 'piePercentage',
                afterDraw(chart, args, options) {
                    if (chart.config.type !== 'pie') {
                        return;
                    }
                    const { ctx } = chart;
                    const dataset = chart.data.datasets[0];
                    if (!dataset) return;

                    const meta = chart.getDatasetMeta(0);
                    const total = dataset.data.reduce((sum, value) => sum + Number(value || 0), 0);
                    if (!total) return;

                    meta.data.forEach((element, index) => {
                        const value = Number(dataset.data[index] || 0);
                        if (!value) return;

                        const percentage = (value / total) * 100;
                        const { x, y } = element.tooltipPosition();

                        ctx.save();
                        ctx.fillStyle = options.color || '#000000';
                        ctx.font = (options.fontSize || 12) + 'px sans-serif';
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'middle';

                        const decimals = options.decimals ?? 0;
                        ctx.fillText(percentage.toFixed(decimals) + '%', x, y);
                        ctx.restore();
                    });
                }
            };

            Chart.register(barValueLabelsPlugin, piePercentagePlugin);

            // === Grafik Batang ===
            if (barLabels.length) {
                const reversedLabels = [...barLabels].reverse();
                const reversedData = [...barData].reverse();
                const barColors = reversedLabels.map(label => getColorForLabel(label));
                persistColorMap();

                // Bungkus label tiap 2 kata agar tidak kepanjangan
                const wrappedLabels = reversedLabels.map(label => {
                    const words = label.split(' ');
                    const lines = [];
                    for (let i = 0; i < words.length; i += 2) {
                        lines.push(words.slice(i, i + 2).join(' '));
                    }
                    return lines;
                });

                const ctx = document.getElementById('diseaseChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: wrappedLabels,
                        datasets: [
                            {
                                label: 'Jumlah Kasus',
                                data: reversedData,
                                backgroundColor: barColors,
                                borderRadius: 6,
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        aspectRatio: 2,
                        plugins: {
                            legend: {
                                display: false,
                            },
                            barValueLabels: {
                                color: '#0f172a',
                                fontSize: 12,
                                fontWeight: 600,
                                offset: 12,
                            },
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grace: '10%',
                                ticks: {
                                    precision: 0,
                                },
                            },
                        },
                    },
                });
            }

           // === Pie Chart + Legend di Kanan ===
            if (pieLabels.length) {
                const pieBackgrounds = pieLabels.map(label => getColorForLabel(label));
                persistColorMap();

                const pieCtx = document.getElementById('diseasePieChart').getContext('2d');
                const pieChart = new Chart(pieCtx, {
                    type: 'pie',
                    data: {
                        labels: pieLabels,
                        datasets: [
                            {
                                label: 'Persentase Diagnosa',
                                // boleh pakai percentages (0–100) atau nilai asli, tidak masalah
                                data: percentages,
                                backgroundColor: pieBackgrounds,
                                borderWidth: 0,
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            // legend bawaan dimatikan, kita pakai legend HTML manual
                            legend: {
                                display: false,
                            },
                            tooltip: {
                                callbacks: {
                                    label: context => {
                                        const label = context.label || '';
                                        const value = context.raw ?? 0;
                                        const roundedValue = Number(value).toFixed(
                                            value % 1 === 0 ? 0 : 1
                                        );
                                        return `${label}: ${roundedValue}%`;
                                    },
                                },
                            },
                            // plugin custom untuk teks % di dalam pie (yang sudah kamu buat)
                            piePercentage: {
                                color: '#ffffff',
                                fontSize: 12,
                                decimals: 0,
                            },
                        },
                    },
                });

                // === Legend HTML manual dengan Nama (XX%) ===
                const legendContainer = document.getElementById('diseasePieLegend');
                if (legendContainer) {
                    legendContainer.classList.remove('hidden');
                    legendContainer.innerHTML = '';

                    const data = pieChart.data.datasets[0].data || [];
                    const labels = pieChart.data.labels || [];
                    const colors = pieChart.data.datasets[0].backgroundColor || [];
                    const total = data.reduce((sum, value) => sum + Number(value || 0), 0);

                    labels.forEach((label, index) => {
                        const value = Number(data[index] || 0);
                        if (!value) return;

                        const percent = total ? Math.round((value / total) * 100) : 0;
                        const color = colors[index % colors.length];

                        const li = document.createElement('li');
                        li.className = 'flex items-center gap-2';

                        li.innerHTML = `
                            <span class="inline-block h-3 w-3 rounded-full" style="background-color: ${color};"></span>
                            <span class="text-slate-700">
                                ${label}
                                <span class="font-semibold text-emerald-700">(${percent}%)</span>
                            </span>
                        `;

                        legendContainer.appendChild(li);
                    });
                }
            }
        });


    </script>
@endpush
