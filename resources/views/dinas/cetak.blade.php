<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Form Dinas</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body { font-family: 'Times New Roman', Times, serif; margin: 0; background-color: #fff; color: #000; }
        
        /* JARAK 5 CM DARI ATAS (padding-top: 50mm) */
        .a4-container { width: 100%; min-height: auto; margin: 0; padding: 35mm 20mm 20mm 20mm; border: none; }
        @page { size: A4; margin: 35mm 20mm 20mm 20mm; background-color: transparent; }
        
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
    </style>
</head>
<body>
    <div class="a4-container">
        @include('dinas.komponen_cetak')
    </div>

    <!-- SCRIPT AUTO-PRINT & KEMBALI -->
    <script>
        window.onload = function() {
            window.print();
            setTimeout(function() {
                window.location.href = "{{ route('dinas.create') }}";
            }, 1000);
        }
    </script>
</body>
</html>