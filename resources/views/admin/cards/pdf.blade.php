<?php
// resources/views/admin/cards/pdf.blade.php (VERSÃO MELHORADA)
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cartão - {{ $card->employee->name }}</title>
    <style>
        @page {
            margin: 20px;
            size: A4;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background: #f8f9fa;
            color: #333;
        }

        .page {
            page-break-after: always;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 90vh;
            padding: 40px;
        }

        .page:last-child {
            page-break-after: avoid;
        }

        .card {
            width: {{ $card->cardTemplate->width * 3.78 }}px;
            height: {{ $card->cardTemplate->height * 3.78 }}px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0,0,0,0.15);
            position: relative;
            border: 2px solid #e1e5e9;
        }

        /* FRENTE DO CARTÃO */
        .card-front {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            height: 100%;
            box-sizing: border-box;
            position: relative;
            overflow: hidden;
        }

        .card-front::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            transform: rotate(45deg);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }

        .company-logo {
            font-size: 12px;
            font-weight: bold;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .card-type {
            font-size: 10px;
            opacity: 0.8;
            background: rgba(255,255,255,0.2);
            padding: 4px 8px;
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }

        .content {
            display: flex;
            gap: 20px;
            position: relative;
            z-index: 2;
            height: calc(100% - 80px);
        }

        .photo-section {
            flex-shrink: 0;
        }

        .employee-photo {
            width: 70px;
            height: 85px;
            border-radius: 8px;
            object-fit: cover;
            border: 3px solid rgba(255,255,255,0.3);
            box-shadow: 0 4px 16px rgba(0,0,0,0.2);
        }

        .info-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .employee-name {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 6px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .employee-position {
            font-size: 13px;
            margin-bottom: 4px;
            opacity: 0.95;
            font-weight: 500;
        }

        .employee-department {
            font-size: 11px;
            opacity: 0.8;
            margin-bottom: 15px;
        }

        .employee-id {
            font-size: 10px;
            font-family: 'Courier New', monospace;
            background: rgba(255,255,255,0.2);
            padding: 4px 8px;
            border-radius: 4px;
            display: inline-block;
            backdrop-filter: blur(10px);
        }

        .footer {
            position: absolute;
            bottom: 20px;
            left: 20px;
            right: 20px;
            display: flex;
            justify-content: space-between;
            font-size: 9px;
            opacity: 0.8;
            z-index: 2;
        }

        /* VERSO DO CARTÃO */
        .card-back {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white;
            padding: 20px;
            height: 100%;
            box-sizing: border-box;
            position: relative;
            overflow: hidden;
        }

        .card-back::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .back-header {
            text-align: center;
            margin-bottom: 25px;
            position: relative;
            z-index: 2;
        }

        .back-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .back-subtitle {
            font-size: 10px;
            opacity: 0.8;
        }

        .back-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: calc(100% - 120px);
            position: relative;
            z-index: 2;
        }

        .qr-section {
            text-align: center;
        }

        .qr-code {
            width: 80px;
            height: 80px;
            background: white;
            padding: 8px;
            border-radius: 8px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.2);
        }

        .qr-code img {
            width: 100%;
            height: 100%;
            display: block;
        }

        .qr-label {
            font-size: 9px;
            margin-top: 8px;
            opacity: 0.8;
        }

        .validity-section {
            text-align: right;
            flex: 1;
            margin-left: 20px;
        }

        .validity-label {
            font-size: 10px;
            opacity: 0.8;
            margin-bottom: 4px;
        }

        .validity-date {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .verification-info {
            font-size: 8px;
            opacity: 0.7;
            line-height: 1.4;
        }

        .back-footer {
            position: absolute;
            bottom: 20px;
            left: 20px;
            right: 20px;
            text-align: center;
            font-size: 8px;
            opacity: 0.7;
            z-index: 2;
        }

        .warning-text {
            border-top: 1px solid rgba(255,255,255,0.2);
            padding-top: 8px;
        }

        /* Decorative elements */
        .decorative-corner {
            position: absolute;
            width: 40px;
            height: 40px;
            border: 2px solid rgba(255,255,255,0.1);
        }

        .decorative-corner.top-left {
            top: 15px;
            left: 15px;
            border-right: none;
            border-bottom: none;
        }

        .decorative-corner.bottom-right {
            bottom: 15px;
            right: 15px;
            border-left: none;
            border-top: none;
        }

        /* Print optimizations */
        @media print {
            body {
                background: white !important;
            }

            .page {
                margin: 0;
                padding: 20px;
            }

            .card {
                box-shadow: none;
                border: 1px solid #ccc;
            }
        }
    </style>
</head>
<body>
    <!-- PÁGINA DA FRENTE -->
    <div class="page">
        <div class="card">
            <div class="card-front">
                <div class="decorative-corner top-left"></div>
                <div class="decorative-corner bottom-right"></div>

                <div class="header">
                    <div class="company-logo">{{ config('app.name', 'EMPRESA') }}</div>
                    <div class="card-type">ID CARD</div>
                </div>

                <div class="content">
                    <div class="photo-section">
                        @if($card->employee->photo && file_exists(public_path('storage/' . $card->employee->photo)))
                            <img src="{{ public_path('storage/' . $card->employee->photo) }}" class="employee-photo" alt="{{ $card->employee->name }}">
                        @else
                            <div class="employee-photo" style="background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 10px;">
                                SEM FOTO
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

                <div class="footer">
                    <div>{{ $card->serial_number }}</div>
                    <div>{{ $card->issued_date->format('m/Y') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- PÁGINA DO VERSO -->
    <div class="page">
        <div class="card">
            <div class="card-back">
                <div class="decorative-corner top-left"></div>
                <div class="decorative-corner bottom-right"></div>

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
                            <div class="qr-code" style="background: #f8f9fa; display: flex; align-items: center; justify-content: center; color: #666; font-size: 10px;">
                                QR CODE
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
                            <strong>{{ parse_url(config('app.url'), PHP_URL_HOST) }}/v/{{ $card->verification_token }}</strong>
                        </div>
                    </div>
                </div>

                <div class="back-footer">
                    <div class="warning-text">
                        Em caso de perda ou roubo, comunique imediatamente ao departamento de segurança<br>
                        Este documento é intransferível e deve ser portado durante o expediente
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

