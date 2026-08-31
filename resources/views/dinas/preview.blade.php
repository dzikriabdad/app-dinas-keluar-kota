<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Preview Form Dinas</title>
    <style>
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
        
        /* Barisan Tombol Preview */
        .preview-bar { background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.2); display: flex; justify-content: center; gap: 15px; margin-bottom: 20px; text-align: center; position: sticky; top: 10px; z-index: 100; }
        .btn-edit { background: #ffc107; color: #000; padding: 10px 20px; border: none; border-radius: 5px; font-weight: bold; font-size: 16px; cursor: pointer; }
        .btn-save { background: #198754; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; font-weight: bold; font-size: 16px; cursor: pointer; }
    </style>
</head>
<body>
    
    <!-- TOMBOL PREVIEW -->
    <div class="preview-bar">
        <button onclick="history.back()" class="btn-edit"> Kembali</button>
        
        <form action="{{ route('dinas.store') }}" method="POST" style="margin: 0;">
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
          <button type="submit" style="background-color: #198754; color: white; border: none; padding: 10px 24px; border-radius: 6px; font-weight: bold; font-size: 15px; cursor: pointer; margin-left: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.2);" onclick="return confirm('PENGINGAT PENTING:\n\nMohon di cetak dengan kertas KOP PT Sukun Wartono Indonesia\n\nLanjutkan Simpan & Cetak?');">
    💾 Data Benar, Simpan & Cetak!
</button>
        </form>
    </div>

    <!-- KERTAS PREVIEW -->
    <div class="a4-container">
        @include('dinas.komponen_cetak')
    </div>

</body>
</html>