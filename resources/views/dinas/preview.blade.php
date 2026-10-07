<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Preview Form Dinas</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ═══════════════════════════════════════════════
           KERTAS A4 — IDENTIK DENGAN SEBELUMNYA
           Jangan diubah, dipakai bersama cetak.blade.php
           melalui dinas/komponen_cetak.blade.php
        ═══════════════════════════════════════════════ */
        *, *::before, *::after { box-sizing: border-box; }
        body { font-family: 'Times New Roman', Times, serif; margin: 0; padding: 20px; background-color: #525659; color: #000; }

        /* JARAK 50mm / 5cm DARI ATAS */
        .a4-container { width: 210mm; min-height: 297mm; margin: 0 auto; background-color: #fff; padding: 35mm 20mm 20mm 20mm; box-shadow: 0 4px 12px rgba(0,0,0,0.5); position: relative; }

        .form-title { text-align: center; font-size: 24px; font-weight: bold; text-transform: uppercase; margin-bottom: 25px; letter-spacing: 0.5px; }
        .meta-info { width: 100%; margin-bottom: 15px; font-size: 15px; border: none; border-collapse: collapse; }
        .meta-info td { padding: 4px 0; border: none; vertical-align: top; font-weight: bold; }
        .meta-info td.meta-val { font-weight: normal; }
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; font-size: 14px; }
        .data-table th, .data-table td { border: 1px solid #000; padding: 8px; text-align: center; vertical-align: middle; }
        .text-left { text-align: justify !important; text-align-last: left; padding-left: 12px !important; padding-right: 12px !important; }
        .align-top { vertical-align: top !important; }
        .data-table th { background-color: #fff; text-transform: uppercase; font-weight: 900; font-size: 16px; padding: 12px 8px; }
        .note { font-size: 13px; font-style: italic; color: #222; margin-bottom: 20px; }

        .signature-table { width: 100%; margin-top: 30px; font-size: 15px; display: table; page-break-inside: avoid; table-layout: fixed; }
        .sig-cell { display: table-cell; width: 50%; vertical-align: top; }
        .sig-box { width: 100%; max-width: 250px; margin: 0 auto; text-align: center; }
        .sig-date { height: 25px; margin-bottom: 5px; }
        .sig-title { height: 40px; line-height: 1.3; font-weight: bold; display: flex; align-items: flex-end; justify-content: center; }
        .sig-space { height: 80px; }
        .sig-line { border-bottom: 1px solid #000; width: 90%; margin: 0 auto; }

        /* ═══════════════════════════════════════════════
           TOOLBAR PREVIEW — DI-RESTYLE
           Hanya bagian ini yang berubah.
           Mengikuti design system (navy + Inter).
        ═══════════════════════════════════════════════ */
        .preview-bar{
            position: sticky;
            top: 12px;
            z-index: 100;
            max-width: 210mm;
            margin: 0 auto 20px;
            padding: 13px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            flex-wrap: wrap;
            background: linear-gradient(120deg, #0a1a33 0%, #12305c 52%, #1c4d95 100%);
            border-radius: 14px;
            box-shadow: 0 18px 44px rgba(8,21,43,.34);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        .pb-info{ min-width: 0; padding-left: 4px; }

        .pb-title{
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            letter-spacing: .2px;
        }

        .pb-sub{
            display: block;
            font-size: 11px;
            color: rgba(255,255,255,.62);
            margin-top: 2px;
        }

        .pb-actions{
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .pb-form{ margin: 0; display: flex; }

        .pb-btn{
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 20px;
            border-radius: 10px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .2px;
            cursor: pointer;
            white-space: nowrap;
            transition: background .2s ease, box-shadow .2s ease, transform .18s ease, border-color .2s ease;
        }

        .pb-btn svg{ width: 15px; height: 15px; }

        .pb-btn-ghost{
            background: rgba(255,255,255,.10);
            border: 1px solid rgba(255,255,255,.22);
            color: #dcebff;
        }

        .pb-btn-ghost:hover{
            background: rgba(255,255,255,.19);
            border-color: rgba(255,255,255,.34);
        }

        .pb-btn-primary{
            background: linear-gradient(135deg, #0f7a48, #16a34a);
            border: 0;
            color: #fff;
            box-shadow: 0 10px 24px rgba(15,122,72,.28);
        }

        .pb-btn-primary:hover{
            background: linear-gradient(135deg, #0c6a3e, #15803d);
            box-shadow: 0 14px 30px rgba(15,122,72,.34);
            transform: translateY(-1px);
        }

        .pb-btn:focus-visible{
            outline: none;
            box-shadow: 0 0 0 4px rgba(59,130,246,.28);
        }

        /* ═══════════════════════════════════════════════
           CETAK — toolbar disembunyikan, kertas bersih
        ═══════════════════════════════════════════════ */
        @media print{
            body{ background: #fff; padding: 0; }
            .preview-bar{ display: none !important; }
            .a4-container{
                width: 100%;
                min-height: auto;
                margin: 0;
                padding: 35mm 20mm 20mm 20mm;
                box-shadow: none;
            }
            @page{ size: A4; margin: 0; background-color: transparent; }
        }
    </style>
</head>
<body>

    <!-- ══════════ TOOLBAR PREVIEW ══════════ -->
    <div class="preview-bar">
        <div class="pb-info">
            <span class="pb-title">Preview Form Dinas</span>
            <span class="pb-sub">Periksa kembali seluruh isi sebelum dicetak</span>
        </div>

        <div class="pb-actions">
            <button type="button" class="pb-btn pb-btn-ghost" onclick="history.back()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M19 12H5M11 18l-6-6 6-6"/>
                </svg>
                Kembali
            </button>

            <form action="{{ route('dinas.store') }}" method="POST" class="pb-form">
                @csrf
                @foreach($rawData as $key => $value)
                    @if($key === '_token') @continue @endif
                    @if(is_array($value))
                        @foreach($value as $v)
                            <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                        @endforeach
                    @else
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endif
                @endforeach

                <button type="submit"
                        class="pb-btn pb-btn-primary"
                        onclick="return confirm('PENGINGAT PENTING:\n\nMohon di cetak dengan kertas KOP PT Sukun Wartono Indonesia\n\nLanjutkan Simpan &amp; Cetak?');">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M19 21H5a2 2 0 0 1-2-2v-5h18v5a2 2 0 0 1-2 2Z"/>
                        <path d="M7 14V3h10v11"/>
                        <path d="M7 18h10"/>
                    </svg>
                    Data Benar, Simpan &amp; Cetak
                </button>
            </form>
        </div>
    </div>

    <!-- ══════════ KERTAS PREVIEW ══════════ -->
    <div class="a4-container">
        @include('dinas.komponen_cetak')
    </div>

</body>
</html>
