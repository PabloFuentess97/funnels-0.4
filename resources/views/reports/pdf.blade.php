<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte - {{ $project->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        h1 {
            color: #1a365d;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 10px;
        }
        h2 {
            color: #2d3748;
            margin-top: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #e2e8f0;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f7fafc;
        }
        .summary {
            background-color: #f7fafc;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .status {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
        }
        .status-active {
            background-color: #c6f6d5;
            color: #22543d;
        }
        .status-inactive {
            background-color: #fed7d7;
            color: #822727;
        }
    </style>
</head>
<body>
    <h1>Reporte: {{ $project->name }}</h1>
    
    <div class="summary">
        <p><strong>Slug:</strong> {{ $project->slug }}</p>
        <p><strong>Estado:</strong> 
            <span class="status {{ $project->is_active ? 'status-active' : 'status-inactive' }}">
                {{ $project->is_active ? 'Activo' : 'Inactivo' }}
            </span>
        </p>
        <p><strong>Total de Links:</strong> {{ $project->links->count() }}</p>
        <p><strong>Total de Rondas:</strong> {{ $project->rounds->count() }}</p>
        <p><strong>Total de Clicks:</strong> {{ $totalClicks }}</p>
    </div>

    <h2>Estadísticas por Link</h2>
    <table>
        <thead>
            <tr>
                <th>URL</th>
                <th>Responsable</th>
                <th>Clicks</th>
                <th>Límite</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($project->links as $link)
            <tr>
                <td>{{ $link->url }}</td>
                <td>{{ $link->responsible ?: 'Sin responsable' }}</td>
                <td>{{ $link->clicks_count }}</td>
                <td>{{ $link->click_limit }}</td>
                <td>
                    <span class="status {{ $link->is_active ? 'status-active' : 'status-inactive' }}">
                        {{ $link->is_active ? 'Activo' : 'Inactivo' }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Historial de Rondas</h2>
    <table>
        <thead>
            <tr>
                <th>Ronda</th>
                <th>Clicks</th>
                <th>Estado</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($project->rounds as $round)
            <tr>
                <td>#{{ $round->round_number }}</td>
                <td>{{ $round->clicks_count }}</td>
                <td>
                    <span class="status {{ $round->is_active ? 'status-active' : 'status-inactive' }}">
                        {{ $round->is_active ? 'En progreso' : 'Completada' }}
                    </span>
                </td>
                <td>{{ $round->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $round->is_completed ? $round->updated_at->format('d/m/Y H:i') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 40px; font-size: 12px; color: #718096; text-align: center;">
        Reporte generado el {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
