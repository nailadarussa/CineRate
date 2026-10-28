<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Film</title>
    <style>
        body { font-family: sans-serif; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid #444; font-size: 12px; padding: 8px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Laporan Data Film CineRate</h2>
    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 30%">Judul</th>
                <th style="width: 20%">Sutradara</th>
                <th style="width: 10%">Tahun</th>
                <th style="width: 35%">Genre</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($films as $index => $film)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $film->title }}</td>
                <td>{{ $film->director }}</td>
                <td style="text-align: center;">{{ $film->release_year }}</td>
                <td>{{ $film->genre }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>