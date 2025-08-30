<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cartão - {{ $card->employee->name }}</title>
    <style>
        body {
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
            background: white;
        }

        .card-container {
            width: {{ $card->cardTemplate->width * 3.78 }}px;
            height: {{ $card->cardTemplate->height * 3.78 }}px;
            margin: 0 auto 30px;
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .card-front {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: white;
            padding: 15px;
            height: 100%;
            box-sizing: border-box;
            position: relative;
        }

        .card-back {
            background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
            color: white;
            padding: 15px;
            height: 100%;
            box-sizing: border-box;
            position: relative;
        }

        .employee-photo {
            width: 60px;
            height: 75px;
            object-fit: cover;
            border-radius: 4px;
            border: 2px solid rgba(255,255,255,0.3);
            float: left;
            margin-right: 15px;
        }

        .employee-info {
            margin-top: 80px;
            clear: both;
        }

        .employee-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .employee-position {
            font-size: 12px;
            opacity: 0.9;
            margin-bottom: 3px;
        }

        .employee-department {
            font-size: 10px;
            opacity: 0.7;
        }

        .serial-number {
            position: absolute;
            bottom: 15px;
            left: 15px;
            font-size: 10px;
            opacity: 0.7;
        }

        .issue-date {
            position: absolute;
            bottom: 15px;
            right: 15px;
            font-size: 10px;
            opacity: 0.7;
        }

        .qr-code {
            position: absolute;
            bottom: 15px;
            right: 15px;
            width: 60px;
            height: 60px;
            background: white;
            padding: 5px;
            border-radius: 4px;
        }

        .qr-code img {
            width: 100%;
            height: 100%;
        }

        .validity-info {
            position: absolute;
            bottom: 15px;
            left: 15px;
            font-size: 10px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- Card Front -->
    <div class="card-container">
        <div class="card-front">
            <img src="{{ public_path('storage/' . $card->employee->photo) }}" class="employee-photo" alt="{{ $card->employee->name }}">

            <div style="text-align: right; font-size: 10px; opacity: 0.8;">
                ID CARD
            </div>

            <div class="employee-info">
                <div class="employee-name">{{ $card->employee->name }}</div>
                <div class="employee-position">{{ $card->employee->position }}</div>
                <div class="employee-department">{{ $card->employee->department }}</div>
            </div>

            <div class="serial-number">{{ $card->serial_number }}</div>
            <div class="issue-date">{{ $card->issued_date->format('m/Y') }}</div>
        </div>
    </div>

    <div class="page-break"></div>

    <!-- Card Back -->
    <div class="card-container">
        <div class="card-back">
            <div style="text-align: center; margin-bottom: 20px;">
                <div style="font-weight: bold; font-size: 12px; margin-bottom: 5px;">
                    CARTÃO DE IDENTIFICAÇÃO
                </div>
                <div style="font-size: 10px; opacity: 0.7;">
                    Este cartão é propriedade da empresa
                </div>
            </div>

            @if($card->qr_code_path && file_exists(public_path('storage/' . $card->qr_code_path)))
                <div class="qr-code">
                    <img src="{{ public_path('storage/' . $card->qr_code_path) }}" alt="QR Code">
                </div>
            @endif

            <div class="validity-info">
                <div style="opacity: 0.7; margin-bottom: 3px;">Válido até:</div>
                <div style="font-weight: bold;">{{ $card->expiry_date->format('d/m/Y') }}</div>
                <div style="opacity: 0.6; font-size: 8px; margin-top: 5px;">
                    Para verificar: escaneie o QR
                </div>
            </div>

            <div style="position: absolute; bottom: 15px; left: 50%; transform: translateX(-50%); text-align: center; font-size: 8px; opacity: 0.6;">
                Em caso de perda, comunique imediatamente
            </div>
        </div>
    </div>
</body>
</html>
