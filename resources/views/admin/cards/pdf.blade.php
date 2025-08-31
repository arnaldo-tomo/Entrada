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
            width: 320px;
            height: 200px;
            margin: 20px auto;
            position: relative;
            border: 2px solid #333;
            border-radius: 10px;
            page-break-after: always;
            overflow: hidden;
        }

        .card-container:last-child {
            page-break-after: avoid;
        }

        /* FRENTE DO CARTÃO */
        .card-front {
            background: linear-gradient(45deg, #2980b9, #3498db);
            color: white;
            padding: 15px;
            height: 170px;
            position: relative;
        }

        .card-header {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }

        .company-name {
            display: table-cell;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .card-type {
            display: table-cell;
            text-align: right;
            font-size: 10px;
            opacity: 0.9;
        }

        .card-content {
            display: table;
            width: 100%;
            height: 120px;
        }

        .photo-section {
            display: table-cell;
            width: 70px;
            vertical-align: top;
        }

        .employee-photo {
            width: 60px;
            height: 75px;
            border: 2px solid rgba(255,255,255,0.5);
            border-radius: 5px;
            background: rgba(255,255,255,0.2);
        }

        .info-section {
            display: table-cell;
            vertical-align: top;
            padding-left: 15px;
        }

        .employee-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
            line-height: 1.2;
        }

        .employee-position {
            font-size: 12px;
            margin-bottom: 3px;
            opacity: 0.95;
        }

        .employee-department {
            font-size: 10px;
            margin-bottom: 8px;
            opacity: 0.9;
        }

        .employee-id {
            font-size: 9px;
            font-family: "Courier New", monospace;
            background: rgba(255,255,255,0.2);
            padding: 2px 5px;
            border-radius: 3px;
            display: inline-block;
        }

        .card-footer {
            position: absolute;
            bottom: 10px;
            left: 15px;
            right: 15px;
            font-size: 8px;
            opacity: 0.8;
        }

        .serial-left {
            float: left;
        }

        .date-right {
            float: right;
        }

        /* VERSO DO CARTÃO */
        .card-back {
            background: linear-gradient(45deg, #34495e, #2c3e50);
            color: white;
            padding: 15px;
            height: 170px;
            position: relative;
        }

        .back-header {
            text-align: center;
            margin-bottom: 15px;
        }

        .back-title {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .back-subtitle {
            font-size: 9px;
            opacity: 0.8;
        }

        .back-content {
            display: table;
            width: 100%;
            height: 100px;
        }

        .qr-section {
            display: table-cell;
            width: 80px;
            text-align: center;
            vertical-align: middle;
        }

        .qr-code {
            width: 70px;
            height: 70px;
            background: white;
            border-radius: 5px;
            margin: 0 auto 5px auto;
            padding: 5px;
        }

        .qr-code img {
            width: 100%;
            height: 100%;
        }

        .qr-label {
            font-size: 7px;
            opacity: 0.8;
        }

        .validity-section {
            display: table-cell;
            vertical-align: middle;
            padding-left: 20px;
            text-align: right;
        }

        .validity-label {
            font-size: 9px;
            opacity: 0.8;
            margin-bottom: 3px;
        }

        .validity-date {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .verification-info {
            font-size: 7px;
            opacity: 0.7;
            line-height: 1.3;
        }

        .back-footer {
            position: absolute;
            bottom: 8px;
            left: 15px;
            right: 15px;
            text-align: center;
            font-size: 7px;
            opacity: 0.7;
            border-top: 1px solid rgba(255,255,255,0.2);
            padding-top: 5px;
        }

        .no-photo {
            width: 60px;
            height: 75px;
            background: rgba(255,255,255,0.3);
            border: 2px solid rgba(255,255,255,0.5);
            border-radius: 5px;
            display: table;
            text-align: center;
        }

        .no-photo-text {
            display: table-cell;
            vertical-align: middle;
            font-size: 8px;
            opacity: 0.7;
        }

        .no-qr {
            width: 70px;
            height: 70px;
            background: #f8f9fa;
            border-radius: 5px;
            margin: 0 auto 5px auto;
            padding: 5px;
            display: table;
            color: #666;
        }

        .no-qr-text {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
            font-size: 8px;
        }
    </style>
</head>
<body>
    <!-- FRENTE DO CARTÃO -->
    <div class="card-container">
        <div class="card-front">
            <div class="card-header">
                <div class="company-name">{{ config('app.name', 'SISTEMA DE CARTÕES') }}</div>
                <div class="card-type">ID CARD</div>
            </div>

            <div class="card-content">
                <div class="photo-section">
                    @if($card->employee->photo && file_exists(public_path('storage/' . $card->employee->photo)))
                        <img src="{{ public_path('storage/' . $card->employee->photo) }}" class="employee-photo" alt="{{ $card->employee->name }}">
                    @else
                        <div class="no-photo">
                            <div class="no-photo-text">SEM FOTO</div>
                        </div>
                    @endif
                </div>

                <div class="info-section">
                    <div class="employee-name">{{ $card->employee->name }}</div>
                    <div class="employee-position">{{ $card->employee->position }}</div>
                    <div class="employee-department">{{ $card->employee->department }}</div>
                    <div class="employee-id">ID: {{ $card->employee->identification_number }}</div>
                </div>
            </div>

            <div class="card-footer">
                <div class="serial-left">{{ $card->serial_number }}</div>
                <div class="date-right">{{ $card->issued_date->format('m/Y') }}</div>
                <div style="clear: both;"></div>
            </div>
        </div>
    </div>

    <!-- VERSO DO CARTÃO -->
    <div class="card-container">
        <div class="card-back">
            <div class="back-header">
                <div class="back-title">Cartão de Identificação</div>
                <div class="back-subtitle">Este cartão é propriedade da empresa</div>
            </div>

            <div class="back-content">
                <div class="qr-section">
                    @if($card->qr_code_path && file_exists(public_path('storage/' . $card->qr_code_path)))
                        <div class="qr-code">
                            <img src="{{ public_path('storage/' . $card->qr_code_path) }}" alt="QR Code">
                        </div>
                    @else
                        <div class="no-qr">
                            <div class="no-qr-text">QR CODE</div>
                        </div>
                    @endif
                    <div class="qr-label">Escaneie para verificar</div>
                </div>

                <div class="validity-section">
                    <div class="validity-label">Válido até:</div>
                    <div class="validity-date">{{ $card->expiry_date->format('d/m/Y') }}</div>
                    <div class="verification-info">
                        Para verificar a autenticidade<br>
                        escaneie o QR code ou acesse:<br>
                        {{ config('app.url') }}/v/{{ $card->verification_token }}
                    </div>
                </div>
            </div>

            <div class="back-footer">
                Em caso de perda ou roubo, comunique imediatamente<br>
                Este documento é intransferível
            </div>
        </div>
    </div>
</body>
</html>
