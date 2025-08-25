<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>CV - {{ $profile->first_name['en'] ?? $user->name }}</title>
    <style>
        /* This CSS is optimized for PDF generation with dompdf */
        @page {
            margin: 25px;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif; /* Important for Arabic support */
            font-size: 10pt;
            color: #333;
        }
        h1, h2, h3, h4 {
            margin: 0;
            padding: 0;
            font-weight: bold;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #0D253F; /* Primary Color */
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 24pt;
            color: #0D253F; /* Primary Color */
        }
        .header h2 {
            font-size: 14pt;
            color: #01D277; /* Secondary Color */
            margin-top: 5px;
        }
        .contact-info {
            text-align: center;
            font-size: 9pt;
            margin-bottom: 20px;
        }
        .section {
            margin-bottom: 15px;
        }
        .section-title {
            font-size: 12pt;
            font-weight: bold;
            color: #0D253F; /* Primary Color */
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .item {
            margin-bottom: 10px;
        }
        .item-header {
            display: block;
            margin-bottom: 2px;
        }
        .item-title {
            font-weight: bold;
            font-size: 11pt;
        }
        .item-date {
            float: right;
            color: #555;
        }
        .item-subtitle {
            font-style: italic;
            color: #555;
        }
        .item-description {
            font-size: 9.5pt;
            color: #444;
        }
        .skills-container, .languages-container {
            width: 100%;
        }
        .skills-list {
             padding: 0;
             margin: 0;
             list-style-type: none;
        }
         .skills-list li {
            display: inline-block;
            background-color: #f0f0f0;
            color: #333;
            padding: 5px 10px;
            border-radius: 15px;
            margin: 2px;
            font-size: 9pt;
        }
        .languages-list {
            padding: 0;
            margin: 0;
        }
        .languages-list td {
            padding: 2px 0;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>{{ $profile->first_name['en'] ?? $user->name }} {{ $profile->last_name['en'] ?? '' }}</h1>
        <h2>{{ $cv->job_title }}</h2>
    </div>

    <div class="contact-info">
        {{ $profile->emails[0]['email'] ?? $user->email }} | 
        {{ $profile->phone_numbers[0]['number'] ?? '' }}
    </div>

    @if($cv->summary)
    <div class="section">
        <div class="section-title">Summary</div>
        <div class="item-description">{{ $cv->summary }}</div>
    </div>
    @endif

    @if($cv->workExperiences->isNotEmpty())
    <div class="section">
        <div class="section-title">Work Experience</div>
        @foreach($cv->workExperiences as $exp)
        <div class="item">
            <div class="item-header">
                <span class="item-date">{{ $exp->start_date }} - {{ $exp->end_date ?? 'Present' }}</span>
                <span class="item-title">{{ $exp->job_title }}</span>
            </div>
            <div class="item-subtitle">{{ $exp->company }}</div>
            <div class="item-description">{{ $exp->description }}</div>
        </div>
        @endforeach
    </div>
    @endif

    @if($cv->education->isNotEmpty())
    <div class="section">
        <div class="section-title">Education</div>
        @foreach($cv->education as $edu)
        <div class="item">
            <div class="item-header">
                <span class="item-date">{{ $edu->start_date }} - {{ $edu->end_date ?? 'Present' }}</span>
                <span class="item-title">{{ $edu->degree }}</span>
            </div>
            <div class="item-subtitle">{{ $edu->institution }}</div>
        </div>
        @endforeach
    </div>
    @endif
    
    <table class="skills-container">
        <tr>
            @if($cv->skills->isNotEmpty())
            <td style="width: 50%; vertical-align: top;">
                <div class="section">
                    <div class="section-title">Skills</div>
                    <ul class="skills-list">
                        @foreach($cv->skills as $skill)
                            <li>{{ $skill->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </td>
            @endif
            @if($cv->languages->isNotEmpty())
            <td style="width: 50%; vertical-align: top;">
                <div class="section">
                    <div class="section-title">Languages</div>
                    <table class="languages-list">
                        @foreach($cv->languages as $lang)
                            <tr>
                                <td style="width: 50%;">{{ $lang->name }}</td>
                                <td>{{ $lang->level }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </td>
            @endif
        </tr>
    </table>

</body>
</html>
